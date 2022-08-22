<?php

require_once '../db/dbConnect.php';

$rev_id = $_GET['rev_id'];
$status = $_GET['status'];

if ($status == 'rejected') {
    $sql = "UPDATE review SET status = 'rejected' WHERE id = '$rev_id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Location: /dashboard");
    }
} else {
    $sql = "UPDATE review SET status = 'approved' WHERE id = '$rev_id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Location: /dashboard");
    }
}

?>