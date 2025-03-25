Vanilla PHP User Authentication System

A secure and modern user registration/login system built using Vanilla PHP (no frameworks), with file upload support, session handling, logging, and clean frontend design using Bootstrap and jQuery.

---

 Features

-  User Registration
  - Frontend & Backend validation
  - Password hashing using `password_hash()`
  - File upload with type/size validation (PDF, JPG, PNG – max 2MB)
-  Login
  - Secure login with session handling
  - Password verification using `password_verify()`
-  File Upload
  - Uploaded files stored securely with unique names
-  Logging
  - Logs registration, login, logout, and errors in `logs/app.log`
-  Clean Code
  - Parameterized queries (PDO)
  - Helper functions
  - Structured folder organization


  
---

 Tech Stack

- PHP (Vanilla, no frameworks)
- MySQL (with PDO)
- Bootstrap 5 (UI)
- jQuery (Frontend validation)
- HTML5, CSS3, JavaScript

---

 Setup Instructions

1. Get Clone 

```bash
git clone https://github.com/Saurabh2511s/user-auth-system.git


2. Create the Database

CREATE DATABASE IF NOT EXISTS user_auth;

USE user_auth;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    file_path VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);


3.  Configure the Database

Update config/db.php with your local database credentials

$host = 'localhost';
$db   = 'user_auth';
$user = 'root';
$pass = ''; // Your DB password



4. Run the Application

http://localhost/user-auth-system/

Note: Place the project in your local server (e.g., XAMPP htdocs folder)
