<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php
	include '../config.php';
	require_once '../db/dbConnect.php';
	?>
	<link href="<?php echo $css_path; ?>" rel="stylesheet">
	<title><?php echo $site_name; ?></title>
</head>

<body>
	<img src="" alt="">
	<?php include '../components/nav.php'; ?>
	<?php
	$id = $_GET['id'];
	if (!$id) {
		$id = $_SESSION['id'];
	}
	$sql = "SELECT * FROM users WHERE id = $id";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
	$username = $row['username'];
	$email = $row['email'];
	$role = $row['role'];
	$department = $row['department'];
	$sql2 = "SELECT * FROM users WHERE id = $_SESSION[id]";
	$result2 = mysqli_query($conn, $sql2);
	$row2 = mysqli_fetch_assoc($result2);
	$visitor_id = $row2['id'];
	$visitor_role = $row2['role'];
	$visitor_username = $row2['username'];

	// echo '<script>console.log("' . $role . '")</script>';
	?>
	<div class="px-8 py-10">
		<div class="container mx-auto px-4">
			<div class="flex flex-col items-center">
				<div class="flex-shrink-0">
					<?php echo '<img class="w-32 h-32 rounded-full" src="https://avatars.dicebear.com/api/bottts/' .
						$username .
						'.png" alt="">'; ?>
				</div>
				<div class="flex-1 py-4">
					<h2 class="text-2xl font-semibold"><?php echo $username; ?></h2>
				</div>
				<?php if ($department != '') {
					echo '<div class="badge badge-lg rounded-md bg-blue-600">' . $department . '</div>';
				} ?>
				<?php
				if ($username == $_SESSION['username']) {
					echo '<div class="flex-1 py-4">
                <a href="../pages/edit-profile.php" class="px-5 py-2.5 relative rounded group overflow-hidden font-medium bg-purple-50 text-purple-600 inline-block">
                <span class="absolute top-0 left-0 flex w-full h-0 mb-0 transition-all duration-200 ease-out transform translate-y-0 bg-purple-600 group-hover:h-full opacity-90"></span>
                <span class="relative group-hover:text-white">Edit Profile</span>
                </a></div>';
				} else {
					echo '<div class="flex-1 py-4">';
				}
				if ($role == 'faculty') {
					if ($visitor_role == 'student') {
						echo '<a href="../pages/review.php?id=' . $id . '" class="px-5 py-2.5 relative rounded group overflow-hidden font-medium bg-purple-50 text-purple-600 inline-block">
								<span class="absolute top-0 left-0 flex w-full h-0 mb-0 transition-all duration-200 ease-out transform translate-y-0 bg-purple-600 group-hover:h-full opacity-90"></span>
								<span class="relative group-hover:text-white">Review</span>
								</a>
								<a href="../pages/consultation.php?id=' . $id . '" class="px-5 py-2.5 relative rounded group overflow-hidden font-medium bg-blue-50 text-blue-600 inline-block">
								<span class="absolute top-0 left-0 flex w-full h-0 mb-0 transition-all duration-200 ease-out transform translate-y-0 bg-blue-600 group-hover:h-full opacity-90"></span>
								<span class="relative group-hover:text-white">Consult</span>
								</a>
								</div>';
					}
					$sql = "SELECT * FROM review WHERE faculty = $id";
					$result = mysqli_query($conn, $sql);
					$numReviews = mysqli_num_rows($result);
					$sql = "SELECT AVG(stars) AS avg FROM review WHERE faculty = $id";
					$result = mysqli_query($conn, $sql);
					$row = mysqli_fetch_assoc($result);
					$avgReviews = $row['avg'];
					echo '<div class="stats stats-vertical lg:stats-horizontal shadow items-center">
              	<div class="stat">
                <div class="stat-title">Total Review</div>
                <div class="stat-value text-center">' .
						$numReviews .
						'</div>
              </div>
              <div class="stat">
                <div class="stat-title">Average Rating</div>
                <div class="stat-value text-center">' .
						number_format((float) $avgReviews, 2, '.', '') .
						'⭐</div>
              </div>
            </div>';
				}
				?>
			</div>
		</div>
		<?php
		session_start();
		if (isset($_SESSION['revsuccess'])) {
			echo '<div class="flex justify-center my-8">
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">Success!</strong>
                                <span class="block sm:inline">You have successfully reviewed the faculty.</span>
                            </div>';
			unset($_SESSION['revsuccess']);
		}
		?>
	</div>
	<div class="bg-white">
		<div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
			<h2 class="text-lg font-medium text-gray-900">Recent reviews</h2>
			<?php if ($visitor_role == 'faculty') {
				echo '<div class="flex justify-center my-8">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Permission Denied!</strong>
                    <span class="block sm:inline">You can not read reviews here.</span>
                </div></div>';
			} else {
				if ($role == 'faculty') {
					$sql = "SELECT * FROM review WHERE faculty = \"$id\"";
					$result = mysqli_query($conn, $sql);
					if (mysqli_num_rows($result) == 0) {
						echo '<div class="flex justify-center my-8">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">No reviews yet!</strong>
                    <span class="block sm:inline">Be the first to review this faculty.</span>
                </div>';
					} else {
						while ($row = mysqli_fetch_assoc($result)) {
							$id = $row['id'];
							$id = md5($id);
							$review = $row['review'];
							$stars = $row['stars'];
							$course = $row['course'];
							$date = date('F j, Y, g:i a', strtotime($row['date']));
							$faculty = $row['faculty'];
							$student = $row['student'];
							$sql2 = "SELECT * FROM users WHERE id = $student";
							$result2 = mysqli_query($conn, $sql2);
							$row2 = mysqli_fetch_assoc($result2);
							$studentname = $row2['username'];
							echo '<div class="mt-6 pb-10 border-t  border-gray-200 divide-y divide-gray-200 space-y-10">
                            <div class="pt-10 lg:grid lg:grid-cols-12 lg:gap-x-8">
                            <div class="lg:col-start-5 lg:col-span-8 xl:col-start-4 xl:col-span-9 xl:grid xl:grid-cols-3 xl:gap-x-8 xl:items-start">
                            <div class="flex items-center xl:col-span-1">
                              <div class="flex items-center">
                                <div class="rating rating-sm rating-half">
                                    <input type="radio" name="rating-id-' .
								$id .
								'" class="rating-hidden" value="0" disabled/>
                                    <input type="radio" name="rating-id-' .
								$id .
								'" class="bg-green-500 mask mask-star-2 mask-half-1" value="0.5"' .
								($stars == 0.5 ? 'checked disabled' : 'disabled') .
								' />                     
                                    <input type="radio" name="rating-id-' .
								$id .
								'" class="bg-green-500 mask mask-star-2 mask-half-2" value="1"' .
								($stars == 1 ? 'checked disabled' : 'disabled') .
								' />   
                                    <input type="radio" name="rating-id-' .
								$id .
								'" class="bg-green-500 mask mask-star-2 mask-half-1" value="1.5"' .
								($stars == 1.5 ? 'checked disabled' : 'disabled') .
								' />   
                                    <input type="radio" name="rating-id-' .
								$id .
								'" class="bg-green-500 mask mask-star-2 mask-half-2" value="2"' .
								($stars == 2 ? 'checked disabled' : 'disabled') .
								' />   
                                    <input type="radio" name="rating-id-' .
								$id .
								'" class="bg-green-500 mask mask-star-2 mask-half-1" value="2.5"' .
								($stars == 2.5 ? 'checked disabled' : 'disabled') .
								' />   
                                    <input type="radio" name="rating-id-' .
								$id .
								'" class="bg-green-500 mask mask-star-2 mask-half-2" value="3"' .
								($stars == 3 ? 'checked disabled' : 'disabled') .
								' />   
                                    <input type="radio" name="rating-id-' .
								$id .
								'" class="bg-green-500 mask mask-star-2 mask-half-1" value="3.5"' .
								($stars == 3.5 ? 'checked disabled' : 'disabled') .
								' />   
                                    <input type="radio" name="rating-id-' .
								$id .
								'" class="bg-green-500 mask mask-star-2 mask-half-2" value="4"' .
								($stars == 4 ? 'checked disabled' : 'disabled') .
								' />   
                                    <input type="radio" name="rating-id-' .
								$id .
								'" class="bg-green-500 mask mask-star-2 mask-half-1" value="4.5"' .
								($stars == 4.5 ? 'checked disabled' : 'disabled') .
								' />   
                                    <input type="radio" name="rating-id-' .
								$id .
								'" class="bg-green-500 mask mask-star-2 mask-half-2" value="5"' .
								($stars == 5 ? 'checked disabled' : 'disabled') .
								' />   
                                </div>
                              </div>
                              <p class="ml-3 text-sm text-gray-700">' .
								$stars .
								'<span class="sr-only"> out of 5 stars</span></p>
                          </div>
                          <div class="mt-4 lg:mt-6 xl:mt-0 xl:col-span-2">
                              <h3 class="text-sm font-medium text-gray-900">Course Name: ' .
								$course .
								'</h3>
                              <div class="mt-3 space-y-6 text-sm text-gray-500">
                                <p>' .
								$review .
								'</p>
                              </div>
                          </div>
                        </div>
                        <div class="mt-6 flex items-center text-sm lg:mt-0 lg:col-start-1 lg:col-span-4 lg:row-start-1 lg:flex-col lg:items-start xl:col-span-3">
                          <p class="font-medium text-gray-900">' .
								$studentname .
								'</p>
                          <time datetime="2021-01-06" class="ml-4 border-l border-gray-200 pl-4 text-gray-500 lg:ml-0 lg:mt-2 lg:border-0 lg:pl-0">' .
								$date .
								'</time>
                        </div>
                    </div>
                  </div>';
						}
					}
				} else {
					$sql1 = "SELECT * FROM review WHERE student = \"$id\"";
					$result1 = mysqli_query($conn, $sql1);
					if (mysqli_num_rows($result1) == 0) {
						echo '<div class="flex justify-center my-8">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">No reviews yet!</strong>
                <span class="block sm:inline">Search and review a faculty to display here.</span>
            </div>';
					} else {
						while ($row1 = mysqli_fetch_assoc($result1)) {
							$id = $row1['id'];
							$id = md5($id);
							$review = $row1['review'];
							$stars = $row1['stars'];
							$course = $row1['course'];
							$date = date('F j, Y, g:i a', strtotime($row1['date']));
							$faculty = $row1['faculty'];
							$student = $row1['student'];
							$sql2 = "SELECT * FROM users WHERE id = $faculty";
							$result2 = mysqli_query($conn, $sql2);
							$row2 = mysqli_fetch_assoc($result2);
							$facultyname = $row2['username'];
							$facultyid = $row2['id'];
							echo '<div class="mt-6 pb-10 border-t  border-gray-200 divide-y divide-gray-200 space-y-10">
        <div class="pt-10 lg:grid lg:grid-cols-12 lg:gap-x-8">
            <div class="lg:col-start-5 lg:col-span-8 xl:col-start-4 xl:col-span-9 xl:grid xl:grid-cols-3 xl:gap-x-8 xl:items-start">
              <div class="flex items-center xl:col-span-1">
                  <div class="flex items-center">
                    <div class="rating rating-sm rating-half">
                        <input type="radio" name="rating-id-' .
								$id .
								'" class="rating-hidden" value="0" disabled/>
                        <input type="radio" name="rating-id-' .
								$id .
								'" class="bg-green-500 mask mask-star-2 mask-half-1" value="0.5"' .
								($stars == 0.5 ? 'checked disabled' : 'disabled') .
								' />                     
                        <input type="radio" name="rating-id-' .
								$id .
								'" class="bg-green-500 mask mask-star-2 mask-half-2" value="1"' .
								($stars == 1 ? 'checked disabled' : 'disabled') .
								' />   
                        <input type="radio" name="rating-id-' .
								$id .
								'" class="bg-green-500 mask mask-star-2 mask-half-1" value="1.5"' .
								($stars == 1.5 ? 'checked disabled' : 'disabled') .
								' />   
                        <input type="radio" name="rating-id-' .
								$id .
								'" class="bg-green-500 mask mask-star-2 mask-half-2" value="2"' .
								($stars == 2 ? 'checked disabled' : 'disabled') .
								' />   
                        <input type="radio" name="rating-id-' .
								$id .
								'" class="bg-green-500 mask mask-star-2 mask-half-1" value="2.5"' .
								($stars == 2.5 ? 'checked disabled' : 'disabled') .
								' />   
                        <input type="radio" name="rating-id-' .
								$id .
								'" class="bg-green-500 mask mask-star-2 mask-half-2" value="3"' .
								($stars == 3 ? 'checked disabled' : 'disabled') .
								' />   
                        <input type="radio" name="rating-id-' .
								$id .
								'" class="bg-green-500 mask mask-star-2 mask-half-1" value="3.5"' .
								($stars == 3.5 ? 'checked disabled' : 'disabled') .
								' />   
                        <input type="radio" name="rating-id-' .
								$id .
								'" class="bg-green-500 mask mask-star-2 mask-half-2" value="4"' .
								($stars == 4 ? 'checked disabled' : 'disabled') .
								' />   
                        <input type="radio" name="rating-id-' .
								$id .
								'" class="bg-green-500 mask mask-star-2 mask-half-1" value="4.5"' .
								($stars == 4.5 ? 'checked disabled' : 'disabled') .
								' />   
                        <input type="radio" name="rating-id-' .
								$id .
								'" class="bg-green-500 mask mask-star-2 mask-half-2" value="5"' .
								($stars == 5 ? 'checked disabled' : 'disabled') .
								' />   
                    </div>
                  </div>
                  <p class="ml-3 text-sm text-gray-700">' .
								$stars .
								'<span class="sr-only"> out of 5 stars</span></p>
              </div>
              <div class="mt-4 lg:mt-6 xl:mt-0 xl:col-span-2">
                  <h3 class="text-sm font-medium text-gray-900">Course Name: ' .
								$course .
								'</h3>
                  <div class="mt-3 space-y-6 text-sm text-gray-500">
                    <p>' .
								$review .
								'</p>
                  </div>
              </div>
            </div>
            <div class="mt-6 flex items-center text-sm lg:mt-0 lg:col-start-1 lg:col-span-4 lg:row-start-1 lg:flex-col lg:items-start xl:col-span-3">
              <class="font-medium text-gray-900">➥ <b><a href="../pages/profile.php?id=' . $facultyid . '">' .
								$facultyname .
								'</a></b></p>
              <time datetime="2021-01-06" class="ml-4 border-l border-gray-200 pl-4 text-gray-500 lg:ml-0 lg:mt-2 lg:border-0 lg:pl-0">' .
								$date .
								'</time>
            </div>
        </div>
      </div>';
						}
					}
				}
			} ?>
		</div>
	</div>

</body>
<?php include '../components/footer.php'; ?>

</html>