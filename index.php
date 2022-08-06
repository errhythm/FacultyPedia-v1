<!DOCTYPE html>
<html lang="en" >
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php include('config.php'); ?>
    <link href="<?php echo $css_path; ?>" rel="stylesheet">
    <!-- get Title from config.php -->

    <title><?php echo $site_name; ?></title>
</head>
<body>
    <?php include('components/nav.php'); ?>
    <?php include('components/hero.php'); ?>
    <?php include('components/features.php'); ?>
    <?php include('components/footer.php'); ?>
</body>
</html>