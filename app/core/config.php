<?php

// Define app settings
define('APP_NAME', 'MVC');
define('APP_DESC', 'FREE AND PAID TUTORIALS');
define('ROOt','http://localhost/MVC/public');

// Environment check
define('ENV', 'development');  // Set to 'production' in production environment

// Database connection settings
if (ENV === 'development' || $_SERVER['SERVER_NAME'] === 'localhost') {
    define('DBHOST', 'localhost');
    define('DBNAME', 'youdemy');
    define('DBUSER', 'postgres');
    define('DBPASS', '123456789');
    define('DBDRIVER', 'pgsql'); // PostgreSQL driver
    define('DBPORT', 5432); // Default PostgreSQL port
} else {
    // Production environment settings (adjust as needed)
    define('DBHOST', 'production_host');
    define('DBNAME', 'production_db');
    define('DBUSER', 'production_user');
    define('DBPASS', 'production_password');
    define('DBDRIVER', 'pgsql'); // PostgreSQL driver
    define('DBPORT', 5432); // Production port (or a different one if needed)
}
