<?php

require_once '../db/dbConnect.php';

$ap_id = $_GET['ap_id'];
$status = $_GET['status'];

if ($status == 'rejected') {
    $sql = "UPDATE appointments SET status = 'rejected' WHERE id = '$ap_id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Location: /dashboard");
    }
} else {
    $sql = "UPDATE appointments SET status = 'approved' WHERE id = '$ap_id'";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header("Location: /dashboard");
    }
}
