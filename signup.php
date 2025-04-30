<?php
session_start();
require_once 'db.php';
require_once 'mail_config.php';

// Function to generate and send OTP
function sendOTP($email) {
    // Generate 6-digit OTP
    $otp = rand(100000, 999999);
    
    // Store OTP in session with timestamp
    $_SESSION['signup_otp'] = $otp;
    $_SESSION['signup_otp_time'] = time();
    $_SESSION['signup_email'] = $email;
    $_SESSION['last_otp_time'] = time();
    
    // Include mail configuration
    require_once 'mail_config.php';
    
    // Send email using PHPMailer
    return sendOTPEmail($email, $otp);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if this is OTP verification step
    if (isset($_POST['verify_otp'])) {
        $user_otp = $_POST['otp'];
        $stored_otp = $_SESSION['signup_otp'] ?? null;
        
        // Check if OTP matches and isn't expired (10 minutes)
        if ($user_otp == $stored_otp && (time() - ($_SESSION['signup_otp_time'] ?? 0)) < 600) {
            $_SESSION['otp_verified'] = true;
            $_SESSION['signup_email_verified'] = $_SESSION['signup_email'];
            $success = "OTP verified successfully! Please complete your registration.";
        } else {
            $error = "Invalid or expired OTP. Please try again.";
        }
    } 
    // Handle final registration submission
    elseif (isset($_POST['register']) && ($_SESSION['otp_verified'] ?? false)) {
        $first_name = trim($_POST['first_name']);
        $last_name = trim($_POST['last_name']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        
        // Validate inputs
        if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
            $error = "All fields are required!";
        }
        // Check if passwords match
        elseif ($password !== $confirm_password) {
            $error = "Passwords do not match!";
        }
        // Check password strength
        elseif (strlen($password) < 8) {
            $error = "Password must be at least 8 characters long!";
        }
        // Check if email matches the verified email
        elseif ($email !== $_SESSION['signup_email_verified']) {
            $error = "Email changed after OTP verification. Please restart registration.";
        } else {
            try {
                // Check if email already exists
                $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
                $stmt->execute([$email]);
                if ($stmt->rowCount() > 0) {
                    $error = "An account with this email already exists. Please login.";
                } else {
                    // Handle file upload
                    $profile_image = null;
                    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
                        $uploadDir = 'uploads/profile_images/';
                        if (!is_dir($uploadDir)) {
                            mkdir($uploadDir, 0755, true);
                        }
                        
                        $fileExt = strtolower(pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION));
                        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                        
                        if (in_array($fileExt, $allowedExtensions)) {
                            $fileName = uniqid('profile_') . '.' . $fileExt;
                            $filePath = $uploadDir . $fileName;
                            
                            if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $filePath)) {
                                $profile_image = $filePath;
                            } else {
                                $error = "Failed to upload image.";
                            }
                        } else {
                            $error = "Only JPG, PNG, and GIF files are allowed.";
                        }
                    }
                    
                    if (!isset($error)) {
                        // Hash the password
                        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                        
                        $stmt = $pdo->prepare("INSERT INTO users (first_name, last_name, email, password, profile_image) VALUES (?, ?, ?, ?, ?)");
                        $stmt->execute([$first_name, $last_name, $email, $hashed_password, $profile_image]);
                        
                        // Clear session data
                        unset(
                            $_SESSION['signup_otp'], 
                            $_SESSION['signup_otp_time'], 
                            $_SESSION['signup_email'],
                            $_SESSION['signup_email_verified'],
                            $_SESSION['otp_verified'],
                            $_SESSION['signup_email_entered']
                        );
                        
                        // Redirect to login page after successful signup
                        header("Location: login.php?signup=success");
                        exit();
                    }
                }
            } catch (PDOException $e) {
                $error = "Registration failed. Please try again later.";
                // Log the error for debugging
                error_log("Registration error: " . $e->getMessage());
            }
        }
    }
    // Handle initial email submission (send OTP)
    elseif (isset($_POST['send_otp'])) {
        $email = trim($_POST['email']);
        
        // Basic email validation
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = "Please enter a valid email address.";
        } else {
            // Check for OTP cooldown (prevent spamming)
            $lastOTPTime = $_SESSION['last_otp_time'] ?? 0;
            if (time() - $lastOTPTime < 60) { // 60 seconds cooldown
                $error = "Please wait before requesting another OTP.";
            } else {
                if (sendOTP($email)) {
                    $success = "OTP sent to your email! Please check your inbox.";
                    $_SESSION['signup_email_entered'] = $email;
                } else {
                    $error = "Failed to send OTP. Please try again later.";
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - FarmTech Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        body {
            background: linear-gradient(45deg, #FAD7CD 0%, #FADDE8 33%, #F0DDF4 66%, #E2D9F5 100%);
            background-attachment: fixed;
            min-height: 100vh;
        }
        .preview-image {
            max-width: 100px;
            max-height: 100px;
            margin-top: 10px;
            display: none;
            border-radius: 50%;
            object-fit: cover;
        }
        .hidden-section {
            display: none;
        }
        .password-strength {
            height: 4px;
            margin-top: 4px;
            background: #e0e0e0;
            border-radius: 2px;
        }
        .password-strength-bar {
            height: 100%;
            border-radius: 2px;
            transition: width 0.3s, background 0.3s;
        }
    </style>
</head>
<body>
    <div class="min-h-screen flex items-center justify-center px-4 pt-24 pb-12">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md animate__animated animate__fadeIn">
            <h3 class="text-2xl font-bold mb-6 text-center">Create an Account</h3>
            
            <?php if (isset($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 animate__animated animate__shakeX">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($success)): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 animate__animated animate__fadeIn">
                    <?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>
            
            <!-- Step 1: Email entry and OTP request -->
            <form method="POST" action="signup.php" id="emailForm" class="<?php echo isset($_SESSION['signup_email_entered']) && !isset($_SESSION['otp_verified']) ? 'hidden-section' : 'space-y-4'; ?>">
                <div>
                    <label class="block text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" required 
                           value="<?php echo isset($_SESSION['signup_email_entered']) ? htmlspecialchars($_SESSION['signup_email_entered']) : ''; ?>"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                </div>
                <button type="submit" name="send_otp" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition-colors">
                    Send Verification Code
                </button>
            </form>
            
            <!-- Step 2: OTP verification -->
            <form method="POST" action="signup.php" id="otpForm" class="<?php echo isset($_SESSION['signup_email_entered']) && !isset($_SESSION['otp_verified']) ? 'space-y-4' : 'hidden-section'; ?>">
                <div>
                    <label class="block text-gray-700 mb-2">Enter 6-digit OTP sent to <?php echo isset($_SESSION['signup_email_entered']) ? htmlspecialchars($_SESSION['signup_email_entered']) : 'your email'; ?></label>
                    <input type="text" name="otp" required pattern="\d{6}" maxlength="6" 
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600"
                           placeholder="123456">
                </div>
                <button type="submit" name="verify_otp" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition-colors">
                    Verify OTP
                </button>
                <div class="text-center mt-2">
                    <button type="button" onclick="resendOTP()" class="text-green-600 hover:underline">Resend OTP</button>
                    <span id="otpTimer" class="text-gray-500 ml-2"></span>
                </div>
            </form>
            
            <!-- Step 3: Complete registration (shown after OTP verification) -->
            <form method="POST" action="signup.php" id="registrationForm" enctype="multipart/form-data" class="<?php echo isset($_SESSION['otp_verified']) ? 'space-y-4' : 'hidden-section'; ?>">
                <input type="hidden" name="email" value="<?php echo isset($_SESSION['signup_email_verified']) ? htmlspecialchars($_SESSION['signup_email_verified']) : ''; ?>">
                
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 mb-2">First Name</label>
                        <input type="text" name="first_name" required 
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-2">Last Name</label>
                        <input type="text" name="last_name" required 
                               class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                    </div>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" required minlength="8" id="password"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                    <div class="password-strength">
                        <div id="password-strength-bar" class="password-strength-bar"></div>
                    </div>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Confirm Password</label>
                    <input type="password" name="confirm_password" required minlength="8" id="confirm_password"
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                    <div id="password-match" class="text-sm mt-1 hidden"></div>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Profile Image (Optional)</label>
                    <input type="file" name="profile_image" accept="image/*" 
                           class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600" 
                           id="imageInput">
                    <img id="imagePreview" src="#" alt="Preview" class="preview-image">
                </div>
                <div class="flex items-start">
                    <input type="checkbox" id="terms" name="terms" required class="mt-1 mr-2">
                    <label for="terms" class="text-gray-700 text-sm">I agree to the <a href="terms.php" class="text-green-600 hover:underline">Terms & Conditions</a> and <a href="privacy.php" class="text-green-600 hover:underline">Privacy Policy</a></label>
                </div>
                <button type="submit" name="register" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition-colors">
                    Complete Registration
                </button>
            </form>
            
            <div class="mt-4 text-center">
                <p class="text-gray-600">Already have an account? <a href="login.php" class="text-green-600 hover:underline">Login</a></p>
            </div>
        </div>
    </div>

    <script>
        // Image preview functionality
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');
        
        if (imageInput) {
            imageInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    // Validate file size (max 2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Image size should be less than 2MB');
                        this.value = '';
                        return;
                    }
                    
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        imagePreview.style.display = 'block';
                    }
                    
                    reader.readAsDataURL(file);
                }
            });
        }
        
        // Password strength indicator
        const passwordInput = document.getElementById('password');
        const strengthBar = document.getElementById('password-strength-bar');
        
        if (passwordInput && strengthBar) {
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;
                
                // Check length
                if (password.length >= 8) strength += 1;
                if (password.length >= 12) strength += 1;
                
                // Check for mixed case
                if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength += 1;
                
                // Check for numbers
                if (/\d/.test(password)) strength += 1;
                
                // Check for special chars
                if (/[^a-zA-Z0-9]/.test(password)) strength += 1;
                
                // Update strength bar
                let width = 0;
                let color = 'red';
                
                switch(strength) {
                    case 1:
                        width = 20;
                        color = 'red';
                        break;
                    case 2:
                        width = 40;
                        color = 'orange';
                        break;
                    case 3:
                        width = 60;
                        color = '#ffcc00';
                        break;
                    case 4:
                        width = 80;
                        color = '#99cc33';
                        break;
                    case 5:
                        width = 100;
                        color = 'green';
                        break;
                    default:
                        width = 0;
                }
                
                strengthBar.style.width = width + '%';
                strengthBar.style.background = color;
            });
        }
        
        // Password match verification
        const confirmPassword = document.getElementById('confirm_password');
        const passwordMatch = document.getElementById('password-match');
        
        if (confirmPassword && passwordMatch) {
            confirmPassword.addEventListener('input', function() {
                if (this.value !== passwordInput.value) {
                    passwordMatch.textContent = "Passwords don't match!";
                    passwordMatch.style.color = 'red';
                    passwordMatch.classList.remove('hidden');
                } else {
                    passwordMatch.textContent = "Passwords match!";
                    passwordMatch.style.color = 'green';
                    passwordMatch.classList.remove('hidden');
                }
            });
        }
        
        // OTP resend functionality with cooldown timer
        // OTP resend functionality with cooldown timer
