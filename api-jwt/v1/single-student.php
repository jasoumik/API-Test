<?php 
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../classes/student.php';

//Instantiate Db and Connect
 $database= new Database();
 $db=$database->connect();

 //Instantiate Blog student object
 $student = new Student($db);

 //get id
 $student->id = isset($_GET['id'])?$_GET['id'] : die();

 //get student
 $student->read_single();
 $student_item =array(
    'id' =>$student->id,
    'name'=>$student->name,
    'email' => $student->email,
    'mobile' => $student->mobile
);

print_r(json_encode($student_item));
?>