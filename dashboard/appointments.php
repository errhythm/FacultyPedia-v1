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

    // get user's appointments
    $sql = "SELECT * FROM appointments WHERE f_id = $id AND status = 'approved'";
    $result = mysqli_query($conn, $sql);
    $approved_appointments = mysqli_num_rows($result);

    // get user's pending appointments
    $sql = "SELECT * FROM appointments WHERE f_id = $id AND status = 'pending'";
    $result = mysqli_query($conn, $sql);
    $pending_appointments = mysqli_num_rows($result);

    // get user's completed appointments
    $sql = "SELECT * FROM appointments WHERE f_id = $id AND status = 'completed'";
    $result = mysqli_query($conn, $sql);
    $completed_appointments = mysqli_num_rows($result);

    // get faculty average rating
    $sql = "SELECT AVG(stars) AS rating FROM review WHERE faculty = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $faculty_rating = $row['rating'];

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


                    <?php include('../components/dashboard-navigation.php'); ?>
                </div>
            </div>
        </nav>
        <div class="relative md:ml-64 bg-blueGray-50 max-h-screen">
            <nav class="absolute top-0 left-0 w-full z-10 bg-transparent md:flex-row md:flex-nowrap md:justify-start flex items-center p-4">
                <div class="w-full mx-auto items-center flex justify-between md:flex-nowrap flex-wrap md:px-10 px-4">
                    <a class="text-white text-sm uppercase hidden lg:inline-block font-semibold" href="./">Dashboard</a>

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
                        <div class="flex flex-wrap">
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($role == 'faculty') { ?>
                <div class="px-4 md:px-10 mx-auto w-full -m-24">
                    <div class="flex flex-wrap mt-4">
                        <div class="w-full xl:w-12/12 mb-12 xl:mb-0 px-4">
                            <div class="relative flex flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded bg-white">
                                <div class="rounded-t mb-0 px-4 py-3 border-0">
                                    <div class="flex flex-wrap items-center">
                                        <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                                            <h3 class="font-semibold text-lg text-blueGray-700">
                                                Appointments
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="block w-full overflow-x-auto">
                                    <table class="items-center w-full bg-transparent border-collapse">
                                        <thead>
                                            <tr>
                                                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                                    Appointment Time
                                                </th>
                                                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                                    Student
                                                </th>
                                                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                                    Message
                                                </th>
                                                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100">
                                                    Course Name
                                                </th>
                                                <th class="px-6 align-middle border border-solid py-3 text-xs uppercase border-l-0 border-r-0 whitespace-nowrap font-semibold text-left bg-blueGray-50 text-blueGray-500 border-blueGray-100"></th>
                                            </tr>
                                        </thead>
                                        <?php
                                        // get all pending appointments where the faculty is the current user and order by date, if date is same, order by time
                                        $sql = "SELECT * FROM appointments WHERE f_id = '$id' AND status = 'approved' ORDER BY date, time ASC";
                                        $result = mysqli_query($conn, $sql);
                                        $resultCheck = mysqli_num_rows($result);
                                        if ($resultCheck > 0) {
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $appointment_id = $row['id'];
                                                $st_id = $row['st_id'];
                                                $f_id = $row['f_id'];
                                                $course_name = $row['course_name'];
                                                $date = $row['date'];
                                                $time = $row['time'];
                                                $message = $row['message'];
                                                $status = $row['status'];
                                                $created_at = $row['created_at'];
                                                $updated_at = $row['updated_at'];
                                                $created_by = $row['created_by'];
                                                $updated_by = $row['updated_by'];
                                                $appointment_date = date("F j, Y, g:i a", strtotime($date . " " . $time));

                                                $sql2 = "SELECT * FROM users WHERE id = '$st_id'";
                                                $result2 = mysqli_query($conn, $sql2);
                                                $resultCheck2 = mysqli_num_rows($result2);
                                                $row2 = mysqli_fetch_assoc($result2);
                                                $st_name = $row2['username'];

                                                $sql3 = "SELECT * FROM users WHERE id = '$f_id'";
                                                $result3 = mysqli_query($conn, $sql3);
                                                $resultCheck3 = mysqli_num_rows($result3);
                                                $row3 = mysqli_fetch_assoc($result3);
                                                $f_name = $row3['username'];
                                        ?>
                                                <tbody>
                                                    <tr>
                                                        <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left flex items-center">
                                                            <span class="ml-3 font-bold text-blueGray-600">
                                                                <?php echo $appointment_date; ?>
                                                            </span>
                                                        </th>
                                                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                            <span class="ml-3 font-bold text-blueGray-600"><?php echo $st_name; ?></span>
                                                        </td>
                                                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4"><?php echo $message; ?></td>
                                                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4">
                                                            <span class="ml-3 font-bold text-blueGray-600"><?php echo $course_name; ?></span>
                                                        </td>
                                                        <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-right">
                                                            <a href="#" class="text-blueGray-500 block py-1 px-3" onclick="openDropdown(event,'table-appointment-<?php echo $appointment_id; ?>-dropdown')">
                                                                <i class="fas fa-ellipsis-v"></i>
                                                            </a>
                                                            <div class="hidden bg-white text-base z-50 float-left py-2 list-none text-left rounded shadow-lg min-w-48" id="table-appointment-<?php echo $appointment_id; ?>-dropdown">
                                                                <a href="../components/pending-appointment.php?ap_id=<?php echo $appointment_id; ?>&status=approved" class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-green-700">Approve</a>
                                                                <a href="../components/pending-appointment.php?ap_id=<?php echo $appointment_id; ?>&status=rejected" class="text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-red-700">Reject</a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                        <?php
                                            }
                                        }

                                        ?>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
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
</script>
<script src="https://kit.fontawesome.com/692c2638c1.js" crossorigin="anonymous"></script>

</html>