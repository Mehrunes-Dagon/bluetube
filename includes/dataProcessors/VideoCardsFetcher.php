<?php

class VideoCardsFetcher {

   private $db, $user, $expanded;

   public function __construct($db, $user) {
      $this->db = $db;
      $this->user = $user;
   }
   
   // Just random for now
   public function getRecommended() {
      $query = $this->db->prepare(
         "SELECT * FROM videos ORDER BY RAND() LIMIT 15");
      $query->execute();
      $cards = array();

      while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
         $card = new VideoCard($this->db, $row, $this->user);
         array_push($cards, $card);
      }

      return $cards;
   }

   public function getSubscribed() {
      $cards = array();
      $subbedUsernames = $this->user->subscriptionsArray();
      $length = sizeof($subbedUsernames);

      if ($length > 0) {
         $sql = "WHERE uploadedBy=?";
         $i = 1;

         while ($i < $length) {
            $sql .= " OR uploadedBy=?";
            $i++;
         }
      } else {
         return $cards;
      }

      $query = $this->db->prepare(
         "SELECT * FROM videos $sql ORDER BY uploadDate DESC"
      );
      $i = 1;
      foreach ($subbedUsernames as $username) {
         $query->bindValue($i, $username);
         $i++;
      }
      $query->execute();

      while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
         $card = new VideoCard($this->db, $row, $this->user);
         array_push($cards, $card);
      }

      return $cards;
   }

   public function getSearchResults($term, $orderBy) {
      $query = $this->db->prepare(
         "SELECT * FROM videos WHERE title LIKE CONCAT('%' :term, '%')
         OR uploadedBy LIKE CONCAT('%' :term, '%') ORDER BY $orderBy DESC"
      );
      $query->bindParam(":term", $term);
      $query->execute();

      $cards = array();

      while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
         $card = new VideoCard($this->db, $row, $this->user);
         array_push($cards, $card);
      }

      return $cards;
   }

   public function getTrending() {
      $query = $this->db->prepare(
         "SELECT * FROM videos WHERE uploadDate >= now() - INTERVAL 7 DAY
         ORDER BY views DESC LIMIT 15"
      );
      $query->execute();

      $cards = array();

      while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
         $card = new VideoCard($this->db, $row, $this->user);
         array_push($cards, $card);
      }

      return $cards;
   }

   public function getLiked() {
      $username = $this->user->username();

      $query = $this->db->prepare(
         "SELECT videoId FROM likes WHERE username=:username AND commentId=0
         ORDER BY id DESC"
      );
      $query->bindParam(":username", $username);
      $query->execute();

      $cards = array();

      while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
         $card = new VideoCard($this->db, $row["videoId"], $this->user);
         array_push($cards, $card);
      }

      return $cards;
   }

   public function getOwned() {
      $username = $this->user->username();

      $query = $this->db->prepare(       
         "SELECT * FROM videos WHERE uploadedBy=:uploadedBy ORDER BY uploadDate DESC");
      $query->bindParam(":uploadedBy", $username);
      $query->execute();

      $cards = array();

      while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
         $card = new VideoCard($this->db, $row, $this->user);
         array_push($cards, $card);
      }

      return $cards;
   }

}
?>