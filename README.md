# Azure Robotics Website - Technical README

A web-based control system that provides secure login, protected pages, and multiple robot-related interfaces such as walking control, SLAM navigation, and obstacle avoidance.  
The project is built using **PHP, MySQL, HTML, and CSS**.

---

## Features

- Secure login system using **PHP Sessions**
-  Protected pages with automatic redirection if the user is not  logged in
-  Modern dark UI design
-  Animated sidebar with blur effects
-  Multiple robot system pages:
  - Balance & Walking Control
  - Walking Gait Control
  - Optical Obstacle Avoidance
  - Real-World Navigation (SLAM)
  - Team Page


---


##  Project Structure

/project-folder
 index.php          # Login page (session authentication)
 home.php           # Balance & Walking control systems
 walking.php        # Walking gait control
 avoiding.php       # Optical obstacle avoidance 
 navigating.php     # Real-world navigation using SLAM
  team.php          # Team information page
 logout.php         # Session destroy and logout page
 db_config.php      # Database configuration
 README.md          # Documentation file

--- 

## System Requirements

| Component | Requirement |
|-----------|-------------|
| Web Server | Apache (XAMPP recommended) |
| PHP | Version 7.4 or higher |
| Database | MySQL 5.7 or higher |
| Operating System | Windows / Linux / macOS (tested on Windows 11) |

---

## Database Structure

User table:

| Field     | Type              |
|-----------|-------------------|
| username  | VARCHAR           |
| email     | VARCHAR           |
| password  | VARCHAR           |


## How to Start the Database (my_website_db)

Follow these steps to set up and start the project database using XAMPP:

1. **Open XAMPP Control Panel**

2. **Start Required Services:**
   - Start Apache
   - Start MySQL

3. **Open phpMyAdmin**  
   Go to: `http://localhost/phpmyadmin`

4. **Create a New Database**  
   Click on "New" in the left sidebar, then create a database named: `my_website_db`

5. **Import the SQL File**  
   - Click on the database name `my_website_db`
   - Go to the "Import" tab
   - Click "Choose File"
   - Select the file: `my_website_db (1).sql`
   - Press "Go" to import the tables and data

---

## Database Configuration File (db_config.php)

The file `db_config.php` already contains:

