<?php
/*if(isset($_POST['login_button'])) {

  $email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL); //sanitize email

  //$_SESSION['log_email'] = $email; //Store the email into session variable
  //$password = md5($_POST['log_password']); //Get password
  $password = $_POST["log_password"];

  $check_database_query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND password='$password'");
  $check_login_query = mysqli_num_rows($check_database_query);

  if($check_login_query == 1) {
    $row = mysqli_fetch_array($check_database_query);
    $username = $row['username'];

    $_SESSION['username'] = $username;
    header("Location: index.php");
    exit();
  }
}*/

  
if (isset($_POST["login_button"])){      
// ensure email is in sanitized (valid) format and assign to var      
$email = filter_var($_POST["log_email"], FILTER_SANITIZE_EMAIL);      // create an email session      
$_SESSION["log_email"] = $email;       
// check the password against the password_hash      
$password = $_POST["log_password"];      
// get hash     
$check_database_query = mysqli_query($conn, "SELECT password, username, email from users WHERE email='$email'");      
$row = mysqli_fetch_array($check_database_query);      
// get the value of the password column      
$hash = $row["password"];      
// verifies the input password against the hashed password      
$password_verify = password_verify($password, $hash);      
// if a record is found, grab the data from the username column      
if ($password_verify == 1){         $username = $row["username"];         
// create a new session with username         
$user_closed_query = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND user_closed='yes'");
if(mysqli_num_rows($user_closed_query) == 1){
    $reopen_account = mysqli_query($conn, "UPDATE users SET user_closed='no' WHERE email='$email'");
}

$_SESSION["username"] = $username;         
// redirect user to index page         
header("Location: index.php");         
exit();      
}
else {
    array_push($error_array, "Email or password was incorrect<br>");
}
}


?>