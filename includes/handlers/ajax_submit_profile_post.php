<?php
require_once '../../config/config.php';
include_once("../classes/Users.php");
include_once("../classes/Post.php");
include_once("../classes/Notification.php");

if(isset($_POST['post_body'])) {
  $post = new Post($conn, $_POST['user_from']);
  $post->submitPost($_POST['post_body'], $_POST['user_to']);
}


?>