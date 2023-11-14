<?php
// start the session
session_start();

// check if the form was submitted
if(isset($_POST['username'])) {
  // retrieve the username and password from the form
  $username = $_POST['username'];
  $password = $_POST['password'];

  // perform some basic validation
  if(empty($username) || empty($password)) {
    // if either field is empty, redirect back to the login page with an error message
    $_SESSION['error'] = 'Please enter both a username and password.';
    header('Location: login.php');
    exit;
  }

  // connect to the database
  $link = mysqli_connect('localhost', 'root', 'phpproject', 'wanwan');
  if(!$link) {
    die('Failed to connect to the database.');
  }

  // query the database to check if the username exists
  $query = "SELECT user_account, user_password, user_role FROM uuser WHERE user_account = '$username'";
  $result = mysqli_query($link, $query);
  if(mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    $storedPassword = $row['user_password'];
    $userRole = $row['user_role'];
    if($userRole == 'banned'){
      $_SESSION['error'] = 'You are banned.';
      header("Location: login.php");
      exit;
    }

    $query = "SELECT * FROM uuser WHERE user_account = '$username'";
    $result = mysqli_query($link, $query);
    //if(mysqli_num_rows($result) === 1) {
      $row = mysqli_fetch_assoc($result);
    // verify the password
    if($password == $storedPassword) {
      // if the username and password are correct, store the user's information in the session
      $_SESSION['username'] = $row['user_account'];
      $_SESSION['role'] = $userRole;
      $_SESSION['viewer_user_ID'] = $row['user_ID'];
      mysqli_free_result($result);
      mysqli_close($link);

      // redirect to the appropriate page based on the user's role
      if($userRole === 'admin') {
        header('Location: admin.php');
        exit;
      } else if($userRole === 'artist'){
        header('Location: artist.php');
        exit;
      } else if($userRole === 'collector'){
        header('Location: artist.php');
        exit;
      }
    }
  }

  // if the username and password are incorrect or the user doesn't exist, redirect back to the login page with an error message
  $_SESSION['error'] = 'Incorrect username or password.';
  mysqli_free_result($result);
  mysqli_close($link);
  header('Location: login.php');
  exit;
} else {
  // if the form was not submitted, redirect back to the login page
  header('Location: login.php');
  exit;
}
?>
