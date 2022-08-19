<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('../config.php');
    require_once '../db/dbConnect.php';
    ?>
    <link href="<?php echo $css_path; ?>" rel="stylesheet">
    <!-- get Title from config.php -->

    <title>Search - <?php echo $site_name; ?></title>
</head>
<body>
    <?php 
        include('../components/nav.php'); 
        echo '<div class="px-4 py-16">
<h1 class="text-3xl font-semibold text-center py-10 text-gray-900">
Search
</h1>
<div class="max-w-4xl mx-auto">
	<form class="flex items-center" action="../pages/search.php" method="get">   
        <label for="simple-search" class="sr-only">Search</label>
        <div class="relative w-full">
            <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
            </div>';
        $search = $_GET['search'];


        echo '<input type="text" name="search" id="simple-search" class="bg-white-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5" placeholder="Search" value="'.$search.'" required>
        </div>
        <button type="submit" class="p-2.5 ml-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg></button>
    </form>
</div>
</div>';

        $sql = "SELECT * FROM users WHERE username LIKE '%$search%' AND role = 'faculty'";

        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);

        if($resultCheck > 0){
            echo '<div class="container mx-auto px-4 sm:px-8 min-h-screen">
    <div class="py-8">
        <div class="-mx-4 sm:-mx-8 px-4 sm:px-8 py-4 overflow-x-auto">
            <div class="inline-block min-w-full shadow rounded-lg overflow-hidden">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th scope="col" class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
                                User
                            </th>
                            <th scope="col" class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
                                Role
                            </th>
                            <th scope="col" class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
                                Created at
                            </th>
                            <th scope="col" class="px-5 py-3 bg-white  border-b border-gray-200 text-gray-800  text-left text-sm uppercase font-normal">
                                Profile
                            </th>
                        </tr>
                    </thead>
                    <tbody>';
            while($row = mysqli_fetch_assoc($result)){
                $id = $row['id'];
                $username = $row['username'];
                $email = $row['email'];
                $role = $row['role'];
                $reg_date = $row['reg_date'];
                $department = $row['department'];

                echo '<tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <a href="../pages/profile.php?id='.$id.'" class="block relative">
                                            <img alt="profile" src="https://avatars.dicebear.com/api/bottts/'.$username.'.png" class="mx-auto object-cover rounded-full h-10 w-10 "/>
                                        </a>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-gray-900 whitespace-no-wrap">
                                            <a href="../pages/profile.php?id='.$id.'" class="text-base leading-6 font-medium text-gray-900">'.$username.'</a>
                                        </p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    '.ucwords($department).'
                                </p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    '.$reg_date.'
                                </p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                    <span aria-hidden="true" class="absolute inset-0 bg-green-200 opacity-50 rounded-full">
                                    </span>
                                    <span class="relative">
                                        <a href="../pages/profile.php?id='.$id.'" class="block hover:bg-green-100 text-green-900">
                                            View Profile
                                        </a>
                                    </span>
                                </span>
                            </td>
                        </tr>';
            }
        }
        else{
            echo '<div class="container mx-auto px-4 sm:px-8 min-h-screen">
    <div class="py-8">
            <div class="flex flex-col items-center justify-center">
                <p class="text-2xl font-semibold">No results found</p>
                <p class="text-lg">Try again with different keywords</p>
            </div>
        </div>
    </div>';
        }


        echo '</tbody>
                </table>
            </div>
        </div>
    </div>
</div>';
    ?>
</body>
    <?php include('../components/footer.php'); ?>
</html>