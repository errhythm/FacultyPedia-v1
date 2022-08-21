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

  <title>Review - <?php echo $site_name; ?></title>
</head>

<body>
  <!-- Review a user with faculty role in database -->
  <?php
  include('../components/nav.php');
  $id = $_GET['id'];
  $sql = "SELECT * FROM users WHERE id = $id AND role = 'faculty'";
  $result = mysqli_query($conn, $sql);
  $resultCheck = mysqli_num_rows($result);
  if ($resultCheck > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $id = $row['id'];
      $username = $row['username'];
      $email = $row['email'];
      $role = $row['role'];
      $image = $row['image'];
      $description = $row['description'];
      $created_at = $row['created_at'];
      $updated_at = $row['updated_at'];
      $deleted_at = $row['deleted_at'];
      $status = $row['status'];

      echo '<section class="py-40 bg-gray-100 bg-opacity-50 ">
      <div class="mx-auto container max-w-2xl md:w-3/4 shadow-md">
        <div class="bg-gray-100 p-4 border-t-2 bg-opacity-5 border-indigo-400 rounded-t">
          <div class="max-w-sm mx-auto md:w-full md:mx-0">
            <div class="inline-flex items-center space-x-4">
              <img
                class="w-10 h-10 object-cover rounded-full"
                alt="User avatar"
                src="https://avatars.dicebear.com/api/bottts/' . $username . '.png"
              />
              <h1 class="text-gray-600">' . $username . '</h1>
            </div>
          </div>
        </div>';
      if (isset($_SESSION['zerostar'])) {
        echo '<div class="alert alert-error shadow-lg">
                  <div>
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span>Error! You can not give 0 stars.</span>
          </div>
        </div>';
        unset($_SESSION['zerostar']);
      }
      if (isset($_SESSION['alreadreviewed'])) {
        echo '<div class="alert alert-error shadow-lg">
                  <div>
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span>Error! You can not review same course again.</span>
          </div>
        </div>';
        unset($_SESSION['alreadreviewed']);
      }
      if (isset($_SESSION['revpending'])) {
        echo '<div class="alert alert-warning shadow-lg">
                  <div>
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            <span>As the review is anonymous, it will be forwarded to the admin to get approved.</span>
          </div>
        </div>';
        unset($_SESSION['revpending']);
      }
      if (isset($_SESSION['zerofield'])) {
        echo '<div class="alert alert-error shadow-lg">
                  <div>
            <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current flex-shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span>Error! Course name or review cannot be empty.</span>
          </div>
        </div>';
        unset($_SESSION['zerofield']);
      }
      echo '<form action="../components/review.php" method="POST">
        <div class="bg-white space-y-6">
          <input type="hidden" name="faculty" value="' . $id . '">
          <div class="md:inline-flex space-y-4 md:space-y-0 w-full p-4 text-gray-500 items-center">
            <h2 class="md:w-1/3 max-w-sm mx-auto">Course Details</h2>
            <div class="md:w-2/3 max-w-sm mx-auto">
              <label class="text-sm text-gray-400">Course Name</label>
              <div class="w-full inline-flex border">
                <div class="pt-2 w-1/12 bg-gray-100 bg-opacity-50">
                  <svg
                    fill="none"
                    class="w-6 text-gray-400 mx-auto"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                  </svg>
                </div>
                <input
                  type="text"
                  name="course"
                  class="w-11/12 focus:outline-none focus:text-gray-600 p-2"
                  placeholder="CSE391"
                />
              </div>
            </div>
          </div>

          <hr />
          <div class="md:inline-flex  space-y-4 md:space-y-0  w-full p-4 text-gray-500 items-center">
            <h2 class="md:w-1/3 mx-auto max-w-sm">Review</h2>
            <div class="md:w-2/3 mx-auto max-w-sm space-y-5">
              <div>
                <label class="text-sm text-gray-400">Review</label>
                <div class="w-full inline-flex border">
                  <div class="w-1/12 pt-2 bg-gray-100">
                    <svg
                      fill="none"
                      class="w-6 text-gray-400 mx-auto"
                      viewBox="0 0 24 24"
                      stroke="currentColor"
                    >
                      <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                      />
                    </svg>
                  </div>
                  <textarea
                    name="review"
                    id="review"
                    cols="60"
                    rows="10"
                    class="px-4 py-2 border-none bg-transparent focus:outline-none focus:text-gray-600 w-11/12"
                ></textarea>
                </div>
              </div>
            </div>
          </div>
          <hr />
          <div class="md:inline-flex w-full space-y-4 md:space-y-0 p-8 text-gray-500 items-center">
            <h2 class="md:w-4/12 max-w-sm mx-auto">Stars</h2>

            <div class="md:w-5/12 w-full md:pl-9 max-w-sm mx-auto space-y-5 md:inline-flex pl-2">
              <div class="rating rating-lg rating-half">
                <input type="radio" name="rating-10" class="rating-hidden" value="0" checked />
                <input type="radio" name="rating-10" class="bg-accent mask mask-star-2 mask-half-1" value="0.5" />
                <input type="radio" name="rating-10" class="bg-accent mask mask-star-2 mask-half-2" value="1" />
                <input type="radio" name="rating-10" class="bg-accent mask mask-star-2 mask-half-1" value="1.5" />
                <input type="radio" name="rating-10" class="bg-accent mask mask-star-2 mask-half-2" value="2" />
                <input type="radio" name="rating-10" class="bg-accent mask mask-star-2 mask-half-1" value="2.5" />
                <input type="radio" name="rating-10" class="bg-accent mask mask-star-2 mask-half-2" value="3" />
                <input type="radio" name="rating-10" class="bg-accent mask mask-star-2 mask-half-1" value="3.5" />
                <input type="radio" name="rating-10" class="bg-accent mask mask-star-2 mask-half-2" value="4" />
                <input type="radio" name="rating-10" class="bg-accent mask mask-star-2 mask-half-1" value="4.5" />
                <input type="radio" name="rating-10" class="bg-accent mask mask-star-2 mask-half-2" value="5" />
              </div>
            </div>
            <div class="md:w-3/12 text-center md:pl-6">
            </div>
          </div>
          <hr />
          <div class="md:inline-flex space-y-4 md:space-y-0 w-full p-4 text-gray-500 items-center">
            <div class="md:w-1/3 mx-auto max-w-sm">
              <div class="form-control">
                <label class="cursor-pointer label justify-center">
                  <input type="checkbox" name="anonymous" class="checkbox checkbox-accent mr-2 rounded-2xl" />
                  <span>Post as anonymous</span>
                </label>
              </div>
            </div>
            <div class="md:w-2/3 max-w-sm mx-auto">
              <div class="w-full p-4 text-right text-gray-500">
            <button type="submit" name="submit" class="btn btn-xs sm:btn-sm md:btn-md lg:btn-md rounded-lg bg-gray-900">
            <svg
              fill="none"
              class="w-6 text-gray-400 mr-1  mx-auto"
              viewBox="0 0 24 24"
              stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                />
            </svg>
            Review</button>
          </div>
            </div>
          </div>          
        </div>
        </form>
      </div>
    </section>';
    }
  } else {
    header("Location: ../pages/search.php");
  }
  ?>

</body>
<?php include('../components/footer.php'); ?>

</html>