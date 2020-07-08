<?php
class Student{
    //db stuff
    private $connect;
    private $table='tbl_students';

    //Student props
    public $name;
    public $email;
    public $mobile;
    public $id;

    //constructor with db
    public function __construct($db)
    {
      $this->connect =$db;  
        
    }
    public function read(){
        $qry =' SELECT *
        FROM
        '.$this->table.'
        ORDER BY 
        created_at DESC
        ';
        //prepare statement
        $stm =$this->connect->prepare($qry);
        $stm->execute();
        return $stm;

    }

    public function read_single(){
      $qry =' SELECT *
      FROM
      '.$this->table.'
      WHERE id=:id
      LIMIT 0,1
      ';
      //prepare statement
      $stm =$this->connect->prepare($qry);
      //bind id
      $stm->bindParam(':id',$this->id);
      $stm->execute();
      $row=$stm->fetch(PDO::FETCH_ASSOC);
      //set props
      $this->id =$row['id'];
      $this->name =$row['name'];
      $this->email=$row['email'];
      $this->mobile =$row['mobile'];

  }
  public function create(){
    $qry ='INSERT INTO ' . $this->table . '
    SET
     name = :name,
     email = :email,
     mobile = :mobile
     ';
       //prepare statement
       $stm =$this->connect->prepare($qry);
       //clean data
       
       $this->name = htmlspecialchars(strip_tags($this->name));
       $this->email = htmlspecialchars(strip_tags($this->email));
       $this->mobile = htmlspecialchars(strip_tags($this->mobile));

       //bind data
       $stm->bindParam(':name',$this->name);
       $stm->bindParam(':email',$this->email);
       $stm->bindParam(':mobile',$this->mobile);

       //execute qry
       if($stm->execute()){
         return true;
       }
       //print error
       printf("Error: %s.\n",$stm->error);
       return false;
  }


  //update post

  public function update(){
    $qry ='UPDATE ' . $this->table . '
    SET
    name = :name,
    email = :email,
    mobile = :mobile WHERE id= :id
     ';
       //prepare statement
       $stm =$this->connect->prepare($qry);
       //clean data
       $this->name = htmlspecialchars(strip_tags($this->name));
       $this->email = htmlspecialchars(strip_tags($this->email));
       $this->mobile = htmlspecialchars(strip_tags($this->mobile));
       

       //bind data
       $stm->bindParam(':name',$this->name);
       $stm->bindParam(':email',$this->email);
       $stm->bindParam(':mobile',$this->mobile);
       $stm->bindParam(':id',$this->id);
       //execute qry
       if($stm->execute()){
         return true;
       }
       //print error
       printf("Error: %s.\n",$stm->error);
       return false;
  }


  //delte post
  public function delete(){
    $qry ='DELETE FROM ' . $this->table . '
     WHERE id= :id
     ';
       //prepare statement
       $stm =$this->connect->prepare($qry);
       //clean data
      
       $this->id = htmlspecialchars(strip_tags($this->id));

       //bind data with id
       $stm->bindParam(':id',$this->id);
       //execute qry
       if($stm->execute()){
         return true;
       }
       //print error
       printf("Error: %s.\n",$stm->error);
       return false;
  }
}
?>