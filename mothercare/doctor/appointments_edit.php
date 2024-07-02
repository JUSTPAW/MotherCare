<?php 
session_start();
include('includes/header.php');
include('includes/navbar.php');
require 'db_conn.php';

// Check if an appointment ID was provided in the URL
if(isset($_GET['id'])) {
    $app_id = mysqli_real_escape_string($conn, $_GET['id']);

    // Fetch the appointment details from the database
    $query = "SELECT appointments.*, users.firstname, users.middlename, users.lastname 
              FROM appointments 
              INNER JOIN users ON appointments.patient_id = users.id 
              WHERE appointments.id='$app_id'";
    $query_run = mysqli_query($conn, $query);

    if(mysqli_num_rows($query_run) > 0) {
        $row = mysqli_fetch_array($query_run);    
?>

<!-- Edit Appointment Form -->
<div class="container-fluid">
    <div class="row justify-content-center"> 
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg">
                <div class="card-header py-3">
                    <div class="d-sm-flex align-items-center justify-content-between py-2">
                        <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-edit fw-fa fa-1x text-gray-600 mr-1"></i>Respond to Appointment Request</h6>
                        <a href="appointments.php" class="btn btn-sm btn-info shadow-sm"><i class="fa fa-arrow-left fa-sm text-white-100 mr-1"></i>Back</a>
                    </div>
                </div>
                <div class="card-body">
                    <form class="user text-info small" action="code.php" method="POST">
                        <!-- Hidden input field for appointment ID -->
                        <input type="hidden" name="id" value="<?= $row['id']; ?>" class="form-control">

                        <!-- Show the patient details -->
                        <div class="form-group">
                            <label>Patient Name</label>
                            <input type="text" name="patient_name" value="<?= $row['firstname'] . ' ' . $row['middlename'] . ' ' . $row['lastname']; ?>" class="form-control" readonly>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label>Appointment Date</label>
                                <input type="date" name="app_date" required class="form-control" value="<?= $row['app_date']; ?>" placeholder="Appointment Date" readonly>
                            </div>
                            <div class="col-sm-6">
                                <label>Appointment Time</label>
                                <input type="time" name="app_time" value="<?= $row['app_time']; ?>" class="form-control" placeholder="Appointment Time" readonly>
                            </div>
                        </div>

                    <div class="form-group">
                        <label>Purpose</label>
                        <select type="text" name="purpose" required class="form-control custom-select" onchange="checkOther(this);" readonly>
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
                      <textarea class="form-control" name="message" rows="3" readonly><?=$row['message'];?></textarea>
                    </div>

                   <div class="form-group">
                        <label>Status</label>
                        <select name="status" required class="form-control custom-select">
                            <option selected value="<?=$row['status'];?>"><?=$row['status'];?></option>
                            <option value="Scheduled" data-toggle="tooltip" data-placement="top" title="The appointment is scheduled">Scheduled</option>
                            <option value="Cancelled" data-toggle="tooltip" data-placement="top" title="The appointment is cancelled">Cancelled</option>
                            <option value="Completed" data-toggle="tooltip" data-placement="top" title="The appointment is completed">Completed</option>
                        </select>
                    </div>


                    
                        <button type="submit" name="update_appointment" class="btn btn-info btn-user ml-2">Update Appointment Status</button>
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