<?php
    require '\db\dbConnect.php';
    if(isset($_POST['submit'])){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0){
            header("Location: ../signup.php?signup=usertaken");
            exit();
        } else {
            // check if email exist
            $sql = "SELECT * FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);
            $resultCheck = mysqli_num_rows($result);
            if($resultCheck > 0){
                header("Location: ../signup.php?signup=emailtaken");
                exit();
            } else {
                if($password == $confirm_password){
                    $password = md5($password);
                    $sql = "INSERT INTO users (username, password, email) VALUES ('$username', '$password', '$email')";
                    mysqli_query($conn, $sql);
                    header("Location: ../signup.php?signup=success");
                    exit();
                } else {
                    header("Location: ../signup.php?signup=passwordnotmatch");
                    exit();
                }
            }
        }
    } else {
        header("Location: ../signup.php?signup=error");
        exit();
}
?>

