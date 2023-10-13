<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require_once './admin/vendor/autoload.php';
    use App\Classes\Orders;
    use App\Classes\Users;
    $users = new Users();
    if (isset($_SESSION['user_id'])) {
        $user = $users->show($_SESSION['user_id']);
        $orders = $orderObj->getAllOrdersOfUser($_SESSION['user_id']);
    }
    $isLogIn = false;
    if(isset($_GET['showOrders'])){
        $id = $_GET['showOrderId'];
    }else{
        $id = 0;
    }
    $order = new Orders();
    $items = $order->show($id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <style>
      td {
          vertical-align: middle !important;
          text-align: center;
        }
      th{
        text-align: center;
        background-color: gray !important;
        color: white !important;
        font-weight: bolder !important;
        font-size: 16px;
      }
    </style>
</head>
<body>
    <!-- nav bar -->
    <nav class="navbar navbar-expand-lg bg-secondary ">
        <div class="container-fluid bg-secondary ">
            <a class="navbar-brand text-light" href="#">Cafereria</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                <a class="nav-link active text-light" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                <a class="nav-link text-light" href="userOrder.php">My Orders</a>
                </li>

                <!-- if the user does not logged in sign-in or sign-up will appear  -->
                <li class="nav-item <?php echo ($isLogIn) ? 'd-none':'d-block' ?>">
                    <a class="nav-link active text-light" aria-current="page" href="login.php">Sign In</a>
                </li>
                <li class="nav-item <?php echo ($isLogIn) ? 'd-none':'d-block' ?>">
                <a class="nav-link text-light" href="signUp.php">Sign Up</a>
                </li>

                <!-- if the user logged sign-out will appear  -->
                <li class="nav-item <?php echo ($isLogIn) ? 'd-block':'d-none' ?>">
                <form method="POST">
                    <input type="hidden" name="signOut" value="1">
                    <button type="submit" name="signOut" class="nav-link active text-light" aria-current="page">Sign Out</button>
                </form>
                </li>
            </ul>
            <div class="d-flex align-content-center  " role="search">
                <div class="me-2">
                    <?php
                    if (isset($_SESSION['user_id'])) {
                        $imagePath = './admin/assets/images/users/';
                        $imageFilename = $user['profileImg'] ;
                        $imageFullPath = $imagePath . $imageFilename;
                        
                        // Check if the image file exists
                        if (file_exists($imageFullPath)) {
                        echo '<img src="' . $imageFullPath . '" alt="" width="60px" height="60px" class="rounded-5">';
                        } else {
                        // If the image file doesn't exist, display a default image
                        echo '<img src="' . $imagePath . 'default.png" alt="" width="60px" height="60px"  class="rounded-5">';
                        }
                    }else{
                        $imagePath = './admin/assets/images/users/';
                        echo '<img src="' . $imagePath . 'default.png" alt="" width="60px" height="60px"  class="rounded-5">';
                    }
                    
                    ?>
                </div>
                <div class="d-flex flex-wrap align-content-center ms-2 text-white">
                    <?php echo (isset($_SESSION['user_id'])) ? $user['user_name'] : 'Login' ?>
                </div>
            </div>
        </div>
    </div>
    </nav>
    <!-- end navbar -->

    <div>
        <div class="d-flex justify-content-between w-75 m-auto mt-5">
            <h3 class="fs-4">
                <span class="text-danger text-capitalize">User name: </span>
                <?php
                    echo $items[0]['user_name'];
                ?>
            </h3>
            <p>
                <span class="text-danger text-capitalize">order date: </span>
                <?php
                    echo $items[0]['order_date'];
                ?>
            </p>
        </div>
    </div>
    <div class='container'>
        <table class="table overflow-x-scroll w-100" *ngIf="cartItems.length > 0">
        <h3 class="text-center">Your Order</h3>
        <thead>
            <tr>
                <th scope="col" class="text-capitalize">Product name</th>
                <th scope="col" class="text-capitalize">quantity</th>
                <th scope="col" class="text-capitalize">price</th>
            </tr>
        </thead>
        <tbody class="over-flow-x-scroll">
            <?php foreach($items as $order){ ?>
            <tr *ngFor="let item of cartItems">
                <td class="align-middle "> <?php echo $order['product_name']; ?></td>
                <td class="align-middle "><?php echo $order['quantity']; ?></td>
                <td class="align-middle "><?php echo $order['price'] * $order['quantity']; ?></td>
            </tr>
            <?php } ?>
        </tbody>
        </table>
        <div class="d-flex justify-content-center w-75 m-auto mt-5">
            <h3 class="fs-4"><span class="text-danger">Total Price of Order: </span>
                <?php
                    echo $items[0]['totalPrice'] . " E.L";
                ?>
            </h3>
        </div>

    </div>
</body>
</html>