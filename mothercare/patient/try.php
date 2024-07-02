<?php 
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
include('includes/header.php');
include('includes/navbar.php');
require 'db_conn.php';
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
$sql = "SELECT * FROM users WHERE user_name = '$user_name'";

// Execute SQL query
$result = mysqli_query($conn, $sql);

// Check if query returned any result
if (mysqli_num_rows($result) === 1) {
    // Access the row using mysqli_fetch_assoc() function
    $row = mysqli_fetch_assoc($result);
    
    // Access values using column names
?>
<div class="row">
<div class="col-md-5">
  <div class="card mt-4 shadow">
    <div class="card-body">
      <div class="text-center">
        <img src="img/5.jpg" alt="User Image" class="mx-auto img-fluid rounded-image mb-3">
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
    <div class="card-footer" style="text-align:center;">
      <a href="#" class="btn btn-sm btn-outline-primary mt-2 ml-auto">
        <i class="fa fa-camera"></i>
      </a>
      <a class="btn btn-sm btn-outline-info mt-2 ml-auto" href="personal_info_edit.php?id=<?= $row['id']; ?>" 
         data-toggle="tooltip" title="Edit Personal Information" data-placement="top">
        <i class="fa fa-edit fw-fa" aria-hidden="true"></i>
      </a>
      <form action="code.php" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete your account?')">
        <button type="submit" name="delete_account" value="<?= $row['id']; ?>" class="btn btn-sm btn-outline-danger mt-2">
          <i class="fa fa-trash fw-fa" aria-hidden="true"></i>
        </button>
      </form>
    </div>
  </div>
</div>


  <div class="col-md-7">
    <div class="card mt-4 text-center">
      <div class="card-header">
        <h4 class="mb-0 small">Current Pregnancy Records</h4>
      </div>
      <div class="card-body">
        <ul class="list-inline">
          <li class="list-inline-item">
            <span class="badge badge-info">X lbs</span>
          </li>
          <li class="list-inline-item">
            <span class="badge badge-info">Y mmHg</span>
          </li>
          <li class="list-inline-item">
            <span class="badge badge-info">Z cm</span>
          </li>
          <li class="list-inline-item">
            <span class="badge badge-info">W mg/dL</span>
          </li>
        </ul>
      </div>
    </div>

    <div class="card mt-4 text-center">
  <div class="card-header">
    <h4 class="mb-0 small">Pregnancy Information</h4>
  </div>
  <div class="card-body small">
    <div class="row">
      <div class="col-sm-12 col-md-4 mb-3 mb-md-0">
        <p><strong>Doctor:</strong></p>
      </div>
      <div class="col-sm-12 col-md-4 mb-3 mb-md-0">
        <p><strong>Due Date:</strong></p>
      </div>
      <div class="col-sm-12 col-md-4 mb-3 mb-md-0">
        <p><strong>Pregnancy Status:</strong></p>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 col-md-4 mb-3 mb-md-0">
        <p>Dr. Robert White</p>
      </div>
      <div class="col-sm-12 col-md-4 mb-3 mb-md-0">
        <p>October 1, 2023</p>
      </div>
      <div class="col-sm-12 col-md-4 mb-3 mb-md-0">
        <p>1st Semester</p>
      </div>
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