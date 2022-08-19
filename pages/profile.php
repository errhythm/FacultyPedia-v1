<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('../config.php'); 
    require_once '../db/dbConnect.php';?>
    <link href="<?php echo $css_path; ?>" rel="stylesheet">
    <!-- get Title from config.php -->
    <title><?php echo $site_name; ?></title>
</head>
<body>
    <?php include('../components/nav.php'); ?>
    <?php
    $id = $_GET['id'];
    // if theres no id, get it from the session
    if(!$id){
        $id = $_SESSION['id'];
    }
    $sql = "SELECT * FROM users WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $username = $row['username'];
    echo "<script>console.log('$username')</script>";
    $email = $row['email'];
    $role = $row['role'];?>
    <div class="px-8 py-10">
  <div class="container mx-auto px-4">
    <div class="flex flex-col items-center">
      <div class="flex-shrink-0">
        <?php
        echo '<img class="w-32 h-32 rounded-full" src="https://avatars.dicebear.com/api/bottts/'.$username.'.png" alt="">' ?>
      </div>
      <div class="flex-1 ml-4 py-4">
        <h2 class="text-2xl font-semibold"><?php echo $username; ?></h2>
        <div class="flex items-center text-gray-400 text-sm">
          <div class="flex-shrink-0">
            
          </div>
        </div>
      </div>
      <!-- check if the user is faculty or student -->
      <?php if($role == "faculty"){
        echo '<div class="flex-1 ml-4 py-4">
  <a href="../pages/review.php?id='.$id.'" class="px-5 py-2.5 relative rounded group overflow-hidden font-medium bg-purple-50 text-purple-600 inline-block">
  <span class="absolute top-0 left-0 flex w-full h-0 mb-0 transition-all duration-200 ease-out transform translate-y-0 bg-purple-600 group-hover:h-full opacity-90"></span>
  <span class="relative group-hover:text-white">Review</span>
  </a>
  <a href="#_" class="px-5 py-2.5 relative rounded group overflow-hidden font-medium bg-blue-50 text-blue-600 inline-block">
  <span class="absolute top-0 left-0 flex w-full h-0 mb-0 transition-all duration-200 ease-out transform translate-y-0 bg-blue-600 group-hover:h-full opacity-90"></span>
  <span class="relative group-hover:text-white">Consult</span>
  </a>
</div>
<div class="stats stats-vertical lg:stats-horizontal shadow items-center">
  <div class="stat">
    <div class="stat-title">Total Review</div>
    <div class="stat-value">31K</div>
  </div>
  <div class="stat">
    <div class="stat-title">Average Rating</div>
    <div class="stat-value">4.2⭐</div>
  </div>
</div>';

        }?>

    </div>
  </div>
  <?php
    session_start();
                    if(isset($_SESSION['revsuccess'])){
                        echo '
                        <div class="flex justify-center my-8">
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">Success!</strong>
                                <span class="block sm:inline">You have successfully reviewed the faculty.</span>
                            </div>';
                        unset($_SESSION['revsuccess']);
                    }
  
  ?>
</div>
<?php include('../components/review-list.php'); ?>
</body>
    <?php include('../components/footer.php'); ?>
</html>