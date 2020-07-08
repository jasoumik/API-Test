<?php
//headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');

include_once '../config/database.php';
include_once '../classes/student.php';

//Instantiate Db and Connect
 $database= new Database();
 $db=$database->connect();

 //Instantiate Blog student object
 $student = new Student($db);

 //blog student query
 $result =$student->read();
 //get row count
 $num =$result->rowCount();

 //Check if any students

 if($num>0){
   //student array
   $student_arr=array();
   $student_arr['data']=array();

   while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);
        $student_item =array(
            'id' =>$id,
            'name'=>$name,
            'email' => html_entity_decode($email),
            'mobile' => $mobile,
            'status' => $status
        );
        //push to "data"
        array_push($student_arr['data'],$student_item);
   }
   echo json_encode($student_arr);
 }else{
   echo json_encode(
       array('message'=>'No student Found')
   );
 }
?>