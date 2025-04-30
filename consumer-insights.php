<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>For Consumers | FarmTech Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        /* Custom Animations */
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        @keyframes wave {
            0% { transform: rotate(0deg); }
            25% { transform: rotate(5deg); }
            50% { transform: rotate(0deg); }
            75% { transform: rotate(-5deg); }
            100% { transform: rotate(0deg); }
        }
        
        .float-animate {
            animation: float 6s ease-in-out infinite;
        }
        .pulse-animate {
            animation: pulse 3s ease infinite;
        }
        .wave-animate {
            animation: wave 4s ease infinite;
        }
        .rotate-animate {
            animation: spin 8s linear infinite;
        }
        
        /* Card Styles */
        .edu-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
        }
        
        .edu-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        .recipe-card {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border: 1px solid rgba(134, 239, 172, 0.5);
            transition: all 0.4s ease;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .recipe-card:hover {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            transform: translateY(-5px) scale(1.02);
        }
        
        .feedback-card {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border: 1px solid rgba(110, 231, 183, 0.5);
            transition: all 0.4s ease;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .feedback-card:hover {
            transform: rotateX(5deg) rotateY(5deg);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        /* Gradient Underlines */
        .gradient-underline {
            position: relative;
            display: inline-block;
        }
        
        .gradient-underline::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 100%;
            height: 4px;
            border-radius: 2px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
        }
        
        /* Image Hover Effects */
        .edu-img-container {
            position: relative;
            overflow: hidden;
            border-radius: 0.75rem;
        }
        
        .edu-img-container img {
            transition: all 0.6s ease;
        }
        
        .edu-img-container:hover img {
            transform: scale(1.1);
        }
        
        .edu-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(59, 130, 246, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.4s ease;
        }
        
        .edu-img-container:hover .edu-overlay {
            opacity: 1;
        }
        
        /* Floating Elements */
        .floating-element {
            animation: float 6s ease-in-out infinite;
            filter: drop-shadow(0 10px 8px rgba(0, 0, 0, 0.1));
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-purple-50">
    <!-- Navigation -->
    <nav class="fixed w-full bg-white shadow-md z-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-16">
            <div class="flex items-center">
                <a href="index.php"><span class="text-2xl font-bold text-indigo-600">FarmTech Hub</span></a>
            </div>
            
            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-8">
                <a href="index.php" class="nav-link text-gray-600 hover:text-indigo-600">Home</a>
                <a href="index.php#about" class="nav-link text-gray-600 hover:text-indigo-600">About</a>
                <a href="index.php#services" class="nav-link text-gray-600 hover:text-indigo-600">Services</a>
                <a href="index.php#blog" class="nav-link text-gray-600 hover:text-indigo-600">Blog</a>
                
                <?php if (isset($_SESSION['user_id'])): ?>
                    <!-- Show user info when logged in -->
                    <div class="flex items-center space-x-4">
                        <?php if (!empty($_SESSION['profile_image'])): ?>
                            <img src="<?php echo htmlspecialchars($_SESSION['profile_image']); ?>" 
                                 alt="Profile" class="w-8 h-8 rounded-full object-cover">
                        <?php endif; ?>
                        <span class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-4 py-2 rounded-lg hover:opacity-90 transition-all">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                        <a href="logout.php" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">Logout</a>
                    </div>
                <?php else: ?>
                    <!-- Show login/signup when not logged in -->
                    <a href="login.php" class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-4 py-2 rounded-lg hover:opacity-90 transition-all">Login</a>
                    <a href="signup.php" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">Sign Up</a>
                <?php endif; ?>
            </div>

            <!-- Mobile menu button -->
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
        <a href="index.php" class="block nav-link text-gray-600 hover:text-indigo-600">Home</a>
        <a href="index.php#about" class="block nav-link text-gray-600 hover:text-indigo-600">About</a>
        <a href="index.php#services" class="block nav-link text-gray-600 hover:text-indigo-600">Services</a>
        <a href="index.php#blog" class="block nav-link text-gray-600 hover:text-indigo-600">Blog</a>
        
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="flex flex-col space-y-2">
                <div class="flex items-center space-x-2">
                    <?php if (!empty($_SESSION['profile_image'])): ?>
                        <img src="<?php echo htmlspecialchars($_SESSION['profile_image']); ?>" 
                             alt="Profile" class="w-8 h-8 rounded-full object-cover">
                    <?php endif; ?>
                    <span class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-4 py-2 rounded-lg hover:opacity-90 transition-all">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                </div>
                <a href="logout.php" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors text-center">Logout</a>
            </div>
        <?php else: ?>
            <a href="login.php" class="block bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-4 py-2 rounded-lg hover:opacity-90 transition-all text-center">Login</a>
            <a href="signup.php" class="block bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors text-center">Sign Up</a>
        <?php endif; ?>
    </div>
</div>

    <!-- Main Content - For Consumers -->
    <main class="pt-20">
        <div class="container mx-auto px-4 py-12">
            <!-- Hero Section -->
            <div class="text-center mb-16 animate__animated animate__fadeIn">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
                    <span class="gradient-underline">For Consumers</span>
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Learn about food quality, discover delicious recipes, and connect directly with the producers of your food.
                </p>
                <div class="mt-8 flex justify-center">
                    <div class="relative w-64 h-64 floating-element">
                        <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" 
                             alt="Fresh produce market" 
                             class="w-full h-full object-cover rounded-xl shadow-xl">
                        <div class="absolute -bottom-4 -right-4 bg-white p-2 rounded-full shadow-lg">
                            <div class="w-12 h-12 bg-indigo-600 rounded-full flex items-center justify-center text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Educational Content Section -->
            <div class="mb-16 animate__animated animate__fadeIn">
                <h2 class="text-3xl font-bold text-gray-800 mb-8 relative inline-block">
                    <span class="gradient-underline">Educational Content</span>
                </h2>
                <p class="text-gray-600 mb-8 max-w-3xl">
                    Information on food quality, nutritional benefits, and how to identify fresh produce.
                </p>
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Food Quality Card -->
                    <div class="edu-card p-6 group animate__animated animate__fadeInLeft">
                        <div class="edu-img-container mb-4">
                            <img src="https://images.unsplash.com/photo-1606787366850-de6330128bfc?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" 
                                 alt="Food Quality" 
                                 class="w-full h-48 object-cover">
                            <div class="edu-overlay">
                                <span class="text-white text-lg font-semibold">Learn More</span>
                            </div>
                        </div>
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Food Quality Guide</h3>
                        </div>
                        <p class="text-gray-600 mb-4">Learn how to identify fresh, high-quality produce and understand quality grading systems.</p>
                        <button class="text-blue-600 font-semibold hover:underline flex items-center group-hover:text-blue-700 transition-colors">
                            <a href="food-quality-guide.html">Read Guide</a>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    <!-- Nutritional Benefits Card -->
                    <div class="edu-card p-6 group animate__animated animate__fadeInUp">
                        <div class="edu-img-container mb-4">
                            <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" 
                                 alt="Nutritional Benefits" 
                                 class="w-full h-48 object-cover">
                            <div class="edu-overlay">
                                <span class="text-white text-lg font-semibold">Learn More</span>
                            </div>
                        </div>
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3 text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Nutritional Benefits</h3>
                        </div>
                        <p class="text-gray-600 mb-4">Discover the health benefits of fresh produce and how to maximize nutritional value.</p>
                        <button class="text-green-600 font-semibold hover:underline flex items-center group-hover:text-green-700 transition-colors">
                            <a href="nutritional-guide.html">Explore Benefits</a>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    <!-- Fresh Produce Card -->
                    <div class="edu-card p-6 group animate__animated animate__fadeInRight">
                        <div class="edu-img-container mb-4">
                            <img src="https://images.unsplash.com/photo-1518843875459-f738682238a6?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" 
                                 alt="Fresh Produce" 
                                 class="w-full h-48 object-cover">
                            <div class="edu-overlay">
                                <span class="text-white text-lg font-semibold">Learn More</span>
                            </div>
                        </div>
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3 text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Fresh Produce Guide</h3>
                        </div>
                        <p class="text-gray-600 mb-4">Tips for selecting, storing, and preparing fresh produce to maintain quality and flavor.</p>
                        <button class="text-purple-600 font-semibold hover:underline flex items-center group-hover:text-purple-700 transition-colors">
                            <a href="fresh-produce-guide.html">View Tips</a>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Recipes and Usage Tips Section -->
            <div class="mb-16 animate__animated animate__fadeIn">
                <h2 class="text-3xl font-bold text-gray-800 mb-8 relative inline-block">
                    <span class="gradient-underline">Recipes and Usage Tips</span>
                </h2>
                <p class="text-gray-600 mb-8 max-w-3xl">
                    Creative ideas for using processed or preserved foods in your daily cooking.
                </p>
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Seasonal Recipes Card -->
                    <div class="recipe-card p-6 group animate__animated animate__fadeInLeft">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center mr-4 text-orange-600 group-hover:bg-orange-600 group-hover:text-white transition-colors pulse-animate">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Seasonal Recipes</h3>
                        </div>
                        <p class="text-gray-600 mb-4">Delicious recipes using seasonal produce to enjoy fresh flavors year-round.</p>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-orange-500 rounded-full mr-2"></div>
                                <span class="text-gray-700 text-sm">Spring vegetable stir-fry</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-orange-500 rounded-full mr-2"></div>
                                <span class="text-gray-700 text-sm">Summer fruit salads</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-orange-500 rounded-full mr-2"></div>
                                <span class="text-gray-700 text-sm">Winter squash soups</span>
                            </div>
                        </div>
                    </div>

                    <!-- Preserved Foods Card -->
                    <div class="recipe-card p-6 group animate__animated animate__fadeInUp">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center mr-4 text-red-600 group-hover:bg-red-600 group-hover:text-white transition-colors wave-animate">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Preserved Foods</h3>
                        </div>
                        <p class="text-gray-600 mb-4">Creative ways to use canned, dried, and fermented foods in your meals.</p>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                                <span class="text-gray-700 text-sm">Canned tomato sauces</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                                <span class="text-gray-700 text-sm">Dried fruit snacks</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                                <span class="text-gray-700 text-sm">Fermented vegetable dishes</span>
                            </div>
                        </div>
                    </div>

                    <!-- Cooking Techniques Card -->
                    <div class="recipe-card p-6 group animate__animated animate__fadeInRight">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mr-4 text-yellow-600 group-hover:bg-yellow-600 group-hover:text-white transition-colors rotate-animate">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Cooking Techniques</h3>
                        </div>
                        <p class="text-gray-600 mb-4">Methods to preserve nutrients and enhance flavors when cooking produce.</p>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></div>
                                <span class="text-gray-700 text-sm">Blanching vegetables</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></div>
                                <span class="text-gray-700 text-sm">Slow cooking methods</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></div>
                                <span class="text-gray-700 text-sm">Raw food preparation</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feedback Mechanism Section -->
            <div class="animate__animated animate__fadeIn">
                <h2 class="text-3xl font-bold text-gray-800 mb-8 relative inline-block">
                    <span class="gradient-underline">Feedback Mechanism</span>
                </h2>
                <p class="text-gray-600 mb-8 max-w-3xl">
                    Share your experience, report quality issues, or provide suggestions directly to farmers and processors.
                </p>
                <div class="feedback-card p-8 rounded-xl">
                    <div class="grid md:grid-cols-2 gap-8 items-center">
                        <div>
                            <h3 class="text-2xl font-bold mb-4 text-gray-800">Connect With Producers</h3>
                            <p class="text-gray-600 mb-6 leading-relaxed">
                                Your feedback helps improve food quality and farming practices. Share your thoughts about 
                                the products you've purchased, report any quality concerns, or suggest improvements 
                                directly to the producers.
                            </p>
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center mr-3 text-teal-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="text-gray-700">Quality Reports</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center mr-3 text-teal-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="text-gray-700">Product Suggestions</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center mr-3 text-teal-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="text-gray-700">Farmer Messages</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center mr-3 text-teal-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="text-gray-700">Recipe Ideas</span>
                                </div>
                            </div>
                            <button class="bg-gradient-to-r from-teal-500 to-blue-600 text-white px-6 py-3 rounded-lg hover:opacity-90 transition-all flex items-center float-animate">
                                <a href="feedback.php">Share Feedback</a>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                            </button>
                        </div>
                        <div class="relative h-64 md:h-80 rounded-lg overflow-hidden shadow-lg">
                            <img src="https://images.unsplash.com/photo-1521791136064-7986c2920216?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80" 
                                 alt="Consumer providing feedback" 
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-6">
                                <span class="text-white font-medium">Your feedback helps improve food quality</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <a href="index.php"><h3 class="text-xl font-bold mb-4">FarmTech Hub</h3></a>
                    <p class="text-gray-400">Connecting the agricultural ecosystem through technology and innovation.</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="index.php" class="text-gray-400 hover:text-white">Home</a></li>
                        <li><a href="index.php#about" class="text-gray-400 hover:text-white">About</a></li>
                        <li><a href="index.php#services" class="text-gray-400 hover:text-white">Services</a></li>
                        <li><a href="index.php#blog" class="text-gray-400 hover:text-white">Blog</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Contact</h4>
                    <p class="text-gray-400">info@farmtechhub.com</p>
                    <p class="text-gray-400">+1 (555) 123-4567</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Subscribe</h4>
                    <p class="text-gray-400 mb-2">Stay updated with our newsletter</p>
                    <div class="flex">
                        <input type="email" placeholder="Your email" class="px-4 py-2 rounded-l-lg w-full">
                        <button class="bg-green-600 text-white px-4 py-2 rounded-r-lg hover:bg-green-700 transition-colors">Subscribe</button>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2023 FarmTech Hub. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
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

        // Modal handling (if needed)
       
    </script>
</body>
</html>