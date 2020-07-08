<?php
ini_set("display_errors",1);
require '../vendor/autoload.php';
use \Firebase\JWT\JWT;

//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');


include_once '../config/database.php';
include_once '../classes/Users.php';
//Instantiate Db and Connect
$database= new Database();
$db=$database->connect();

//Instantiate  users object
$users = new Users($db);

//get raw users data
$data= json_decode(file_get_contents("php://input"));
$users->email =$data->email;
if(!empty($data->email) && !empty($data->password)){
    
    $user_data =$users->check_login();
    if(!empty($user_data)){
     $name=$user_data['name'];
     $email=$user_data['email'];
     $password=$user_data['password'];

     if(password_verify($data->password,$password)){
        $iss="localhost";
        $iat=time();
        $nbf=$iat+10;
        $exp=$iat+300;
        $aud="my_users";
        $user_arr_data=array(
                "id"=>$user_data['id'],
                "name"=>$user_data['name'],
                "email"=>$user_data['email']
        );
        $secret_key="jasoumik";
        $payload_info = array(
            "iss"=>$iss,
            "iat"=>$iat,
            "nbf"=>$nbf,
            "exp"=>$exp,
            "aud"=>$aud,
            "data"=>$user_arr_data
        );
        $jwt=JWT::encode($payload_info,$secret_key);
        echo json_encode(
            array(
                "jwt"=>$jwt,
                'message'=>'Successfully logged in')
        ); 
     }else{
        echo json_encode(
            array('message'=>'Wrong password')
        );
     }
    }
    else{
        echo json_encode(
            array('message'=>'Invalid info')
        );
    }
}
else{
    echo json_encode(
        array('message'=>'Input the required data')
    );
}
?>