<?php
// ربط إعدادات قاعدة البيانات
require_once 'db_config.php';

// التحقق إذا المستخدم مسجل دخول
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
    <title>Azure Robotics | Real-World Navigation - SLAM Technology</title> <!-- عنوان الصفحة -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- أيقونات -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700;800&display=swap" rel="stylesheet"> <!-- الخط -->
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
        
        .level-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 25px; margin: 30px 0; }
        .level-card { background: rgba(42,111,156,0.08); border-radius: 24px; padding: 25px; border: 1px solid rgba(42,111,156,0.2); }
        .level-card h4 { font-size: 1.2rem; margin-bottom: 15px; color: #7AB3CC; }
        .level-card i { font-size: 1.8rem; color: #2A6F9C; margin-bottom: 12px; display: block; }
        
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
        <a href="avoiding.php"><i class="fas fa-eye"></i> Optical Avoidance</a>
        <a href="navigating.php" class="active"><i class="fas fa-map"></i> Navigation</a>
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
            <h1><i class="fas fa-map"></i> Real-World Navigation</h1>
            <p>Spatial Intelligence using SLAM (Simultaneous Localization and Mapping) for GPS-denied environments.</p>
        </div>
        <img src="https://images.unsplash.com/photo-1581092160562-40aa08e78837?w=300&h=200&fit=crop" alt="SLAM Navigation">
    </div>

    <div class="content-card">
        <h2><i class="fas fa-brain"></i> Navigation in the Real World: "Spatial Intelligence"</h2>
        <p>The real world is "unstructured," which means it is full of irregular edges, slopes, and slippery surfaces. Navigation here requires multiple levels of processing:</p>
        
        <h3>A. Simultaneous Localization and Mapping (SLAM)</h3>
        <p>This is the classic dilemma: "I need a map to know where I am, and I need to know where I am to draw the map." The humanoid robot uses Visual SLAM (through cameras) or LiDAR SLAM to merge motion data with visual references. The difference here is that the robot's head sway while walking makes image processing difficult, so advanced digital stabilization algorithms are used.</p>
        
        <h3>B. Global Path Planning</h3>
        <p>Here the robot thinks like "Google Maps." It analyzes the overall map and decides: "I will go through this corridor, go up the stairs, and enter the room." It uses algorithms like D* or Informed RRT*, which seek the shortest possible route taking into account the width and height of the robot.</p>
        
        <h3>C. Step Planning (Footstep Planning): "The highest level of complexity"</h3>
        <p>This is the essence of the humanoid robot. The robot does not see the ground as a flat surface, but as potential landing points (Candidate Landing Spots).</p>
        <p><strong>Surface Analysis:</strong> The sensors analyze whether the surface can support the weight and if it is tilted at an angle that could cause slipping.</p>
        <p><strong>Sequence of Steps:</strong> The robot performs "omnidirectional" calculations (movement in all directions). It can decide that the best way to cross a narrow corridor is by side-stepping instead of moving forward.</p>
    </div>

    <div class="level-grid">
        <div class="level-card">
            <i class="fas fa-map-draw"></i>
            <h4>SLAM (Visual + LiDAR)</h4>
            <p>Merges motion data with visual references using advanced digital stabilization algorithms to compensate for head sway during walking.</p>
        </div>
        <div class="level-card">
            <i class="fas fa-route"></i>
            <h4>Global Path Planning</h4>
            <p>Uses D* or Informed RRT* algorithms to find the shortest possible route considering robot dimensions.</p>
        </div>
        <div class="level-card">
            <i class="fas fa-shoe-prints"></i>
            <h4>Footstep Planning</h4>
            <p>Analyzes candidate landing spots, surface weight capacity, tilt angles, and omnidirectional movement calculations.</p>
        </div>
    </div>

    <footer class="footer">
        <div>© 2026 AZURE ROBOTICS — SLAM Navigation Systems for Extreme Environments</div>
    </footer>
</div>

<script>
    const hamburger = document.getElementById('hamburger'), sidebar = document.getElementById('sidebar'), overlay = document.getElementById('overlay');
    hamburger.addEventListener('click', () => { sidebar.classList.add('open'); overlay.classList.add('active'); });
    overlay.addEventListener('click', () => { sidebar.classList.remove('open'); overlay.classList.remove('active'); });
</script>
</body>
</html>