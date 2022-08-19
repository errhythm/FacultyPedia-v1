<?php
    require_once '../db/dbConnect.php';
    if(isset($_POST['submit'])){
        $username = strtolower($_POST['username']);
        $password = $_POST['password'];
        $password = md5($password);
        $query = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
        $result = mysqli_query($conn, $query);
        // create a variable for user_id from $result
        $user = mysqli_fetch_assoc($result);
        $id = $user['id'];
        if(mysqli_num_rows($result) == 1){
            session_start();
            $_SESSION['username'] = $username;
            $_SESSION['id'] = $id;
            header('location: ../index.php');
        }else{
            session_start();
            $_SESSION['incorrectpassword']="1";
            header('location: ../pages/login.php');
        }
    }
?>