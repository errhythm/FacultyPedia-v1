<?php
require_once '../db/dbConnect.php';

if (isset($_POST['submit'])) {
    $course = $_POST['course'];
    $review = $_POST['review'];
    $stars = $_POST['rating-10'];
    $student = $_SESSION['id'];
    $faculty = $_POST['faculty'];
    $anonymous = $_POST['anonymous'];
    if ($anonymous == 'on') {
        $anonymous = 1;
    } else {
        $anonymous = 0;
    }
    $check = "SELECT * FROM review WHERE student = $student AND faculty = $faculty AND course = \"$course\"";
    $result = mysqli_query($conn, $check);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0) {
        $_SESSION['alreadreviewed'] = "1";
        header("Location: ../pages/review.php?id=$faculty");
    } else {
        if ($stars == 0) {
            $_SESSION['zerostar'] = "1";
            header("Location: ../pages/review.php?id=$faculty");
        } else if ($course == "" || $review == "") {
            $_SESSION['zerofield'] = "1";
            header("Location: ../pages/review.php?id=$faculty");
        } else {
            if ($anonymous == 1) {
                $revstatus = "pending";
            } else {
                $revstatus = "approved";
            }
            $sql = "INSERT INTO review (course, review, stars, faculty, student, anonymous, status) VALUES ('$course', '$review', '$stars', '$faculty', '$student', '$anonymous', '$revstatus')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                if ($anonymous == 1) {
                    $_SESSION['revpending'] = "1";
                    header("Location: ../pages/review.php?id=$faculty");
                } else {
                    $_SESSION['revsuccess'] = "1";
                    header("Location: ../pages/profile.php?id=$faculty");
                }
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
        }
    }
}
