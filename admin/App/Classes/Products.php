<?php 
namespace App\Classes;
use PDO;
// use App\Interfaces\CurdInterface;
class Products extends DataBase{ 
    public $pruduct_name, $price, $image, $isAvailable;

    public function getAll(){
        $result = $this->runDML("SELECT * FROM products");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function show($id){
        $sql = "SELECT * FROM products WHERE product_id = $id";
        $result = $this->runDML($sql);
        return $result->fetch(PDO::FETCH_ASSOC);
        
    }

    public function delete($id){
        $sql = "DELETE FROM products WHERE product_id = $id";
        $this->runDML($sql);
    }

    public function update($id){
        $sql = "UPDATE products SET name = '$this->pruduct_name', price = '$this->price', image = '$this->image',
                    isAvailable = '$this->isAvailable';
                    WHERE product_id = $id";
        $this->runDML($sql);
    }

    public function add(){
        $sql = "INSERT INTO products (product_name, price, product_img, isAvailable) VALUES 
                    ('$this->pruduct_name', '$this->price', '$this->image', '$this->isAvailable')";
        $this->runDML($sql);
    }
}