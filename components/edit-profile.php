<!-- php to update data from the form in edit profile -->
<?php

require_once '../db/dbConnect.php';
if (isset($_GET['full_name'])) {
    $full_name = $_GET['full_name'];
    $email = $_GET['email'];
    $username = $_GET['username'];
    $department = $_GET['department'];
    $id = $_SESSION['id'];
    $sql = "UPDATE users SET full_name = '$full_name', email = '$email', department = '$department' WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        // create a session variable
        $_SESSION['open_banner'] = 1;
        $_SESSION['profile_update_success'] = 1;
        header('Location: ../pages/edit-profile.php');
    } else {
        $_SESSION['open_banner'] = 1;
        $_SESSION['profile_update_failed'] = 1;
        header('Location: ../pages/edit-profile.php');
    }
}

if (isset($_GET['password'])) {
    $id = $_SESSION['id'];
    $password = $_GET['password'];
    $password = md5($password);
    $sql = "SELECT password FROM users WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $db_password = $row['password'];
    if ($password == $db_password) {
        $new_password = $_GET['newpassword'];
        $confirm_new_password = $_GET['confirmnewpassword'];
        if ($new_password == $confirm_new_password) {
            $new_password = md5($new_password);
            $sql = "UPDATE users SET password = '$new_password' WHERE id = $id";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                $_SESSION['open_banner'] = 1;
                $_SESSION['pass_update_success'] = 1;
                header('Location: ../pages/edit-profile.php');
            } else {
                $_SESSION['open_banner'] = 1;
                $_SESSION['pass_update_fail'] = 1;
                header('Location: ../pages/edit-profile.php');
            }
        } else {
            $_SESSION['open_banner'] = 1;
            $_SESSION['newpassword_notsame'] = 1;
            header('Location: ../pages/edit-profile.php');
        }
    } else {
        $_SESSION['open_banner'] = 1;
        $_SESSION['oldpassword_invalid'] = 1;
        header('Location: ../pages/edit-profile.php');
    }
}
?>