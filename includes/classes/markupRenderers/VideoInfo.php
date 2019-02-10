<?php
require_once("Button.php");

class VideoInfo {

   private $dbConnection, $video, $user;

   public function __construct($dbConnection, $video, $user) {
      $this->dbConnection = $dbConnection;
      $this->user = $user;

      $this->video = $vide;
      $this->id = $video->id;
      $this->title = $video->title;
      $this->views = $video->views;
      $this->likes = sizeof($video->likes);
      $this->dislikes = sizeof($video->dislikes);
      $this->wasLikedBy = $video->wasLikedBy;
      $this->wasDislikedBy = $video->wasDislikedBy;

      $this->likeButton = $this->likeButton();
      $this->dislikeButton = $this->dislikeButton();
   }

   public function render() {
      return "
         <div class='videoInfo'>
            <h1>$this->title</h1>
            <div class='infoLower'>
               <span class='views'>$this->views views</span>
               <div class=likeButtons>
                  $this->likeButton
                  $this->dislikeButton
               </div>
            </div>
         </div>
      ";
   }

   private function likeButton() {
      $text = $this->likes;
      $action = "likeVideo(this, $this->id)";
      $class = "likeButton";
      $src = "assets/images/icons/thumb-up.png";

      if ($this->video->wasLikedBy()) {
         $src = "assets/images/icons/thumb-up-active.png";
      }

      return Button::regular($text, $action, $class, $src);
   }

   private function dislikeButton() {
      $text = $this->dislikes;
      $action = "dislikeVideo(this, $this->id)";
      $class = "dislikeButton";
      $src = "assets/images/icons/thumb-down.png";

      if ($this->video->wasDislikedBy()) {
         $src = "assets/images/icons/thumb-down-active.png";
      }

      return Button::regular($text, $action, $class, $src);
   }

}
?>
