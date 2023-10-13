<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    require_once "../vendor/autoload.php";
    use App\Classes\Products;
    if(isset($_GET['id'])){
        $id=$_GET['id'];
      }else{
        $id=0;
      }
    $product = new Products();
    $product->delete($id);
    header("Location: index.php ");
?>