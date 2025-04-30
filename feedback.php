<?php
session_start();
require_once 'db.php';

// Redirect to login if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $feedback_type = $_POST['feedback_type'];
    $message = $_POST['message'];
    $user_id = $_SESSION['user_id'];
    
    // Handle file upload
    // initialize to null or empty so your INSERT/UPDATE won't blow up
$image_path = null;

// only try to process if user actually picked a file
if (
    isset($_FILES['image']) &&
    $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE &&    // not “no file”
    $_FILES['image']['error'] === UPLOAD_ERR_OK             // no other upload errors
) {
    // double‑check it's a real image
    $tmp = $_FILES['image']['tmp_name'];
    $check = @getimagesize($tmp);
    if ($check !== false) {
        // build a unique filename
        $ext        = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename   = "feedback_" . time() . "_" . $user_id . "." . $ext;
        $target_file = $target_dir . $filename;

        if (move_uploaded_file($tmp, $target_file)) {
            $image_path = $target_file;
        }
    }
}

// now you can safely INSERT $image_path (it will be null/empty if no image)

    // Insert feedback into database
    try {
        $stmt = $pdo->prepare("INSERT INTO feedback (user_id, feedback_type, message, image_path) VALUES (?, ?, ?, ?)");
        $stmt->execute([$user_id, $feedback_type, $message, $image_path]);
        
        $_SESSION['feedback_success'] = "Thank you for your feedback!";
        header("Location: feedback.php");
        exit();
    } catch (PDOException $e) {
        $_SESSION['feedback_error'] = "Error submitting feedback: " . $e->getMessage();
    }
}

