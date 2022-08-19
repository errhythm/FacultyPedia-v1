<?php
    require_once '../db/dbConnect.php';
    
    if (isset($_POST['submit'])) {
        $course = $_POST['course'];
        $review = $_POST['review'];
        $stars = $_POST['rating-10'];
        $student = $_SESSION['id'];
        $faculty = $_POST['faculty'];
        $check = "SELECT * FROM review WHERE student = $student AND faculty = $faculty AND course = \"$course\"";
        $result = mysqli_query($conn, $check);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0) {
            $_SESSION['alreadreviewed']="1";
            header("Location: ../pages/review.php?id=$faculty");
        }
        else {
            if ($stars == 0) {
                $_SESSION['zerostar']="1";
                header("Location: ../pages/review.php?id=$faculty");
            }
            else if ($course == "" || $review == "") {
                $_SESSION['zerofield']="1";
                header("Location: ../pages/review.php?id=$faculty");
            }
            else {
                $sql = "INSERT INTO review (course, review, stars, faculty, student) VALUES ('$course', '$review', '$stars', '$faculty', '$student')";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    $_SESSION['revsuccess']="1";    
                    header("Location: ../pages/profile.php?id=$faculty");
                } else {
                    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
                }
            }
        }
    }
?>