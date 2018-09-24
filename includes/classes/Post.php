<?php
class Post

  {
  private $user_obj;
  private $conn;
  
  
  public function __construct($conn, $user)
    {
    $this->conn = $conn;
    $this->user_obj = new User($conn, $user);
    }

  public function submitPost($body, $user_to)
    {
    $body = strip_tags($body); //removes html tags
    $body = mysqli_real_escape_string($this->conn, $body);
    $check_empty = preg_replace('/\s+/', '', $body); //Deletes all spaces
    if ($check_empty != "")
      {

      // Current date and time

      $date_added = date("Y-m-d H:i:s");

      // Get username

      $added_by = $this->user_obj->getUsername();

      // If user is not on own profile, user_to is 'none'

      if ($user_to == $added_by)
        {
        $user_to = "none";
        }

      // insert post into the database

      $query = mysqli_query($this->conn, "INSERT INTO posts VALUES('', '$body', '$added_by', '$user_to', '$date_added', 'no', 'no', '0')");
      $returned = mysqli_insert_id($this->conn);

      // Insert notification
      // Update post count for user

      $num_posts = $this->user_obj->getNumPosts();
      $num_posts++;
      $update_query = mysqli_query($this->conn, "UPDATE users SET num_posts='$num_posts' WHERE username='added_by'");
      }
    }

  public function loadPostsFriends()
    {
    $str = ""; //String to return
    $data = mysqli_query($this->conn, "SELECT * FROM posts WHERE deleted='no' ORDER BY id DESC");
    while ($row = mysqli_fetch_array($data))
      {
      $id = $row['id'];
      $body = $row['body'];
      $added_by = $row['added_by'];
      $date_time = $row['date_added'];

      // Prepare user_to string so it can be included even if is not posted to a user

      if ($row['user_to'] == "none")
        {
        $user_to = "";
        }
        else
        {
        $user_to_obj = new User($conn, $row['user_to']);
        $user_to_name = $user_to_obj->getFirstAndLastName();
        $user_to ="<a href='" . $row['user_to'] . "'>" . $user_to_name . "</a>";
        }

        //Check if user who posted, has their account closed
        $added_to_obj = new User($conn, $row['added_by']);
        if($added_by_obj->isClosed()){
          continue;
        }

        $user_details_query = mysqli_query($this->conn, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
        $user_row = mysqli_fetch_array($user_details_query);

        //Timeframe
        $date_time_now = date("Y-m-d H:i:s");
        $start_date = new DateTime($date_time); //Time of post
        $end_date = new DateTime($date_time_now); //Current time
        $interval = $start_date->diff($end_date); //Difference between dates
        if($interval->y >=1) {
          if($interval == 1)
            $time_message = $interval->y . " year ago"; //1 year ago
          else
            $time_message = $interval->y . " years ago"; //1+ years ago
        }
        else if ($interval -> m >= 1){
          if($interval->d == 0) {
            $days = " ago";
          }
          else if($interval -> d == 1){
            $days = $interval->d . " day ago";
          }
          else {
            $days = $interval->d . " days ago";
          }

          if($interval ->m == 1){
            $time_message = $interval->m . " month". $days;
          }
          else {
            $time_message = $interval->m . " months". $days;
          }
        }
        else if($interval ->d >= 1){
          if($interval->d == 1) {
            $days = "Yesterday";
          }
        } else {
          $time_message = $interval->d . " days ago";
        }
      }
      else if($interval->h >= 1) {
        if($interval->h == 1){
          $time_message = $interval->h . " hour ago";
        }
        else {
          $time_message = $interval->h . " hours ago";
        }
      }
    }
  }
?>
