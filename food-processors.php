<?php
session_start();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Processors | FarmTech Hub</title>
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

    <!-- Main Content - Food Processors -->
    <main class="pt-20">
        <div class="container mx-auto px-4 py-12">
            <!-- Hero Section -->
            <div class="text-center mb-16 animate__animated animate__fadeIn">
                <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-6">
                    <span class="gradient-underline">Food Processors Hub</span>
                </h1>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Advanced tools and resources to enhance your food processing operations, ensure compliance, 
                    and maximize product value.
                </p>
                <div class="mt-8 flex justify-center">
                    <div class="relative w-64 h-64 floating-element">
                        <img src="https://images.unsplash.com/photo-1550583724-b2692b85b150?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" 
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

            <!-- Value-Addition Techniques Section -->
            <div class="mb-16 animate__animated animate__fadeIn">
                <h2 class="text-3xl font-bold text-gray-800 mb-8 relative inline-block">
                    <span class="gradient-underline">Value-Addition Techniques</span>
                </h2>
                <p class="text-gray-600 mb-8 max-w-3xl">
                    Resources on processing methods to enhance shelf life and marketability of your products.
                </p>
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Drying Techniques Card -->
                    <div class="tech-card p-6 group animate__animated animate__fadeInLeft">
                        <div class="tech-img-container mb-4">
                            <img src="https://images.unsplash.com/photo-1606787366850-de6330128bfc?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" 
                                 alt="Drying Techniques" 
                                 class="w-full h-48 object-cover">
                            <div class="tech-overlay">
                                <span class="text-white text-lg font-semibold">Learn More</span>
                            </div>
                        </div>
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-3 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Drying Techniques</h3>
                        </div>
                        <p class="text-gray-600 mb-4">Modern methods for dehydrating foods while preserving nutrients and flavor.</p>
                        <button class="text-blue-600 font-semibold hover:underline flex items-center group-hover:text-blue-700 transition-colors">
                            <a href="drying method.html">Explore Techniques</a>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    <!-- Canning Methods Card -->
                    <div class="tech-card p-6 group animate__animated animate__fadeInUp">
                        <div class="tech-img-container mb-4">
                            <img src="https://images.unsplash.com/photo-1606787366850-de6330128bfc?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" 
                                 alt="Canning Methods" 
                                 class="w-full h-48 object-cover">
                            <div class="tech-overlay">
                                <span class="text-white text-lg font-semibold">Learn More</span>
                            </div>
                        </div>
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-3 text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Canning Methods</h3>
                        </div>
                        <p class="text-gray-600 mb-4">Safe and effective canning processes for long-term preservation.</p>
                        <button class="text-purple-600 font-semibold hover:underline flex items-center group-hover:text-purple-700 transition-colors">
                            <a href="canning method.html">View Methods</a>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>

                    <!-- Fermentation Card -->
                    <div class="tech-card p-6 group animate__animated animate__fadeInRight">
                        <div class="tech-img-container mb-4">
                            <img src="https://images.unsplash.com/photo-1606787366850-de6330128bfc?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" 
                                 alt="Fermentation Processes" 
                                 class="w-full h-48 object-cover">
                            <div class="tech-overlay">
                                <span class="text-white text-lg font-semibold">Learn More</span>
                            </div>
                        </div>
                        <div class="flex items-center mb-3">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-3 text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Fermentation</h3>
                        </div>
                        <p class="text-gray-600 mb-4">Traditional and modern fermentation techniques for value-added products.</p>
                        <button class="text-green-600 font-semibold hover:underline flex items-center group-hover:text-green-700 transition-colors">
                            <a href="farmentation.html">Discover Processes</a>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Regulatory Compliance Section -->
            <div class="mb-16 animate__animated animate__fadeIn">
                <h2 class="text-3xl font-bold text-gray-800 mb-8 relative inline-block">
                    <span class="gradient-underline">Regulatory Compliance</span>
                </h2>
                <p class="text-gray-600 mb-8 max-w-3xl">
                    Essential information on food safety standards, packaging requirements, and certifications.
                </p>
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Food Safety Standards Card -->
                    <div class="compliance-card p-6 group animate__animated animate__fadeInLeft">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-4 text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors pulse-animate">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Food Safety Standards</h3>
                        </div>
                        <p class="text-gray-600 mb-4">Comprehensive guides to national and international food safety regulations.</p>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                <span class="text-gray-700 text-sm">HACCP Guidelines</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                <span class="text-gray-700 text-sm">GMP Requirements</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                <span class="text-gray-700 text-sm">Sanitation Protocols</span>
                            </div>
                        </div>
                    </div>

                    <!-- Packaging Requirements Card -->
                    <div class="compliance-card p-6 group animate__animated animate__fadeInUp">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center mr-4 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors wave-animate">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Packaging Requirements</h3>
                        </div>
                        <p class="text-gray-600 mb-4">Regulations and best practices for food packaging and labeling.</p>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mr-2"></div>
                                <span class="text-gray-700 text-sm">Labeling Laws</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mr-2"></div>
                                <span class="text-gray-700 text-sm">Material Safety</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mr-2"></div>
                                <span class="text-gray-700 text-sm">Sustainability Standards</span>
                            </div>
                        </div>
                    </div>

                    <!-- Certifications Card -->
                    <div class="compliance-card p-6 group animate__animated animate__fadeInRight">
                        <div class="flex items-center mb-4">
                            <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center mr-4 text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors rotate-animate">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-gray-800">Certifications</h3>
                        </div>
                        <p class="text-gray-600 mb-4">Guidance on obtaining industry certifications and audits.</p>
                        <div class="space-y-2">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-purple-500 rounded-full mr-2"></div>
                                <span class="text-gray-700 text-sm">Organic Certification</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-purple-500 rounded-full mr-2"></div>
                                <span class="text-gray-700 text-sm">ISO Standards</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-purple-500 rounded-full mr-2"></div>
                                <span class="text-gray-700 text-sm">Third-Party Audits</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Equipment and Technology Section -->
            <div class="animate__animated animate__fadeIn">
                <h2 class="text-3xl font-bold text-gray-800 mb-8 relative inline-block">
                    <span class="gradient-underline">Equipment and Technology</span>
                </h2>
                <p class="text-gray-600 mb-8 max-w-3xl">
                    Listings and reviews of post-harvest technologies and machinery to streamline your operations.
                </p>
                <div class="equipment-card p-8 rounded-xl">
                    <div class="grid md:grid-cols-2 gap-8 items-center">
                        <div>
                            <h3 class="text-2xl font-bold mb-4 text-gray-800">Advanced Processing Equipment</h3>
                            <p class="text-gray-600 mb-6 leading-relaxed">
                                Discover cutting-edge machinery and technologies to enhance your processing efficiency, 
                                reduce waste, and improve product quality. Our curated selection includes equipment 
                                reviews, vendor comparisons, and technology adoption guides.
                            </p>
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center mr-3 text-teal-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="text-gray-700">Sorting Machines</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center mr-3 text-teal-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="text-gray-700">Packaging Systems</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center mr-3 text-teal-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="text-gray-700">Preservation Tech</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-8 h-8 bg-teal-100 rounded-full flex items-center justify-center mr-3 text-teal-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <span class="text-gray-700">Quality Scanners</span>
                                </div>
                            </div>
                            <button class="bg-gradient-to-r from-teal-500 to-blue-600 text-white px-6 py-3 rounded-lg hover:opacity-90 transition-all flex items-center float-animate">
                               <a href="advanced-processing-equippment.html"> Browse Equipment</a>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </button>
                        </div>
                        <div class="relative h-64 md:h-80 rounded-lg overflow-hidden shadow-lg">
                            <img src="https://media.istockphoto.com/id/1490311871/photo/asian-chinese-female-juice-factory-worker-tighten-bottle-cap-in-production-line.webp?a=1&b=1&s=612x612&w=0&k=20&c=ZDnqmCpbqHl1RuI7gXUuPaX9BDWvr623-0SZ3SxgnDA=" 
                                 alt="Food processing equipment" 
                                 class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent flex items-end p-6">
                                <span class="text-white font-medium">State-of-the-art food processing equipment</span>
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
       
    </script>
</body>
</html>