```php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'my_website_db';
$port = 3306;

If your MySQL has a password, update the $pass variable accordingly.

 Open your browser and go to:
http://localhost/robot_site/index.php


---

##  Development Environment (Your Device Specs)

Component	                  Specification
Processor	                  Intel Core i7-1355U
RAM	                        16 GB
GPU	                        NVIDIA RTX 2050
Integrated Graphics	        Intel Iris Xe Graphics
OS	                        Windows 11 Home (Version 25H2)
Architecture	              64-bit system
Storage                    	954 GB (172 GB used)
---

## Styling and Responsive Design
All pages use CSS with dark theme (#0A0E1A background, #2A6F9C accent).
Fonts: Inter from Google Fonts.
Icons: Font Awesome 6.
Sidebar menu slides from left on mobile/desktop with hamburger button.
Fully responsive (media queries for max-width 768px and 900px).


---

## Important Notes

Important Notes
The project uses plain text passwords. For production, implement password_hash() and password_verify()

Images are loaded from Unsplash placeholders. You may replace with local images

Session is started in db_config.php if not already active, ensuring consistent session handling

 ---

##  Security Notes

 Passwords are currently stored in plain text → recommended to use password_hash()

 Consider adding CSRF protection

 Consider adding rate limiting for login attempts
---


## Troubleshooting

- "Cannot connect to database"
Ensure MySQL is running in XAMPP.
Check credentials in db_config.php.
Verify database name my_website_db exists.

- Login redirects back to login page
Confirm the users table contains at least one record.
Check that $_SESSION['user'] is being set correctly in index.php.
Ensure no output before session_start().


- White screen or PHP errors
Enable error reporting by adding at the top of the problematic file: php

- error_reporting(E_ALL);
ini_set('display_errors', 1);
Check PHP error logs in C:\xampp\php\logs\.

- Sidebar not working
Verify JavaScript console for errors.
Ensure the hamburger, sidebar, and overlay element IDs are correct.

- Images not loading
The site uses external Unsplash URLs. If offline, replace src attributes with local image paths.

##  License

Private project — not intended for public distribution.├── team.php           # Team members and supervisor information
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
## 
INSERT INTO users (username, email, password) 
VALUES ('Lamar_Admin', 'lamar@example.com', 'mypassword123');

Database Configuration File (db_config.php)The file db_config.php already contains:
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'my_website_db';
$port = 3306;
If your MySQL has a password, update the $pass variable accordingly

## Installation Steps
Install XAMPP: Download from Apache Friends and install with default settings.

Start Services: Open XAMPP Control Panel and start Apache and MySQL.

Copy Project Files: Place all PHP files into a folder inside C:\xampp\htdocs\, for example: C:\xampp\htdocs\azure_robotics\

Create or Import Database: Follow the Database Setup section above (Method 1 or Method 2).

Adjust Configuration (if needed): If your MySQL root password is not empty, edit db_config.php and set $pass = 'your_password';

Access the Website: Navigate to http://localhost/azure_robotics/index.php

## Authentication & Default CredentialsThe login system uses plain text password comparison (for demonstration purposes).Session variable $_SESSION['user'] stores the username after successful login.All protected pages check for isset($_SESSION['user']) and redirect to index.php if not set

Field,Value
Username,Lamar_Admin
Email,lamar@example.com
Password,mypassword123

## File,Description
index.php,"Login form with username/email and password, error messages, password toggle."
home.php,"Explains balance control, Zero Momentum Point (ZMP), ASIMO reference. Also covers walking basics and MPC technology."
walking.php,"Detailed Model Predictive Control (MPC) for gait generation, LIP model, TALOS and Atlas examples."
avoiding.php,"Optical obstacle avoidance using Octomap/Voxel Grid, center of mass adjustment, soft vs rigid obstacles."
navigating.php,"SLAM (Simultaneous Localization and Mapping), global path planning (D*, Informed RRT*), footstep planning."
team.php,"Displays team members (Lamar, Jana, Layan, Renad) and supervisor Dr. Mona Alawadh."
logout.php,Destroys session and shows a logout confirmation page with return link.

 ## Styling and Navigation
Styling: All pages use CSS with dark theme (#0A0E1A background, #2A6F9C accent), Inter font from Google Fonts, and Font Awesome 6 icons.

Responsive Design: Fully responsive with media queries for screens under 768px and 900px.

Sidebar Navigation: Available on home.php, walking.php, avoiding.php, navigating.php, and team.php. Open using the hamburger menu icon (three bars).


##  Development Environment
Device name: shamesx

Processor: 13th Gen Intel(R) Core(TM) i7-1355U (1.70 GHz)

RAM: 16.0 GB (15.7 GB usable)

Graphics: NVIDIA GeForce RTX 2050 (4 GB) + Intel Iris Xe Graphics

OS: Windows 11 Home (64-bit)




## Troubleshooting"Cannot connect to database": Ensure MySQL is running in XAMPP,
 check credentials in db_config.php, and verify my_website_db exists.Login redirects back to login page:
 Confirm the users table contains at least one record and $_SESSION['user'] is set correctly.
White screen or PHP errors: Enable error reporting by adding this code to the top of the file:

error_reporting(E_ALL);
ini_set('display_errors', 1);

error_reporting(E_ALL);
ini_set('display_errors', 1);

Security Recommendations for Production
Replace plain text password comparison with password_hash() and password_verify().

Use prepared statements for all database queries.

Add CSRF tokens to the login form.

Implement rate limiting on login attempts.

Move database credentials outside the document root.

Enable HTTPS

## License and Copyright
© 2026 AZURE ROBOTICS - Humanoid Autonomy for Extreme Environments. All content is for educational and demonstration purposes.
