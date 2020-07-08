<?php
require '../vendor/autoload.php';
use \Firebase\JWT\JWT;
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');


include_once '../config/database.php';
include_once '../classes/Users.php';
$database= new Database();
$db=$database->connect();

//Instantiate  users object
$users = new Users($db);
$all_headers=getallheaders();
$jwt =$all_headers['Authorization'];
try {
   
        $secret_key="jasoumik";
        $decoded_data=JWT::decode($jwt,$secret_key,array('HS256'));  
        $users->user_id=$decoded_data->data->id;
        
    $projects =$users->user_prjct_list();
if($projects->rowCount()>0){
while($row=$projects->fetch(PDO::FETCH_ASSOC)){
    $projects_arr[]=array(
        "id" =>$row['id'],
        "name" =>$row["name"],
        "description" =>$row["description"],
        "user_id" =>$row["user_id"],
        "status" =>$row["status"],
        "created_at" =>$row["created_at"]

    );
    echo json_encode(
        array('projects'=>$projects_arr)
    );
}
}else{
    echo json_encode(
        array('message'=>'No Project Found')
    );
}
} catch (Exception $ex) {
    echo json_encode(
        array('message'=>$ex->getMessage())
    );
}

?>