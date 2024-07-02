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

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4 ml-3">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fa fa-user-md fa-1x text-gray-600 mr-1"></i>
            Choose Your Doctor
        </h1>
    </div>
<?php // Check if the user has clicked the "Set as Your Doctor" button
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['set_doctor'])) {
    $user_id = $_SESSION['id'];
    $doctor_id = $_POST['doctor_id'];
    $sql = "UPDATE users SET doctor_id = '$doctor_id' WHERE id = '$user_id'";
    if ($conn->query($sql) === TRUE) {
        // Doctor ID updated successfully
        echo "<div class='alert alert-success'>Doctor set successfully!</div>";
    } else {
        // Error updating doctor ID
        echo "<div class='alert alert-danger'>Error setting doctor!</div>";
    }
}
?>
    <!-- Doctor Selection Form -->
<div class="card shadow mb-4">
  <div class="card-header text-info">
    Select a Doctor
  </div>
  <div class="card-body">
    <div class="row">
      <div class="col-md-10">
        <form method="POST" class="text-info small" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
          <div class="form-group">
            <select class="form-control" id="doctor" name="doctor">
              <option class="small" value="" selected disabled>Select Doctor</option>
              <?php
              // Retrieve list of doctors from database
              $sql = "SELECT doctors.id, doctors.firstname, doctors.lastname, specialities.speciality_name 
              FROM doctors 
              INNER JOIN specialities ON doctors.speciality_id = specialities.id";
              $result = $conn->query($sql);

              // Output each doctor's name as a dropdown option
              if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                  echo "<option value='" . $row['id'] . "'>" . $row['firstname'] . " " . $row['lastname'] . " (" . $row['speciality_name'] . ")</option>";
                }
              } else {
                echo "<option value=''>No doctors found</option>";
              }
              ?>
            </select>
          </div>
      </div>
      <div class="col-md-2">
        <button type="submit" class="btn btn-info btn-block">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>



<?php
function display_doctor_info($conn, $doctor_id) {
    $sql = "SELECT * FROM doctors INNER JOIN specialities ON doctors.speciality_id = specialities.id WHERE doctors.id = $doctor_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
$output = "
    <div class='card shadow'>
        <div class='card-body'>
            <form method='POST'>
                <input type='hidden' name='doctor_id' value='{$doctor_id}'/>
                <div class='table-responsive text-info'>
                    <table class='table-sm table table-bordered table-hover' width='100%' cellspacing='0'>
                        <thead class='thead-light'>
                            <tr style='text-align:center' >
                                <th scope='col'>Doctor Name</th>
                                <th scope='col'>Age</th>
                                <th scope='col'>Gender</th>
                                <th scope='col'>Specialization</th>
                                <th scope='col'>Description</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr style='text-align:center' >
                                <td>Dr. {$row['firstname']} {$row['lastname']}</td>
                                <td>{$row['age']}</td>
                                <td>{$row['gender']}</td>
                                <td>{$row['speciality_name']}</td>
                                <td>{$row['description']}</td>                                
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class='text-right mt-3'>
                    <button type='submit' class='btn btn-success btn-sm' name='set_doctor'>
                          <i class='fas fa-check-circle mr-1'></i> Set as Your Doctor
                      </button>
                </div>
            </form>
        </div>
    </div>";
    } else {
        $output = "<p>No doctor found with that ID</p>";
    }
    return $output;
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['doctor'])) {
    $doctor_id = $_POST['doctor'];
    echo display_doctor_info($conn, $doctor_id);
}
?>

<script>
    $(document).on('click', '.set-doctor', function(e) {
    e.preventDefault();
    var doctor_id = $(this).data('doctor-id');
    var user_id = <?php echo $_SESSION['id']; ?>;

    $.ajax({
        url: 'set_doctor.php',
        method: 'POST',
        data: {doctor_id: doctor_id, user_id: user_id},
        success: function(response) {
            // Reload the page to show the updated information
            location.reload();
        }
    });
});

</script>


  
  </div>
</div>

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
