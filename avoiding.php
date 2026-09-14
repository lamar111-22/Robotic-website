<?php
// ربط إعدادات قاعدة البيانات
require_once 'db_config.php';

// التحقق من تسجيل الدخول
if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Azure Robotics | Optical Obstacle Avoidance - Instant Response System</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #0A0E1A; font-family: 'Inter', sans-serif; color: #FFFFFF; }

        /* Sidebar */
        .sidebar { position: fixed; top: 0; left: -320px; width: 320px; height: 100%; background: rgba(8,14,24,0.98); backdrop-filter: blur(16px); border-right: 1px solid rgba(42,111,156,0.4); z-index: 1000; transition: left 0.3s; padding: 30px 20px; }
        .sidebar.open { left: 0; }
        .sidebar-header { display: flex; align-items: center; gap: 14px; padding-bottom: 30px; border-bottom: 1px solid rgba(42,111,156,0.3); margin-bottom: 30px; }
        .sidebar-header i { font-size: 2rem; color: #2A6F9C; }
        .sidebar-nav a { text-decoration: none; color: #C2D4EC; padding: 14px 18px; border-radius: 16px; display: flex; align-items: center; gap: 16px; background: rgba(255,255,255,0.02); margin-bottom: 8px; transition: 0.2s; }
        .sidebar-nav a:hover, .sidebar-nav a.active { background: #2A6F9C; color: white; }
        .overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.6); backdrop-filter: blur(3px); z-index: 999; display: none; }
        .overlay.active { display: block; }

        /* Main Container */
        .container { max-width: 1200px; margin: 0 auto; padding: 0 30px; }
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
        
        .feature-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 25px; margin: 30px 0; }
        .feature-item { background: rgba(42,111,156,0.08); border-radius: 24px; padding: 25px; text-align: center; border: 1px solid rgba(42,111,156,0.2); }
        .feature-item i { font-size: 2.2rem; color: #2A6F9C; margin-bottom: 15px; }
        
        .footer { border-top: 1px solid rgba(42,111,156,0.3); padding: 30px 0; margin-top: 50px; display: flex; justify-content: space-between; color: #8DA3C9; }
        @media (max-width: 768px) { .container { padding: 0 20px; } .hero h1 { font-size: 1.8rem; } }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-header"><i class="fas fa-robot"></i><h3>Azure Robotics</h3></div>
    <div class="sidebar-nav">
        <a href="home.php"><i class="fas fa-balance-scale"></i> Balance & Walking</a>
        <a href="walking.php"><i class="fas fa-person-walking"></i> Walking Gait</a>
        <a href="avoiding.php" class="active"><i class="fas fa-eye"></i> Optical Avoidance</a>
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
            <h1><i class="fas fa-eye"></i> Optical Obstacle Avoidance</h1>
            <p>Instant Response System for dynamic obstacle detection and avoidance using advanced perception technologies.</p>
        </div>
        <img src="https://images.unsplash.com/photo-1555255707-c07966088b7b?w=300&h=200&fit=crop" alt="Obstacle Detection">
    </div>

    <div class="content-card">
        <h2><i class="fas fa-shield-haltered"></i> Obstacle Avoidance: "Instant Response System"</h2>
        <p>This part is responsible for the safety of the robot and its environment. In humanoid robots, obstacle avoidance is much more complex than in wheeled robots due to Dynamic Stability.</p>
        
        <h3>Perception and Representation:</h3>
        <p>The robot does not see objects simply as images, but transforms them into what is known as Octomap or Voxel Grid. These are three-dimensional meshes that indicate to the robot which spaces in the void are "occupied" and which are "free".</p>
        
        <h3>Dynamic Maneuver:</h3>
        <p>When the robot detects a sudden obstacle, the system does not just change direction, but must adjust the Center of Mass (Center of Mass). If the robot has to sharply veer to the right, the hip and knee joints must tilt in a way that counteracts the inertia to prevent the robot from falling to the ground.</p>
        
        <h3>Avoidance of "Soft" and "Rigid" Obstacles:</h3>
        <p>Advanced robots have begun to distinguish between a rigid obstacle (a wall) and a soft obstacle (a curtain or a bush). In this way, the robot can choose to pass through soft obstacles if the alternative path is impossible.</p>
    </div>

    <div class="feature-grid">
        <div class="feature-item">
            <i class="fas fa-cube"></i>
            <h4>Octomap / Voxel Grid</h4>
            <p>3D meshes indicating occupied and free spaces</p>
        </div>
        <div class="feature-item">
            <i class="fas fa-chart-line"></i>
            <h4>Center of Mass Adjustment</h4>
            <p>Dynamic maneuver to prevent falling during obstacle avoidance</p>
        </div>
        <div class="feature-item">
            <i class="fas fa-feather-alt"></i>
            <h4>Soft vs Rigid Obstacles</h4>
            <p>Distinguishing between walls and soft obstacles like curtains</p>
        </div>
    </div>

    <footer class="footer">
        <div>© 2026 AZURE ROBOTICS — Optical Obstacle Avoidance Systems</div>
    </footer>
</div>

<script>
    const hamburger = document.getElementById('hamburger'), sidebar = document.getElementById('sidebar'), overlay = document.getElementById('overlay');
    hamburger.addEventListener('click', () => { sidebar.classList.add('open'); overlay.classList.add('active'); });
    overlay.addEventListener('click', () => { sidebar.classList.remove('open'); overlay.classList.remove('active'); });
</script>
</body>
</html>