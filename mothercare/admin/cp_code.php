<?php
session_start();
require 'db_conn.php';
update_user
$current_password = md5($_POST['current_password']);
$new_password = ($_POST['new_password']);
$confirm_password = ($_POST['confirm_password']);

$user_id = $_SESSION['id'];

// Check if current password matches actual password in database
$query = "SELECT * FROM admins WHERE id='$user_id' AND password='$current_password'";
$result = mysqli_query($conn, $query);

if ($result->num_rows == 1) { // Check if current password is correct
  if(preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[_\-#])[A-Za-z\d_\-#]{8,}$/',$new_password)) {
    // Check if new password and confirm password match
    if ($new_password === $confirm_password) {
      // Update user's password in database
      $new_password = md5($new_password);

      $query = "UPDATE admins SET password='$new_password' WHERE id='$user_id'";
      mysqli_query($conn, $query);

      $_SESSION['message'] = "Password changed successfully!";
      header("Location: change_password.php");
      exit(0);
    } else {
      $_SESSION['message_danger'] = "New Password and Confirm Password do not match";
      header("Location: change_password.php");
      exit(0);
    }
  } else {
    $_SESSION['message_danger'] = "New Password must contain at least one uppercase letter, one lowercase letter, one number, and one of the following special characters: _ - # and be at least 8 characters long";
    header("Location: change_password.php");
    exit(0);
  }
} else {
    $_SESSION['message_danger'] = "Current Password is incorrect";
    header("Location: change_password.php");
    exit(0);
}
?>
