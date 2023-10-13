<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once './admin/vendor/autoload.php';
use App\Classes\Users;
$person = new Users();
$users = $person->getAll();
// Start the session
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logIn'])) {
    $matchFound = false; // Flag variable to track if a match is found
    foreach ($users as $user) {
        if ($user['email'] == $_POST['email'] && $user['passwd'] == $_POST['passwd'] && !empty($_POST['email'])) {
            if($_POST['email'] == 'admin@gmial.com'){
                header('Location: ./admin/orders');
            }else{
                $_SESSION['user_id']= $user['user_id'];
                $matchFound = true; // Set the flag to true if a match is found
                header('Location: index.php');
            }
           
        }
    }
    if (!$matchFound) {
        echo '<script>alert("Invalid email or password...")</script>'; // Display the alert if no match is found
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sign in</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/css/bootstrap.min.css">
</head>
<body class="bg-body-secondary">
<!-- nav bar -->
<nav class="navbar navbar-expand-lg bg-body-tertiary p-0">
    <div class="container-fluid bg-secondary">
        <a class="navbar-brand text-light" href="index.php">Cafereria</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active text-light" aria-current="page" href="login.php">Sign In</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-light" href="signUp.php">Sign Up</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- end navbar -->
<!-- sign in page -->
<div>
    <h3 class="text-center my-3 text-capitalize text-secondary-emphasis fw-bold ">
        sign in
    </h3>
</div>
<div class="w-50 px-5 m-auto ">
    <form method="POST" enctype="multipart/form-data" class="border border-1 p-4 rounded bg-light">
        <div class="mb-3">
            <label for="email1" class="form-label">Email</label>
            <input type="email" class="form-control" id="email1" name="email">
        </div>
        <div class="mb-3">
            <label for="passwd" class="form-label">Password</label>
            <input type="password" class="form-control" id="passwd" name="passwd">
        </div>
        <button type="submit" class="btn btn-primary text-capitalize " name="logIn">sign in</button>
        <button type="reset" class="btn btn-danger ms-3">Reset</button>
        <div class="text-center py-2 mt-2">
            don't have an account?!
            <a href="signUp.php">
                Register NOW!
            </a>
        </div>
    </form>
</div>
</body>
</html>