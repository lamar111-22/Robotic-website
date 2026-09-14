<?php
require_once 'db_config.php'; // ربط إعدادات قاعدة البيانات

if (!isset($_SESSION['user'])) { // التحقق من تسجيل الدخول
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html> <!-- تعريف HTML5 -->
<html lang="en"> <!-- لغة الصفحة -->
<head>
    <meta charset="UTF-8"> <!-- ترميز النص -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover"> <!-- ضبط عرض الجوال -->
    <title>Azure Robotics | Our Team</title> <!-- عنوان الصفحة -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- أيقونات -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&display=swap" rel="stylesheet"> <!-- الخط -->

    <style>
        * {
            margin: 0; /* تصفير عام */
            padding: 0;
            box-sizing: border-box;
        }

        body {
            background: #0A0E1A; /* خلفية الصفحة */
            font-family: 'Inter', sans-serif; /* الخط */
            color: #FFFFFF;
            min-height: 100vh;
        }

        ::-webkit-scrollbar {
            width: 6px; /* عرض شريط التمرير */
        }
        ::-webkit-scrollbar-track {
            background: #151E2C; /* خلفية المسار */
        }
        ::-webkit-scrollbar-thumb {
            background: #2A6F9C; /* لون المقبض */
            border-radius: 10px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 24px 0 20px;
            flex-wrap: wrap;
            gap: 20px;
            border-bottom: 1px solid rgba(42, 111, 156, 0.35);
        }
        .logo-area {
            display: flex;
            align-items: center;
            gap: 14px;
            cursor: pointer;
        }
        .logo-icon {
            font-size: 2rem;
            color: #2A6F9C;
        }
        .logo-text {
            font-weight: 700;
            font-size: 1.6rem;
            background: linear-gradient(135deg, #FFFFFF, #A0D0FF);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }
        .logo-text span {
            color: #2A6F9C;
        }
        .nav-menu {
            display: flex;
            gap: 32px;
            align-items: center;
            flex-wrap: wrap;
        }
        .nav-menu a {
            text-decoration: none;
            color: #E8F0FE;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 0;
            border-bottom: 2px solid transparent;
        }
        .nav-menu a i {
            color: #2A6F9C;
        }
        .nav-menu a:hover {
            color: #FFFFFF;
            border-bottom-color: #2A6F9C;
        }
        .nav-menu a.active {
            color: #FFFFFF;
            border-bottom-color: #2A6F9C;
        }
        .logout-nav-btn {
            background: rgba(220, 53, 69, 0.15);
            border: 1px solid #DC3545;
            border-radius: 30px;
            padding: 8px 20px !important;
        }
        .logout-nav-btn:hover {
            background: #DC3545;
            color: white !important;
            border-color: #DC3545;
        }
        .logout-nav-btn:hover i {
            color: white !important;
        }

        .team-header {
            text-align: center;
            margin: 60px 0 40px;
        }
        .team-header h1 {
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(135deg, #FFFFFF, #A0D0FF);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            margin-bottom: 16px;
        }
        .team-header p {
            color: #9BB5DA;
        }

        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 32px;
            margin: 40px 0 60px;
        }

        .team-card {
            background: rgba(16, 24, 36, 0.7);
            backdrop-filter: blur(8px);
            border-radius: 32px;
            padding: 32px 24px;
            text-align: center;
            border: 1px solid rgba(42, 111, 156, 0.3);
            transition: all 0.3s ease;
        }
        .team-card:hover {
            transform: translateY(-8px);
            border-color: #2A6F9C;
        }

        .team-avatar {
            width: 100px;
            height: 100px;
            background: linear-gradient(135deg, #1E4A6B, #2A6F9C);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }
        .team-avatar i {
            font-size: 3rem;
            color: #FFFFFF;
        }

        .doctor-avatar {
            background: linear-gradient(135deg, #6B2E1E, #9C422A);
        }

        .team-card h3 {
            font-size: 1.3rem;
            margin-bottom: 8px;
        }
        .team-role {
            display: inline-block;
            background: rgba(42, 111, 156, 0.2);
            border-radius: 30px;
            padding: 4px 16px;
            font-size: 0.7rem;
            font-weight: 600;
            color: #7AB8DC;
            margin-bottom: 12px;
        }
        .doctor-role {
            background: rgba(156, 66, 42, 0.2);
            color: #E08E6B;
        }
        .team-desc {
            color: #C2D4EC;
            font-size: 0.85rem;
        }

        .doctor-section {
            text-align: center;
            margin: 20px 0 40px;
        }
        .doctor-section .team-card {
            max-width: 400px;
            margin: 0 auto;
        }

        .footer {
            border-top: 1px solid rgba(42, 111, 156, 0.3);
            padding: 36px 0 32px;
            text-align: center;
            color: #8DA3C9;
            margin-top: 40px;
        }

        @media (max-width: 900px) {
            .container {
                padding: 0 24px;
            }
            .navbar {
                flex-direction: column;
                align-items: flex-start;
            }
            .nav-menu {
                width: 100%;
                justify-content: flex-start;
            }
            .team-header h1 {
                font-size: 2.2rem;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <nav class="navbar">
        <div class="logo-area" onclick="window.location.href='home.php'">
            <i class="fas fa-robot logo-icon"></i>
            <div class="logo-text">AZURE<span>ROBOTICS</span></div>
        </div>
        <div class="nav-menu">
            <a href="home.php"><i class="fas fa-home"></i> Home</a>
            <a href="team.php" class="active"><i class="fas fa-users"></i> Our Team</a>
            <a href="logout.php" class="logout-nav-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </nav>

    <div class="team-header">
        <h1>Our Team</h1>
        <p>The people behind Azure Robotics</p>
    </div>

    <div class="team-grid">
        <div class="team-card">
            <div class="team-avatar"><i class="fas fa-laptop-code"></i></div>
            <h3>Lamar Alluhaidan</h3>
            <div class="team-role">Programming & Development</div>
        </div>

        <div class="team-card">
            <div class="team-avatar"><i class="fas fa-code"></i></div>
            <h3>Jana Alowairdhi</h3>
            <div class="team-role">Programming & Development</div>
        </div>

        <div class="team-card">
            <div class="team-avatar"><i class="fas fa-chart-line"></i></div>
            <h3>Layan Albaz</h3>
            <div class="team-role">Reporting & Presentation</div>
        </div>

        <div class="team-card">
            <div class="team-avatar"><i class="fas fa-chart-pie"></i></div>
            <h3>Renad Alhamidi</h3>
            <div class="team-role">Reporting & Presentation</div>
        </div>
    </div>

    <div class="doctor-section">
        <div class="team-card">
            <div class="team-avatar doctor-avatar"><i class="fas fa-user-graduate"></i></div>
            <h3>Dr. Mona Alawadh</h3>
            <div class="team-role doctor-role">Project Supervisor - Imam Bin Saud University</div>
            <div class="team-desc">Our supervisor who guided and supported us throughout this project.</div>
        </div>
    </div>

    <footer class="footer">
        <div>© 2026 AZURE ROBOTICS — Humanoid Autonomy for Extreme Environments</div>
    </footer>
</div>

</body>
</html>