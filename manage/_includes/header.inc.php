<?php
/*
 * B!B! management console header - _includes/header.inc.php
 */

// require the functions file in all pages
require_once 'functions.php';

if (isset($_COOKIE['last_load_time'])) {
    $lastPageLoad = $_COOKIE['last_load_time'];
} else {
    $lastPageLoad = time();
}

$q = "SELECT COUNT(request_id) FROM requests WHERE contacted IS NULL AND UNIX_TIMESTAMP(time_requested) > $lastPageLoad";
$r = queryMysql($q);

$row = $r->fetch_array(MYSQLI_ASSOC);

$newRequests = $row['COUNT(request_id)'];

$r->close();

setcookie("last_load_time", time(), (time() + (86400 * 30)), "/");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        <?php echo $pageTitle ?> | Bistro! Bistro!
    </title>

    <!-- Favicon -->
    <link rel="icon" href="favicon.ico">
    <!-- Font Awesome icons -->
    <link rel="stylesheet" href="css/fontawesome.all.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="jquery-ui/jquery-ui.min.css">
    <!-- Site CSS -->
    <link rel="stylesheet" href="css/console.css">
</head>
<body>
    <!-- Start nav bar -->
    <nav class="navbar navbar-dark fixed-top p-0 shadow">
        <a class="navbar-brand pl-3 text-nowrap" href="index.php">
            <img class="rounded-circle mr-1" src="img/bb-logo.jpg" width="30" height="30" alt="Bistro! Bistro!" title="Bistro! Bistro!"> 
            Management Console
        </a>
        <ul class="navbar-nav pr-3">
            <li class="nav-item text-nowrap text-right">
                <a class="nav-link" href="logout.php">Sign out</a>
            </li>
        </ul>
    </nav>
    <div class="container-fluid">
        <div class="row">
<?php // start sidebar ?>