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
$sql=mysqli_query($conn,"delete from projects where id=$rid");
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
$sql = "SELECT * FROM users WHERE user_name = '$user_name'";

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

<div class="row">
<div class="col-md-5">
  <div class="card mt-1 shadow">
    <div class="card-body">
      <div class="text-center">
                <?php
if (!isset($row['image']) || empty($row['image'])) {
  $profile_picture = "img/woman.png";
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


<?php
// SQL SELECT statement
$sql = "SELECT *
FROM pregnancy_records
WHERE patient_id = {$_SESSION['id']}
ORDER BY date_created DESC
LIMIT 1
";

// Execute SQL query
$result = mysqli_query($conn, $sql);

// Check if query returned any result
if (mysqli_num_rows($result) === 1) {
    // Access the row using mysqli_fetch_assoc() function
    $row = mysqli_fetch_assoc($result);
?>
    <div class="col-md-7">
        <div class="card mt-1 text-center">
            <div class="card-header">
                <h4 class="mb-0 small">Current Pregnancy Records</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="weight-gain">Weight Gain:</label>
                    <span class="badge badge-info"><?= !empty($row['weight_gain']) ? $row['weight_gain'] . ' pounds' : '0' ?></span>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="blood-pressure">Blood Pressure:</label>
                    <span class="badge badge-info"><?= !empty($row['blood_pressure']) ? $row['blood_pressure'] . ' mmHg' : '0' ?></span>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="fetal-growth">Fetal Growth:</label>
                    <span class="badge badge-info"><?= !empty($row['fetal_growth']) ? $row['fetal_growth'] . ' inch' : '0' ?></span>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group">
                    <label for="glucose-level">Glucose Level:</label>
                    <span class="badge badge-info"><?= !empty($row['glucose_level']) ? $row['glucose_level'] . ' mg/dL' : '0' ?></span>
                  </div>
                </div>
              </div>
            </div>
        </div>
<?php
} else {
    $row = array(
        'weight_gain' => '',
        'blood_pressure' => '',
        'fetal_growth' => '',
        'glucose_level' => ''
    );
?>
    <div class="col-md-7">
        <div class="card mt-1 text-center">
            <div class="card-header">
                <h4 class="mb-0 small">Current Pregnancy Records</h4>
            </div>
            <div class="card-body">
              <ul class="list-inline d-flex justify-content-between">
                <li class="list-inline-item text-center">
                  <span class="label">Weight Gain:</span>
                  <div class="badge badge-info">0 pounds</div>
                </li>
                <li class="list-inline-item text-center">
                  <span class="label">Blood Pressure:</span>
                  <div class="badge badge-info">0 mmHg</div>
                </li>
                <li class="list-inline-item text-center">
                  <span class="label">Fetal Growth:</span>
                  <div class="badge badge-info">0 inch</div>
                </li>
                <li class="list-inline-item text-center">
                  <span class="label">Glucose Level:</span>
                  <div class="badge badge-info">0 mg/dL</div>
                </li>
              </ul>
            </div>
        </div>
<?php
}
?>



    <div class="card mt-1 text-center">
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
        <p><?php
            $user_id = $_SESSION['id'];
            $query = "SELECT d.firstname, d.middlename, d.lastname
                      FROM doctors d
                      INNER JOIN users u ON d.id = u.doctor_id
                      WHERE u.id = $user_id";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                echo "Dr. " . $row['firstname'] . " " . substr($row['middlename'], 0, 1) . ". " . $row['lastname'] . "<br>";
              }
            } else {
              echo "Not yet selected a doctor";
            }
            ?>
            </p>
      </div>
      <div class="col-sm-12 col-md-4 mb-3 mb-md-0">
        <p><?php
            $user_id = $_SESSION['id'];
            $query = "SELECT due_date
                      FROM pregnancy_informations
                      WHERE patient_id = $user_id";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                $due_date = date("M, d Y", strtotime($row['due_date']));
                echo $due_date;
              }
            } else {
              echo "Due date not set.";
            }
            ?></p>
      </div>
      <div class="col-sm-12 col-md-4 mb-3 mb-md-0">
        <p><?php
            $user_id = $_SESSION['id'];
            $query = "SELECT pregnancy_status
                      FROM pregnancy_informations
                      WHERE patient_id = $user_id";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                echo $row['pregnancy_status'];
              }
            } else {
              echo "Due date not set.";
            }
            ?></p>
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