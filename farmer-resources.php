<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Resources | FarmTech Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        /* Copy all the relevant CSS styles from your main file */

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
        .tech-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
            transform-style: preserve-3d;
        }
        
        .tech-card:hover {
            transform: translateY(-10px) rotateY(10deg);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        .tech-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #3b82f6, #8b5cf6);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.6s ease;
        }
        
        .tech-card:hover::before {
            transform: scaleX(1);
        }
        
        .compliance-card {
            background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
            border: 1px solid rgba(134, 239, 172, 0.5);
            transition: all 0.4s ease;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        
        .compliance-card:hover {
            background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
            transform: translateY(-5px) scale(1.02);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
        
        .equipment-card {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border: 1px solid rgba(110, 231, 183, 0.5);
            transition: all 0.4s ease;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            perspective: 1000px;
        }
        
        .equipment-card:hover {
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
        .tech-img-container {
            position: relative;
            overflow: hidden;
            border-radius: 0.75rem;
        }
        
        .tech-img-container img {
            transition: all 0.6s ease;
        }
        
        .tech-img-container:hover img {
            transform: scale(1.1) rotate(2deg);
        }
        
        .tech-overlay {
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
        
        .tech-img-container:hover .tech-overlay {
            opacity: 1;
        }
        
        /* Floating Elements */
        .floating-element {
            animation: float 6s ease-in-out infinite;
            filter: drop-shadow(0 10px 8px rgba(0, 0, 0, 0.1));
        }

        .resource-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            background: white;
            border-radius: 1rem;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            position: relative;
        }

        .resource-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .resource-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #4f46e5, #7c3aed);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s ease;
        }

        .resource-card:hover::before {
            transform: scaleX(1);
        }

        .resource-icon {
            transition: all 0.4s ease;
        }

        .resource-card:hover .resource-icon {
            transform: rotate(10deg) scale(1.1);
            color: #4f46e5;
        }

        .resource-card:hover {
            box-shadow: 0 0 25px rgba(79, 70, 229, 0.3);
        }

        .quality-card {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            border: 1px solid rgba(147, 197, 253, 0.5);
            transition: all 0.4s ease;
        }

        .quality-card:hover {
            background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(59, 130, 246, 0.2);
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .pulse-animate {
            animation: pulse 2s infinite;
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .float-animate {
            animation: float 6s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-50 to-purple-50">
    <!-- Navigation (same as your main page) -->
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

    <!-- Main Content - Farmer Resources -->
    <main class="pt-20">
        <div class="container mx-auto px-4 py-12">


            <!-- Hero Section -->
            <div class="text-center mb-16 animate__animated animate__fadeIn">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
                    <span class="gradient-underline">Farmer Resources Hub</span>
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Advanced tools and resources to enhance your food processing operations, ensure compliance, 
                    and maximize product value.
                </p>
                <div class="mt-8 flex justify-center">
                    <div class="relative w-64 h-64 floating-element">
                        <img src="https://media.istockphoto.com/id/1267793786/photo/immigrant-farm-workers.jpg?s=612x612&w=0&k=20&c=xzMMspbaUiCJT2disGgLD5hNwctL7vyK2YaZ8CCHhcI=" 
                             alt="Food Processing" 
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

            <!-- Knowledge Sharing Section -->
            <div class="mb-16 animate__animated animate__fadeIn">
                <h2 class="text-3xl font-bold text-gray-800 mb-8 relative inline-block">
                    Knowledge Sharing
                    <span class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-indigo-500 to-purple-600 rounded-full"></span>
                </h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Articles Card -->
                    <div class="resource-card p-6 group">
                        <div class="resource-icon w-14 h-14 bg-indigo-100 rounded-full flex items-center justify-center mb-4 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-gray-800">Articles</h3>
                        <p class="text-gray-600 mb-4">In-depth articles on modern farming techniques, crop management, and sustainable practices.</p>
                        <button class="text-indigo-600 font-semibold hover:underline flex items-center">
                            <a href="farmer-articles.html">Explore Articles</a>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    <!-- Tutorials Card -->
                    <div class="resource-card p-6 group">
                        <div class="resource-icon w-14 h-14 bg-green-100 rounded-full flex items-center justify-center mb-4 text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-gray-800">Tutorials</h3>
                        <p class="text-gray-600 mb-4">Step-by-step guides for implementing new technologies and farming methods.</p>
                        <button class="text-green-600 font-semibold hover:underline flex items-center">
                            <a href="farmers-tutorials.html">View Tutorials</a>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    <!-- Videos Card -->
                    <div class="resource-card p-6 group">
                        <div class="resource-icon w-14 h-14 bg-purple-100 rounded-full flex items-center justify-center mb-4 text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-gray-800">Videos</h3>
                        <p class="text-gray-600 mb-4">Visual demonstrations and expert interviews covering all aspects of modern farming.</p>
                        <button class="text-purple-600 font-semibold hover:underline flex items-center">
                            <a href="farmers-videos.html">Watch Videos</a>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Marketplace Links Section -->
            <div class="mb-16 animate__animated animate__fadeIn">
                <h2 class="text-3xl font-bold text-gray-800 mb-8 relative inline-block">
                    Marketplace Links
                    <span class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-green-500 to-teal-600 rounded-full"></span>
                </h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Local Markets Card -->
                    <div class="resource-card p-6 group">
                        <div class="resource-icon w-14 h-14 bg-blue-100 rounded-full flex items-center justify-center mb-4 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-gray-800">Local Markets</h3>
                        <p class="text-gray-600 mb-4">Direct links to nearby markets with real-time pricing and demand information.</p>
                        <button class="text-blue-600 font-semibold hover:underline flex items-center">
                            <a href="marketplace-links.html">Find Markets</a>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    <!-- Buyers Network Card -->
                    <div class="resource-card p-6 group">
                        <div class="resource-icon w-14 h-14 bg-yellow-100 rounded-full flex items-center justify-center mb-4 text-yellow-600 group-hover:bg-yellow-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-gray-800">Buyers Network</h3>
                        <p class="text-gray-600 mb-4">Connect directly with wholesale buyers and food processors in your region.</p>
                        <button class="text-yellow-600 font-semibold hover:underline flex items-center">
                            <a href="buyers-network.html">Connect Now</a>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    <!-- Cooperatives Card -->
                    <div class="resource-card p-6 group">
                        <div class="resource-icon w-14 h-14 bg-red-100 rounded-full flex items-center justify-center mb-4 text-red-600 group-hover:bg-red-600 group-hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-gray-800">Cooperatives</h3>
                        <p class="text-gray-600 mb-4">Join or create farmer cooperatives to increase bargaining power and resources.</p>
                        <button class="text-red-600 font-semibold hover:underline flex items-center">
                            Explore Co-ops
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Quality Assessment Tools Section -->
            <div class="animate__animated animate__fadeIn">
                <h2 class="text-3xl font-bold text-gray-800 mb-8 relative inline-block">
                    Quality Assessment Tools
                    <span class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-teal-500 to-blue-600 rounded-full"></span>
                </h2>
                <div class="quality-card p-8 rounded-xl shadow-md">
                    <div class="grid md:grid-cols-2 gap-8 items-center">
                        <div>
                            <h3 class="text-2xl font-bold mb-4 text-gray-800">Produce Quality Evaluator</h3>
                            <p class="text-gray-600 mb-6 leading-relaxed">
                                Our comprehensive quality assessment tools help you evaluate your harvest against industry standards. 
                                Get instant feedback on moisture content, color grading, size classification, and more to maximize 
                                your produce value.
                            </p>
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center mr-3 text-teal-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="text-gray-700">Moisture Content</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center mr-3 text-teal-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="text-gray-700">Color Grading</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center mr-3 text-teal-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="text-gray-700">Size Classification</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center mr-3 text-teal-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="text-gray-700">Defect Detection</span>
                                </div>
                            </div>
                            <button class="bg-gradient-to-r from-teal-500 to-blue-600 text-white px-6 py-3 rounded-lg hover:opacity-90 transition-all flex items-center float-animate">
                                <a href="quality assesment .html">Start Quality Assessment</a>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </button>
                        </div>
                        <div class="relative h-64 md:h-80 rounded-lg overflow-hidden">
                            <img src="https://images.unsplash.com/photo-1605000797499-95a51c5269ae?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80" 
                                 alt="Quality assessment" 
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-6">
                                <span class="text-white font-medium">Real-time quality analysis dashboard</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer (same as your main page) -->
    <footer class="bg-gray-800 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">FarmTech Hub</h3>
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
       
        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                // Check if the link is to a section on the same page
                if (this.getAttribute('href').startsWith('#')) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('href');
                    const targetElement = document.querySelector(targetId);
                    
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                }
                // If it's a link to another page (like index.php#section), let it follow normally
            });
        });
    </script>
</body>
</html>