function resendOTP() {
    const email = "<?php echo isset($_SESSION['signup_email_entered']) ? addslashes($_SESSION['signup_email_entered']) : ''; ?>";
    const lastOTPTime = <?php echo $_SESSION['last_otp_time'] ?? 0; ?>;
    const currentTime = Math.floor(Date.now() / 1000);
    const cooldown = 60; // 60 seconds cooldown

    if (email && (currentTime - lastOTPTime >= cooldown)) {
        fetch('resend_otp.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'email=' + encodeURIComponent(email)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('OTP resent successfully!');
                startOTPTimer();
            } else {
                alert('Failed to resend OTP: ' + (data.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Failed to resend OTP');
        });
    } else {
        const remaining = cooldown - (currentTime - lastOTPTime);
        alert(`Please wait ${remaining} seconds before requesting another OTP.`);
    }
}
        
        // Start OTP timer
        function startOTPTimer() {
            const timerElement = document.getElementById('otpTimer');
            if (!timerElement) return;
            
            let timeLeft = 60;
            timerElement.textContent = `(Resend in ${timeLeft}s)`;
            
            const timer = setInterval(() => {
                timeLeft--;
                timerElement.textContent = `(Resend in ${timeLeft}s)`;
                
                if (timeLeft <= 0) {
                    clearInterval(timer);
                    timerElement.textContent = '';
                }
            }, 1000);
        }
        
        // Initialize timer if on OTP page
        if (document.getElementById('otpForm') && !document.getElementById('otpForm').classList.contains('hidden-section')) {
            startOTPTimer();
        }
    </script>
</body>
</html> 