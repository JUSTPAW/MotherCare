<?php 
session_start();
include('includes/header.php');
include('includes/navbar.php');
require 'db_conn.php';

// Function to generate doctor dropdown options
function generateDoctorSelect($conn, $selectedDoctorId) {
    $query = "SELECT doctors.id, doctors.firstname, doctors.lastname, specialities.speciality_name FROM doctors JOIN specialities ON doctors.speciality_id = specialities.id";
    $result = mysqli_query($conn, $query);
    $selectHtml = '<select name="doctor_id" required class="form-control" placeholder="Doctor">' . PHP_EOL;
    $selectHtml .= '<option selected disabled value>Choose Doctor...</option>' . PHP_EOL;
    while($row = mysqli_fetch_assoc($result)) {
        $doctorName = 'Dr. ' . $row['firstname'] . ' ' . $row['lastname'];
        $specialityName = $row['speciality_name'];
        $isSelected = ($row['id'] == $selectedDoctorId) ? 'selected' : '';
        $optionHtml = sprintf('<option data-toggle="tooltip" title="%s" value="%s" %s>%s</option>', $specialityName, $row['id'], $isSelected, $doctorName);
        $selectHtml .= $optionHtml . PHP_EOL;
    }
    $selectHtml .= '</select>' . PHP_EOL;
    return $selectHtml;
}

// Check if an appointment ID was provided in the URL
if(isset($_GET['id'])) {
    $app_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Fetch the appointment details from the database
    $query = "SELECT * FROM appointments WHERE id='$app_id'";
    $query_run = mysqli_query($conn, $query);

    if(mysqli_num_rows($query_run) > 0) {
        $row = mysqli_fetch_array($query_run);    
?>



<?php include('message.php'); ?>
<?php include('message_danger.php'); ?>

<!-- Edit Appointment Form -->
<div class="container-fluid">
    <div class="row justify-content-center"> 
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg">
                <div class="card-header py-3">
                    <div class="d-sm-flex align-items-center justify-content-between py-2">
                        <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-edit fw-fa fa-1x text-gray-600 mr-1"></i>Edit Appointment</h6>
                        <a href="appointments.php" class="btn btn-sm btn-info shadow-sm"><i class="fa fa-arrow-left fa-sm text-white-100 mr-1"></i>Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form class="user text-info" action="code.php" method="POST">
                        <!-- Hidden input field for appointment ID -->
                        <input type="hidden" name="id" value="<?= $row['id']; ?>" class="form-control">

                        <!-- Doctor Select Dropdown -->
                        <div class="form-group">
                            <label>Doctor</label>
                            <?php echo generateDoctorSelect($conn, $row['doctor_id']); ?>
                        </div>
                        
                    <div class="form-group">
                        <input type="hidden" name="patient_id" value="<?php echo $_SESSION['id']; ?>" class="form-control">
                    </div>


                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                        <label>Appointment Date</label>
                        <input type="date" name="app_date" required class="form-control" value = "<?=$row['app_date'];?>" placeholder="Appointment Date">
                        </div>
                        <div class="col-sm-6">
                        <label>Appointment Time</label>
                        <input type="time" name="app_time" value = "<?=$row['app_time'];?>" class="form-control" placeholder="Appointment Time">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Purpose</label>
                        <select type="text" name="purpose" required class="form-control custom-select" onchange="checkOther(this);">
                            <option selected><?=$row['purpose'];?></option>
                            <option>Prenatal care</option>
                            <option>Ultrasound</option>
                            <option>Glucose screening</option>
                            <option>Labor and delivery planning</option>
                            <option>Fetal monitoring</option>
                            <option>Postpartum planning</option>
                            <option>Vaccinations</option>
                            <option>Cervical checks</option>
                            <option>Emotional support</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>

                    <div class="form-group" id="other-purpose" style="display: none;">
                        <label>Other purpose</label>
                        <input type="text" name="other_purpose" class="form-control">
                    </div>

                    <script>
                        function checkOther(select) {
                            if (select.value === "Others") {
                                document.getElementById("other-purpose").style.display = "block";
                                document.getElementById("other-purpose").querySelector("input").required = true;
                            } else {
                                document.getElementById("other-purpose").style.display = "none";
                                document.getElementById("other-purpose").querySelector("input").required = false;
                            }
                        }
                    </script>

                    <div class="form-group">
                      <label>Message<span class="text-gray-600">(optional)</span></label>
                      <textarea class="form-control" name="message" rows="3"><?=$row['message'];?></textarea>
                    </div>

                    <div class="form-group" id="other-purpose">
                        <input type="hidden" name="status" class="form-control">
                    </div>
                    
                        <button type="submit" name="update_appointment" class="btn btn-info btn-user ml-2">Update Appointment</button>
                    </form>


            <?php
                    }
                    else
                    {
                        echo "<h4>No Such Id Found</h4>";
                    }
                }
            ?>
            </div>
            </div>
        </div>
    </div>




</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>