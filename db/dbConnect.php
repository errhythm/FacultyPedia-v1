<?php
    $servername = "localhost";
    $username = "root";
    $password = "root";
    $dbname = "cse391a3";
    $conn = new mysqli($servername, $username, $password, $dbname);

    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "<script>console.log('Connected successfully')</script>";
    
    session_start();
?>