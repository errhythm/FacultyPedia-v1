<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('../config.php');
    require_once '../db/dbConnect.php';
    ?>
    <link href="<?php echo $css_path; ?>" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.css" />
    <title>Dashboard - <?php echo $site_name; ?></title>
</head>

<body class="text-blueGray-700 antialiased">
    <?php
    // user info
    $id = $_SESSION['id'];
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $username = $row['username'];
    $email = $row['email'];
    $role = $row['role'];
    $department = $row['department'];

    // get total number of users
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);
    $total_users = mysqli_num_rows($result);

    // get total number of reviews
    $sql = "SELECT * FROM review";
    $result = mysqli_query($conn, $sql);
    $total_reviews = mysqli_num_rows($result);

    // get total number of reviews which are pending
    $sql = "SELECT * FROM review WHERE status = 'pending'";
    $result = mysqli_query($conn, $sql);
    $total_pending = mysqli_num_rows($result);

    // get total number of appointments
    $sql = "SELECT * FROM appointments";
    $result = mysqli_query($conn, $sql);
    $total_appointments = mysqli_num_rows($result);
    ?>
    <noscript>You need to enable JavaScript to run this app.</noscript>
    <div id="root">
        <nav class="md:left-0 md:block md:fixed md:top-0 md:bottom-0 md:overflow-y-auto md:flex-row md:flex-nowrap md:overflow-hidden shadow-xl bg-white flex flex-wrap items-center justify-between relative md:w-64 z-10 py-4 px-6">
            <div class="md:flex-col md:items-stretch md:min-h-full md:flex-nowrap px-0 flex flex-wrap items-center justify-between w-full mx-auto">
                <button class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent" type="button" onclick="toggleNavbar('example-collapse-sidebar')">
                    <i class="fas fa-bars"></i>
                </button>
                <a class="md:block text-left md:pb-2 text-blueGray-600 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold p-4 px-0" href="../">FacultyPedia</a>
                <ul class="md:hidden items-center flex flex-wrap list-none">

                    <li class="inline-block relative">
                        <a class="text-blueGray-500 block" href="#pablo" onclick="openDropdown(event,'user-responsive-dropdown')">
                            <div class="items-center flex">
                                <span class="w-12 h-12 text-sm text-white bg-blueGray-200 inline-flex items-center justify-center rounded-full"><img alt="<?php echo $username; ?>" class="w-full rounded-full align-middle border-none shadow-lg" src="https://avatars.dicebear.com/api/bottts/<?php echo $username; ?>.png" /></span>
                            </div>
                        </a>
                        <div class="hidden bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-lg min-w-48" id="user-responsive-dropdown">
                            <a href="/pages/profile.php" class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">Profile</a>
                            <a href="/pages/edit-profile.php" class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">Edit Profile</a>
                            <a href="/pages/logout.php" class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">Logout</a>
                        </div>
                    </li>
                </ul>
                <div class="md:flex md:flex-col md:items-stretch md:opacity-100 md:relative md:mt-4 md:shadow-none shadow absolute top-0 left-0 right-0 z-40 overflow-y-auto overflow-x-hidden h-auto items-center flex-1 rounded hidden" id="example-collapse-sidebar">
                    <div class="md:min-w-full md:hidden block pb-4 mb-4 border-b border-solid border-blueGray-200">
                        <div class="flex flex-wrap">
                            <div class="w-6/12">
                                <a class="md:block text-left md:pb-2 text-blueGray-600 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold p-4 px-0" href="../">FacultyPedia</a>
                            </div>
                            <div class="w-6/12 flex justify-end">
                                <button type="button" class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent" onclick="toggleNavbar('example-collapse-sidebar')">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- Divider -->
                    <hr class="my-4 md:min-w-full" />
                    <!-- Navigation -->

                    <ul class="md:flex-col md:min-w-full flex flex-col list-none">
                        <li class="items-center">
                            <a href="./" class="text-xs uppercase py-3 font-bold block text-pink-500 hover:text-pink-600">
                                <i class="fas fa-tv mr-2 text-sm opacity-75"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="items-center">
                            <a href="./settings.html" class="text-xs uppercase py-3 font-bold block text-blueGray-700 hover:text-blueGray-500">
                                <i class="fas fa-tools mr-2 text-sm text-blueGray-300"></i>
                                Settings
                            </a>
                        </li>
                        <?php if ($role == 'faculty') { ?>
                            <li class="items-center">
                                <a href="./tables.html" class="text-xs uppercase py-3 font-bold block text-blueGray-700 hover:text-blueGray-500">
                                    <i class="fas fa-table mr-2 text-sm text-blueGray-300"></i>
                                    Tables
                                </a>
                            </li>
                        <?php } ?>
                        <li class="items-center">
                            <a href="../pages/logout.php" class="text-xs uppercase py-3 font-bold block text-blueGray-700 hover:text-blueGray-500">
                                <i class="fas fa-right-from-bracket mr-2 text-sm text-blueGray-300"></i>
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="relative md:ml-64 bg-blueGray-50 max-h-screen">
            <nav class="absolute top-0 left-0 w-full z-10 bg-transparent md:flex-row md:flex-nowrap md:justify-start flex items-center p-4">
                <div class="w-full mx-autp items-center flex justify-between md:flex-nowrap flex-wrap md:px-10 px-4">
                    <a class="text-white text-sm uppercase hidden lg:inline-block font-semibold" href="./index.html">Dashboard</a>

                    <ul class="flex-col md:flex-row list-none items-center hidden md:flex">
                        <a class="text-blueGray-500 block cursor-pointer" onclick="openDropdown(event,'user-dropdown')">
                            <div class="items-center flex">
                                <span class="w-12 h-12 text-sm text-white bg-blueGray-200 inline-flex items-center justify-center rounded-full"><img alt="<?php echo $username; ?>" class="w-full rounded-full align-middle border-none shadow-lg" src="https://avatars.dicebear.com/api/bottts/<?php echo $username; ?>.png" /></span>
                            </div>
                        </a>
                        <div class="hidden bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-lg min-w-48" id="user-dropdown">
                            <a href="/pages/profile.php" class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">Profile</a>
                            <a href="/pages/edit-profile.php" class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">Edit Profile</a>
                            <a href="/pages/logout.php" class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-blueGray-700">Logout</a>
                        </div>
                    </ul>
                </div>
            </nav>
            <!-- Header -->
            <div class="relative bg-pink-600 md:pt-32 pb-32 pt-12">
                <div class="px-4 md:px-10 mx-auto w-full">
                    <div>
                        <!-- Card stats -->
                        <div class="flex flex-wrap">
                            <!-- show if user is admin -->
                            <?php if ($role == 'admin') { ?>
                                <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
                                    <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                                        <div class="flex-auto p-4">
                                            <div class="flex flex-wrap">
                                                <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                                    <h5 class="text-blueGray-400 uppercase font-bold text-xs">
                                                        Total Reviews
                                                    </h5>
                                                    <span class="font-semibold text-xl text-blueGray-700">
                                                        <?php echo $total_reviews; ?>
                                                    </span>
                                                </div>
                                                <div class="relative w-auto pl-4 flex-initial">
                                                    <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-red-500">
                                                        <i class="far fa-star"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
                                    <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                                        <div class="flex-auto p-4">
                                            <div class="flex flex-wrap">
                                                <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                                    <h5 class="text-blueGray-400 uppercase font-bold text-xs">
                                                        Pending Reviews
                                                    </h5>
                                                    <span class="font-semibold text-xl text-blueGray-700">
                                                        <?php echo $total_pending; ?>
                                                    </span>
                                                </div>
                                                <div class="relative w-auto pl-4 flex-initial">
                                                    <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-red-500">
                                                        <i class="far fa-clock"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
                                    <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                                        <div class="flex-auto p-4">
                                            <div class="flex flex-wrap">
                                                <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                                    <h5 class="text-blueGray-400 uppercase font-bold text-xs">
                                                        Total Appointments
                                                    </h5>
                                                    <span class="font-semibold text-xl text-blueGray-700">
                                                        <?php echo $total_appointments; ?>
                                                    </span>
                                                </div>
                                                <div class="relative w-auto pl-4 flex-initial">
                                                    <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-red-500">
                                                        <i class="far fa-calendar-check"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
                                    <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                                        <div class="flex-auto p-4">
                                            <div class="flex flex-wrap">
                                                <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                                    <h5 class="text-blueGray-400 uppercase font-bold text-xs">
                                                        Total Users
                                                    </h5>
                                                    <span class="font-semibold text-xl text-blueGray-700">
                                                        <?php echo $total_users; ?>
                                                    </span>
                                                </div>
                                                <div class="relative w-auto pl-4 flex-initial">
                                                    <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-red-500">
                                                        <i class="far fa-user"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($role == 'faculty') { ?>
                                <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
                                    <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                                        <div class="flex-auto p-4">
                                            <div class="flex flex-wrap">
                                                <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                                    <h5 class="text-blueGray-400 uppercase font-bold text-xs">
                                                        Total Reviews
                                                    </h5>
                                                    <span class="font-semibold text-xl text-blueGray-700">
                                                        <?php echo $total_reviews; ?>
                                                    </span>
                                                </div>
                                                <div class="relative w-auto pl-4 flex-initial">
                                                    <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-red-500">
                                                        <i class="far fa-chart-bar"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
                                    <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                                        <div class="flex-auto p-4">
                                            <div class="flex flex-wrap">
                                                <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                                    <h5 class="text-blueGray-400 uppercase font-bold text-xs">
                                                        New users
                                                    </h5>
                                                    <span class="font-semibold text-xl text-blueGray-700">
                                                        2,356
                                                    </span>
                                                </div>
                                                <div class="relative w-auto pl-4 flex-initial">
                                                    <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-orange-500">
                                                        <i class="fas fa-chart-pie"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="text-sm text-blueGray-400 mt-4">
                                                <span class="text-red-500 mr-2">
                                                    <i class="fas fa-arrow-down"></i> 3.48%
                                                </span>
                                                <span class="whitespace-nowrap"> Since last week </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
                                    <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                                        <div class="flex-auto p-4">
                                            <div class="flex flex-wrap">
                                                <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                                    <h5 class="text-blueGray-400 uppercase font-bold text-xs">
                                                        Sales
                                                    </h5>
                                                    <span class="font-semibold text-xl text-blueGray-700">
                                                        924
                                                    </span>
                                                </div>
                                                <div class="relative w-auto pl-4 flex-initial">
                                                    <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-pink-500">
                                                        <i class="fas fa-users"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="text-sm text-blueGray-400 mt-4">
                                                <span class="text-orange-500 mr-2">
                                                    <i class="fas fa-arrow-down"></i> 1.10%
                                                </span>
                                                <span class="whitespace-nowrap"> Since yesterday </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="w-full lg:w-6/12 xl:w-3/12 px-4">
                                    <div class="relative flex flex-col min-w-0 break-words bg-white rounded mb-6 xl:mb-0 shadow-lg">
                                        <div class="flex-auto p-4">
                                            <div class="flex flex-wrap">
                                                <div class="relative w-full pr-4 max-w-full flex-grow flex-1">
                                                    <h5 class="text-blueGray-400 uppercase font-bold text-xs">
                                                        Performance
                                                    </h5>
                                                    <span class="font-semibold text-xl text-blueGray-700">
                                                        49,65%
                                                    </span>
                                                </div>
                                                <div class="relative w-auto pl-4 flex-initial">
                                                    <div class="text-white p-3 text-center inline-flex items-center justify-center w-12 h-12 shadow-lg rounded-full bg-lightBlue-500">
                                                        <i class="fas fa-percent"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <p class="text-sm text-blueGray-400 mt-4">
                                                <span class="text-emerald-500 mr-2">
                                                    <i class="fas fa-arrow-up"></i> 12%
                                                </span>
                                                <span class="whitespace-nowrap">
                                                    Since last month
                                                </span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-4 md:px-10 mx-auto w-full -m-24">
                <div class="flex flex-wrap mt-4">
                    <div class="w-full xl:w-8/12 mb-12 xl:mb-0 px-4">
                        <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                            <div class="rounded-t mb-0 px-4 py-3 border-0">
                                <div class="flex flex-wrap items-center">
                                    <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                                        <h3 class="font-semibold text-base text-blueGray-700">
                                            Page visits
                                        </h3>
                                    </div>
                                    <div class="relative w-full px-4 max-w-full flex-grow flex-1 text-right">
                                        <button class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button">
                                            See all
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="block w-full overflow-x-auto">
                                <!-- Projects table -->
                                <table class="items-center w-full bg-transparent border-collapse">
                                    <thead>
                                        <tr>
                                            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                                Page name
                                            </th>
                                            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                                Visitors
                                            </th>
                                            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                                Unique users
                                            </th>
                                            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                                Bounce rate
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                                /argon/
                                            </th>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                4,569
                                            </td>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                340
                                            </td>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                <i class="fas fa-arrow-up text-emerald-500 mr-4"></i>
                                                46,53%
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                                /argon/index.html
                                            </th>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                3,985
                                            </td>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                319
                                            </td>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                <i class="fas fa-arrow-down text-orange-500 mr-4"></i>
                                                46,53%
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                                /argon/charts.html
                                            </th>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                3,513
                                            </td>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                294
                                            </td>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                <i class="fas fa-arrow-down text-orange-500 mr-4"></i>
                                                36,49%
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                                /argon/tables.html
                                            </th>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                2,050
                                            </td>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                147
                                            </td>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                <i class="fas fa-arrow-up text-emerald-500 mr-4"></i>
                                                50,87%
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                                /argon/profile.html
                                            </th>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                1,795
                                            </td>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                190
                                            </td>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                <i class="fas fa-arrow-down text-red-500 mr-4"></i>
                                                46,53%
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="w-full xl:w-4/12 px-4">
                        <div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-lg rounded">
                            <div class="rounded-t mb-0 px-4 py-3 border-0">
                                <div class="flex flex-wrap items-center">
                                    <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                                        <h3 class="font-semibold text-base text-blueGray-700">
                                            Social traffic
                                        </h3>
                                    </div>
                                    <div class="relative w-full px-4 max-w-full flex-grow flex-1 text-right">
                                        <button class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150" type="button">
                                            See all
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="block w-full overflow-x-auto">
                                <!-- Projects table -->
                                <table class="items-center w-full bg-transparent border-collapse">
                                    <thead class="thead-light">
                                        <tr>
                                            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                                Referral
                                            </th>
                                            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left">
                                                Visitors
                                            </th>
                                            <th class="px-6 bg-blueGray-50 text-blueGray-500 align-middle border border-solid border-blueGray-100 py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left min-w-140-px"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                                Facebook
                                            </th>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                1,480
                                            </td>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                <div class="flex items-center">
                                                    <span class="mr-2">60%</span>
                                                    <div class="relative w-full">
                                                        <div class="overflow-hidden h-2 text-xs flex rounded bg-red-200">
                                                            <div style="width: 60%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-red-500"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                                Facebook
                                            </th>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                5,480
                                            </td>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                <div class="flex items-center">
                                                    <span class="mr-2">70%</span>
                                                    <div class="relative w-full">
                                                        <div class="overflow-hidden h-2 text-xs flex rounded bg-emerald-200">
                                                            <div style="width: 70%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-emerald-500"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                                Google
                                            </th>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                4,807
                                            </td>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                <div class="flex items-center">
                                                    <span class="mr-2">80%</span>
                                                    <div class="relative w-full">
                                                        <div class="overflow-hidden h-2 text-xs flex rounded bg-purple-200">
                                                            <div style="width: 80%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-purple-500"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                                Instagram
                                            </th>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                3,678
                                            </td>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                <div class="flex items-center">
                                                    <span class="mr-2">75%</span>
                                                    <div class="relative w-full">
                                                        <div class="overflow-hidden h-2 text-xs flex rounded bg-lightBlue-200">
                                                            <div style="width: 75%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-lightBlue-500"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left">
                                                twitter
                                            </th>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                2,645
                                            </td>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                <div class="flex items-center">
                                                    <span class="mr-2">30%</span>
                                                    <div class="relative w-full">
                                                        <div class="overflow-hidden h-2 text-xs flex rounded bg-orange-200">
                                                            <div style="width: 30%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-emerald-500"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <footer class="block py-4">
                    <div class="container mx-auto px-4">
                        <hr class="mb-4 border-b-1 border-blueGray-200" />
                        <div class="flex flex-wrap items-center md:justify-between justify-center">
                            <div class="w-full md:w-4/12 px-4">
                                <div class="text-sm text-blueGray-500 font-semibold py-1 text-center md:text-left">
                                    Copyright © <span id="get-current-year"></span>
                                    <a href="https://www.creative-tim.com?ref=njs-dashboard" class="text-blueGray-500 hover:text-blueGray-700 text-sm font-semibold py-1">
                                        Creative Tim
                                    </a>
                                </div>
                            </div>
                            <div class="w-full md:w-8/12 px-4">
                                <ul class="flex flex-wrap list-none md:justify-end justify-center">
                                    <li>
                                        <a href="https://www.creative-tim.com?ref=njs-dashboard" class="text-blueGray-600 hover:text-blueGray-800 text-sm font-semibold block py-1 px-3">
                                            Creative Tim
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://www.creative-tim.com/presentation?ref=njs-dashboard" class="text-blueGray-600 hover:text-blueGray-800 text-sm font-semibold block py-1 px-3">
                                            About Us
                                        </a>
                                    </li>
                                    <li>
                                        <a href="http://blog.creative-tim.com?ref=njs-dashboard" class="text-blueGray-600 hover:text-blueGray-800 text-sm font-semibold block py-1 px-3">
                                            Blog
                                        </a>
                                    </li>
                                    <li>
                                        <a href="https://github.com/creativetimofficial/notus-js/blob/main/LICENSE.md?ref=njs-dashboard" class="text-blueGray-600 hover:text-blueGray-800 text-sm font-semibold block py-1 px-3">
                                            MIT License
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" charset="utf-8"></script>
    <script src="https://unpkg.com/@popperjs/core@2/dist/umd/popper.js"></script>
    <script type="text/javascript">
        /* Make dynamic date appear */
        (function() {
            if (document.getElementById("get-current-year")) {
                document.getElementById("get-current-year").innerHTML =
                    new Date().getFullYear();
            }
        })();
        /* Sidebar - Side navigation menu on mobile/responsive mode */
        function toggleNavbar(collapseID) {
            document.getElementById(collapseID).classList.toggle("hidden");
            document.getElementById(collapseID).classList.toggle("bg-white");
            document.getElementById(collapseID).classList.toggle("m-2");
            document.getElementById(collapseID).classList.toggle("py-3");
            document.getElementById(collapseID).classList.toggle("px-6");
        }
        /* Function for dropdowns */
        function openDropdown(event, dropdownID) {
            let element = event.target;
            while (element.nodeName !== "A") {
                element = element.parentNode;
            }
            Popper.createPopper(element, document.getElementById(dropdownID), {
                placement: "bottom-start"
            });
            document.getElementById(dropdownID).classList.toggle("hidden");
            document.getElementById(dropdownID).classList.toggle("block");
        }

        (function() {
            /* Chart initialisations */
            /* Line Chart */
            var config = {
                type: "line",
                data: {
                    labels: [
                        "January",
                        "February",
                        "March",
                        "April",
                        "May",
                        "June",
                        "July"
                    ],
                    datasets: [{
                            label: new Date().getFullYear(),
                            backgroundColor: "#4c51bf",
                            borderColor: "#4c51bf",
                            data: [65, 78, 66, 44, 56, 67, 75],
                            fill: false
                        },
                        {
                            label: new Date().getFullYear() - 1,
                            fill: false,
                            backgroundColor: "#fff",
                            borderColor: "#fff",
                            data: [40, 68, 86, 74, 56, 60, 87]
                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    title: {
                        display: false,
                        text: "Sales Charts",
                        fontColor: "white"
                    },
                    legend: {
                        labels: {
                            fontColor: "white"
                        },
                        align: "end",
                        position: "bottom"
                    },
                    tooltips: {
                        mode: "index",
                        intersect: false
                    },
                    hover: {
                        mode: "nearest",
                        intersect: true
                    },
                    scales: {
                        xAxes: [{
                            ticks: {
                                fontColor: "rgba(255,255,255,.7)"
                            },
                            display: true,
                            scaleLabel: {
                                display: false,
                                labelString: "Month",
                                fontColor: "white"
                            },
                            gridLines: {
                                display: false,
                                borderDash: [2],
                                borderDashOffset: [2],
                                color: "rgba(33, 37, 41, 0.3)",
                                zeroLineColor: "rgba(0, 0, 0, 0)",
                                zeroLineBorderDash: [2],
                                zeroLineBorderDashOffset: [2]
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                fontColor: "rgba(255,255,255,.7)"
                            },
                            display: true,
                            scaleLabel: {
                                display: false,
                                labelString: "Value",
                                fontColor: "white"
                            },
                            gridLines: {
                                borderDash: [3],
                                borderDashOffset: [3],
                                drawBorder: false,
                                color: "rgba(255, 255, 255, 0.15)",
                                zeroLineColor: "rgba(33, 37, 41, 0)",
                                zeroLineBorderDash: [2],
                                zeroLineBorderDashOffset: [2]
                            }
                        }]
                    }
                }
            };
            var ctx = document.getElementById("line-chart").getContext("2d");
            window.myLine = new Chart(ctx, config);

            /* Bar Chart */
            config = {
                type: "bar",
                data: {
                    labels: [
                        "January",
                        "February",
                        "March",
                        "April",
                        "May",
                        "June",
                        "July"
                    ],
                    datasets: [{
                            label: new Date().getFullYear(),
                            backgroundColor: "#ed64a6",
                            borderColor: "#ed64a6",
                            data: [30, 78, 56, 34, 100, 45, 13],
                            fill: false,
                            barThickness: 8
                        },
                        {
                            label: new Date().getFullYear() - 1,
                            fill: false,
                            backgroundColor: "#4c51bf",
                            borderColor: "#4c51bf",
                            data: [27, 68, 86, 74, 10, 4, 87],
                            barThickness: 8
                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    responsive: true,
                    title: {
                        display: false,
                        text: "Orders Chart"
                    },
                    tooltips: {
                        mode: "index",
                        intersect: false
                    },
                    hover: {
                        mode: "nearest",
                        intersect: true
                    },
                    legend: {
                        labels: {
                            fontColor: "rgba(0,0,0,.4)"
                        },
                        align: "end",
                        position: "bottom"
                    },
                    scales: {
                        xAxes: [{
                            display: false,
                            scaleLabel: {
                                display: true,
                                labelString: "Month"
                            },
                            gridLines: {
                                borderDash: [2],
                                borderDashOffset: [2],
                                color: "rgba(33, 37, 41, 0.3)",
                                zeroLineColor: "rgba(33, 37, 41, 0.3)",
                                zeroLineBorderDash: [2],
                                zeroLineBorderDashOffset: [2]
                            }
                        }],
                        yAxes: [{
                            display: true,
                            scaleLabel: {
                                display: false,
                                labelString: "Value"
                            },
                            gridLines: {
                                borderDash: [2],
                                drawBorder: false,
                                borderDashOffset: [2],
                                color: "rgba(33, 37, 41, 0.2)",
                                zeroLineColor: "rgba(33, 37, 41, 0.15)",
                                zeroLineBorderDash: [2],
                                zeroLineBorderDashOffset: [2]
                            }
                        }]
                    }
                }
            };
            ctx = document.getElementById("bar-chart").getContext("2d");
            window.myBar = new Chart(ctx, config);
        })();
    </script>
</body>
<script src="https://kit.fontawesome.com/692c2638c1.js" crossorigin="anonymous"></script>

</html>