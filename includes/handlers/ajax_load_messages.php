<?php 
include_once("../../config/config.php");
include_once("../classes/Users.php");
include_once("../classes/Message.php");

$limit = 7; //Number of messages to load

$message = new Message($conn, $_REQUEST['userLoggedIn']);
echo $message->getConvosDropdown($_REQUEST, $limit);

?>