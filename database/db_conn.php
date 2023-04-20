<?php
    // setting up the database connection
    define('DB_USER',"root");
    define('DB_PASSWORD', '');
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'TechStore');
    define('CHARSET', 'utf8mb4');
    // creating the connection
    if (defined("INITIALIZING_DATABASE")) {
        
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD)
            OR die("Could not connect to MySQL" . mysqli_connect_error());
        
    } else {
        $dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
            OR die("Could not connect to MySQL" . mysqli_connect_error());
    }
    
?>