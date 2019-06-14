<?php
/*
 * B!B! management console script - login.php
 */
$pageTitle = 'Login';
require_once '_includes/functions.php';

if (isset($_SESSION['user'])) {
    header("Location: index.php");
    die();
}

$errorMsg = $user = $pass = "";

if (isset($_POST['user'])) {
    $user = sanitizeString($_POST['user']);
    $pass = sanitizeString($_POST['pass']);

    if ($user == "" || $pass == "") {
        $errorMsg = '<div class="alert alert-danger">Please enter a username and password.</div>';
    } else {
        $q = "SELECT username, password FROM managers WHERE username='$user' AND password='$pass'";
        $r = queryMysql($q);
        
        if ($r->num_rows == 0) {
            $errorMsg = '<div class="alert alert-danger">Username or password invalid.</div>';
        } else {
            $_SESSION['user'] = $user;
            $_SESSION['pass'] = $pass;
            header("Location: index.php");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Management Console | Bistro! Bistro!</title>

    <!-- Favicon -->
    <link rel="icon" href="favicon.ico">
    <!-- Font Awesome icons -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- jQuery UI CSS -->
    <link rel="stylesheet" href="jquery-ui/jquery-ui.min.css">
    <!-- Site CSS -->
    <link rel="stylesheet" href="css/console.css">
    <style>
        body {
            background-color: #222;
        }
        .centered-box {
            position: absolute;
            top: 50%;
            left: 50%;
            padding: 1rem;
            width: 100%;
            max-width: 370px;
            background-color: white;
            border-radius: 0.5rem;
            transform: translate(-50%, -50%);
            overflow-x: auto;
            display: flex;
            flex-direction: column;
        }
        .centered-box img {
            max-width: 100px;
            margin-bottom: 1rem;
        }
        .centered-box div {
            text-align: center;
        }
        form input[type="text"] {
            margin-bottom: 10px;
        }
        form input[type="password"] {
            margin-bottom: 10px;
        }
        </style>
</head>
<body>
    <div class="centered-box">
        <form method="post" action="login.php">
            <div class="text-center">
                <img class="mb-4 text-center" src="img/bb-logo.jpg" alt="Bistro! Bistro!" title="Bistro! Bistro!">
                <h1 class="h3 mb-4 font-weight-normal">
                    Welcome.
                </h1>
            </div>
            <?php echo $errorMsg; ?>
            <label for="user">Username</label>
            <input type="text" name="user" class="form-control mb-2" autofocus>
            <label for="pass">Password</label>
            <input type="password" name="pass" class="form-control">
            <button class="btn btn-primary btn-block mt-4 mb-2" type="submit">Sign in</button>
        </form>
        <div style="font-size: 0.88rem; margin-top: 0.5rem; color: #777; text-align: center;">&copy; 2019 John Devine – IT Capstone, Peirce College</div>
    </div>
</body>
</html>