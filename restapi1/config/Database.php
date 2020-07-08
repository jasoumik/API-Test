<?php
class Database {
private $host ='localhost';
private $db_name ='restapi1';
private $username='root';
private $pass ='root';
private $connect;

// db connect
public function connect(){
    $this->connect =null;
    try{
    $this->connect =new PDO('mysql:host=' . $this->host . ';dbname=' . 
    $this->db_name,$this->username,$this->pass);
    $this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch(PDOException $e){
        echo 'Connection Error: ' . $e->getMessage();

    }
    return $this->connect;
}
}
?>