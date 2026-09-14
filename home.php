<?php
// تضمين ملف إعدادات قاعدة البيانات الذي يحتوي على بدء الجلسة
require_once 'db_config.php';
//التحقق من تسجيل دخول المستخدم - إذا لم يسجل الدخول يتم إعادة التوجيه إلى صفحة تسجيل الدخول
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>  <!--تعريف إن الصفحة HTML5 -->
<html lang="en"> <!-- لغة الصفحة -->
<head>
    <meta charset="UTF-8"> <!-- ترميز يدعم كل الحروف -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover"> <!-- يخلي الصفحة مناسبة للجوال -->
    <title>Azure Robotics | Balance & Walking Control System</title> <!-- عنوان الصفحة -->

    <!-- Font Awesome 6 for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- استدعاء أيقونات -->

    <!-- Google Fonts Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet"> <!-- استدعاء الخط -->

    <style>
        * {
            margin: 0; /* تصفير الهوامش */
            padding: 0; /* تصفير الحشوات */
            box-sizing: border-box; /* ضبط حساب المساحات */
        }

        body {
            background: #0A0E1A; /* خلفية الصفحة */
            font-family: 'Inter', sans-serif; /* الخط المستخدم */
            color: #FFFFFF; /* لون النص */
            overflow-x: hidden; /* منع التمرير الأفقي */
        }


        /* ========== SIDEBAR MENU (ثلاث نقاط) ========== */
        .sidebar {
            position: fixed;
            top: 0;
            left: -320px;
            width: 320px;
            height: 100%;
            background: rgba(8, 14, 24, 0.98);
            backdrop-filter: blur(16px);
            border-right: 1px solid rgba(42, 111, 156, 0.4);
            z-index: 1000;
            transition: left 0.3s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            padding: 30px 20px;
            box-shadow: 4px 0 30px rgba(0, 0, 0, 0.5);
        }

        .sidebar.open {
            left: 0;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 14px;
            padding-bottom: 30px;
            border-bottom: 1px solid rgba(42, 111, 156, 0.3);
            margin-bottom: 30px;
        }

        .sidebar-header i {
            font-size: 2rem;
            color: #2A6F9C;
        }

        .sidebar-header h3 {
            font-size: 1.3rem;
            font-weight: 600;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .sidebar-nav a {
            text-decoration: none;
            color: #C2D4EC;
            padding: 14px 18px;
            border-radius: 16px;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 16px;
            font-weight: 500;
            background: rgba(255, 255, 255, 0.02);
        }

        .sidebar-nav a i {
            width: 28px;
            font-size: 1.2rem;
            color: #2A6F9C;
        }

        .sidebar-nav a:hover {
            background: rgba(42, 111, 156, 0.25);
            color: white;
            transform: translateX(5px);
        }

        .sidebar-nav a.active {
            background: linear-gradient(135deg, #2A6F9C, #1E5A80);
            color: white;
        }

        .sidebar-nav a.active i {
            color: white;
        }

        /* Overlay when sidebar is open */
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(3px);
            z-index: 999;
            display: none;
        }

        .overlay.active {
            display: block;
        }

        /* ========== MAIN CONTAINER ========== */
        .container {
            max-width: 1300px;
            margin: 0 auto;
            padding: 0 40px;
        }

        /* Top Navigation Bar */
        .top-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
            border-bottom: 1px solid rgba(42, 111, 156, 0.3);
        }

        .hamburger {
            background: rgba(42, 111, 156, 0.2);
            border: 1px solid rgba(42, 111, 156, 0.5);
            border-radius: 12px;
            padding: 10px 14px;
            cursor: pointer;
            transition: 0.2s;
        }

        .hamburger:hover {
            background: #2A6F9C;
        }

        .hamburger i {
            font-size: 1.4rem;
            color: white;
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-icon {
            font-size: 1.8rem;
            color: #2A6F9C;
        }

        .logo-text {
            font-weight: 700;
            font-size: 1.4rem;
            background: linear-gradient(135deg, #FFFFFF, #A0D0FF);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        .nav-menu {
            display: flex;
            gap: 25px;
            align-items: center;
        }

        .nav-menu a {
            text-decoration: none;
            color: #E8F0FE;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 0;
        }

        .logout-btn {
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid #DC3545;
            border-radius: 30px;
            padding: 8px 20px !important;
            transition: 0.2s;
        }

        .logout-btn:hover {
            background: #DC3545;
            color: white !important;
        }

        /* Hero Section */
        .hero {
            background: linear-gradient(135deg, rgba(42, 111, 156, 0.15), rgba(10, 18, 30, 0.95));
            border-radius: 48px;
            padding: 50px 40px;
            margin: 40px 0;
            border: 1px solid rgba(42, 111, 156, 0.3);
        }

        .hero-text h1 {
            font-size: 2.8rem;
            margin-bottom: 20px;
        }

        .hero-text .accent {
            color: #2A6F9C;
        }

        .hero-text p {
            color: #C2D4EC;
            max-width: 550px;
            line-height: 1.6;
        }

        /* Section Title */
        .section-title {
            font-size: 1.8rem;
            margin: 50px 0 30px 0;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .section-title i {
            color: #2A6F9C;
            font-size: 2rem;
        }

        /* Content Cards */
        .content-card {
            background: rgba(16, 24, 36, 0.7);
            backdrop-filter: blur(8px);
            border-radius: 32px;
            padding: 40px;
            margin: 30px 0;
            border-left: 5px solid #2A6F9C;
            transition: 0.2s;
        }

        .content-card h2 {
            font-size: 1.8rem;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .content-card h3 {
            font-size: 1.4rem;
            margin: 20px 0 15px 0;
            color: #7AB3CC;
        }

        .content-card p {
            color: #C2D4EC;
            line-height: 1.7;
            font-size: 1rem;
            margin-bottom: 15px;
        }

        .content-card .reference {
            color: #5A7A9A;
            font-size: 0.85rem;
            margin-top: 15px;
            font-style: italic;
        }

        .feature-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            margin: 30px 0;
        }

        .feature-item {
            background: rgba(42, 111, 156, 0.08);
            border-radius: 24px;
            padding: 25px;
            text-align: center;
            border: 1px solid rgba(42, 111, 156, 0.2);
        }

        .feature-item i {
            font-size: 2.2rem;
            color: #2A6F9C;
            margin-bottom: 15px;
        }

        .feature-item h4 {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .feature-item p {
            font-size: 0.85rem;
            color: #B0CAF0;
        }

        /* Footer */
        .footer {
            border-top: 1px solid rgba(42, 111, 156, 0.3);
            padding: 35px 0 30px;
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px;
            color: #8DA3C9;
            font-size: 0.8rem;
        }

        .footer-social a {
            color: #8DA3C9;
            margin-left: 25px;
            font-size: 1.2rem;
            transition: 0.2s;
            text-decoration: none;
        }

        .footer-social a:hover {
            color: #2A6F9C;
        }

        @media (max-width: 900px) {
            .container { padding: 0 24px; }
            .hero-text h1 { font-size: 2rem; }
            .sidebar { width: 280px; }
        }
    </style>
</head>
<body>

<!-- ===== SIDEBAR MENU ===== -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <i class="fas fa-robot"></i>
        <h3>Azure Robotics</h3>
    </div>
    <div class="sidebar-nav">
        <a href="home.php" class="active">
            <i class="fas fa-balance-scale"></i>
            <span>Balance & Walking</span>
        </a>
        <a href="walking.php">
            <i class="fas fa-person-walking"></i>
            <span>Walking Gait</span>
        </a>
        <a href="avoiding.php">
            <i class="fas fa-eye"></i>
            <span>Optical Avoidance</span>
        </a>
        <a href="navigating.php">
            <i class="fas fa-map"></i>
            <span>Real-World Navigation</span>
        </a>
        <a href="team.php">
            <i class="fas fa-users"></i>
            <span>Our Team</span>
        </a>
    </div>
</div>

<div class="overlay" id="overlay"></div>

<div class="container">
    <!-- Top Navigation -->
    <div class="top-nav">
        <div class="hamburger" id="hamburger">
            <i class="fas fa-bars"></i>
        </div>
        <div class="logo-area">
            <i class="fas fa-robot logo-icon"></i>
            <div class="logo-text">AZURE<span style="color:#2A6F9C;">ROBOTICS</span></div>
        </div>
        <div class="nav-menu">
            <a href="team.php"><i class="fas fa-users"></i> Team</a>
            <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="hero">
        <div class="hero-text">
            <h1>Humanoid <span class="accent">Balance & Walking</span><br>Control Systems</h1>
            <p>Advanced balance algorithms and walking gait generation for humanoid robots operating in diverse environments.</p>
        </div>
    </div>

    <!-- Section Title -->
    <div class="section-title">
        <i class="fas fa-microchip"></i>
        <h2>Balance Control System</h2>
    </div>

    <!-- Balance Content from your document -->
    <div class="content-card">
        <h2><i class="fas fa-balance-scale"></i> Balancing</h2>
        <p>Balancing is an ability to maintain structural stability and prevent collapse in the robot, whether the robot is stationary or moving, was a significant obstacle in robot design. This problem was solved by focusing on specific points such as continuously controlling the position of the center of mass and ensuring it remains within the boundaries of its fulcrum. (1)</p>
        <p>This system relies on real-time coordination between sensors and actuators across multiple degrees of freedom to compensate for gravitational and inertial forces, allowing the robot to smoothly mimic human walking in diverse environments.</p>
        <p>Balance is one of the most important characteristics of humanoid robots, as it facilitates their interaction with the surrounding environment, such as their ability to walk on flat surfaces or stairs, making them more useful and productive. It also prevents them from falling, which could cause them significant losses in the event of a collision.</p>
        <p>One of the most common, stable and effective methods is to use the Zero Momentum Point (ZMP), which is the location on Earth where the combined effects of gravity and inertia diminish. (2)</p>
        <p>One real-world application of the (ZMP) method is the Japanese company Honda's famous robot (Asimo). It was the first humanoid robot to climb stairs and mimic humans. (3)</p>
        <div class="reference">References: (1) Vukobratović, (2) Honda ASIMO Technical Report, (3) Honda Motor Co.</div>
    </div>

    <!-- Feature Grid for Balance Methods -->
    <div class="feature-grid">
        <div class="feature-item">
            <i class="fas fa-chart-line"></i>
            <h4>ZMP Method</h4>
            <p>Zero Momentum Point for dynamic stability control</p>
        </div>
        <div class="feature-item">
            <i class="fas fa-waveform"></i>
            <h4>Real-time Coordination</h4>
            <p>Sensors and actuators across multiple degrees of freedom</p>
        </div>
        <div class="feature-item">
            <i class="fas fa-robot"></i>
            <h4>Center of Mass Control</h4>
            <p>Maintaining COM within fulcrum boundaries</p>
        </div>
    </div>

    <!-- Walking Control Section -->
    <div class="section-title">
        <i class="fas fa-person-walking"></i>
        <h2>Walking Control System</h2>
    </div>

    <div class="content-card">
        <h2><i class="fas fa-person-walking"></i> Walking</h2>
        <p>Walking is a form of bipedal locomotion in which a humanoid machine moves by coordinating its joints to maintain balance, thus mimicking human walking.</p>
        <p>The primary importance of walking is in its ability to adapt to the environment. Since our world is designed for humans, robots must be able to overcome obstacles and achieving natural movement is fundamental to integrating robots into human environments.</p>
        <h3>Model Predictive Control (MPC) Technology</h3>
        <p>Unlike traditional methods, Model Predictive Control (MPC) technology allows robots to calculate their future state in real time. This dynamic approach enables the robot to adjust its gait when encountering uneven terrain.</p>
        <p>The Model Predictive Control (MPC) technique for generating humanoid robot gait ensures stable trajectories for the center of mass. This method uses a dynamic extension of the linear motion model (LIP), considering the zero-point velocity (ZMP) as the control variable, and incorporating an explicit stability constraint into the formula. This constraint is linear with respect to the control variables, resulting in a standard quadratic programming problem with equality and inequality constraints.(1)</p>
        <h3>Real-world Examples</h3>
        <p>TALOS, by PAL Robotics is "A walking biped robot capable of lifting objects up to 6 kg with one arm fully extended. It is completely configurable, thanks to being fully developed in ROS."(2), It is an example of a robot that combines most of the methods mentioned previously, such as MPC and LIP.</p>
        <p>And another example is Boston Dynamics' Atlas robot, which uses advanced control algorithms, jumps, and even somersaults, giving it a level of agility far surpassing other technologies.(3)</p>
        <div class="reference">References: (1) MPC for Humanoid Gait Generation, (2) PAL Robotics TALOS, (3) Boston Dynamics Atlas</div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div>© 2026 AZURE ROBOTICS — Humanoid Balance & Walking Control Systems | Extreme Environment Robotics</div>
        <div class="footer-social">
            <a href="#"><i class="fab fa-github"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-linkedin-in"></i></a>
        </div>
    </footer>
</div>

<!-- JavaScript for Sidebar Toggle -->
<script>
    // الحصول على عناصر القائمة الجانبية
    const hamburger = document.getElementById('hamburger');
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('overlay');

    // دالة لفتح القائمة الجانبية
    function openSidebar() {
        sidebar.classList.add('open');
        overlay.classList.add('active');
    }

    // دالة لإغلاق القائمة الجانبية
    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('active');
    }

    // إضافة أحداث النقر
    hamburger.addEventListener('click', openSidebar);
    overlay.addEventListener('click', closeSidebar);
</script>

</body>
</html>