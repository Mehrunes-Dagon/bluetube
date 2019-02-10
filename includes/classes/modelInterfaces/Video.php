<?php

class Video {

   private $dbConnection;
   private $user;

   public 
      $id,
      $tile,
      $description,
      $privacy,
      $category,
      $views,
      $duration,
      $filePath,
      $uploadedBy,
      $uploadedDate
   ;

   public function __construct($dbConnection, $input, $user) {
      $this->dbConnection = $dbConnection;
      $this->user = $user;

      if (is_array($input)) {
         $video = $input;
      } else {
         $query = $this->dbConnection->prepare(
            "SELECT * FROM videos WHERE id = :id"
         );
         $query->bindParam(":id", $input);
         $query->execute();

         $video = $query->fetch(PDO::FETCH_ASSOC);
      }

      $this->id = $video["id"];
      $this->title = $video["title"];
      $this->description = $video["description"];
      $this->privacy = $video["privacy"];
      $this->category = $video["category"];
      $this->views = $video["views"];
      $this->duration = $video["duration"];
      $this->filePath = $video["filePath"];
      $this->uploadedBy = $video["uploadedBy"];
      $this->uploadDate = $video["uploadDate"];
   }

   public function id() {
      return $this->video["id"];
   }
   
   public function title() {

   }
   
   public function description() {

   }
   
   public function privacy() {

   }
   
   public function category() {

   }
   
   public function views() {
      $video["views"];
   }
   
   public function duration() {

   }
   
   public function filePath() {

   }
   
   public function getUploadDate() {
      return date("M j, Y", strtotime($this->date));
   }

   public function getTimeStamp() {
      return date("M jS, Y", strtotime($this->date));
   }

   public function incrementViews() {
      $query = $this->dbConnection->prepare(
         "UPDATE videos SET views=views+1 WHERE id=:id"
      );
      $query->bindParam(":id", $this->id);
      $query->execute();

      $this->views++;
   }

   function getLikedUsernameArray() {
      $query = $this->dbConnection->prepare(
         "SELECT * FROM likes WHERE videoId = :videoId"
      );
      $query->bindParam(":videoId", $this->id);
      $query->execute();

      $likes = $query->fetchAll();
      $array = array();
      
      foreach ($likes as $like) {
         array_push($array, $like["username"]);
      }

      return $array;
   }

   function getDislikedUsernameArray() {
      $query = $this->dbConnection->prepare(
         "SELECT * FROM dislikes WHERE videoId = :videoId"
      );
      $query->bindParam(":videoId", $this->id);
      $query->execute();

      $dislikes = $query->fetchAll();
      $array = array();
      
      foreach ($dislikes as $dislike) {
         array_push($array, $dislike["username"]);
      }

      return $array;
   }


}