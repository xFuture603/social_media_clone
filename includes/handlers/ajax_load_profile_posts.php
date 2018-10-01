<?php 
include_once("../../config/config.php");
include_once("../classes/Users.php");
include_once("../classes/Post.php");

$limit = 10; // Number of posts that get loaded per call

$posts = new Post($conn, $_REQUEST['userLoggedIn']);
$posts->loadProfilePosts($_REQUEST, $limit);
?>