<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php include('../config.php');
    require_once '../db/dbConnect.php';
    ?>
    <link href="<?php echo $css_path; ?>" rel="stylesheet">
    <title>Schedule a Consultation - <?php echo $site_name; ?></title>
</head>

<body>
    <?php include('../components/nav.php'); ?>
    <?php
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id = $id AND role = 'faculty'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $id = $row['id'];
    $username = $row['username'];
    $email = $row['email'];
    $role = $row['role'];
    $full_name = $row['full_name'];
    $department = $row['department'];
    ?>
    <?php
    // get visitors ID details by session
    $st_id = $_SESSION['id'];
    $sql = "SELECT * FROM users WHERE id = $st_id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $st_id = $row['id'];
    $st_username = $row['username'];
    $st_email = $row['email'];
    $st_role = $row['role'];
    $st_full_name = $row['full_name'];
    $st_department = $row['department'];
    ?>
    <section class="bg-gray-100">
        <div class="max-w-screen-xl px-4 py-16 mx-auto sm:px-6 lg:px-8">
            <div class="grid gap-x-16 gap-y-8 lg:grid-cols-5">
                <div class="lg:py-12 lg:col-span-2">
                    <h1 class="max-w-xl text-xl font-bold text-center">
                        Schedule a consultation with <?php echo $username; ?>
                    </h1>
                    <!-- show the avatar of the faculty -->
                    <div class="flex justify-center py-8">
                        <div class="avatar">
                            <div class="w-32 rounded-full ring ring-primary ring-offset-base-100 ring-offset-2">
                                <a href="../pages/profile.php?id=<?php echo $id; ?>"><img class="w-32 h-32 rounded-full" src="https://avatars.dicebear.com/api/bottts/' .$username .'.png" alt=""></a>
                            </div>
                        </div>
                    </div>

                    <div class="text-center">
                        <a href="../pages/profile.php?id=<?php echo $id; ?>" class="text-2xl font-bold text-pink-600"><?php
                                                                                                                        if ($full_name = 'NULL') {
                                                                                                                            echo $username;
                                                                                                                        } else {
                                                                                                                            echo $full_name;
                                                                                                                        }
                                                                                                                        ?></a>

                        <address class="mt-2 not-italic"><?php if ($department != 'NULL') {
                                                                echo $department;
                                                            } else {
                                                                echo '';
                                                            }
                                                            ?></address>
                    </div>
                </div>

                <div class="p-8 bg-white rounded-lg shadow-lg lg:p-12 lg:col-span-3">
                    <?php if ($st_full_name == 'NULL' or $st_full_name == '' or $st_department == 'NULL' or $st_department == '') { ?>
                        <div class="text-center">
                            <p class="text-lg font-bold text-gray-600">Please update your profile to schedule a consultation</p>
                            <a href="../pages/edit-profile.php" class="text-lg font-bold text-pink-600">Update Profile</a>
                        </div>
                    <?php } else { ?>
                        <form action="../pages/consultation.php" method="post" class="space-y-4">
                            <div>
                                <label class="sr-only" for="name">Name</label>
                                <input class="w-full p-3 text-sm bg-gray-100 border-gray-500 rounded-lg" placeholder="Name" type="text" id="name" name="name" value="<?php echo $st_full_name; ?>" disabled />
                                <input type="hidden" id="st_id" name="st_id" value="<?php echo $st_id; ?>">
                                <input type="hidden" id="id" name="f_id" value="<?php echo $id; ?>">
                            </div>
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="sr-only" for="email">Email</label>
                                    <input class="w-full p-3 text-sm bg-gray-100 border-gray-500 rounded-lg" placeholder="Email address" type="email" id="email" name="email" value="<?php echo $st_email; ?>" disabled />
                                </div>
                                <div>
                                    <label class="sr-only" for="department">Department</label>
                                    <input class="w-full p-3 text-sm bg-gray-100 border-gray-500 rounded-lg" placeholder="Department" type="text" id="Department" name="Department" value="<?php echo $st_department; ?>" disabled />
                                </div>
                            </div>
                            <div>
                                <label class="sr-only" for="course_name">Course Name</label>
                                <input class="w-full p-3 text-sm bg-gray-100 border-gray-500 rounded-lg" placeholder="Course Name" type="text" id="course_name" name="course_name" />
                            </div>


                            <div class="grid grid-cols-1 gap-4 text-center sm:grid-cols-2">
                                <div class="relative">
                                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                        <svg aria-hidden="true" class="w-5 h-5 " fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </div>
                                    <input type="date" name="date" class="w-full p-3 text-sm bg-gray-100 border-gray-500 rounded-lg block w-full pl-10 p-2.5 datepicker-input" placeholder="Select date">
                                </div>
                                <div>
                                    <input type="time" name="time" class="w-full p-3 text-sm bg-gray-100 border-gray-500 rounded-lg block w-full pl-10 p-2.5 timepicker-input" placeholder="Select time">
                                </div>
                            </div>
                            <div>
                                <label class="sr-only" for="message">Message</label>
                                <textarea class="w-full p-3 text-sm bg-gray-100 border-gray-500 rounded-lg" placeholder="Message" rows="8" name="message" id="message"></textarea>
                            </div>
                            <div class="mt-4">
                                <button type="submit" name="submit" class="btn gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none">
                                        <path d="M9 20H6C3.79086 20 2 18.2091 2 16V7C2 4.79086 3.79086 3 6 3H17C19.2091 3 21 4.79086 21 7V10" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M8 2V4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M15 2V4" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M2 8H21" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M18.5 15.6429L17 17.1429" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        <circle cx="17" cy="17" r="5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    Schedule a Consultation
                                </button>
                            </div>
                        </form>
                    <?php } ?>
                </div>
            </div>
        </div>
    </section>
</body>
<?php include('../components/footer.php'); ?>

</html>
<?php
// create appointment from the form and add it in db
if (isset($_POST['submit'])) {
    $st_id = $_POST['st_id'];
    $f_id = $_POST['f_id'];
    $course_name = $_POST['course_name'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $message = $_POST['message'];
    $status = 'pending';
    $created_at = date('Y-m-d H:i:s');
    $updated_at = date('Y-m-d H:i:s');
    $created_by = $st_id;
    $updated_by = $st_id;
    // create appointments table sql first 

    $query = "INSERT INTO appointments (st_id, f_id, course_name, date, time, message, status, created_at, updated_at, created_by, updated_by) VALUES ('$st_id', '$f_id', '$course_name', '$date', '$time', '$message', '$status', '$created_at', '$updated_at', '$created_by', '$updated_by')";
    $result = mysqli_query($conn, $query);
    if ($result) {
        echo "<script>alert('Appointment scheduled successfully')</script>";
    } else {
        echo "<script>alert('Appointment not scheduled')</script>";
    }
}


?>