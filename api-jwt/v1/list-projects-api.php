<?php

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
$projects =$users->prjct_list();
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
?>