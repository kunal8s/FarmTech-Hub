<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FarmTech Hub</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>

        .about-card {
            transition: all 0.3s ease;
            background: linear-gradient(145deg, #ffffff, #f8fafc);
            border-radius: 1rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .about-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .parallax-img {
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }

        /* Blog Detail Pages */
        .blog-detail {
            display: none;
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .blog-active {
            display: block;
            opacity: 1;
        }

        .blog-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .back-button {
            transition: all 0.3s ease;
        }

        .back-button:hover {
            transform: translateX(-5px);
        }

        .section {
            min-height: 100vh;
            padding: 2rem;
            scroll-margin-top: 4rem;
        }
        
        /* Image hover effects */
        .service-img-container, .blog-img-container {
            position: relative;
            overflow: hidden;
            border-radius: 0.5rem;
        }
        
        .service-img-container img, .blog-img-container img {
            transition: all 0.5s ease;
        }
        
        .service-img-container:hover img, .blog-img-container:hover img {
            transform: scale(1.05);
        }
        
        .img-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(94, 114, 228, 0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .service-img-container:hover .img-overlay, 
        .blog-img-container:hover .img-overlay {
            opacity: 1;
        }
        
        .view-icon {
            color: white;
            font-size: 2rem;
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.3s ease 0.1s;
        }
        
        .service-img-container:hover .view-icon,
        .blog-img-container:hover .view-icon {
            opacity: 1;
            transform: translateY(0);
        }
        
        /* Hero image animation */
        .hero-image {
            position: relative;
            overflow: hidden;
            border-radius: 0.5rem;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        .hero-image img {
            transition: transform 10s ease;
        }
        
        .hero-image:hover img {
            transform: scale(1.1);
        }
        
        .hero-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0) 100%);
            padding: 2rem;
            color: white;
        }
        
        .hero-text {
            transform: translateY(20px);
            opacity: 0;
            transition: all 0.5s ease;
        }
        
        .hero-image:hover .hero-text {
            transform: translateY(0);
            opacity: 1;
        }

        /* --- New Background Gradient Styling for Full Page Scrolling --- */
        html, body {
            min-height: 100%;
        }
        
        /* This rule overrides the Tailwind background classes applied on the body element */
        body {
            /* The gradient below is set to exactly match the image gradient with:
               a 45deg angle and color stops from peach (#FAD7CD) to soft lavender (#E2D9F5) */
            background: linear-gradient(45deg, #FAD7CD 0%, #FADDE8 33%, #F0DDF4 66%, #E2D9F5 100%) !important;
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
        }

        /* Farmer Resources Card Styles */
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

        /* Glow effect on hover */
        .resource-card:hover {
            box-shadow: 0 0 25px rgba(79, 70, 229, 0.3);
        }

        .service-card a {
    display: block;
    color: inherit; /* Keeps text color consistent */
    text-decoration: none; /* Removes underline */
}

.service-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
}

        /* Quality Assessment Card */
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

        /* Pulse animation for important elements */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }

        .pulse-animate {
            animation: pulse 2s infinite;
        }

        /* Floating animation */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .float-animate {
            animation: float 6s ease-in-out infinite;
        }

        .about-card {
            transition: all 0.3s ease;
            background: linear-gradient(145deg, #ffffff, #f8fafc);
            border-radius: 1rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }
        /* ... rest of your CSS styles ... */
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
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#home" class="nav-link text-gray-600 hover:text-indigo-600">Home</a>
                    <a href="#about" class="nav-link text-gray-600 hover:text-indigo-600">About</a>
                    <a href="#services" class="nav-link text-gray-600 hover:text-indigo-600">Services</a>
                    <a href="#blog" class="nav-link text-gray-600 hover:text-indigo-600">Blog</a>

                    
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <div class="flex items-center space-x-4">
                            <a href="dashboard.php" class="nav-link text-gray-600 hover:text-indigo-600 ">Dashboard</a>
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

    <!-- Rest of your index.html content remains the same -->
    <!-- ... -->
     <div id="mobile-menu" class="md:hidden fixed w-full bg-white shadow-md hidden pt-16">
        <div class="px-4 py-2 space-y-4">
            <a href="#home" class="block nav-link text-gray-600 hover:text-indigo-600">Home</a>
            <a href="#about" class="block nav-link text-gray-600 hover:text-indigo-600">About</a>
            <a href="#services" class="block nav-link text-gray-600 hover:text-indigo-600">Services</a>
            <a href="#blog" class="block nav-link text-gray-600 hover:text-indigo-600">Blog</a>
            <button onclick="showLogin()" class="block w-full text-left bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-4 py-2 rounded-lg">Login</button>
            <button onclick="showSignup()" class="block w-full text-left bg-gray-200 text-gray-700 px-4 py-2 rounded-lg">Sign Up</button>
        </div>
    </div>

    <main>

    <!-- Rest of your index.html content -->
    <!-- Home Section -->
    <section id="home" class="section pt-20">
        <!-- ... -->
        <div class="container mx-auto px-4">
            <div class="hero-image animate__animated animate__fadeIn">
                <img src="https://images.unsplash.com/photo-1500382017468-9049fed747ef?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" 
                     alt="Farm landscape with crops" 
                     class="w-full h-auto max-h-[600px] object-cover">
                <div class="hero-overlay">
                    <div class="hero-text">
                        <h1 class="text-5xl font-bold text-white mb-4">Welcome to FarmTech Hub</h1>
                        <p class="text-xl text-gray-200 mb-6">Connecting Farmers, Processors, and Consumers</p>
                        <button class="bg-gradient-to-r from-indigo-500 to-purple-600 text-white px-6 py-3 rounded-lg hover:opacity-90 transition-all">
                            <a href="#about" class="block">Explore Our Platform</a>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="section bg-white">
        <!-- ... -->
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-gray-800 mb-8 animate__animated animate__fadeIn">About Us</h2>
            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div class="space-y-8">
                    <div class="about-card p-6 animate__animated animate__fadeInLeft">
                        <p class="text-gray-600 leading-relaxed text-lg">
                            FarmTech Hub is a comprehensive platform connecting all stakeholders in the agricultural value chain. 
                            We provide innovative solutions for post-harvest management, quality assessment, and value addition.
                        </p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="about-card p-6 animate__animated animate__fadeInUp">
                            <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold mb-2">Fast Connectivity</h3>
                            <p class="text-gray-600">Instant access to markets and resources</p>
                        </div>
                        <div class="about-card p-6 animate__animated animate__fadeInUp animate-delay-1">
                            <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold mb-2">Secure Platform</h3>
                            <p class="text-gray-600">Protected transactions and data</p>
                        </div>
                    </div>
                </div>
                <div class="relative h-96 rounded-xl overflow-hidden parallax-img" 
                     style="background-image: url('https://images.unsplash.com/photo-1605000797499-95a51c5269ae?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80')">
                    <div class="absolute inset-0 bg-black bg-opacity-30 flex items-center justify-center">
                        <h3 class="text-3xl text-white font-bold animate__animated animate__fadeIn">Join Our Growing Community</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section id="services" class="section bg-gradient-to-br from-blue-50 to-purple-50">
        <!-- ... -->
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-gray-800 mb-8">Our Services</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Farmer Resources Card -->
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow service-card">
                    <a href="farmer-resources.php" class="block">
                        <div class="service-img-container">
                            <img src="https://media.istockphoto.com/id/1267793786/photo/immigrant-farm-workers.jpg?s=612x612&w=0&k=20&c=xzMMspbaUiCJT2disGgLD5hNwctL7vyK2YaZ8CCHhcI=" 
                                 alt="Farmer checking crops" 
                                 class="mb-4 h-48 w-full object-cover">
                            <div class="img-overlay">
                                <span class="view-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-4 text-indigo-700">Farmer Resources</h3>
                        <p class="text-gray-600">Access to post-harvest techniques, storage solutions, and direct market links to maximize your yields.</p>
                    </a>
                </div>
    
                <!-- Processor Tools Card -->
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow service-card">
                    <a href="food-processors.php" class="block">
                        <div class="service-img-container">
                            <img src="https://images.unsplash.com/photo-1550583724-b2692b85b150?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" 
                                 alt="Food processing equipment" 
                                 class="mb-4 h-48 w-full object-cover">
                            <div class="img-overlay">
                                <span class="view-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-4 text-indigo-700">Processor Tools</h3>
                        <p class="text-gray-600">Value-addition technologies, quality control systems, and distribution network access.</p>
                    </a>
                </div>
    
                <!-- Consumer Insights Card -->
                <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition-shadow service-card">
                    <a href="consumer-insights.php" class="block">
                        <div class="service-img-container">
                            <img src="https://images.unsplash.com/photo-1542838132-92c53300491e?ixlib=rb-1.2.1&auto=format&fit=crop&w=600&q=80" 
                                 alt="Fresh produce market" 
                                 class="mb-4 h-48 w-full object-cover">
                            <div class="img-overlay">
                                <span class="view-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                        <h3 class="text-xl font-bold mb-4 text-indigo-700">Consumer Insights</h3>
                        <p class="text-gray-600">Learn about food quality, nutritional benefits, and connect directly with producers.</p>
                    </a>
                </div>
            </div>
            </div>
    </section>

    <!-- Blog Section -->
    <section id="blog" class="section bg-white">
        <!-- ... -->
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-bold text-gray-800 mb-8">Latest Blogs</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="blog-img-container">
                        <img src="https://images.unsplash.com/photo-1606787366850-de6330128bfc?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80" 
                             alt="Food storage containers" 
                             class="w-full h-64 object-cover">
                        <div class="img-overlay">
                            <span class="view-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 text-indigo-700">Modern Food Storage Solutions</h3>
                        <p class="text-gray-600 mb-4">Discover innovative techniques to extend shelf life and maintain food quality.</p>
                        <div class="text-indigo-600 font-semibold hover:underline">Read more →</div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="blog-img-container">
                        <img src="https://images.unsplash.com/photo-1601493700631-2b16ec4b4716?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80" 
                             alt="Organic farming" 
                             class="w-full h-64 object-cover">
                        <div class="img-overlay">
                            <span class="view-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </span>
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="text-xl font-bold mb-2 text-indigo-700">Sustainable Farming Practices</h3>
                        <p class="text-gray-600 mb-4">Learn how eco-friendly methods can increase your yields while protecting the environment.</p>
                        <div class="text-indigo-600 font-semibold hover:underline">Read more →</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog Detail Container -->
    <div id="blog-detail-container" class="fixed inset-0 bg-white z-50 blog-detail overflow-y-auto">
        <div class="container mx-auto px-4 py-24">
            <!-- Blog 1 Content -->
            <div id="blog1-content" class="blog-content blog-detail">
                <button onclick="hideBlog()" class="back-button mb-8 text-indigo-600 font-semibold flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Blogs
                </button>
                <h2 class="text-4xl font-bold text-gray-800 mb-6 animate__animated animate__fadeInDown">Modern Food Storage Solutions</h2>
                <div class="grid md:grid-cols-2 gap-8 mb-12">
                    <div class="rounded-lg overflow-hidden animate__animated animate__fadeInLeft">
                        <img src="https://images.unsplash.com/photo-1606787366850-de6330128bfc?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80" 
                             alt="Advanced Storage" 
                             class="w-full h-64 object-cover">
                    </div>
                    <div class="animate__animated animate__fadeInRight">
                        <p class="text-gray-600 leading-relaxed mb-4">
                            Discover cutting-edge technologies revolutionizing food preservation. Our latest solutions combine 
                            smart temperature control with AI-powered monitoring systems to extend shelf life while maintaining 
                            nutritional value.
                        </p>
                        <div class="bg-indigo-50 p-4 rounded-lg">
                            <h4 class="text-lg font-semibold mb-2">Key Features:</h4>
                            <ul class="list-disc list-inside text-gray-600 space-y-2">
                                <li>IoT-enabled smart storage units</li>
                                <li>Real-time quality monitoring</li>
                                <li>Energy-efficient cooling systems</li>
                                <li>Automated inventory management</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Blog 2 Content -->
            <div id="blog2-content" class="blog-content blog-detail">
                <button onclick="hideBlog()" class="back-button mb-8 text-green-600 font-semibold flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Back to Blogs
                </button>
                <h2 class="text-4xl font-bold text-gray-800 mb-6 animate__animated animate__fadeInDown">Sustainable Farming Practices</h2>
                <div class="grid md:grid-cols-2 gap-8 mb-12">
                    <div class="rounded-lg overflow-hidden animate__animated animate__fadeInLeft">
                        <img src="https://images.unsplash.com/photo-1601493700631-2b16ec4b4716?ixlib=rb-1.2.1&auto=format&fit=crop&w=1200&q=80" 
                             alt="Organic Farming" 
                             class="w-full h-64 object-cover">
                    </div>
                    <div class="animate__animated animate__fadeInRight">
                        <p class="text-gray-600 leading-relaxed mb-4">
                            Explore eco-friendly agricultural methods that boost productivity while protecting our planet. 
                            Learn about crop rotation techniques, organic pest control, and water conservation strategies 
                            that are transforming modern agriculture.
                        </p>
                        <div class="bg-green-50 p-4 rounded-lg">
                            <h4 class="text-lg font-semibold mb-2">Key Benefits:</h4>
                            <ul class="list-disc list-inside text-gray-600 space-y-2">
                                <li>Reduced environmental impact</li>
                                <li>Increased soil fertility</li>
                                <li>Natural pest management</li>
                                <li>Long-term cost savings</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12">
        <!-- ... -->
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">FarmTech Hub</h3>
                    <p class="text-gray-400">Connecting the agricultural ecosystem through technology and innovation.</p>
                </div>
                <div>
                    <h4 class="font-bold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="#home" class="text-gray-400 hover:text-white">Home</a></li>
                        <li><a href="#about" class="text-gray-400 hover:text-white">About</a></li>
                        <li><a href="#services" class="text-gray-400 hover:text-white">Services</a></li>
                        <li><a href="#blog" class="text-gray-400 hover:text-white">Blog</a></li>
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

</main>

    <script>
        // Your existing JavaScript
        // Smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Mobile menu toggle
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        window.onclick = function(event) {
            if (event.target.classList.contains('fixed')) {
                hideModals();
            }
        }

        // Close mobile menu when clicking a link
        document.querySelectorAll('#mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                mobileMenu.classList.add('hidden');
            });
        });

        // Blog functionality
        function showBlog(blogId) {
            document.getElementById('blog-detail-container').classList.add('blog-active');
            document.querySelectorAll('.blog-content').forEach(blog => blog.style.display = 'none');
            document.getElementById(`${blogId}-content`).style.display = 'block';
            setTimeout(() => {
                document.getElementById(`${blogId}-content`).style.opacity = 1;
            }, 50);
        }

        function hideBlog() {
            document.getElementById('blog-detail-container').classList.remove('blog-active');
            document.querySelectorAll('.blog-content').forEach(blog => {
                blog.style.display = 'none';
                blog.style.opacity = 0;
            });
        }



        // Update blog card click handlers
        document.querySelectorAll('.blog-img-container').forEach((blog, index) => {
            if(index == 0){
                blog.parentElement.setAttribute('onclick', "showBlog('blog1')");
            }else{
                blog.parentElement.setAttribute('onclick', "showBlog('blog2')");
            }
        });
    </script>
</body>
</html>