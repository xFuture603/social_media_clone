<?php
class Notification {
  private $user_obj;
  private $conn;
  
  
  public function __construct($conn, $user)
    {
    $this->conn = $conn;
    $this->user_obj = new User($conn, $user);
    }

  public function getUnreadNumber() {
    $userLoggedIn = $this->user_obj->getUsername();
    $query = mysqli_query($this->conn, "SELECT * FROM notifications WHERE viewed='no' AND user_to='$userLoggedIn'");
    return mysqli_num_rows($query);
  }
}

?>