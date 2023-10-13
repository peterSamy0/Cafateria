<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once './admin/vendor/autoload.php';
use App\Classes\Products;
use App\Classes\Users;
use App\Classes\Orders;
$orderObj = new Orders();
$orders = $orderObj->getAll();
$order_id = 0;
$totalPrice = 0;
// $cartEmpty = '';
foreach($orders as $order){
    $order_id = $order['order_id'];
}
$products = new Products();
$items = $products->getAll();

// get user information from sign in by session
$users = new Users();
if (isset($_SESSION['user_id'])) {
    $user = $users->show($_SESSION['user_id']);
}
$isLogIn = false;
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
if (isset($_POST['removeFromCart'])) {
    $removedProductId = $_POST['deletedProductId'];
    
    // Check if the 'cart' session variable exists
    if (isset($_SESSION['cart'])) {
        // Check if the product ID exists in the cart
        if (array_key_exists($removedProductId, $_SESSION['cart'])) {
            // Remove the product from the cart
            unset($_SESSION['cart'][$removedProductId]);
        }
    }
}
// add product to cart by using session
if (isset($_POST['addToCart'])) {
    if (isset($_SESSION['user_id'])) {
        // Get the product ID from the form data
        $productID = $_POST['productID'];
        
        // Check if the 'cart' session variable exists
        if (isset($_SESSION['cart'])) {
            // If the 'cart' session variable exists, check if the product ID already exists in the cart
            if (array_key_exists($productID, $_SESSION['cart'])) {
                // If the product ID exists, increment the quantity by one
                $_SESSION['cart'][$productID] += 1;
            } else {
                // If the product ID doesn't exist, add it to the cart with a quantity of one
                $_SESSION['cart'][$productID] = 1;
            }
        } else {
            // If the 'cart' session variable doesn't exist, create it and add the product ID with a quantity of one
            $_SESSION['cart'] = array($productID => 1);
        }
    }else{
        echo '<script>alert("Please Login First...")</script>';
    }
}


// check out the order
if(isset($_POST['checkout']) && !empty($_SESSION['cart']) ){

    $orderObj->user_id = $user['user_id'];
    $orderObj->order_id = $order_id+1;
    foreach ($_SESSION['cart'] as $productID => $quantity) {
        $showItem = $products->show($productID);
        $totalPrice += $quantity * $showItem['price'];
    }
    $orderObj->totalPrice = $totalPrice;
    $orderObj->addOrder();
    foreach($_SESSION['cart'] as $productID => $quantity){
        $orderObj->product_id = $productID;
        $orderObj->quantity = $quantity;
        $orderObj->addOrderItems();
    }
    $totalPrice = 0;
    unset($_SESSION['cart']);
}
if(isset($_POST['clearCart']) && !empty($_SESSION['cart']) ){
    if (isset($_SESSION['user_id'])) {
        $totalPrice = 0;
        unset($_SESSION['cart']);
    }
}elseif(isset($_POST['clearCart']) && empty($_SESSION['cart']) ){
    echo '<script>alert("Cart Already Empty...")</script>';
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <style>
        th, td{
            vertical-align: middle;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- nav bar -->
    <nav class="navbar navbar-expand-lg bg-secondary ">
        <div class="container-fluid bg-secondary ">
            <a class="navbar-brand text-light" href="index.php">Cafereria</a>
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

    <!-- products -->
    <div class="container d-flex my-5 p-5">
        <div class="row w-100">
            <?php foreach($items as $item){ ?>
            <div class="card col-lg-3 offset-lg-1 mt-4 p-0">
            <div class="w-100 bg-secondary-subtle ">   
                <?php
                    $imagePath = './admin/assets/images/product/';
                    $imageFilename = $item['product_img'] ;
                    $imageFullPath = $imagePath . $imageFilename;
                    
                    // Check if the image file exists
                    if (file_exists($imageFullPath)) {
                    echo '<img src="' . $imageFullPath . '" alt="" class="w-100 object-fit-contain" height="100px">';
                    } else {
                    // If the image file doesn't exist, display a default image
                    echo '<img src="' . $imagePath . 'default.jpeg" alt="" class="w-100 object-fit-contain " height="100px">';
                    }
                ?>
            </div>
            <form method="POST">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $item['product_name']?></h5>
                    <p class="card-text">Price: <?php echo $item['price']?> E.L</p>
                        <input type="hidden" name="productID" value="<?php echo $item['product_id']; ?>">
                        <input name="addToCart" value="Add To Cart" class="btn btn-primary w-100" type="submit">
                    </form>
                </div>
            </div>
        <?php } ?>
        </div>
    </div>

    <!-- table to show the cart content -->
    <div class="container border border-1 mt-5 p-5">
        <h3 class="text-center my-3 text-uppercase text-primary">Cart</h3>
        <table id="zero_config" class="table table-striped table-bordered container px-5 <?php
            echo (empty($_SESSION['cart'])) ? 'd-none' : 'd-table';
        ?>">
            <thead>
            <tr>
                <th>no</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total Price</th>
                <th>Image</th>
                <th>Remove</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
            $i = 0; // Initialize the index variable
            foreach ($_SESSION['cart'] as $productID => $quantity) {
                $showItem = $products->show($productID);
                $i++;
                ?>
                <tr>
                    <td><?php echo $i ?></td>
                    <td><?php echo $showItem['product_name'] ?></td>
                    <td><?php echo $showItem['price'] ?></td>
                    <td><?php echo $quantity; ?></td>
                    <td><?php echo $quantity * $showItem['price']; ?></td>
                    <td>
                        <?php
                        $imagePath = './admin/assets/images/product/';
                        $imageFilename = $showItem['product_img'];
                        $imageFullPath = $imagePath . $imageFilename;

                        // Check if the image file exists
                        if (file_exists($imageFullPath)) {
                            echo '<img src="' . $imageFullPath . '" alt="" width="60px" height="60px">';
                        } else {
                            // If the image file doesn't exist, display a default image
                            echo '<img src="' . $imagePath . 'default.jpeg" alt="" width="60px" height="60px">';
                        }
                        ?>
                        <input type="hidden" value=<?php
                            echo $totalPrice += $quantity * $showItem['price'];
                        ?>>
                    </td>
                    <td>
                        <!-- remove form from cart -->
                        <form method="POST">
                            <input type="hidden" name="deletedProductId" value=<?php echo $showItem['product_id']?> >
                            <button class="btn btn-danger" name="removeFromCart">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php } }?>
            </tbody>
        </table>
        <div class=" <?php
            echo (empty($_SESSION['cart'])) ? 'd-block' : 'd-none';
        ?>">
            <p class="text-center text-danger my-5 fs-4">the Cart is empty Choose your Drink...</p>
            <div class="alert alert-danger mt-2 <?php 
                echo (isset($_POST['checkout']) && empty($_SESSION['cart'])) ? 'd-block' : 'd-none';
                ?>" role="alert">
                    Empty Cart! enter the Drink first ...
            </div>
        </div>
        <div class="d-flex justify-content-center w-75 m-auto mt-5">
            <h3 class="fs-4"><span class="text-danger">Total Price of Order: </span><?php
                echo $totalPrice. " E.L";
            ?></h3>
        </div>
        <div class="d-flex justify-content-end w-75 m-auto mt-3">
            <form method="POST">
            <input name="checkout" value="Check Out" class="btn btn-primary " type="submit">
            <input name="clearCart" value="Clear Cart" class="btn btn-danger " type="submit">
            </form>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js"></script>
</body>
</html>