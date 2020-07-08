<?php
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

$data= json_decode(file_get_contents("php://input"));
//if want to load from headers otherwise above line will be uncommented :)
$all_headers=getallheaders();
// $data->jwt = $all_headers['Authorization'];
// if(!empty($data->jwt)){
    
//     try{
        
//         $secret_key="jasoumik";
//         $decoded_data= JWT::decode($data->jwt,$secret_key,array('HS256'));  
//         $user_id=$decoded_data->data->id;
//         echo json_encode(array(
//             "message" =>"We got JWT token",
//             "user_data" =>$decoded_data,
//             "user_id" =>$user_id
//         ));
    
//     }
//     catch(Exception $ex){

//         echo json_encode(array(
//             "message" =>$ex->getMessage()
//         ));
//     }

   
// }
if(!empty($data->name)&&!empty($data->desc)&&!empty($data->status)){
    try {
        $jwt =$all_headers['Authorization'];
        $secret_key="jasoumik";
        $decoded_data= JWT::decode($jwt,$secret_key,array('HS256'));  
        $users->user_id=$decoded_data->data->id;
        $users->project_name =$data->name;
        $users->description =$data->desc;
        $users->status =$data->status;
        if($users->create_prjct()){
            echo json_encode(array(
                "msg" => "Project Added Successfully"
            ));
        }else {
            echo json_encode(array(
                "msg" => "Check and Try again"
            ));
        }
    } catch (Exception $ex) {
        echo json_encode(array(
            "msg" => $ex->getMessage()
        ));
    }
}

?>