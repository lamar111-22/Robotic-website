<?php 
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// هنا بدأت الجلسة عشان النظام يتذكر اليوزر اللي دخل

// معلومات السيرفر في XAMPP
$host='localhost'; 
$user='root'; // يوزر XAMPP الافتراضي
// If 'email' exists, use it; otherwise, set it to null/empty.
$email = $_POST['email'] ?? '';$pass='';     // باسوورد XAMPP الافتراضي يكون "فاضي"
$dbname='my_website_db'; // اسم الداتا بيس اللي سويناها 
$port=3306;

// سويت الاتصال
$conn = new mysqli($host, $user, $pass, $dbname, $port);

// عشان نقرأ ونكتب بالعربي بدون مشاكل
$conn->set_charset("utf8mb4");

// فحص بسيط لو الربط خربان يعلمني
if ($conn->connect_error) {
    die("مشكلة في الربط: " . $conn->connect_error);
}
?>