<ul class="md:flex-col md:min-w-full flex flex-col list-none">
    <li class="items-center">
        <a href="./" class="text-xs uppercase py-3 font-bold block text-pink-500 hover:text-pink-600">
            <i class="fas fa-tv mr-2 text-sm opacity-75"></i>
            Dashboard
        </a>
    </li>
    <?php if ($role == 'admin') { ?>
        <li class="items-center">
            <a href="../dashboard/users.php" class="text-xs uppercase py-3 font-bold block text-blueGray-700 hover:text-blueGray-500">
                <i class="fas fa-table mr-2 text-sm text-blueGray-300"></i>
                Users
            </a>
        </li>
    <?php } ?>
    <?php if ($role == 'faculty') { ?>
        <li class="items-center">
            <a href="./appointments.php" class="text-xs uppercase py-3 font-bold block text-blueGray-700 hover:text-blueGray-500">
                <i class="fas fa-table mr-2 text-sm text-blueGray-300"></i>
                Appointments
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