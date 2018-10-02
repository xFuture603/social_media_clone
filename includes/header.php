<?php
require_once 'config/config.php';
include_once("includes/classes/Users.php");
include_once("includes/classes/Post.php");

if (isset($_SESSION['username'])) {
  $userLoggedIn = $_SESSION['username'];
  $user_details_query = mysqli_query($conn, "SELECT * FROM users WHERE username='$userLoggedIn'");
  $user = mysqli_fetch_array($user_details_query);
}
else {
  header("Location: register.php");
}

?>

<html>
<head>
  <title>Welcome to my social media!</title>
  <script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
  <!--Javascript -->
  <script src="assets/js/bootstrap.js"></script>
  <script src="assets/js/bootbox.min.js"></script>
  <script src="assets/js/social.js"></script>
  <script src="assets/js/jquery.jcrop.js"></script>
  <script src="assets/js/jcrop_bits.js"></script>

  <!-- CSS -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
  <link rel="stylesheet" type=text/css href="assets/css/bootstrap.css">
  <link rel="stylesheet" type=text/css href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/jquery.Jcrop.css" type="text/css" />
</head>
<body>

<div class="top_bar">
 <div class="logo">
  <a href="index.php">Social Media</a>
 </div>
   <nav>
     <a href="<?php echo $userLoggedIn; ?>">
       <?php echo $user['first_name'];?>
     </a>
     <a href="index.php">
       <i class="fa fa-home fa-lg"></i>
     </a>
     <a href="#">
       <i class="fa fa-envelope fa-lg"></i>
     </a>
     <a href="#">
       <i class="fa fa-bell fa-lg"></i>
     </a>
     <a href="request.php">
       <i class="fa fa-users fa-lg"></i>
     </a>
     <a href="#">
       <i class="fa fa-cog fa-lg"></i>
     </a>
     <a href="includes/handlers/logout.php">
       <i class="fa fa-sign-out-alt fa-lg"></i>
     </a>

   </nav>
</div>

<div class="wrapper">