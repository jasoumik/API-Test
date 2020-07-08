<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');


include_once '../config/database.php';
include_once '../classes/student.php';

//Instantiate Db and Connect
 $database= new Database();
 $db=$database->connect();

 //Instantiate Blog student object
 $student = new Student($db);

 //get raw studented data
 $data= json_decode(file_get_contents("php://input"));
 
 $student->id =$data->id;

 
 //delete student
 if($student->delete()){
   echo json_encode(
       array('message'=>'student Deleted')
   );
 }else{
    echo json_encode(
        array('message'=>'student not Deleted')
    );
 }
?>