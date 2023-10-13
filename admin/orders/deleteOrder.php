<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require_once "../vendor/autoload.php";
    use App\Classes\Orders;
    if(isset($_GET['id'])){
        $id=$_GET['id'];
      }else{
        $id=0;
      }
    $order = new Orders();
    $order->delete($id);
    header("Location: index.php ");
?>