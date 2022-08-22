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
	?>


	<!-- New Profile -->
	<!-- component
	<link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/styles/tailwind.css"> -->
	<link rel="stylesheet" href="https://demos.creative-tim.com/notus-js/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css">


	<main class="profile-page">
		<section class="relative block h-96">
			<div class="absolute top-0 w-full h-full bg-center bg-cover bg-gradient-to-r from-purple-500 to-pink-500">
				<span id="blackOverlay" class="w-full h-full absolute opacity-50 bg-black"></span>
			</div>
		</section>
		<section class="relative py-16 bg-blueGray-200">
			<div class="container mx-auto px-4">
				<div class="relative flex flex-col min-w-0 break-words bg-white w-full mb-6 shadow-xl rounded-lg -mt-64">
					<div class="px-6">
						<div class="flex flex-wrap justify-center">
							<div class="w-full lg:w-3/12 px-4 lg:order-2 flex justify-center">
								<div class="relative">
									<img alt="<?php echo $username; ?>" src="https://avatars.dicebear.com/api/bottts/<?php echo $username; ?>.png" class="rounded-full w-36 h-36 align-middle border-none max-w-max absolute -m-16 -ml-20 lg:-ml-16">
								</div>
							</div>
							<div class="w-full lg:w-4/12 px-4 lg:order-3 lg:text-right lg:self-center">
								<div class="py-6 px-3 mt-32 sm:mt-0">
									<?php
									if ($username == $_SESSION['username']) { ?>
										<button onclick="location.href='../pages/edit-profile.php'" class="bg-pink-500 active:bg-pink-600 uppercase text-white font-bold hover:shadow-md shadow text-xs px-4 py-2 rounded outline-none focus:outline-none sm:mr-2 mb-1 ease-linear transition-all duration-150" type="button">Edit Profile</button>
									<?php } ?>
									<?php if ($role == 'faculty' and $visitor_role == 'student') { ?>
										<button onclick="location.href='../pages/review.php?id=<?php echo $id; ?>'" class="bg-pink-500 active:bg-pink-600 uppercase text-white font-bold hover:shadow-md shadow text-xs px-4 py-2 rounded outline-none focus:outline-none sm:mr-2 mb-1 ease-linear transition-all duration-150" type="button">Review</button>
										<button onclick="location.href='../pages/consultation.php?id=<?php echo $id; ?>'" class="bg-pink-500 active:bg-pink-600 uppercase text-white font-bold hover:shadow-md shadow text-xs px-4 py-2 rounded outline-none focus:outline-none sm:mr-2 mb-1 ease-linear transition-all duration-150" type="button">Consult</button>
									<?php } ?>
									<?php
									$sql = "SELECT * FROM review WHERE faculty = $id";
									$result = mysqli_query($conn, $sql);
									$numReviews = mysqli_num_rows($result);
									$sql = "SELECT AVG(stars) AS avg FROM review WHERE faculty = $id";
									$result = mysqli_query($conn, $sql);
									$row = mysqli_fetch_assoc($result);
									$avgReviews = $row['avg'];
									?>
								</div>
							</div>
							<div class="w-full lg:w-4/12 px-4 lg:order-1">
								<div class="flex justify-center py-4 lg:pt-4 pt-8">
									<?php if ($role == 'faculty') { ?>
										<div class="mr-4 p-3 text-center">
											<span class="text-xl font-bold block uppercase tracking-wide text-blueGray-600"><?php echo $numReviews; ?></span><span class="text-sm text-blueGray-400">Reviews</span>
										</div>
										<div class="mr-4 p-3 text-center">
											<span class="text-xl font-bold block uppercase tracking-wide text-blueGray-600"><?php echo number_format((float) $avgReviews, 2, '.', '') . '⭐'; ?></span><span class="text-sm text-blueGray-400">Avg. Rating</span>
										</div>
									<?php } ?>
								</div>
							</div>
						</div>
						<div class="text-center mt-8">
							<h3 class="text-4xl font-semibold leading-normal mb-2 text-blueGray-700 mb-2">
								<?php echo $username; ?>
							</h3>
							<?php if ($department != '') { ?>
								<div class="text-sm leading-normal mt-0 mb-2 text-blueGray-400 font-bold uppercase">
									<i class="fas fa-map-marker-alt mr-2 text-lg text-blueGray-400"></i><?php echo $department; ?>
								</div>
							<?php } ?>
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

						<div class="mt-10 py-10 border-t border-blueGray-200 ">
							<div class="flex flex-wrap justify-center">
								<div class="w-full lg:w-9/12 px-4">
									<h1 class="mb-4 text-2xl font-bold leading-relaxed text-blueGray-700 text-center">Recent reviews</h1>
									<!-- start of reviews -->
									<?php
									if ($role == 'faculty') {
										$sql = "SELECT * FROM review WHERE faculty = \"$id\" AND status = \"approved\"";
										$result = mysqli_query($conn, $sql);
										if (mysqli_num_rows($result) == 0) {
											echo '<div class="flex justify-center my-8">
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">No reviews yet!</strong>
                    <span class="block sm:inline">Be the first to review this faculty.</span>
                </div>';
										} else {
											while ($row = mysqli_fetch_assoc($result)) {
												$revid = $row['id'];
												$review = $row['review'];
												$stars = $row['stars'];
												$course = $row['course'];
												$date = date('F j, Y, g:i a', strtotime($row['date']));
												$faculty = $row['faculty'];
												$student = $row['student'];
												$anonymous = $row['anonymous'];

												$animalName = array(
													0 => 'Aardvark', 1 => 'Albatross', 2 => 'Alligator', 3 => 'Alpaca', 4 => 'Ant', 5 => 'Anteater', 6 => 'Antelope', 7 => 'Ape', 8 => 'Armadillo', 9 => 'Donkey', 10 => 'Baboon', 11 => 'Badger', 12 => 'Barracuda', 13 => 'Bat', 14 => 'Bear', 15 => 'Beaver', 16 => 'Bee', 17 => 'Bison', 18 => 'Boar', 19 => 'Buffalo', 20 => 'Butterfly', 21 => 'Camel', 22 => 'Capybara', 23 => 'Caribou', 24 => 'Cassowary', 25 => 'Cat', 26 => 'Caterpillar', 27 => 'Cattle', 28 => 'Chamois', 29 => 'Cheetah', 30 => 'Chicken', 31 => 'Chimpanzee', 32 => 'Chinchilla', 33 => 'Chough', 34 => 'Clam', 35 => 'Cobra', 36 => 'Cockroach', 37 => 'Cod', 38 => 'Cormorant', 39 => 'Coyote', 40 => 'Crab', 41 => 'Crane', 42 => 'Crocodile', 43 => 'Crow', 44 => 'Curlew', 45 => 'Deer', 46 => 'Dinosaur', 47 => 'Dog', 48 => 'Dogfish', 49 => 'Dolphin', 50 => 'Dotterel', 51 => 'Dove', 52 => 'Dragonfly', 53 => 'Duck', 54 => 'Dugong', 55 => 'Dunlin', 56 => 'Eagle', 57 => 'Echidna', 58 => 'Eel', 59 => 'Eland', 60 => 'Elephant', 61 => 'Elk', 62 => 'Emu', 63 => 'Falcon', 64 => 'Ferret', 65 => 'Finch', 66 => 'Fish', 67 => 'Flamingo', 68 => 'Fly', 69 => 'Fox', 70 => 'Frog', 71 => 'Gaur', 72 => 'Gazelle', 73 => 'Gerbil', 74 => 'Giraffe', 75 => 'Gnat', 76 => 'Gnu', 77 => 'Goat', 78 => 'Goldfinch', 79 => 'Goldfish', 80 => 'Goose', 81 => 'Gorilla', 82 => 'Goshawk', 83 => 'Grasshopper', 84 => 'Grouse', 85 => 'Guanaco', 86 => 'Gull', 87 => 'Hamster', 88 => 'Hare', 89 => 'Hawk', 90 => 'Hedgehog', 91 => 'Heron', 92 => 'Herring', 93 => 'Hippopotamus', 94 => 'Hornet', 95 => 'Horse', 96 => 'Human', 97 => 'Hummingbird', 98 => 'Hyena', 99 => 'Ibex', 100 => 'Ibis', 101 => 'Jackal', 102 => 'Jaguar', 103 => 'Jay', 104 => 'Jellyfish', 105 => 'Kangaroo', 106 => 'Kingfisher', 107 => 'Koala', 108 => 'Kookabura', 109 => 'Kouprey', 110 => 'Kudu', 111 => 'Lapwing', 112 => 'Lark', 113 => 'Lemur', 114 => 'Leopard', 115 => 'Lion', 116 => 'Llama', 117 => 'Lobster', 118 => 'Locust', 119 => 'Loris', 120 => 'Louse', 121 => 'Lyrebird', 122 => 'Magpie', 123 => 'Mallard', 124 => 'Manatee', 125 => 'Mandrill', 126 => 'Mantis', 127 => 'Marten', 128 => 'Meerkat', 129 => 'Mink', 130 => 'Mole', 131 => 'Mongoose', 132 => 'Monkey', 133 => 'Moose', 134 => 'Mosquito', 135 => 'Mouse', 136 => 'Mule', 137 => 'Narwhal', 138 => 'Newt', 139 => 'Nightingale', 140 => 'Octopus', 141 => 'Okapi', 142 => 'Opossum', 143 => 'Oryx', 144 => 'Ostrich', 145 => 'Otter', 146 => 'Owl', 147 => 'Oyster', 148 => 'Panther', 149 => 'Parrot', 150 => 'Partridge', 151 => 'Peafowl', 152 => 'Pelican', 153 => 'Penguin', 154 => 'Pheasant', 155 => 'Pig', 156 => 'Pigeon', 157 => 'Pony', 158 => 'Porcupine', 159 => 'Porpoise', 160 => 'Quail', 161 => 'Quelea', 162 => 'Quetzal', 163 => 'Rabbit', 164 => 'Raccoon', 165 => 'Rail', 166 => 'Ram', 167 => 'Rat', 168 => 'Raven', 169 => 'Red deer', 170 => 'Red panda', 171 => 'Reindeer', 172 => 'Rhinoceros', 173 => 'Rook', 174 => 'Salamander', 175 => 'Salmon', 176 => 'Sand Dollar', 177 => 'Sandpiper', 178 => 'Sardine', 179 => 'Scorpion', 180 => 'Seahorse', 181 => 'Seal', 182 => 'Shark', 183 => 'Sheep', 184 => 'Shrew', 185 => 'Skunk', 186 => 'Snail', 187 => 'Snake', 188 => 'Sparrow', 189 => 'Spider', 190 => 'Spoonbill', 191 => 'Squid', 192 => 'Squirrel', 193 => 'Starling', 194 => 'Stingray', 195 => 'Stinkbug', 196 => 'Stork', 197 => 'Swallow', 198 => 'Swan', 199 => 'Tapir', 200 => 'Tarsier', 201 => 'Termite', 202 => 'Tiger', 203 => 'Toad', 204 => 'Trout', 205 => 'Turkey', 206 => 'Turtle', 207 => 'Viper', 208 => 'Vulture', 209 => 'Wallaby', 210 => 'Walrus', 211 => 'Wasp', 212 => 'Weasel', 213 => 'Whale', 214 => 'Wildcat', 215 => 'Wolf', 216 => 'Wolverine', 217 => 'Wombat', 218 => 'Woodcock', 219 => 'Woodpecker', 220 => 'Worm', 221 => 'Wren', 222 => 'Yak', 223 => 'Zebra',
												);
												$animal = $animalName[$student];
												$anonymousName = 'Anonymous ' . $animal;

												$sql2 = "SELECT * FROM users WHERE id = $student";
												$result2 = mysqli_query($conn, $sql2);
												$row2 = mysqli_fetch_assoc($result2);
												$studentname = $row2['username'];
												echo '<div class="mt-6 pb-10 border-t border-gray-200 divide-y divide-gray-200 space-y-10">
                            <div class="pt-10 lg:grid lg:grid-cols-12 lg:gap-x-8">
                            <div class="lg:col-start-5 lg:col-span-8 xl:col-start-4 xl:col-span-9 xl:grid xl:grid-cols-3 xl:gap-x-8 xl:items-start">
                            <div class="flex items-center xl:col-span-1">
								<div class="flex items-center">
                                <div class="rating rating-sm rating-half">
                                    <input type="radio" name="rating-id-' .
													$revid .
													'" class="rating-hidden" value="0" disabled/>
                                    <input type="radio" name="rating-id-' .
													$revid .
													'" class="bg-accent mask mask-star-2 mask-half-1" value="0.5"' .
													($stars == 0.5 ? 'checked disabled' : 'disabled') .
													' />                     
                                    <input type="radio" name="rating-id-' .
													$revid .
													'" class="bg-accent mask mask-star-2 mask-half-2" value="1"' .
													($stars == 1 ? 'checked disabled' : 'disabled') .
													' />   
                                    <input type="radio" name="rating-id-' .
													$revid .
													'" class="bg-accent mask mask-star-2 mask-half-1" value="1.5"' .
													($stars == 1.5 ? 'checked disabled' : 'disabled') .
													' />   
                                    <input type="radio" name="rating-id-' .
													$revid .
													'" class="bg-accent mask mask-star-2 mask-half-2" value="2"' .
													($stars == 2 ? 'checked disabled' : 'disabled') .
													' />   
                                    <input type="radio" name="rating-id-' .
													$revid .
													'" class="bg-accent mask mask-star-2 mask-half-1" value="2.5"' .
													($stars == 2.5 ? 'checked disabled' : 'disabled') .
													' />   
                                    <input type="radio" name="rating-id-' .
													$revid .
													'" class="bg-accent mask mask-star-2 mask-half-2" value="3"' .
													($stars == 3 ? 'checked disabled' : 'disabled') .
													' />   
                                    <input type="radio" name="rating-id-' .
													$revid .
													'" class="bg-accent mask mask-star-2 mask-half-1" value="3.5"' .
													($stars == 3.5 ? 'checked disabled' : 'disabled') .
													' />   
                                    <input type="radio" name="rating-id-' .
													$revid .
													'" class="bg-accent mask mask-star-2 mask-half-2" value="4"' .
													($stars == 4 ? 'checked disabled' : 'disabled') .
													' />   
                                    <input type="radio" name="rating-id-' .
													$revid .
													'" class="bg-accent mask mask-star-2 mask-half-1" value="4.5"' .
													($stars == 4.5 ? 'checked disabled' : 'disabled') .
													' />   
                                    <input type="radio" name="rating-id-' .
													$revid .
													'" class="bg-accent mask mask-star-2 mask-half-2" value="5"' .
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
						<p class="font-medium text-gray-900">';
												// if visitor_role is faculty or session id is not set, then show anonymousName
												if ($visitor_role == 'faculty' || !isset($_SESSION['id'])) {
													echo $anonymousName;
												} else {
													if ($anonymous == 1) {
														echo $anonymousName;
													} else {
														echo $studentname;
													}
												}


												echo '</p>
							<time datetime="2021-01-06" class="ml-4 border-l border-gray-200 pl-4 text-gray-500 lg:ml-0 lg:mt-2 lg:border-0 lg:pl-0">' .
													$date .
													'</time>
                        </div>
                    </div>
                </div>';
											}
										}
									} else {
										$sql1 = "SELECT * FROM review WHERE student = \"$id\" AND anonymous = 0";
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
													'" class="bg-accent mask mask-star-2 mask-half-1" value="0.5"' .
													($stars == 0.5 ? 'checked disabled' : 'disabled') .
													' />                     
                        <input type="radio" name="rating-id-' .
													$id .
													'" class="bg-accent mask mask-star-2 mask-half-2" value="1"' .
													($stars == 1 ? 'checked disabled' : 'disabled') .
													' />   
                        <input type="radio" name="rating-id-' .
													$id .
													'" class="bg-accent mask mask-star-2 mask-half-1" value="1.5"' .
													($stars == 1.5 ? 'checked disabled' : 'disabled') .
													' />   
                        <input type="radio" name="rating-id-' .
													$id .
													'" class="bg-accent mask mask-star-2 mask-half-2" value="2"' .
													($stars == 2 ? 'checked disabled' : 'disabled') .
													' />   
                        <input type="radio" name="rating-id-' .
													$id .
													'" class="bg-accent mask mask-star-2 mask-half-1" value="2.5"' .
													($stars == 2.5 ? 'checked disabled' : 'disabled') .
													' />   
                        <input type="radio" name="rating-id-' .
													$id .
													'" class="bg-accent mask mask-star-2 mask-half-2" value="3"' .
													($stars == 3 ? 'checked disabled' : 'disabled') .
													' />   
                        <input type="radio" name="rating-id-' .
													$id .
													'" class="bg-accent mask mask-star-2 mask-half-1" value="3.5"' .
													($stars == 3.5 ? 'checked disabled' : 'disabled') .
													' />   
                        <input type="radio" name="rating-id-' .
													$id .
													'" class="bg-accent mask mask-star-2 mask-half-2" value="4"' .
													($stars == 4 ? 'checked disabled' : 'disabled') .
													' />   
                        <input type="radio" name="rating-id-' .
													$id .
													'" class="bg-accent mask mask-star-2 mask-half-1" value="4.5"' .
													($stars == 4.5 ? 'checked disabled' : 'disabled') .
													' />   
                        <input type="radio" name="rating-id-' .
													$id .
													'" class="bg-accent mask mask-star-2 mask-half-2" value="5"' .
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

									?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	</main>

</body>
<?php include '../components/footer.php'; ?>

</html>