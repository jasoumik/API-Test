<?php
class Users{
    //db stuff
    private $connect;
    private $user_table='users';
    private $project_table='projects';

    //Student props
    public $name;
    public $email;
    public $password;
    public $user_id;
    public $project_name;
    public $description;
    public $status;
  

    //constructor with db
    public function __construct($db)
    {
      $this->connect =$db;  
        
    }
  //   public function read(){
  //       $qry ='SELECT * FROM '.$this->table.' ORDER BY created_at DESC';
  //       //prepare statement
  //       $stm =$this->connect->prepare($qry);
  //       $stm->execute();
  //       return $stm;
  //   }

  //   public function read_single(){
  //     $qry =' SELECT *
  //     FROM
  //     '.$this->table.'
  //     WHERE id=:id
  //     LIMIT 0,1
  //     ';
  //     //prepare statement
  //     $stm =$this->connect->prepare($qry);
  //     //bind id
  //     $stm->bindParam(':id',$this->id);
  //     $stm->execute();
  //     $row=$stm->fetch(PDO::FETCH_ASSOC);
  //     //set props
  //     $this->id =$row['id'];
  //     $this->name =$row['name'];
  //     $this->email=$row['email'];
  //     $this->mobile =$row['mobile'];

  // }
  public function create_prjct(){
    $prj_qry='INSERT INTO
    '.$this->project_table.' SET
     user_id = :user_id,
     name = :name,
     description = :description,
     status = :status';
     $stm =$this->connect->prepare($prj_qry);
     //sanitize
     
     $this->project_name = htmlspecialchars(strip_tags($this->project_name));
       $this->description = htmlspecialchars(strip_tags($this->description));
       $this->status = htmlspecialchars(strip_tags($this->status));
       //bind
       $stm->bindParam(':user_id',$this->user_id);
       $stm->bindParam(':name',$this->project_name);
       $stm->bindParam(':description',$this->description);
       $stm->bindParam(':status',$this->status);
       if($stm->execute()){
        return true;
      }
      //print error
      printf("Error: %s.\n",$stm->error);
      return false;
  }
  public function create(){
    $qry ='INSERT INTO ' . $this->user_table . '
    SET
     name = :name,
     email = :email,
     password = :password
     ';
       //prepare statement
       $stm =$this->connect->prepare($qry);
       //clean data
       
       $this->name = htmlspecialchars(strip_tags($this->name));
       $this->email = htmlspecialchars(strip_tags($this->email));
       $this->password = htmlspecialchars(strip_tags($this->password));

       //bind data
       $stm->bindParam(':name',$this->name);
       $stm->bindParam(':email',$this->email);
       $stm->bindParam(':password',$this->password);

       //execute qry
       if($stm->execute()){
         return true;
       }
       //print error
       printf("Error: %s.\n",$stm->error);
       return false;
  }
  public function check_email(){
    $email_check_qry='SELECT * FROM ' . $this->user_table . ' 
    WHERE email=:check_email';
  $stm =$this->connect->prepare($email_check_qry);
  $stm->bindParam(':check_email',$this->email);
  if($stm->execute()){
    
    return $stm->fetch(PDO::FETCH_ASSOC);
  }
  //print error
  printf("Error: %s.\n",$stm->error);
  return false;
  }
  public function check_login(){
    $pass_check_qry='SELECT * FROM ' . $this->user_table . ' 
    WHERE email=:check_email';
  $stm =$this->connect->prepare($pass_check_qry);
  $stm->bindParam(':check_email',$this->email);
  if($stm->execute()){
    
    return $stm->fetch(PDO::FETCH_ASSOC);
  }
  //print error
  printf("Error: %s.\n",$stm->error);
  return false;
  }
 public function prjct_list(){
   $prj_qry='SELECT * FROM '.$this->project_table.'
   ORDER BY id DESC';
   $stm =$this->connect->prepare($prj_qry);
   $stm->execute();
   return $stm;
 }
 public function user_prjct_list(){
  $prj_qry='SELECT * FROM '.$this->project_table.' WHERE user_id=:user_id
  ORDER BY id DESC';
  $stm =$this->connect->prepare($prj_qry);
  $stm->bindParam(':user_id',$this->user_id);
  $stm->execute();
  return $stm;
}
  //update post

  // public function update(){
  //   $qry ='UPDATE ' . $this->table . '
  //   SET
  //   name = :name,
  //   email = :email,
  //   mobile = :mobile WHERE id= :id
  //    ';
  //      //prepare statement
  //      $stm =$this->connect->prepare($qry);
  //      //clean data
  //      $this->name = htmlspecialchars(strip_tags($this->name));
  //      $this->email = htmlspecialchars(strip_tags($this->email));
  //      $this->mobile = htmlspecialchars(strip_tags($this->mobile));
       

  //      //bind data
  //      $stm->bindParam(':name',$this->name);
  //      $stm->bindParam(':email',$this->email);
  //      $stm->bindParam(':mobile',$this->mobile);
  //      $stm->bindParam(':id',$this->id);
  //      //execute qry
  //      if($stm->execute()){
  //        return true;
  //      }
  //      //print error
  //      printf("Error: %s.\n",$stm->error);
  //      return false;
  // }


  //delte post
  // public function delete(){
  //   $qry ='DELETE FROM ' . $this->table . '
  //    WHERE id= :id
  //    ';
  //      //prepare statement
  //      $stm =$this->connect->prepare($qry);
  //      //clean data
      
  //      $this->id = htmlspecialchars(strip_tags($this->id));

  //      //bind data with id
  //      $stm->bindParam(':id',$this->id);
  //      //execute qry
  //      if($stm->execute()){
  //        return true;
  //      }
  //      //print error
  //      printf("Error: %s.\n",$stm->error);
  //      return false;
  // }
}
?>