<?php

require_once '../db/dbConnect.php';
if (isset($_POST['Submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $full_name = $_POST['full_name'];
    $department = $_POST['department'];
    $role = $_POST['role'];
    $id = $_POST['id'];
    $query = "UPDATE users SET username='$username', email='$email', full_name='$full_name', department='$department', role='$role' WHERE id='$id'";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo '<script>window.location.href="../dashboard/edit-users.php?id=' . $id . '"</script>';
    } else {
        echo '<script>window.location.href="../dashboard/edit-users.php?id=' . $id . '"</script>';
    }
}