// Get user's previous feedback
$user_feedback = [];
try {
    $stmt = $pdo->prepare("SELECT * FROM feedback WHERE user_id = ? ORDER BY created_at DESC");
    $stmt->execute([$_SESSION['user_id']]);
    $user_feedback = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['feedback_error'] = "Error fetching your feedback: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FarmTech Hub - Feedback</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        .float-animate {
            animation: float 6s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .pulse-animate {
            animation: pulse 2s infinite;
        }
        
        .feedback-card {
            transition: all 0.3s ease;
            background: linear-gradient(145deg, #ffffff, #f8fafc);
            border-radius: 1rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .feedback-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .feedback-image {
            transition: all 0.5s ease;
            border-radius: 0.5rem;
        }
        
        .feedback-image:hover {
            transform: scale(1.05);
        }
        
        .type-badge {
            transition: all 0.3s ease;
        }
        
        .type-badge:hover {
            transform: scale(1.1);
        }
        
        .file-input-label {
            transition: all 0.3s ease;
        }
        
        .file-input-label:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .submit-btn {
            transition: all 0.3s ease;
            background: linear-gradient(135deg, #84cc16, #22c55e, #10b981);
            background-size: 200% 200%;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            background-position: right center;
        }
        
        .ripple {
            position: relative;
            overflow: hidden;
        }
        
        .ripple:after {
            content: "";
            display: block;
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            background-image: radial-gradient(circle, #fff 10%, transparent 10.01%);
            background-repeat: no-repeat;
            background-position: 50%;
            transform: scale(10, 10);
            opacity: 0;
            transition: transform .5s, opacity 1s;
        }
        
        .ripple:active:after {
            transform: scale(0, 0);
            opacity: 0.3;
            transition: 0s;
        }
    </style>
</head>
<body class="bg-gradient-to-r from-lime-300 via-green-400 to-teal-500 min-h-screen">
    <!-- Navigation -->
    <nav class="fixed w-full bg-white shadow-md z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="consumer-insights.html"><span class="text-2xl font-bold text-indigo-600">Consumers Portal</span></a>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="index.php#home" class="nav-link text-gray-600 hover:text-indigo-600">Home</a>
                    <a href="index.php#about" class="nav-link text-gray-600 hover:text-indigo-600">About</a>
                    <a href="index.php#services" class="nav-link text-gray-600 hover:text-indigo-600">Services</a>
                    <a href="index.php#blog" class="nav-link text-gray-600 hover:text-indigo-600">Blog</a>
                    <a href="feedback.php" class="nav-link text-indigo-600 font-semibold">Feedback</a>
                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="flex items-center space-x-4">
                            <a href="dashboard.php" class="nav-link text-gray-600 hover:text-indigo-600">Dashboard</a>
                            <span class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-4 py-2 rounded-lg hover:opacity-90 transition-all">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                            <a href="logout.php" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">Logout</a>
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-4 py-2 rounded-lg hover:opacity-90 transition-all">Login</a>
                        <a href="signup.php" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">Sign Up</a>
                    <?php endif; ?>
                </div>

                <!-- Mobile Menu Button -->
                <button id="menu-btn" class="md:hidden">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                    </svg>
                </button>
            </div>
        </div>
    </nav>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden fixed w-full bg-white shadow-md hidden pt-16">
        <div class="px-4 py-2 space-y-4">
            <a href="index.php#home" class="block nav-link text-gray-600 hover:text-indigo-600">Home</a>
            <a href="index.php#about" class="block nav-link text-gray-600 hover:text-indigo-600">About</a>
            <a href="index.php#services" class="block nav-link text-gray-600 hover:text-indigo-600">Services</a>
            <a href="index.php#blog" class="block nav-link text-gray-600 hover:text-indigo-600">Blog</a>
            <a href="feedback.php" class="block nav-link text-indigo-600 font-semibold">Feedback</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="dashboard.php" class="block nav-link text-gray-600 hover:text-indigo-600">Dashboard</a>
                <a href="logout.php" class="block bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">Logout</a>
            <?php else: ?>
                <a href="login.php" class="block bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-4 py-2 rounded-lg hover:opacity-90 transition-all">Login</a>
                <a href="signup.php" class="block bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">Sign Up</a>
            <?php endif; ?>
        </div>
    </div>

    <main class="pt-20 pb-12 px-4">
        <!-- Feedback Form Section -->
        <section class="max-w-4xl mx-auto mt-8 animate__animated animate__fadeIn">
            <div class="feedback-card p-8 backdrop-blur-sm bg-white/80 rounded-xl shadow-xl">
                <div class="text-center mb-8">
                    <h1 class="text-4xl font-bold text-gray-800 mb-2">Share Your Feedback</h1>
                    <p class="text-lg text-gray-600">Your input helps improve food quality and farming practices</p>
                </div>
                
                <?php if (isset($_SESSION['feedback_success'])): ?>
                    <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded animate__animated animate__bounceIn">
                        <?php echo $_SESSION['feedback_success']; unset($_SESSION['feedback_success']); ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_SESSION['feedback_error'])): ?>
                    <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded animate__animated animate__shakeX">
                        <?php echo $_SESSION['feedback_error']; unset($_SESSION['feedback_error']); ?>
                    </div>
                <?php endif; ?>
                
                <form action="feedback.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Feedback Type</label>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="radio" name="feedback_type" value="Quality Report" class="hidden peer" checked>
                                <div class="type-badge peer-checked:bg-red-100 peer-checked:text-red-800 bg-gray-100 text-gray-800 px-4 py-2 rounded-full flex items-center justify-center">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    <span>Quality Report</span>
                                </div>
                            </label>
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="radio" name="feedback_type" value="Product Suggestion" class="hidden peer">
                                <div class="type-badge peer-checked:bg-blue-100 peer-checked:text-blue-800 bg-gray-100 text-gray-800 px-4 py-2 rounded-full flex items-center justify-center">
                                    <i class="fas fa-lightbulb mr-2"></i>
                                    <span>Product Suggestion</span>
                                </div>
                            </label>
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="radio" name="feedback_type" value="Farmer Message" class="hidden peer">
                                <div class="type-badge peer-checked:bg-green-100 peer-checked:text-green-800 bg-gray-100 text-gray-800 px-4 py-2 rounded-full flex items-center justify-center">
                                    <i class="fas fa-comments mr-2"></i>
                                    <span>Farmer Message</span>
                                </div>
                            </label>
                            <label class="flex items-center space-x-2 cursor-pointer">
                                <input type="radio" name="feedback_type" value="Recipe Idea" class="hidden peer">
                                <div class="type-badge peer-checked:bg-purple-100 peer-checked:text-purple-800 bg-gray-100 text-gray-800 px-4 py-2 rounded-full flex items-center justify-center">
                                    <i class="fas fa-utensils mr-2"></i>
                                    <span>Recipe Idea</span>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <div>
                        <label for="message" class="block text-gray-700 font-medium mb-2">Your Feedback</label>
                        <textarea id="message" name="message" rows="5" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent" placeholder="Share your thoughts, suggestions, or concerns..." required></textarea>
                    </div>
                    
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Upload Image (Optional)</label>
                        <label for="image" class="file-input-label cursor-pointer inline-block bg-white border-2 border-dashed border-gray-300 rounded-lg p-6 text-center hover:border-green-500 transition-all">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-2"></i>
                                <span class="text-gray-600">Click to upload an image</span>
                                <span class="text-sm text-gray-400">PNG, JPG, JPEG (Max 5MB)</span>
                            </div>
                            <input type="file" id="image" name="image" accept="image/*" class="hidden">
                        </label>
                        <div id="image-preview" class="mt-4 hidden">
                            <img id="preview-image" src="#" alt="Preview" class="max-h-48 rounded-lg shadow">
                            <button type="button" id="remove-image" class="mt-2 text-red-600 hover:text-red-800">
                                <i class="fas fa-times mr-1"></i> Remove Image
                            </button>
                        </div>
                    </div>
                    
                    <div class="pt-4">
                        <button type="submit" class="submit-btn ripple w-full py-3 px-6 text-white font-bold rounded-lg shadow-lg hover:shadow-xl transition-all duration-300">
                            <i class="fas fa-paper-plane mr-2"></i> Submit Feedback
                        </button>
                    </div>
                </form>
            </div>
        </section>
        
        <!-- Previous Feedback Section -->
        <section class="max-w-4xl mx-auto mt-16 animate__animated animate__fadeInUp">
            <h2 class="text-3xl font-bold text-gray-800 mb-6 text-center">Your Previous Feedback</h2>
            
            <?php if (empty($user_feedback)): ?>
                <div class="text-center py-8 bg-white/80 rounded-xl shadow">
                    <i class="fas fa-comment-slash text-4xl text-gray-400 mb-4"></i>
                    <p class="text-gray-600">You haven't submitted any feedback yet.</p>
                </div>
            <?php else: ?>
                <div class="space-y-6">
                    <?php foreach ($user_feedback as $feedback): ?>
                        <div class="feedback-card p-6 bg-white rounded-xl shadow hover:shadow-lg transition-all">
                            <div class="flex justify-between items-start mb-4">
                                <div>
                                    <span class="inline-block px-3 py-1 rounded-full text-sm font-medium 
                                        <?php 
                                            switch($feedback['feedback_type']) {
                                                case 'Quality Report': echo 'bg-red-100 text-red-800'; break;
                                                case 'Product Suggestion': echo 'bg-blue-100 text-blue-800'; break;
                                                case 'Farmer Message': echo 'bg-green-100 text-green-800'; break;
                                                case 'Recipe Idea': echo 'bg-purple-100 text-purple-800'; break;
                                                default: echo 'bg-gray-100 text-gray-800';
                                            }
                                        ?>">
                                        <?php echo htmlspecialchars($feedback['feedback_type']); ?>
                                    </span>
                                    <span class="text-sm text-gray-500 ml-2">
                                        <?php echo date('M j, Y g:i A', strtotime($feedback['created_at'])); ?>
                                    </span>
                                </div>
                                <?php if ($feedback['image_path']): ?>
                                    <button onclick="toggleImageModal('<?php echo htmlspecialchars($feedback['image_path']); ?>')" class="text-green-600 hover:text-green-800">
                                        <i class="fas fa-image"></i> View Image
                                    </button>
                                <?php endif; ?>
                            </div>
                            <p class="text-gray-700 mb-4"><?php echo nl2br(htmlspecialchars($feedback['message'])); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </section>
    </main>
    
    <!-- Image Modal -->
    <div id="image-modal" class="fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center hidden">
        <div class="relative bg-white rounded-lg max-w-4xl w-full mx-4 p-4 animate__animated animate__zoomIn">
            <button onclick="closeImageModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                <i class="fas fa-times text-2xl"></i>
            </button>
            <img id="modal-image" src="" alt="Feedback Image" class="w-full h-auto max-h-[80vh] object-contain rounded">
        </div>
    </div>
    
    <!-- Floating Elements for Decoration -->
    <div class="fixed top-20 left-10 w-16 h-16 bg-white/30 rounded-full blur-xl animate-pulse hidden md:block"></div>
    <div class="fixed bottom-1/4 right-20 w-24 h-24 bg-green-200/30 rounded-full blur-xl animate-pulse hidden md:block"></div>
    <div class="fixed top-1/3 right-1/4 w-20 h-20 bg-teal-200/30 rounded-full blur-xl animate-pulse hidden md:block"></div>
    
    <script>
        // Mobile menu toggle
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Image preview functionality
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('image-preview');
        const previewImage = document.getElementById('preview-image');
        const removeImage = document.getElementById('remove-image');
        
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    imagePreview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
        
        removeImage.addEventListener('click', function() {
            imageInput.value = '';
            previewImage.src = '';
            imagePreview.classList.add('hidden');
        });
        
        // Image modal functionality
        function toggleImageModal(imageSrc) {
            const modal = document.getElementById('image-modal');
            const modalImage = document.getElementById('modal-image');
            
            modalImage.src = imageSrc;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
        
        function closeImageModal() {
            const modal = document.getElementById('image-modal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }
        
        // Close modal when clicking outside
        document.getElementById('image-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeImageModal();
            }
        });
        
        // Add ripple effect to buttons
        document.querySelectorAll('.ripple').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const x = e.clientX - e.target.getBoundingClientRect().left;
                const y = e.clientY - e.target.getBoundingClientRect().top;
                
                const ripples = document.createElement('span');
                ripples.style.left = x + 'px';
                ripples.style.top = y + 'px';
                this.appendChild(ripples);
                
                setTimeout(() => {
                    ripples.remove();
                }, 1000);
                
                // Submit form if this is the submit button
                if (this.type === 'submit') {
                    this.form.submit();
                }
            });
        });
        
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>