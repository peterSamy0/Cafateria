<?php
    ini_set('display_errors', 1);
    error_reporting(E_ALL);

    require_once './admin/vendor/autoload.php';
    use App\Classes\Users;

    $user = new Users();

    if(isset($_POST['signUp'])){
        if($_POST['passwd'] === $_POST['confPasswd']){
            $user->name = $_POST['name'];
            $user->email = $_POST['email'];
            $user->passwd = $_POST['passwd'];
            $user->phone = $_POST['phone'];
            
            $img_name = time().$_FILES['img']['name'];
            $user->profileImg = $img_name;
            $img_tmp = $_FILES['img']['tmp_name'];
            move_uploaded_file($img_tmp, './admin/assets/images/users/'.$img_name);
            $user->add();
            header("Location: login.php");
        }
        else{
            echo '<script>alert("re-enter the password")</script>';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>sign up</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/css/bootstrap.min.css">
    </head>
    <body class=" bg-body-secondary ">
        <!-- nav bar -->
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid bg-secondary ">
                <a class="navbar-brand text-light" href="#">Cafereria</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
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
        <!-- sign up page -->
        <div>
            <h3 class="text-center my-3 text-capitalize text-secondary-emphasis fw-bold ">
                sign up
            </h3>
        </div>
        <div class="w-50 px-5 m-auto ">
            <form method="POST" enctype="multipart/form-data" class="border border-1 p-4 rounded bg-light">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                <div class="mb-3">
                    <label for="email1" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email">
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="number" class="form-control" id="phone" name="phone">
                </div>
                <div class="mb-3">
                    <label for="passwd" class="form-label">Password</label>
                    <input type="password" class="form-control" id="passwd" name="passwd">
                </div>
                <div class="mb-3">
                    <label for="confPasswd" class="form-label">Confirm Password</label>
                    <input type="password" class="form-control" id="confPasswd" name="confPasswd">
                </div>
                <div class="mb-3">
                    <label for="profileImg" class="form-label">Profile Image</label>
                    <input type="file" class="form-control" id="image" name="img">
                </div>
                <button type="submit" class="btn btn-primary" name="signUp">Sign Up</button>
                <button type="reset" class="btn btn-danger ms-3">Reset</button>
                <div class="text-center py-2 mt-2">
                    already have account?! 
                    <a href="login.php">
                        log in!  
                    </a>
                </div>
            </form>
        </div>
    </body>
</html>
