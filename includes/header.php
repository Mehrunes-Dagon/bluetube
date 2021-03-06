<?php
require_once("includes/config.php");
require_once("includes/modelInterfaces/User.php");
require_once("includes/dataProcessors/ErrorMsg.php");
require_once("includes/dataProcessors/Success.php");
require_once("includes/markupRenderers/Button.php"); 
require_once("includes/markupRenderers/NavigationMenu.php"); 
require_once("includes/markupRenderers/Masthead.php");
?>
<link rel="stylesheet" type="text/css" href="assets/css/Masthead.css">
<link rel="stylesheet" type="text/css" href="assets/css/NavigationMenu.css">
<link rel="stylesheet" type="text/css" href="assets/css/Button.css">
<?php

$loggedInUsername = User::isLoggedIn() ? $_SESSION["loggedIn"] : "";
$loggedInUser = new User($db, $loggedInUsername);
$navMenu = new NavigationMenu($loggedInUser);
$masthead = new Masthead($db, $loggedInUsername);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <title>BlueTube</title>

   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta http-equiv="X-UA-Compatible" content="ie=edge">

   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
   <link rel="stylesheet" type="text/css" href="assets/css/normalize.css">
   <link rel="stylesheet" type="text/css" href="assets/css/header.css">

   <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
   <script src="assets/javascript/userActions.js"></script>
   <script src="assets/javascript/commonActions.js"></script>
</head>

<body>
   <div id="pageContainer">
           
      <?php 
      echo  $masthead->render();
      echo $navMenu->render();     
      ?>

      <div id="mainSectionContainer">
         <div id="mainContentContainer">
            