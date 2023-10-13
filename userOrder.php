<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once './admin/vendor/autoload.php';
use App\Classes\Products;
use App\Classes\Users;
use App\Classes\Orders;
$orderObj = new Orders();
$products = new Products();
$users = new Users();
$items = $products->getAll();
if (isset($_SESSION['user_id'])) {
    $user = $users->show($_SESSION['user_id']);
    $orders = $orderObj->getAllOrdersOfUser($_SESSION['user_id']);
}
$isLogIn = false;
$i = 0;
// check if user log in or not
if(isset($_SESSION['user_id'])){
    $isLogIn = true;
}
if(isset($_POST['signOut'])){
    if (isset($_SESSION['user_id'])) {
        session_unset(); // Remove all session variables
        session_destroy(); // Destroy the session
        header('Location: login.php');
    }
}
// remove product from cart
if (isset($_POST['removeFromOrders'])) {
    $removedProductId = $_POST['deletedOrderId'];
    $orderObj->delete($removedProductId);
}
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

    <div class='container'>
        <table class="table overflow-x-scroll w-100" *ngIf="cartItems.length > 0">
        <h3 class="text-center">Your Orders:</h3>
        <thead>
            <tr>
            <th scope="col" class="text-capitalize">no of orders</th>
            <th scope="col" class="text-capitalize">order date</th>
            <th scope="col" class="text-capitalize">user name</th>
            <th scope="col" class="text-capitalize">total price</th>
            <th></th>
            <th></th>
            </tr>
        </thead>
        <tbody class="over-flow-x-scroll">
            <?php foreach($orders as $order){ $i++ ?>
            <tr *ngFor="let item of cartItems">
            <td class="align-middle "><?php echo $i; ?></td>
            <td class="align-middle "> <?php echo $order['order_date']; ?></td>
            <td class="align-middle "><?php echo $order['user_name']; ?></td>
            <td class="align-middle "><?php echo $order['totalPrice']; ?></td>
            <td class="align-middle ">
            <form method="GET" action="showUserOrder.php">
                <input type="hidden" name="showOrderId" value="<?php echo $order['order_id']; ?>">
                <button class="btn btn-warning mt-2" type="submit" name="showOrders">View</button>
            </form>
            </td>
            <td class="align-middle ">
                <!-- remove form from cart -->
                <form method="POST">
                    <input type="hidden" name="deletedOrderId" value=<?php echo $order['order_id']?> >
                    <button class="btn btn-danger" name="removeFromOrders">Delete</button>
                </form>
            </td>
            </tr>
            <?php } ?>
        </tbody>
        </table>
    </div>

</body>
</html>