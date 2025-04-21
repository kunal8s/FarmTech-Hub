<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Initialize error variable
    $error = null;
    
    // Check if passwords match
    if ($password !== $confirm_password) {
        $error = "Passwords do not match!";
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
                    
                    $fileExt = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
                    $fileName = uniqid('profile_') . '.' . $fileExt;
                    $filePath = $uploadDir . $fileName;
                    
                    // Check if file is an image
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if (in_array($_FILES['profile_image']['type'], $allowedTypes)) {
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
                    
                    // Redirect to login page after successful signup
                    header("Location: login.php?signup=success");
                    exit();
                }
            }
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Keep all your existing head content -->
    <!-- ... -->
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
        }
    </style>
</head>
<body>
    <!-- Navigation (same as before) -->
    <!-- ... -->

    <nav class="fixed w-full bg-white shadow-md z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="index.php"><span class="text-2xl font-bold text-indigo-600">FarmTech Hub</span></a>
                </div>
                
                <div class="hidden md:flex items-center space-x-8">
                    <a href="index.php" class="nav-link text-gray-600 hover:text-indigo-600">Home</a>
                    <a href="index.php#about" class="nav-link text-gray-600 hover:text-indigo-600">About</a>
                    <a href="index.php#services" class="nav-link text-gray-600 hover:text-indigo-600">Services</a>
                    <a href="index.php#blog" class="nav-link text-gray-600 hover:text-indigo-600">Blog</a>
                    <a href="login.php" class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-4 py-2 rounded-lg hover:opacity-90 transition-all">Login</a>
                    <a href="signup.php" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">Sign Up</a>
                </div>

                <button id="menu-btn" class="md:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Signup Content -->
    <div class="min-h-screen flex items-center justify-center px-4 pt-24 pb-12">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-2xl font-bold mb-6 text-center">Create an Account</h3>
            
            <?php if (isset($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="signup.php" class="space-y-4" enctype="multipart/form-data">
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 mb-2">First Name</label>
                        <input type="text" name="first_name" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                    </div>
                    <div>
                        <label class="block text-gray-700 mb-2">Last Name</label>
                        <input type="text" name="last_name" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                    </div>
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" required minlength="8" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Confirm Password</label>
                    <input type="password" name="confirm_password" required minlength="8" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                </div>
                <div>
                    <label class="block text-gray-700 mb-2">Profile Image</label>
                    <input type="file" name="profile_image" accept="image/*" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600" id="imageInput" required>
                    <img id="imagePreview" src="#" alt="Preview" class="preview-image">
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="terms" name="terms" required class="mr-2">
                    <label for="terms" class="text-gray-700">I agree to the <a href="#" class="text-green-600 hover:underline">Terms & Conditions</a></label>
                </div>
                <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition-colors">Sign Up</button>
            </form>
            <div class="mt-4 text-center">
                <p class="text-gray-600">Already have an account? <a href="login.php" class="text-green-600 hover:underline">Login</a></p>
            </div>
        </div>
    </div>

    <script>
        // Mobile menu toggle (same as before)
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Close mobile menu when clicking a link
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
            });
        });

        // Image preview functionality
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');
        
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                }
                
                reader.readAsDataURL(file);
            }
        });
    </script>
</body>
</html>