<?php
session_start(); // تشغيل السيشن عشان نخزن بيانات المستخدم
require_once 'db_config.php'; // ربط ملف إعدادات قاعدة البيانات

$message = ""; // متغير للرسائل

if ($_SERVER["REQUEST_METHOD"] == "POST") { // يتحقق إذا الفورم انرسل
    $login_input = $_POST['username']; // ياخذ اسم المستخدم أو الإيميل
    $password = $_POST['password']; // ياخذ كلمة المرور

    $sql = "SELECT * FROM users WHERE username = ? OR email = ?"; // يبحث عن المستخدم
    $stmt = $conn->prepare($sql);

    $stmt->bind_param("ss", $login_input, $login_input); // يربط القيم
    $stmt->execute();
    $result = $stmt->get_result(); // يجلب النتيجة

    if ($result->num_rows > 0) { // إذا لقى مستخدم
        $user_data = $result->fetch_assoc();

        if ($user_data['password'] === $password) { // يتحقق من كلمة المرور
            $_SESSION['user'] = $user_data['username']; // يحفظ اسم المستخدم في السيشن
            header("Location: home.php"); // يحوله للصفحة الرئيسية
            exit();
        } else {
            $message = "❌ Incorrect username/email or password"; // رسالة خطأ
        }
    } else {
        $message = "❌ Incorrect username/email or password"; // رسالة خطأ
    }
}
?>
<!DOCTYPE html> <!-- تعريف HTML5 -->
<html lang="en"> <!-- لغة الصفحة -->
<head>
    <meta charset="UTF-8"> <!-- ترميز النص -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover"> <!-- ضبط عرض الجوال -->
    <title>Azure Robotics | Secure Access Portal</title> <!-- عنوان الصفحة -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"> <!-- أيقونات -->

    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;14..32,400;14..32,500;14..32,600;14..32,700;14..32,800&family=Space+Mono:wght@400;700&display=swap" rel="stylesheet"> <!-- الخطوط -->

    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { background:#0A0E1A; font-family:'Inter',sans-serif; color:#fff; min-height:100vh; display:flex; flex-direction:column; overflow-x:hidden; }

        body::before {
            content:"";
            position:fixed;
            top:0; left:0;
            width:100%; height:100%;
            background-image:
                linear-gradient(rgba(42,111,156,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(42,111,156,0.03) 1px, transparent 1px);
            background-size:40px 40px;
            pointer-events:none;
        }

        .menu-bar { background:rgba(10,14,26,0.95); border-bottom:1px solid rgba(42,111,156,0.35); position:sticky; top:0; }
        .menu-container { max-width:1400px; margin:auto; padding:16px 40px; display:flex; justify-content:space-between; align-items:center; }

        .logo-area { display:flex; align-items:center; gap:14px; }
        .logo-icon { color:#2A6F9C; font-size:1.8rem; }
        .logo-text { font-weight:700; font-size:1.5rem; }
        .logo-text span { color:#2A6F9C; }

        .nav-menu { display:flex; gap:28px; }
        .nav-menu a { color:#E8F0FE; text-decoration:none; font-size:0.9rem; }

        .login-wrapper { flex:1; display:flex; justify-content:center; align-items:center; padding:60px 24px; }

        .login-card {
            background:rgba(12,18,28,0.92);
            padding:48px;
            border-radius:48px;
            border:1px solid rgba(42,111,156,0.45);
            max-width:480px;
            width:100%;
        }

        .login-header { text-align:center; margin-bottom:36px; }

        .login-icon {
            font-size:3rem;
            color:#2A6F9C;
            width:80px; height:80px;
            margin:auto;
            display:flex; align-items:center; justify-content:center;
            border-radius:50%;
            background:rgba(42,111,156,0.15);
        }

        .input-group { margin-bottom:24px; position:relative; }

        .input-field {
            width:100%;
            padding:14px 18px;
            border-radius:20px;
            border:1px solid rgba(42,111,156,0.35);
            background:rgba(5,10,18,0.7);
            color:#fff;
        }

        .toggle-password {
            position:absolute;
            right:18px;
            top:50%;
            transform:translateY(-50%);
            cursor:pointer;
            color:#8DA3C9;
        }

        .login-btn {
            width:100%;
            padding:14px;
            border:none;
            border-radius:40px;
            background:#2A6F9C;
            color:#fff;
            font-weight:700;
            cursor:pointer;
        }

        .error-message {
            background:rgba(220,53,69,0.12);
            border-left:3px solid #DC3545;
            padding:12px;
            margin-bottom:20px;
            color:#FFA6B5;
            display: <?php echo !empty($message) ? 'flex' : 'none'; ?>;
            gap:10px;
        }

        .footer {
            padding:24px;
            border-top:1px solid rgba(42,111,156,0.3);
            text-align:center;
            color:#8DA3C9;
        }
    </style>
</head>

<body>

<div class="menu-bar">
    <div class="menu-container">
        <div class="logo-area">
            <i class="fas fa-robot logo-icon"></i>
            <div class="logo-text">AZURE<span>ROBOTICS</span></div>
        </div>

        <div class="nav-menu">
            <a href="index.html">Home</a>
            <a href="#">Missions</a>
            <a href="#">Hazard Ops</a>
            <a href="#">Space</a>
            <a href="#">Core AI</a>
        </div>
    </div>
</div>

<div class="login-wrapper">
    <div class="login-card">

        <div class="login-header">
            <div class="login-icon">
                <i class="fas fa-shield-alt"></i>
            </div>
            <h1>Command Access</h1>
        </div>

        <?php if (!empty($message)): ?>
        <div class="error-message">
            <i class="fas fa-exclamation-triangle"></i>
            <span><?php echo htmlspecialchars($message); ?></span>
        </div>
        <?php endif; ?>

        <form method="POST">
            <div class="input-group">
                <input type="text" name="username" class="input-field" placeholder="Username or Email" required>
            </div>

            <div class="input-group">
                <input type="password" id="password" name="password" class="input-field" placeholder="Password" required>
                <i class="fas fa-eye toggle-password" onclick="togglePassword()"></i>
            </div>

            <button type="submit" class="login-btn">
                Sign in
            </button>
        </form>

    </div>
</div>

<div class="footer">
    © 2026 AZURE ROBOTICS
</div>

<script>
function togglePassword() {
    const pass = document.getElementById("password");
    const icon = document.querySelector(".toggle-password");

    if (pass.type === "password") {
        pass.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        pass.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}
</script>

</body>
</html>
