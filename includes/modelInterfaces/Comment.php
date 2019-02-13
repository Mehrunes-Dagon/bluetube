<?php 

class Comment {

   protected $db, $comment, $user, $videoId;

   public function __construct($db, $input, $user, $videoId) {
      if (is_array($input)) {
         $comment = $input;
      } else {
         $query = $db->prepare(
            "SELECT * FROM comments where id=:id"
         );
         $query->bindParam(":id", $input);
         $query->execute();

         $comment = $query->fetch(PDO::FETCH_ASSOC);
      }

      $this->db = $db;
      $this->comment = $comment;
      $this->user = $user;
      $this->videoId = $videoId;
   }

   public function user() {
      return $this->user;
   }

   public function id() {
      return $this->comment["id"];
   }

   public function videoId() {
      return $this->comment["videoId"];
   }

   public function postedBy() {
      return $this->comment["postedBy"];
   }

   public function postDate() {
      return $this->comment["postDate"];
   }

   public function replyTo() {
      if ($this->comment["replyTo"]) {
         return $this->comment["replyTo"];
      } else {
         return 0;
      }
   }

   public function body() {
      $text = $this->comment["body"];
      $text = strip_tags($text);
      return $text;
   }

   public function addComment() {
      // in ajax for now...
   }

   public function getRepliesArray() {
      $id = $this->id();
      $query = $this->db->prepare(
         "SELECT * FROM comments WHERE replyTo=:commentId ORDER BY postDate ASC"
      );
      $query->bindParam(":commentId", $id);
      $query->execute();

      $videoId = $this->videoId();
      $comments = array();

      while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
         $comment = new Comment($this->db, $row, $this->user, $videoId);
         array_push($comments, $comment);
      }

      return $comments;
   }

   function getReplyCount() {
      $id = $this->id();

      $query = $this->db->prepare(
         "SELECT count(*) FROM comments WHERE replyTo=:replyTo"
      );
      $query->bindParam(':replyTo', $id);

      return $query->fetchColumn();
   }

   public function totalLikes() {
      $id = $this->id();

      $query = $this->db->prepare(
         "SELECT count(*) as 'count' FROM likes WHERE commentId=:commentId"
      );
      $query->bindParam(":commentId", $id);
      $query->execute();
      $array = $query->fetch(PDO::FETCH_ASSOC);
      $likeCount = $array["count"];

      $query = $this->db->prepare(
         "SELECT count(*) as 'count' FROM dislikes WHERE commentId=:commentId"
      );
      $query->bindParam(":commentId", $id);
      $query->execute();
      $array = $query->fetch(PDO::FETCH_ASSOC);
      $dislikeCount = $array["count"];

      return $likeCount - $dislikeCount;
   }

   public function addLike() {
      $id = $this->id();

      if (in_array($this->user->username, $this->usersWhoLikedArray())) {
         $query = $this->db->prepare(
            "DELETE FROM likes WHERE username=:username AND commentId=:commentId"
         );
         $query->bindParam(":username", $this->user->username);
         $query->bindParam(":commentId", $id);
         $query->execute();
         return -1;
      } else {
         $query = $this->db->prepare(
            "DELETE FROM dislikes WHERE username=:username AND commentId=:commentId"
         );
         $query->bindParam(":username", $this->user->username);
         $query->bindParam(":commentId", $id);
         $query->execute();
         $count = $query->rowCount();

         $query = $this->db->prepare(
            "INSERT INTO likes (username, commentId) VALUES (:username, :commentId)"
         );
         $query->bindParam(":username", $this->user->username);
         $query->bindParam(":commentId", $id);
         $query->execute();
         return 1 + $count;
      }
   }

   public function usersWhoLikedArray() {
      $id = $this->id();

      $query = $this->db->prepare(
         "SELECT * FROM likes WHERE username=:username AND commentId=:commentId"
      );
      $query->bindParam(":username", $this->user->username);
      $query->bindParam(":commentId", $id);
      $query->execute();
      $users = $query->fetchAll();
      $array = array();

      foreach ($users as $user) {
         array_push($array, $user["username"]);
      }

      return $array;
   }

   public function addDislike() {
      $id = $this->id();

      if (in_array($this->user->username, $this->usersWhoDislikedArray())) {
         $query = $this->db->prepare(
            "DELETE FROM dislikes WHERE username=:username AND commentId=:commentId"
         );
         $query->bindParam(":username", $this->user->username);
         $query->bindParam(":commentId", $id);
         $query->execute();

         return 1;
      } else {
         $query = $this->db->prepare(
            "DELETE FROM likes WHERE username=:username AND commentId=:commentId"
         );
         $query->bindParam(":username", $this->user->username);
         $query->bindParam(":commentId", $id);
         $query->execute();
         $count = $query->rowCount();

         $query = $this->db->prepare(
            "INSERT INTO dislikes (username, commentId) VALUES (:username, :commentId)"
         );
         $query->bindParam(":username", $this->user->username);
         $query->bindParam(":commentId", $id);
         $query->execute();

         return -1 - $count;
      }
   }

   public function usersWhoDislikedArray() {
      $id = $this->id();

      $query = $this->db->prepare(
         "SELECT * FROM dislikes WHERE username=:username AND commentId=:commentId"
      );
      $query->bindParam(":username", $this->user->username);
      $query->bindParam(":commentId", $id);
      $query->execute();
      $users = $query->fetchAll();
      $array = array();

      foreach ($users as $user) {
         array_push($array, $user["username"]);
      }

      return $array;
   }

}
?>