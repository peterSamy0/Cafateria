<?php 
namespace App\Classes;
use PDO;
// use App\Interfaces\CurdInterface;
class Users extends DataBase{ 
    public $name, $email, $phone, $passwd, $profileImg;

    public function getAll(){
        $result = $this->runDML("SELECT * FROM users");
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function show($id){
        $sql = "SELECT * FROM users WHERE user_id = $id";
        $result = $this->runDML($sql);
        return $result->fetch(PDO::FETCH_ASSOC);
    }

    public function delete($id){
        $sql = "DELETE FROM users WHERE user_id = $id";
        $this->runDML($sql);
    }

    public function add(){
        $sql = "INSERT INTO users (user_name, email, phone, passwd, profileImg) VALUES 
                    ('$this->name', '$this->email', '$this->phone', '$this->passwd', '$this->profileImg')";
        $this->runDML($sql);
    }
}
