<?php
session_start();
$id = $_SESSION['id'];
$username = $_SESSION['username'];
$sql = "SELECT * FROM users WHERE id = $id";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$full_name = $row['full_name'];
$department = $row['department'];
?>
<div class="sticky top-0 z-10">
  <div class="navbar bg-gray-900 px-4 py-4 shadow-md">
    <div class="navbar-start">
      <div class="dropdown">
        <label tabindex="0" class="btn btn-ghost lg:hidden text-white">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
          </svg>
        </label>
        <ul tabindex="0" class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
          <li><a href="../pages/search.php" aria-label="Search" title="Search">Search</a></li>
          <?php
          if (!isset($_SESSION['username'])) {
            echo '<li><a href="../pages/login.php">Sign In</a></li>';
          }
          ?>
        </ul>
      </div>
      <a href="/" class="btn btn-ghost normal-case text-xl text-white">FacultyPedia</a>
    </div>
    <div class="navbar-center hidden lg:flex">
      <ul class="menu menu-horizontal p-0">
        <li><a href="/pages/search.php" aria-label="Search" title="Search" class="text-white">Search</a></li>
        <?php
        if (!isset($_SESSION['username'])) {
          echo '<li><a href="../pages/login.php" class="text-white">Sign In</a></li>';
        }
        ?>
      </ul>
    </div>
    <?php
    if (!isset($_SESSION['username'])) {
      echo '<div class="navbar-end">
      <a href="/pages/register.php" class="btn text-white">Get started</a>
    </div>';
    } else {
      echo '
      <div class="navbar-end">
      <a href="/pages/profile.php" class="font-bold text-sm mr-4 text-white">Welcome, ' . $_SESSION['username'] . '</a>
      <div class="dropdown dropdown-end">
        <label tabindex="0" class="btn btn-ghost btn-circle avatar">
          <div class="w-10 rounded-full">
            <img src="https://avatars.dicebear.com/api/bottts/' .
        $username .
        '.png" />
          </div>
        </label>
        <ul tabindex="0" class="menu menu-compact dropdown-content mt-3 p-2 shadow bg-base-100 rounded-box w-52">
          <li>
            <a href="../pages/profile.php" class="justify-between">
              Profile
            </a>
          </li>
          <li><a href="../pages/edit-profile.php">Edit Profile';
      echo '</a></li>
          <li><a href="/pages/logout.php">Logout</a></li>
        </ul>
      </div>
    </div>';
    }
    ?>
  </div>

</div>