<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');


include_once '../config/database.php';
include_once '../classes/student.php';

//Instantiate Db and Connect
 $database= new Database();
 $db=$database->connect();

 //Instantiate  student object
 $student = new Student($db);

 //get raw studented data
 $data= json_decode(file_get_contents("php://input"));

 $student->name =$data->name;
 $student->email =$data->email;
 $student->mobile =$data->mobile;

 //create student
 if($student->create()){
   echo json_encode(
       array('message'=>'student created')
   );
 }else{
    echo json_encode(
        array('message'=>'student not created')
    );
 }
?>