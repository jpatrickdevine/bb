<?php
/*
 * B!B! management console script - login.php
 */
$pageTitle = 'Logout';
include '_includes/header.inc.php';
include '_includes/sidebar.inc.php';

if (isset($_SESSION['user'])) {
    destroySession();
    echo "<div class='my-4'>You have been signed out. <a href='login.php'>Click here</a> to sign back in.";
} else {
    echo "<div class='my-4'>Please <a href='login.php'>click here</a> to sign in.";
}

include '_includes/footer.inc.php';
?>