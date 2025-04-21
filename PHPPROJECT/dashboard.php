<?php
require_once 'db.php';
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user data from database
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT first_name, last_name, email, profile_image FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Set default image if no profile image exists
$profile_image = $user['profile_image'] ? $user['profile_image'] : 'https://randomuser.me/api/portraits/women/44.jpg';
$full_name = htmlspecialchars($user['first_name'] . ' ' . htmlspecialchars($user['last_name']));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FarmTech Hub - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #6C63FF;
            --primary-dark: #5A52E0;
            --dark-text: #E5E7EB;
            --dark-hover: rgba(255, 255, 255, 0.1);
            --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(45deg, #7dd3fc, #d946ef, #f97316);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
            color: var(--dark-text);
            min-height: 100vh;
            display: flex;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Glass panel effect */
        .glass-panel {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.2);
        }

        /* Sidebar Styles */
        .sidebar {
            width: 280px;
            height: 100vh;
            position: fixed;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            z-index: 10;
            transition: var(--transition);
            background: rgba(30, 41, 59, 0.7);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-profile {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 40px;
            position: relative;
        }

        .user-avatar {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--primary);
            box-shadow: 0 5px 15px rgba(108, 99, 255, 0.3);
            transition: var(--transition);
        }

        .user-avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(108, 99, 255, 0.4);
        }

        .user-name {
            margin-top: 15px;
            font-size: 18px;
            font-weight: 600;
        }

        .user-role {
            color: rgba(255, 255, 255, 0.7);
            font-size: 14px;
            margin-top: 5px;
        }

        .nav-menu {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            margin: 5px 0;
            border-radius: 8px;
            color: var(--dark-text);
            text-decoration: none;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .nav-item i {
            font-size: 18px;
            margin-right: 12px;
            width: 24px;
            text-align: center;
        }

        .nav-item:hover {
            background-color: var(--dark-hover);
            transform: translateX(5px);
        }

        .nav-item.active {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
        }

        .app-download {
            margin-top: auto;
            margin-bottom: 30px;
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            box-shadow: 0 4px 12px rgba(108, 99, 255, 0.3);
        }

        .app-download:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(108, 99, 255, 0.4);
        }

        .profile-footer {
            display: flex;
            align-items: center;
            padding: 12px 15px;
            border-radius: 8px;
            transition: var(--transition);
            cursor: pointer;
            background: rgba(255, 255, 255, 0.1);
        }

        .profile-footer:hover {
            background-color: var(--dark-hover);
        }

        .profile-footer img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
        }

        /* Main Content Styles */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 30px;
        }

        .top-nav {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            margin-bottom: 30px;
        }

        .top-nav-item {
            margin-left: 25px;
            color: var(--dark-text);
            text-decoration: none;
            font-weight: 500;
            position: relative;
            transition: var(--transition);
        }

        .top-nav-item:hover {
            color: white;
        }

        .dashboard-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .dashboard-title {
            font-size: 28px;
            font-weight: 700;
        }

        .welcome-text {
            color: rgba(255, 255, 255, 0.7);
            margin-top: 5px;
        }

        /* Content Cards */
        .content-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-top: 40px;
        }

        .content-card {
            padding: 25px;
            transition: var(--transition);
            height: 100%;
        }

        .content-card:hover {
            transform: translateY(-5px);
        }

        .card-icon {
            font-size: 32px;
            margin-bottom: 15px;
            color: var(--primary);
        }

        .card-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .card-description {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6;
        }

        /* Animation Classes */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .animate-fadeIn {
            animation: fadeIn 0.6s ease-out forwards;
        }

        .delay-1 { animation-delay: 0.2s; }
        .delay-2 { animation-delay: 0.4s; }
        .delay-3 { animation-delay: 0.6s; }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .sidebar {
                width: 240px;
                transform: translateX(-100%);
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
    <!-- Sidebar Navigation -->
    <div class="sidebar">
        <div class="user-profile animate-fadeIn">
            <img src="<?php echo $profile_image; ?>" alt="User" class="user-avatar">
            <h3 class="user-name"><?php echo $full_name; ?></h3>
            <p class="user-role">Premium Member</p>
        </div>

        <div class="nav-menu">
            <a href="#" class="nav-item active animate-fadeIn delay-1">
                <i class="fas fa-chart-line"></i>
                <span>Dashboard</span>
            </a>

            <a href="quality assesment .html" class="nav-item animate-fadeIn delay-1">
                <i class="fas fa-clipboard-check"></i>
                <span>Quality Assessment Tools</span>
            </a>
            <a href="advanced-processing-equippment.html" class="nav-item animate-fadeIn delay-2">
                <i class="fas fa-tools"></i>
                <span>Equipment and Technology</span>
            </a>
            <a href="feedback.php" class="nav-item animate-fadeIn delay-2">
                <i class="fas fa-comment-alt"></i>
                <span>Feedback Mechanism</span>
            </a>
        </div>

        <button class="app-download animate-fadeIn delay-3">
            <i class="fas fa-mobile-alt"></i>
            <span>Get App</span>
        </button>

        <div class="profile-footer animate-fadeIn delay-3">
            <img src="<?php echo $profile_image; ?>" alt="Profile">
            <span>My Profile</span>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="main-content">
        <!-- Top Navigation -->
        <nav class="top-nav">
            <a href="index.php" class="top-nav-item">Home</a>
            <a href="index.php#about" class="top-nav-item">About</a>
            <a href="index.php#services" class="top-nav-item">Services</a>
            <a href="index.php#blog" class="top-nav-item">Blog</a>
        </nav>

        <!-- Dashboard Content -->
        <div class="dashboard-header">
            <div>
                <h1 class="dashboard-title">Welcome Back, <?php echo htmlspecialchars($user['first_name']); ?></h1>
                <p class="welcome-text">Here's what's happening with your farm today</p>
            </div>
        </div>

        <!-- Content Cards -->
        <div class="content-grid">
            <div class="glass-panel content-card animate-fadeIn delay-1">
                <div class="card-icon">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <h3 class="card-title">Quality Assessment Tools</h3>
                <p class="card-description">
                    Our comprehensive quality assessment tools help you monitor and improve your farm's output. 
                    Get real-time analytics and recommendations to maintain the highest standards.
                </p>
            </div>
            
            <div class="glass-panel content-card animate-fadeIn delay-2">
                <div class="card-icon">
                    <i class="fas fa-tools"></i>
                </div>
                <h3 class="card-title">Equipment and Technology</h3>
                <p class="card-description">
                    Access the latest farming equipment and technology recommendations. 
                    We help you find the perfect tools to optimize your farm's efficiency and productivity.
                </p>
            </div>
            
            <div class="glass-panel content-card animate-fadeIn delay-3">
                <div class="card-icon">
                    <i class="fas fa-comment-alt"></i>
                </div>
                <h3 class="card-title">Feedback Mechanism</h3>
                <p class="card-description">
                    Our integrated feedback system allows you to communicate with experts and other farmers. 
                    Share experiences and get solutions to your farming challenges.
                </p>
            </div>
        </div>
    </div>

    <script>
        // Add interactive effects
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelectorAll('.nav-item').forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Simulate loading animation
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                document.querySelectorAll('.animate-fadeIn').forEach(el => {
                    el.style.opacity = '1';
                    el.style.transform = 'translateY(0)';
                });
            }, 100);
        });
    </script>
</body>
</html>