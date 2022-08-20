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

    <title>Edit Profile - <?php echo $site_name; ?></title>
</head>

<body>
    <!-- edit your profile -->
    <?php

    include('../components/nav.php');
    $id = $_SESSION['id'];
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $full_name = $row['full_name'];
    $username = $row['username'];
    $email = $row['email'];
    $role = $row['role'];
    $department = $row['department'];
    $password = $row['password'];
    ?>

    <div class="min-h-screen p-6 bg-gray-100 flex flex-col items-center justify-center">
        <div class="container max-w-screen-lg mx-auto">
            <?php

            if (isset($_SESSION['open_banner'])) {
                if (isset($_SESSION['profile_update_success'])) {
                    $alertStatus = 'success';
                    $alertMessage = 'Profile updated successfully';
                    unset($_SESSION['profile_update_success']);
                } else if (isset($_SESSION['profile_update_failed'])) {
                    $alertStatus = 'error';
                    $alertMessage = 'Profile update failed';
                    unset($_SESSION['profile_update_failed']);
                } else if (isset($_SESSION['pass_update_success'])) {
                    $alertStatus = 'success';
                    $alertMessage = 'Password updated successfully';
                    unset($_SESSION['pass_update_success']);
                } else if (isset($_SESSION['pass_update_fail'])) {
                    $alertStatus = 'error';
                    $alertMessage = 'Password update failed';
                    unset($_SESSION['pass_update_fail']);
                } else if (isset($_SESSION['newpassword_notsame'])) {
                    $alertStatus = 'error';
                    $alertMessage = 'New password and confirm password do not match';
                    unset($_SESSION['newpassword_notsame']);
                } else if (isset($_SESSION['oldpassword_invalid'])) {
                    $alertStatus = 'error';
                    $alertMessage = 'Old password is invalid';
                    unset($_SESSION['oldpassword_invalid']);
                }

                echo '<div class="alert alert-' . $alertStatus . ' shadow-lg w-full mb-4">
                <div>';

                if ($alertStatus == 'success') {
                    echo '<svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>';
                } else {
                    echo '<svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>';
                }
                echo '<span>' . $alertMessage . '!</span>
                </div>
            </div>';
                unset($_SESSION['open_banner']);
            }

            ?>
            <div>
                <form action="../components/edit-profile.php" method="get">
                    <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                            <div class="text-gray-600">
                                <p class="font-medium text-lg">Edit Profile</p>
                            </div>
                            <div class="lg:col-span-2">
                                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                                    <div class="md:col-span-5">
                                        <label for="full_name">Full Name</label>
                                        <input type="text" name="full_name" id="full_name" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="<?php echo $full_name ?>" />
                                    </div>
                                    <div class="md:col-span-5">
                                        <label for="email">Email Address</label>
                                        <input type="text" name="email" id="email" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="<?php echo $email ?>" placeholder="" />
                                    </div>
                                    <div class="md:col-span-3">
                                        <label for="address">Username <?php
                                                                        if ($role == 'faculty') {
                                                                            echo '(Faculty Initial)';
                                                                        } elseif ($role == 'student') {
                                                                            echo '(Student ID)';
                                                                        }
                                                                        ?> </label>
                                        <input type="text" name="username" id="username" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="<?php echo $username ?>" placeholder="" disabled />
                                    </div>
                                    <div class="md:col-span-2">
                                        <label for="city">Department</label>
                                        <input type="text" name="department" id="department" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="<?php echo $department ?>" placeholder="" />
                                    </div>
                                    <div class="md:col-span-5 text-right pt-4">
                                        <div class="inline-flex items-end">
                                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="container max-w-screen-lg mx-auto">
            <div>
                <form action="../components/edit-profile.php" method="get">
                    <div class="bg-white rounded shadow-lg p-4 px-4 md:p-8 mb-6">
                        <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 lg:grid-cols-3">
                            <div class="text-gray-600">
                                <p class="font-medium text-lg">Change Password</p>
                            </div>
                            <div class="lg:col-span-2">
                                <div class="grid gap-4 gap-y-2 text-sm grid-cols-1 md:grid-cols-5">
                                    <div class="md:col-span-5">
                                        <label for="password">Current Password</label>
                                        <input type="password" name="password" id="password" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" />
                                    </div>
                                    <div class="md:col-span-5">
                                        <label for="newpassword">New Password</label>
                                        <input type="password" name="newpassword" id="newpassword" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" placeholder="" />
                                    </div>
                                    <div class="md:col-span-5">
                                        <label for="confirmnewpassword">Confirm New Password</label>
                                        <input type="password" name="confirmnewpassword" id="confirmnewpassword" class="h-10 border mt-1 rounded px-4 w-full bg-gray-50" value="" placeholder="" />
                                    </div>
                                    <div class="md:col-span-5 text-right pt-4">
                                        <div class="inline-flex items-end">
                                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Submit</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
<?php include('../components/footer.php'); ?>

</html>