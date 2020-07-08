<?php
class Post{
    //db stuff
    private $connect;
    private $table='posts';

    //Post props
    public $id;
    public $cat_id;
    public $cat_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    //constructor with db
    public function __construct($db)
    {
      $this->connect =$db;  
        
    }
    public function read(){
        $qry =' SELECT 
        c.id as category_id,
        c.name as cat_name,
        p.id,
        p.title,
        p.body,
        p.author,
        p.created_at
        FROM
        '.$this->table.' p LEFT JOIN categories c ON p.category_id = c.id
        ORDER BY 
        p.created_at DESC
        ';
        //prepare statement
        $stm =$this->connect->prepare($qry);
        $stm->execute();
        return $stm;

    }

    public function read_single(){
      $qry =' SELECT 
      c.id as category_id,
      c.name as cat_name,
      p.id,
      p.title,
      p.body,
      p.author,
      p.created_at
      FROM
      '.$this->table.' p LEFT JOIN categories c ON p.category_id = c.id
      WHERE p.id =?
      LIMIT 0,1
      ';
      //prepare statement
      $stm =$this->connect->prepare($qry);
      //bind id
      $stm->bindParam(1,$this->id);
      $stm->execute();
      $row=$stm->fetch(PDO::FETCH_ASSOC);
      //set props
      $this->title =$row['title'];
      $this->body =$row['body'];
      $this->author=$row['author'];
      $this->cat_id =$row['category_id'];
      $this->cat_name =$row['cat_name'];

  }
  public function create(){
    $qry ='INSERT INTO ' . $this->table . '
    SET
     title = :title,
     body = :body,
     author = :author,
     category_id = :category_id
     ';
       //prepare statement
       $stm =$this->connect->prepare($qry);
       //clean data
       $this->title = htmlspecialchars(strip_tags($this->title));
       $this->body = htmlspecialchars(strip_tags($this->body));
       $this->author = htmlspecialchars(strip_tags($this->author));
       $this->cat_id = htmlspecialchars(strip_tags($this->cat_id));

       //bind data
       $stm->bindParam(':title',$this->title);
       $stm->bindParam(':body',$this->body);
       $stm->bindParam(':author',$this->author);
       $stm->bindParam(':category_id',$this->cat_id);

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
     title = :title,
     body = :body,
     author = :author,
     category_id = :category_id WHERE id= :id
     ';
       //prepare statement
       $stm =$this->connect->prepare($qry);
       //clean data
       $this->title = htmlspecialchars(strip_tags($this->title));
       $this->body = htmlspecialchars(strip_tags($this->body));
       $this->author = htmlspecialchars(strip_tags($this->author));
       $this->cat_id = htmlspecialchars(strip_tags($this->cat_id));
       $this->id = htmlspecialchars(strip_tags($this->id));

       //bind data
       $stm->bindParam(':title',$this->title);
       $stm->bindParam(':body',$this->body);
       $stm->bindParam(':author',$this->author);
       $stm->bindParam(':category_id',$this->cat_id);
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