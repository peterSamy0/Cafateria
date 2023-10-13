<?php 
namespace App\Classes;
use PDO;
// use App\Interfaces\CurdInterface;
class Orders extends DataBase{ 
    public $name, $price, $image, $isAvailable, $user_id, $order_id, $totalPrice, $quantity, $product_id;

    public function getAll(){
        $sql = "SELECT O.order_id, U.user_name, O.order_date 
        FROM orders O JOIN users U ON U.user_id = O.user_id";
        $result = $this->runDML($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllOrdersOfUser($id){
        $sql = "SELECT O.order_id, U.user_name, O.order_date, O.totalPrice
        FROM orders O 
        JOIN users U ON U.user_id = O.user_id 
        WHERE O.user_id = '$id'";
        $result = $this->runDML($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
    public function show($id){
        $sql = "SELECT O.order_id, U.user_name, P.product_name, OI.quantity, O.order_date, O.totalPrice, P.price
                FROM order_items OI 
                JOIN orders O ON OI.order_id = O.order_id 
                JOIN users U ON O.user_id = U.user_id
                JOIN products P ON P.product_id = OI.product_id
                WHERE O.order_id = $id";

        $result = $this->runDML($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id){
        $sql = "DELETE FROM orders WHERE order_id = $id";
        $this->runDML($sql);
    }
    public function addOrder(){
        $sql = "INSERT INTO orders (order_id, user_id, totalPrice) VALUES ('$this->order_id', '$this->user_id', '$this->totalPrice')";
        $this->runDML($sql);
    }
    public function addOrderItems(){
        $sql = "INSERT INTO order_items (order_id, quantity, product_id) VALUES ('$this->order_id', '$this->quantity', '$this->product_id')";
        $this->runDML($sql);
    }

}