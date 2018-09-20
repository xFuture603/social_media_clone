<?php
//Declaring variables to prevent errors
$fname = ""; //first name
$lname = ""; //last name
$em = ""; //email
$em2 = ""; //email 2
$password = ""; //password
$password2 = ""; //password2
$date = ""; //Sign up date
$error_array = array(); //Holds error messages

if(isset($_POST['register_button'])){

  //Registration form values

  //First name
  $fname = strip_tags($_POST['reg_fname']); //Remove html tags from first name
  $fname = str_replace(' ','',$fname); //Remove spaces from first name
  $fname = ucfirst(strtolower($fname)); //Uppercase only the first letter
  $_SESSION['reg_fname'] = $fname; //Stores the first name into session variable

  //Last name
  $lname = strip_tags($_POST['reg_lname']); //Remove html tags from last name
  $lname = str_replace(' ','',$lname); //Remove spaces from last name
  $lname = ucfirst(strtolower($lname)); //Uppercase only the first letter
  $_SESSION['reg_lname'] = $lname; //Stores the last name into session variable

  //Email
  $em = strip_tags($_POST['reg_email']); //Remove html tags from email
  $em = str_replace(' ','',$em); //Remove spaces from email
  $em = ucfirst(strtolower($em)); //Uppercase only the first letter
  $_SESSION['reg_email'] = $em; //Stores the email into session variable

  //Email2
  $em2 = strip_tags($_POST['reg_email2']); //Remove html tags from email2
  $em2 = str_replace(' ','',$em2); //Remove spaces from email2
  $em2 = ucfirst(strtolower($em2)); //Uppercase only the first letter
  $_SESSION['reg_email2'] = $em2; //Stores the email2 into session variable

  //Password
  $password = strip_tags($_POST['reg_password']); //Remove html tags from password


  //Password 2
  $password2 = strip_tags($_POST['reg_password2']); //Remove html tags from password2

  $date = date("Y-m-d"); //Gets the current date

  if($em == $em2){
    //Check if emails are in a valid format
    if(filter_var($em, FILTER_VALIDATE_EMAIL)){

      $em = filter_var($em, FILTER_VALIDATE_EMAIL);

      //Check if email already exists
      $e_check = mysqli_query($conn, "SELECT email FROM users WHERE email='$em'");

      //Count the number of rows returned
      $num_rows = mysqli_num_rows($e_check);

      if($num_rows > 0){
        array_push($error_array, "Email already in use<br>");
      }

    }
    else {
      array_push($error_array, "Invalid email format<br>");
    }
  }
  else {
    array_push($error_array, "Emails don't match<br>");
  }

  if(strlen($fname) > 25 || strlen($fname) < 2) {
    array_push($error_array, "Your first name must be between 2 and 25 characters!<br>");
  }
  if(strlen($lname) > 25 || strlen($lname) < 2) {
    array_push($error_array, "Your last name must be between 2 and 25 characters!<br>");
  }

  if($password != $password2){
    array_push($error_array, "Your password do not match<br>");
  }
  else {
    if(preg_match('/^(?=.*\d)(?=.*[@#\-_$%^&+=§!\?])(?=.*[a-z])(?=.*[A-Z])[0-9A-Za-z@#\-_$%^&+=§!\?]{8,20}$/', $password)) {
      array_push($error_array, "Your password can only contain english characters or numbers<br>");
    }
  }

  if(strlen($password > 30 || strlen($password) < 5)) {
    array_push($error_array, "Your password must be between 5 and 30 characters<br>");
  }

  if(empty($error_array)){
    //$password = md5($password); //Encrypt password before sending to database
    $password = password_hash($password, PASSWORD_DEFAULT);



    //Generating username by concatenating first name and last name
    $username = strtolower($fname . "_" . $lname);
    $check_username_query = mysqli_query($conn, "SELECT username FROM users WHERE username ='$username'");

    $i = 0;
    //if username exists add number to username
    while(mysqli_num_rows($check_username_query) != 0) {
     $i++; //$i = $i + 1
     $username = $username . "_" . $i;
     $check_username_query = mysqli_query($conn, "SELECT username FROM users WHERE username ='$username'");
    }

    //Profile picture assignment
    $rand = rand(1, 2); //Random number between 1 and 2

    if($rand == 1)
      $profile_pic = "assets/images/profile_pics/defaults/head_deep_blue.png";
    else if($rand == 2)
      $profile_pic = "assets/images/profile_pics/defaults/head_emerald.png";

    $query = mysqli_query($conn, "INSERT INTO users VALUES ('', '$fname', '$lname', '$username', '$em', '$password', '$date', '$profile_pic', '0', '0', 'no', ',')");

    array_push($error_array, "<span style='color: #14C800;'>You're all set! Go ahead and login!</span><br>");

    //Clear session variables
    $_SESSION['reg_fname'] = "";
    $_SESSION['reg_lname'] = "";
    $_SESSION['reg_email'] = "";
    $_SESSION['reg_email2'] = "";
  }



}

?>