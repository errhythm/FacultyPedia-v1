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
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.2/dist/flowbite.min.css" />
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
                        Schedule a consultation with <?php if ($full_name != '') {
                                                            echo $full_name;
                                                        } else {
                                                            echo $username;
                                                        }
                                                        ?>
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
                        <a href="../pages/profile.php?id=<?php echo $id; ?>" class="text-2xl font-bold text-pink-600"><?php if ($full_name != '') {
                                                                                                                            echo $username;
                                                                                                                        } else {
                                                                                                                            echo $full_name;
                                                                                                                        }
                                                                                                                        ?></a>

                        <address class="mt-2 not-italic"><?php if ($department != '') {
                                                                echo $department;
                                                            } else {
                                                                echo '';
                                                            }
                                                            ?></address>
                    </div>
                </div>

                <div class="p-8 bg-white rounded-lg shadow-lg lg:p-12 lg:col-span-3">
                    <form action="" class="space-y-4">
                        <div>
                            <label class="sr-only" for="name">Name</label>
                            <input class="w-full p-3 text-sm border-gray-200 rounded-lg" placeholder="Name" type="text" id="name" name="name" value="<?php echo $st_full_name; ?>" disabled />
                            <input type="hidden" id="st_id" name="st_id" value="<?php echo $st_id; ?>">
                            <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                        </div>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            <div>
                                <label class="sr-only" for="email">Email</label>
                                <input class="w-full p-3 text-sm border-gray-200 rounded-lg" placeholder="Email address" type="email" id="email" name="email" value="<?php echo $st_email; ?>" disabled />
                            </div>
                            <div>
                                <label class="sr-only" for="department">Department</label>
                                <input class="w-full p-3 text-sm border-gray-200 rounded-lg" placeholder="Department" type="text" id="Department" name="Department" value="<?php echo $st_department; ?>" disabled />
                            </div>
                        </div>
                        <div>
                            <label class="sr-only" for="course_name">Course Name</label>
                            <input class="w-full p-3 text-sm border-gray-200 rounded-lg" placeholder="Course Name" type="text" id="course_name" name="course_name" />
                        </div>


                        <div class="grid grid-cols-1 gap-4 text-center sm:grid-cols-2">
                            <div class="relative">
                                <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 " fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <input datepicker="" type="text" class="w-full p-3 text-sm border-gray-200 rounded-lg block w-full pl-10 p-2.5 datepicker-input" placeholder="Select date">
                            </div>


                            <div>
                                <!-- create a time picker for time input -->
                                <input type="text" class="w-full p-3 text-sm border-gray-200 rounded-lg block w-full pl-10 p-2.5 timepicker-input" placeholder="Select time">

                            </div>
                        </div>

                        <div>
                            <label class="sr-only" for="message">Message</label>
                            <textarea class="w-full p-3 text-sm border-gray-200 rounded-lg" placeholder="Message" rows="8" id="message"></textarea>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="inline-flex items-center justify-center w-full px-5 py-3 text-white bg-black rounded-lg sm:w-auto">
                                <span class="font-medium"> Send Enquiry </span>

                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ml-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script src="https://unpkg.com/flowbite@1.5.2/dist/datepicker.js"></script>
    <script src="https://unpkg.com/flowbite@1.5.2/dist/flowbite.js"></script>
</body>
<?php include('../components/footer.php'); ?>

</html>