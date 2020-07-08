<?php
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

 //get raw usersed data
 $data= json_decode(file_get_contents("php://input"));

 $users->name =$data->name;
 $users->email =$data->email;
 $users->password =password_hash($data->password,PASSWORD_DEFAULT);
 $email_data=$users->check_email();
 if(!empty($email_data)){
  echo json_encode(
    array('message'=>'user email is already used')
   );
 }else{
  

 //create users
 if($users->create()){
   echo json_encode(
       array('message'=>'users created')
   );
 }else{
    echo json_encode(
        array('message'=>'users not created')
    );
 }
}
?>