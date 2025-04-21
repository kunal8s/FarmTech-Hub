<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    
    try {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if ($user) {
            // Generate a unique token
            $token = bin2hex(random_bytes(32));
            $expires = date("Y-m-d H:i:s", strtotime("+1 hour"));
            
            // Store token in database
            $stmt = $pdo->prepare("UPDATE users SET reset_token = ?, reset_expires = ? WHERE id = ?");
            $stmt->execute([$token, $expires, $user['id']]);
            
            // Send email with reset link (you'll need to implement this)
            $resetLink = "http://yourdomain.com/reset_password_form.php?token=$token";
            // mail($email, "Password Reset", "Click here to reset your password: $resetLink");
            
            $message = "Password reset link has been sent to your email.";
        } else {
            $error = "Email not found.";
        }
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Same head content as other pages -->
    <!-- ... -->
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - FarmTech Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        body {
            background: linear-gradient(45deg, #FAD7CD 0%, #FADDE8 33%, #F0DDF4 66%, #E2D9F5 100%);
            background-attachment: fixed;
            min-height: 100vh;
        }
    </style>
</head>
</head>
<body>
    <!-- Navigation -->
    <!-- ... -->
    <nav class="fixed w-full bg-white shadow-md z-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <span class="text-2xl font-bold text-indigo-600">FarmTech Hub</span>
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

    <div class="min-h-screen flex items-center justify-center px-4 pt-24 pb-12">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-md">
            <h3 class="text-2xl font-bold mb-6 text-center">Reset Password</h3>
            
            <?php if (isset($error)): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php elseif (isset($message)): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    <?php echo htmlspecialchars($message); ?>
                </div>
            <?php endif; ?>
            
            <form method="POST" action="reset_password.php" class="space-y-4">
                <div>
                    <label class="block text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" required class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600">
                </div>
                <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700 transition-colors">Send Reset Link</button>
            </form>
            <div class="mt-4 text-center">
                <a href="login.php" class="text-green-600 hover:underline">Back to Login</a>
            </div>
        </div>
    </div>
</body>
</html>