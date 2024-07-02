<?php 
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
include('includes/header.php');
include('includes/navbar.php');
require 'db_conn.php';

//Code for deletion
if(isset($_GET['delid']))
{
$rid=intval($_GET['delid']);
$profilepic=$_GET['ppic'];
$ppicpath="uploads"."/".$profilepic;
$sql=mysqli_query($conn,"delete from admins where id=$rid");
unlink($ppicpath);
echo "<script>alert('Data deleted');</script>"; 
echo "<script>window.location.href = 'profile.php'</script>";     
} 
?>
 
<!-- to not back when logout-->
<script type="text/javascript">
    window.history.forward();
    function noBack() {
        window.history.forward();
    }
</script>
<style>
  .rounded-image {
    border-radius: 50%; /* Make the image always rounded */
    width: 160px; /* Set a fixed width */
    height: 160px; /* Set a fixed height */
  }
</style>
<!-- Begin Page Content -->
<div class="container-fluid">

<?php

// Get user_name from session
$user_name = $_SESSION['user_name'];

// SQL SELECT statement
$sql = "SELECT * FROM admins WHERE user_name = '$user_name'";

// Execute SQL query
$result = mysqli_query($conn, $sql);

// Check if query returned any result
if (mysqli_num_rows($result) === 1) {
    // Access the row using mysqli_fetch_assoc() function
    $row = mysqli_fetch_assoc($result);
    
    // Access values using column names
?>

<?php include('message.php'); ?>    
<?php include('message_danger.php'); ?>

<div class="row justify-content-center"> <div class="col-md-5">
  <div class="card mt-1 shadow">
    <div class="card-body">
      <div class="text-center">
        <?php
if (!isset($row['image']) || empty($row['image'])) {
  $profile_picture = "img/admin.png";
} else {
  $profile_picture = "uploads/" . $row['image'];
}
?>

<img src="<?= $profile_picture ?>" alt="Profile Picture" class="mx-auto img-fluid rounded-image mb-3">

      </div>
      <h6 class="mb-0 text-center text-info mb-2">
        <?= $row['firstname'] . ' ' . $row['middlename'] . '. ' . $row['lastname']; ?>
      </h6>
      <ul class="list-group small">
        <li class="list-group-item">
          <i class="fa fa-user mr-3"></i><?= $row['user_name']; ?>
        </li>
        <li class="list-group-item">
          <i class="fa fa-birthday-cake mr-3"></i><?= $row['age']; ?>
        </li>
        <li class="list-group-item">
          <i class="fa fa-envelope mr-3"></i><?= $row['email']; ?>
        </li>
        <li class="list-group-item">
          <i class="fa fa-phone mr-3"></i><?= $row['phone']; ?>
        </li>
        <li class="list-group-item">
          <i class="fa fa-map-marker mr-3"></i><?= $row['address']; ?>
        </li>
      </ul>
    </div>
    <div class="card-footer d-flex justify-content-center" style="text-align:center;">
      <form method="POST" enctype="multipart/form-data">
        <a href="change_image.php?id=<?=$row['id'];?>" class="btn btn-sm btn-outline-primary mt-2"  data-toggle="tooltip" title="Edit Profile Picture" data-placement="top"><i class="fa fa-camera"></i></a>
      </form>
      <a class="btn btn-sm btn-outline-info mt-2 mr-2 ml-2" href="personal_info_edit.php?id=<?= $row['id']; ?>" 
         data-toggle="tooltip" title="Edit Personal Information" data-placement="top">
        <i class="fa fa-edit fw-fa" aria-hidden="true"></i>
      </a>
      <a class="btn btn-sm btn-outline-secondary mt-2 mr-2" href="change_password.php" 
         data-toggle="tooltip" title="Change Password" data-placement="top">
        <i class="fa fa-key fw-fa" aria-hidden="true"></i>
      </a>
      <a href="profile.php?delid=<?php echo ($row['id']);?>&&ppic=<?php echo $row['image'];?>" 
            class="btn btn-sm btn-outline-danger mt-2" title="Delete this account!" data-toggle="tooltip" onclick="msg()">
            <i class="fa fa-trash" aria-hidden="true"></i>
            <script>
                    function msg(){
                        var result = confirm ('Are you sure you want to delete this account?');
                        if(result==false){
                            event.preventDefault();
                        }
                    }
                </script>    
        </a>
    </div>

  </div>
</div>

</div>
<?php
            } else {
    // No user found with the given user_name
    echo "User not found";
}
?>


</div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php 
 }else{
    header("Location: login.php");
    exit();
 }
 ?>
<?php
include('includes/scripts.php');
include('includes/footer.php');
?>