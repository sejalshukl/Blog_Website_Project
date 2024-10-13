# Blog_Website_Project

## Overview
This is a simple blog website built using PHP and MySQL. It allows users to create, edit, delete, and view blog posts. The project also includes user authentication.

## Table of Contents
- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
- [Contributing](#contributing)

## Features
- User authentication (login/register)
- Create, edit, and delete blog posts
- View all blog posts
- Responsive design

## Requirements
- PHP >= 7.0
- MySQL
- A web server (e.g., Apache or Nginx)
- Composer (for dependency management)

## Installation
1. **Clone the repository:**

   ```bash
   git clone https://github.com/sejalshukl/Blog_Website_Project.git
   ```

2. **Navigate to the project directory:**

   ```bash
   cd Blog_Website_Project
   ```

3. **Create a database:**

   - Log in to your MySQL server and create a new database. For example:

     ```sql
     CREATE DATABASE blog_platform;
     ```

4. **Set up the database:**

   - Import the SQL file (if provided) to create the necessary tables. You can usually find it as a file named blog_platform.sql:

5. **Configure database connection:**

   - Update the database configuration file (usually `config.php` or `db.php`) with your database credentials:

   ```php
   $host = 'localhost';
   $dbname = 'blog_platform';
   $user = 'root';  // Replace with your MySQL username
   $pass = 'your password';  // Replace with your MySQL password
   ```

## Usage
1. **Start the web server in xampp:**
   - If you're using xampp start Apache and mysql.

2. **Access the application:**
   - Open your web browser and navigate to `http://localhost/Blog_Website_Project` to view the blog website.

3. **Register a new user:**
   - Click on the register link to create a new account.

4. **Log in:**
   - Use your credentials to log in and access the dashboard where you can create and manage blog posts.

## Contributing
If you'd like to contribute to this project, please fork the repository and submit a pull request. Make sure to update tests as appropriate.

