<?php 
require_once("includes/header.php");
require_once("includes/classes/UploadedVideoData.php");
require_once("includes/classes/VideoProcessor.php");

if (!isset($_POST["uploadButton"])) {
    echo "No file has been selected.";
    exit();
}

$uploadedVideoData = new UploadedVideoData(
   $_FILES["fileInput"], 
   $_POST["titleInput"],
   $_POST["descriptionInput"],
   $_POST["privacyInput"],
   $_POST["categoryInput"],
   "REPLACE-THIS"    
);

$videoProcessor = new VideoProcessor($dB_Connection);

$wasSuccessful = $videoProcessor->upload($uploadedVideoData);

if ($wasSuccessful) {
    echo "Video upload successful";
}
?>
