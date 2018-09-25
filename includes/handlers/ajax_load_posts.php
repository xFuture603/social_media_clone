<?php 
include("../../config/config.php");
include("../classes/Users.php");
include("../classes/Post.php");

$limit = 10; // Number of posts that get loaded per call

$posts = new Post($conn, $_REQUEST['userLoggedIn']);
$posts->loadPostsFriends($_REQUEST, $limit);
?>