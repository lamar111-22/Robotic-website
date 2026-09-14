<?php
// ربط إعدادات قاعدة البيانات
require_once 'db_config.php';

// التحقق من تسجيل الدخول
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html> <!-- تعريف HTML5 -->
<html lang="en"> <!-- لغة الصفحة -->
<head>
    <meta charset="UTF-8"> <!-- ترميز النص -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- ضبط عرض الجوال -->
    <title>Azure Robotics | Walking Gait - Model Predictive Control</title> <!-- عنوان الصفحة -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- أيقونات -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet"> <!-- الخط -->

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; } /* تصفير عام */
        body { background: #0A0E1A; font-family: 'Inter', sans-serif; color: #FFFFFF; } /* إعدادات أساسية */

        /* Sidebar Styles */
        .sidebar { position: fixed; top: 0; left: -320px; width: 320px; height: 100%; background: rgba(8,14,24,0.98); backdrop-filter: blur(16px); border-right: 1px solid rgba(42,111,156,0.4); z-index: 1000; transition: left 0.3s; padding: 30px 20px; }
        .sidebar.open { left: 0; }
        .sidebar-header { display: flex; align-items: center; gap: 14px; padding-bottom: 30px; border-bottom: 1px solid rgba(42,111,156,0.3); margin-bottom: 30px; }
        .sidebar-header i { font-size: 2rem; color: #2A6F9C; }
        .sidebar-nav a { text-decoration: none; color: #C2D4EC; padding: 14px 18px; border-radius: 16px; display: flex; align-items: center; gap: 16px; background: rgba(255,255,255,0.02); margin-bottom: 8px; transition: 0.2s; }
        .sidebar-nav a:hover, .sidebar-nav a.active { background: #2A6F9C; color: white; }
        .overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); backdrop-filter: blur(3px); z-index: 999; display: none; }
        .overlay.active { display: block; }

        /* Main Container */
        .container { max-width: 1200px; margin: 0 auto; padding: 0 30px; } /* حاوية المحتوى */
        .top-nav { display: flex; justify-content: space-between; align-items: center; padding: 20px 0; border-bottom: 1px solid rgba(42,111,156,0.3); }
        .hamburger { background: rgba(42,111,156,0.2); border: 1px solid rgba(42,111,156,0.5); border-radius: 12px; padding: 10px 14px; cursor: pointer; }
        .hamburger i { font-size: 1.4rem; color: white; }
        .logo-area { display: flex; align-items: center; gap: 12px; }
        .logo-icon { font-size: 1.8rem; color: #2A6F9C; }
        .logo-text { font-weight: 700; font-size: 1.4rem; background: linear-gradient(135deg, #FFFFFF, #A0D0FF); background-clip: text; -webkit-background-clip: text; color: transparent; }
        .logout-btn { background: rgba(220,53,69,0.2); border: 1px solid #DC3545; border-radius: 30px; padding: 8px 20px; text-decoration: none; color: #E8F0FE; }

        /* Content */
        .hero { background: linear-gradient(135deg, rgba(42,111,156,0.15), rgba(10,18,30,0.95)); border-radius: 48px; padding: 50px 40px; margin: 40px 0; display: flex; flex-wrap: wrap; gap: 40px; align-items: center; justify-content: space-between; }
        .hero h1 { font-size: 2.5rem; margin-bottom: 20px; }
        .hero p { color: #C2D4EC; max-width: 550px; line-height: 1.6; }
        .hero img { width: 250px; border-radius: 30px; object-fit: cover; }
        
        .content-card { background: rgba(16,24,36,0.7); border-radius: 32px; padding: 40px; margin: 30px 0; border-left: 5px solid #2A6F9C; }
        .content-card h2 { font-size: 1.8rem; margin-bottom: 20px; display: flex; align-items: center; gap: 12px; }
        .content-card h3 { font-size: 1.4rem; margin: 25px 0 15px 0; color: #7AB3CC; }
        .content-card p { color: #C2D4EC; line-height: 1.7; margin-bottom: 15px; }
        .content-card .reference { color: #5A7A9A; font-size: 0.85rem; margin-top: 20px; font-style: italic; }
        
        .example-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 25px; margin: 30px 0; }
        .example-card { background: rgba(42,111,156,0.08); border-radius: 24px; padding: 25px; text-align: center; border: 1px solid rgba(42,111,156,0.2); }
        .example-card i { font-size: 2.5rem; color: #2A6F9C; margin-bottom: 15px; }
        .example-card h4 { font-size: 1.2rem; margin-bottom: 10px; }
        
        .footer { border-top: 1px solid rgba(42,111,156,0.3); padding: 30px 0; margin-top: 50px; display: flex; justify-content: space-between; color: #8DA3C9; }
        @media (max-width: 768px) { .container { padding: 0 20px; } .hero h1 { font-size: 1.8rem; } .sidebar { width: 280px; } }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header"><i class="fas fa-robot"></i><h3>Azure Robotics</h3></div>
    <div class="sidebar-nav">
        <a href="home.php"><i class="fas fa-balance-scale"></i> Balance & Walking</a>
        <a href="walking.php" class="active"><i class="fas fa-person-walking"></i> Walking Gait</a>
        <a href="avoiding.php"><i class="fas fa-eye"></i> Optical Avoidance</a>
        <a href="navigating.php"><i class="fas fa-map"></i> Navigation</a>
        <a href="team.php"><i class="fas fa-users"></i> Our Team</a>
    </div>
</div>
<div class="overlay" id="overlay"></div>

<div class="container">
    <div class="top-nav">
        <div class="hamburger" id="hamburger"><i class="fas fa-bars"></i></div>
        <div class="logo-area">
            <i class="fas fa-robot logo-icon"></i>
            <div class="logo-text">AZURE<span style="color:#2A6F9C;">ROBOTICS</span></div>
        </div>
        <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>

    <div class="hero">
        <div>
            <h1><i class="fas fa-person-walking"></i> Walking Gait Control</h1>
            <p>Bipedal locomotion systems using Model Predictive Control (MPC) and Linear Inverted Pendulum (LIP) models for stable and adaptive walking.</p>
        </div>
        <img src="https://images.unsplash.com/photo-1581091226033-d5c48150dbaa?w=300&h=200&fit=crop" alt="Walking Robot">
    </div>

    <div class="content-card">
        <h2><i class="fas fa-person-walking"></i> Walking</h2>
        <p>Walking is a form of bipedal locomotion in which a humanoid machine moves by coordinating its joints to maintain balance, thus mimicking human walking.</p>
        <p>The primary importance of walking is in its ability to adapt to the environment. Since our world is designed for humans, robots must be able to overcome obstacles and achieving natural movement is fundamental to integrating robots into human environments.</p>
        
        <h3>Model Predictive Control (MPC) Technology</h3>
        <p>Unlike traditional methods, Model Predictive Control (MPC) technology allows robots to calculate their future state in real time. This dynamic approach enables the robot to adjust its gait when encountering uneven terrain.</p>
        <p>The Model Predictive Control (MPC) technique for generating humanoid robot gait ensures stable trajectories for the center of mass. This method uses a dynamic extension of the linear motion model (LIP), considering the zero-point velocity (ZMP) as the control variable, and incorporating an explicit stability constraint into the formula. This constraint is linear with respect to the control variables, resulting in a standard quadratic programming problem with equality and inequality constraints.(1)</p>
    </div>

    <div class="example-grid">
        <div class="example-card">
            <i class="fas fa-robot"></i>
            <h4>TALOS by PAL Robotics</h4>
            <p>A walking biped robot capable of lifting objects up to 6 kg with one arm fully extended. Fully developed in ROS.</p>
        </div>
        <div class="example-card">
            <i class="fas fa-rocket"></i>
            <h4>Boston Dynamics Atlas</h4>
            <p>Uses advanced control algorithms, jumps, and even somersaults, giving it a level of agility far surpassing other technologies.</p>
        </div>
        <div class="example-card">
            <i class="fas fa-chart-line"></i>
            <h4>MPC + LIP Integration</h4>
            <p>Combines Model Predictive Control with Linear Inverted Pendulum model for optimal gait generation.</p>
        </div>
    </div>

    <div class="content-card">
        <h3>Real-world Examples</h3>
        <p>TALOS, by PAL Robotics is "A walking biped robot capable of lifting objects up to 6 kg with one arm fully extended. It is completely configurable, thanks to being fully developed in ROS."(2), It is an example of a robot that combines most of the methods mentioned previously, such as MPC and LIP.</p>
        <p>And another example is Boston Dynamics' Atlas robot, which uses advanced control algorithms, jumps, and even somersaults, giving it a level of agility far surpassing other technologies.(3)</p>
        <div class="reference">References: (1) MPC for Humanoid Gait Generation, (2) PAL Robotics TALOS Documentation, (3) Boston Dynamics Atlas Technical Specifications</div>
    </div>

    <footer class="footer">
        <div>© 2026 AZURE ROBOTICS — Walking Gait Control Systems</div>
    </footer>
</div>

<script>
    const hamburger = document.getElementById('hamburger'), sidebar = document.getElementById('sidebar'), overlay = document.getElementById('overlay');
    hamburger.addEventListener('click', () => { sidebar.classList.add('open'); overlay.classList.add('active'); });
    overlay.addEventListener('click', () => { sidebar.classList.remove('open'); overlay.classList.remove('active'); });
</script>
</body>
</html>