<?php
session_start(); // بدء الجلسة
session_destroy(); // إنهاء الجلسة
setcookie('remember_token', '', time() - 3600, "/"); // حذف الكوكي
?>
<!DOCTYPE html> <!-- تعريف HTML5 -->
<html lang="en"> <!-- لغة الصفحة -->
<head>
    <meta charset="UTF-8"> <!-- ترميز النص -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover"> <!-- ضبط عرض الجوال -->
    <title>Logged Out | Azure Robotics</title> <!-- عنوان الصفحة -->

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
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logout-container {
            text-align: center; /* محاذاة المحتوى */
            padding: 40px;
        }

        .logout-icon {
            font-size: 5rem;
            color: #2A6F9C;
            margin-bottom: 30px;
            animation: floatIcon 3s ease-in-out infinite;
        }

        @keyframes floatIcon {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-15px); }
        }

        .logout-container h1 {
            font-size: 3rem;
            font-weight: 800;
            background: linear-gradient(135deg, #FFFFFF, #A0D0FF);
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
            margin-bottom: 20px;
        }

        .logout-container p {
            font-size: 1.5rem;
            color: #9BB5DA;
            margin-bottom: 40px;
            letter-spacing: 2px;
        }

        .btn-home {
            background: #2A6F9C;
            border: none;
            padding: 14px 36px;
            border-radius: 40px;
            font-weight: 600;
            font-size: 1rem;
            color: white;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .btn-home:hover {
            background: #1E5A80;
            transform: translateY(-2px);
        }

        .footer {
            position: fixed;
            bottom: 20px;
            width: 100%;
            text-align: center;
            color: #5A7392;
            font-size: 0.8rem;
        }
    </style>
</head>
<body>
    <div class="logout-container">
        <div class="logout-icon">
            <i class="fas fa-shield-alt"></i>
        </div>
        <h1>Stay Safe and Smart</h1>
        <p>You have been logged out</p>
        <a href="index.php" class="btn-home">
            <i class="fas fa-arrow-left"></i> Return to Login
        </a>
    </div>
    <div class="footer">
        <p>Azure Robotics — Protecting lives where none dare to go</p>
    </div>
</body>
</html>