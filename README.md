# Robotic-website
A website that presents technical content about balance control, walking gait (MPC), optical obstacle avoidance, SLAM navigation, and team information. Built with PHP, MySQL, HTML/CSS, and JavaScript.
System Requirements
Web Server: Apache (XAMPP recommended)
PHP: Version 7.4 or higher
Database: MySQL 5.7 or higher
Browser: Modern browser with JavaScript enabled
Operating System: Windows / Linux / macOS (tested on Windows 11)
File Structure
text
project_root/
├── index.php          # Login page (session authentication)
├── home.php           # Balance & Walking control systems
├── walking.php        # Walking gait with Model Predictive Control (MPC)
├── avoiding.php       # Optical obstacle avoidance (Octomap, Voxel Grid)
├── navigating.php     # Real-world navigation using SLAM
├── team.php           # Team members and supervisor information
├── logout.php         # Session destroy and logout page
├── db_config.php      # Database connection configuration
└── README.md          # This documentation
Database Setup
Method 1: Import SQL File via phpMyAdmin (Recommended)
Start XAMPP Control Panel.
Start both Apache and MySQL services.
Open your browser and go to: http://localhost/phpmyadmin
Click on New in the left sidebar to create a new database.
Enter database name: my_website_db
Choose utf8mb4_general_ci as collation and click Create.
Click on the Import tab at the top.
Click Choose File and select the SQL file named my_website_db.sql (create this file with the SQL code below).
Scroll down and click Go to execute the import.
Method 2: Run SQL Directly
Alternatively, execute the following SQL commands in the phpMyAdmin SQL tab:
sql
CREATE DATABASE IF NOT EXISTS my_website_db;
USE my_website_db;

CREATE TABLE users (
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (username),
    UNIQUE KEY (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO users (username, email, password) 
VALUES ('Lamar_Admin', 'lamar@example.com', 'mypassword123');
SQL File Content (my_website_db.sql)
Save the following content as my_website_db.sql and use it for import:
sql
-- phpMyAdmin SQL Dump
-- Database: my_website_db

CREATE DATABASE IF NOT EXISTS my_website_db;
USE my_website_db;

CREATE TABLE users (
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    PRIMARY KEY (username),
    UNIQUE KEY (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO users (username, email, password) 
VALUES ('Lamar_Admin', 'lamar@example.com', 'mypassword123');
Database Configuration File (db_config.php)
The file db_config.php already contains:
php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'my_website_db';
$port = 3306;
If your MySQL has a password, update the $pass variable accordingly.
Installation Steps
Install XAMPP
Download from https://www.apachefriends.org/ and install with default settings.
Start Services
Open XAMPP Control Panel and start Apache and MySQL.
Copy Project Files
Place all PHP files into a folder inside C:\xampp\htdocs\, for example:
C:\xampp\htdocs\azure_robotics\
Create or Import Database
Follow the Database Setup section above (Method 1 or Method 2).
Adjust Configuration (if needed)
If your MySQL root password is not empty, edit db_config.php and set $pass = 'your_password';
Access the Website
Navigate to: http://localhost/azure_robotics/index.php
Authentication
The login system uses plain text password comparison (for demonstration purposes).
Session variable $_SESSION['user'] stores the username after successful login.
All protected pages check for isset($_SESSION['user']) and redirect to index.php if not set.
Default Test Credentials
Field
Value
Username
Lamar_Admin
Email
lamar@example.com
Password
mypassword123

You can add more users via phpMyAdmin or SQL INSERT.
Page Descriptions
File
Description
index.php
Login form with username/email and password, error messages, password toggle.
home.php
Explains balance control, Zero Momentum Point (ZMP), ASIMO reference. Also covers walking basics and MPC technology.
walking.php
Detailed Model Predictive Control (MPC) for gait generation, LIP model, TALOS and Atlas examples.
avoiding.php
Optical obstacle avoidance using Octomap/Voxel Grid, center of mass adjustment, soft vs rigid obstacles.
navigating.php
SLAM (Simultaneous Localization and Mapping), global path planning (D, Informed RRT), footstep planning.
team.php
Displays team members (Lamar, Jana, Layan, Renad) and supervisor Dr. Mona Alawadh.
logout.php
Destroys session and shows a logout confirmation page with return link.

Styling and Responsive Design
All pages use CSS with dark theme (#0A0E1A background, #2A6F9C accent).
Fonts: Inter from Google Fonts.
Icons: Font Awesome 6.
Sidebar menu slides from left on mobile/desktop with hamburger button.
Fully responsive (media queries for max-width 768px and 900px).
Sidebar Navigation
The sidebar is present in home.php, walking.php, avoiding.php, navigating.php. It contains links to:
Balance & Walking (home.php)
Walking Gait (walking.php)
Optical Avoidance (avoiding.php)
Navigation (navigating.php)
Our Team (team.php)
Click the hamburger icon (three bars) to open the sidebar. Click the overlay or any link to close.
Important Notes
The project uses plain text passwords. For production, implement password_hash() and password_verify().
The dashboard.php file is present but not linked; it is a leftover template.
Images are loaded from Unsplash placeholders. You may replace with local images.
Session is started in db_config.php if not already active, ensuring consistent session handling.
Device Information (Development Environment)
This project was developed and tested on the following system:
Device name: shamesx
Processor: 13th Gen Intel(R) Core(TM) i7-1355U (1.70 GHz)
Installed RAM: 16.0 GB (15.7 GB usable)
Graphics: NVIDIA GeForce RTX 2050 (4 GB) + Intel Iris Xe Graphics (128 MB)
Storage: 172 GB used of 954 GB
OS: Windows 11 Home (Version 25H2, OS build 26200.8246)
System type: 64-bit operating system, x64-based processor
Windows Feature Experience Pack: 1000.26100.297.0
Troubleshooting
"Cannot connect to database"
Ensure MySQL is running in XAMPP.
Check credentials in db_config.php.
Verify database name my_website_db exists.
Login redirects back to login page
Confirm the users table contains at least one record.
Check that $_SESSION['user'] is being set correctly in index.php.
Ensure no output before session_start().
White screen or PHP errors
Enable error reporting by adding at the top of the problematic file:
php
error_reporting(E_ALL);
ini_set('display_errors', 1);
Check PHP error logs in C:\xampp\php\logs\.
Sidebar not working
Verify JavaScript console for errors.
Ensure the hamburger, sidebar, and overlay element IDs are correct.
Images not loading
The site uses external Unsplash URLs. If offline, replace src attributes with local image paths.
Security Recommendations for Production
Replace plain text password comparison with hashed passwords.
Use prepared statements for all database queries (already partially implemented).
Add CSRF tokens to login form.
Implement rate limiting on login attempts.
Move database credentials outside document root or use environment variables.
Enable HTTPS.
License and Copyright
(c) 2026 AZURE ROBOTICS - Humanoid Autonomy for Extreme Environments. All content is for educational and demonstration purposes.
