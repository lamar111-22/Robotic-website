#  Robotic Website

A comprehensive web application that presents technical content about balance control, walking gait using Model Predictive Control (MPC), optical obstacle avoidance, SLAM navigation, and team details. 

Built with **PHP**, **MySQL**, **HTML/CSS**, and **JavaScript**.

---

##  System Requirements

* **Web Server:** Apache (XAMPP recommended)
* **PHP Version:** 7.4 or higher
* **Database:** MySQL 5.7 or higher
* **Browser:** Any modern web browser with JavaScript enabled
* **Operating System:** Windows / Linux / macOS (Tested on Windows 11)

---

##  File Structure

```text
project_root/
├── index.php          # Login page (session authentication)
├── home.php           # Balance & Walking control systems
├── walking.php        # Walking gait with Model Predictive Control (MPC)
├── avoiding.php       # Optical obstacle avoidance (Octomap, Voxel Grid)
├── navigating.php     # Real-world navigation using SLAM
├── team.php           # Team members and supervisor information
├── logout.php         # Session destroy and logout page
├── db_config.php      # Database connection configuration
└── README.md          # Documentation
🗄️ Database SetupMethod 1: Import SQL File via phpMyAdmin (Recommended)Start XAMPP Control Panel.Start both Apache and MySQL services.Open your browser and go to: http://localhost/phpmyadminClick on New in the left sidebar to create a new database.Enter database name: my_website_dbChoose utf8mb4_general_ci as collation and click Create.Click on the Import tab at the top.Click Choose File and select the SQL file named my_website_db.sql.Scroll down and click Go to execute the import.Method 2: Run SQL DirectlyAlternatively, execute the following SQL commands in the phpMyAdmin SQL tab:SQLCREATE DATABASE IF NOT EXISTS my_website_db;
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
📜 Database Configuration & SQL FilesSQL File Content (my_website_db.sql)Save the following content as my_website_db.sql and use it for import:SQL-- phpMyAdmin SQL Dump
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
Database Configuration File (db_config.php)The file db_config.php already contains:PHP$host = 'localhost';
$user = 'root';$pass = '';
$dbname = 'my_website_db';$port = 3306;
If your MySQL has a password, update the $pass variable accordingly.🚀 Installation StepsInstall XAMPP: Download from Apache Friends and install with default settings.Start Services: Open XAMPP Control Panel and start Apache and MySQL.Copy Project Files: Place all PHP files into a folder inside C:\xampp\htdocs\, for example: C:\xampp\htdocs\azure_robotics\Create or Import Database: Follow the Database Setup section above (Method 1 or Method 2).Adjust Configuration (if needed): If your MySQL root password is not empty, edit db_config.php and set $pass = 'your_password';Access the Website: Navigate to http://localhost/azure_robotics/index.php🔐 Authentication & Default CredentialsThe login system uses plain text password comparison (for demonstration purposes).Session variable $_SESSION['user'] stores the username after successful login.All protected pages check for isset($_SESSION['user']) and redirect to index.php if not set.FieldValueUsernameLamar_AdminEmaillamar@example.comPasswordmypassword123You can add more users via phpMyAdmin or SQL INSERT.📑 Page DescriptionsFileDescriptionindex.phpLogin form with username/email and password, error messages, password toggle.home.phpExplains balance control, Zero Momentum Point (ZMP), ASIMO reference. Also covers walking basics and MPC technology.walking.phpDetailed Model Predictive Control (MPC) for gait generation, LIP model, TALOS and Atlas examples.avoiding.phpOptical obstacle avoidance using Octomap/Voxel Grid, center of mass adjustment, soft vs rigid obstacles.navigating.phpSLAM (Simultaneous Localization and Mapping), global path planning (D*, Informed RRT*), footstep planning.team.phpDisplays team members (Lamar, Jana, Layan, Renad) and supervisor Dr. Mona Alawadh.logout.phpDestroys session and shows a logout confirmation page with return link.🎨 Styling and NavigationStyling: All pages use CSS with dark theme (#0A0E1A background, #2A6F9C accent), Inter font from Google Fonts, and Font Awesome 6 icons.Responsive Design: Fully responsive with media queries for screens under 768px and 900px.Sidebar Navigation: Available on home.php, walking.php, avoiding.php, navigating.php, and team.php. Open using the hamburger menu icon (three bars).💻 Development EnvironmentDevice name: shamesxProcessor: 13th Gen Intel(R) Core(TM) i7-1355U (1.70 GHz)RAM: 16.0 GB (15.7 GB usable)Graphics: NVIDIA GeForce RTX 2050 (4 GB) + Intel Iris Xe GraphicsOS: Windows 11 Home (64-bit)🛠️ Troubleshooting"Cannot connect to database": Ensure MySQL is running in XAMPP, check credentials in db_config.php, and verify my_website_db exists.Login redirects back to login page: Confirm the users table contains at least one record and $_SESSION['user'] is set correctly.White screen or PHP errors: Enable error reporting by adding this code to the top of the file:PHPerror_reporting(E_ALL);
ini_set('display_errors', 1);
Sidebar not working: Check JavaScript console for errors and verify element IDs (hamburger, sidebar, overlay).Images not loading: Reconnect to the internet (Unsplash URLs are external) or replace src attributes with local file paths.🛡️ Security Recommendations for ProductionReplace plain text password comparison with password_hash() and password_verify().Use prepared statements for all database queries.Add CSRF tokens to the login form.Implement rate limiting on login attempts.Move database credentials outside the document root.Enable HTTPS.📄 License and Copyright© 2026 AZURE ROBOTICS - Humanoid Autonomy for Extreme Environments. All content is for educational and demonstration purposes.
License and Copyright
(c) 2026 AZURE ROBOTICS - Humanoid Autonomy for Extreme Environments. All content is for educational and demonstration purposes.
