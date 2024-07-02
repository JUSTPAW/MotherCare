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

    <div class="row justify-content-center"> 

        <div class="col-xl-10 col-lg-12 col-md-9">

        <?php include('message.php'); ?>
        <?php include('message_danger.php'); ?>

            <div class="card o-hidden border-0 shadow-lg">

            <div class="card-header py-3">

                <div class="d-sm-flex align-items-center justify-content-between py-2">
                <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-plus fa-1x text-gray-600 mr-1"></i>
       Make an Appointment</h6>
                <a href="appointments.php" class="btn btn-sm btn-info shadow-sm"><i
                        class="fa fa-arrow-left fa-sm text-white-100 mr-1"></i>Back</a>
                </div>
            </div>
            <div class="card-body">
                
                <form class="text-info small" action="code.php" method="POST">
                    <?php
                    // Assuming you have a database connection established
                    $query = "SELECT doctors.id, doctors.firstname, doctors.lastname, specialities.speciality_name FROM doctors JOIN specialities ON doctors.speciality_id = specialities.id";
                    $result = mysqli_query($conn, $query);
                    ?>
                    <div class="form-group">
                      <label>Doctor</label>
                      <select name="doctor_id" required class="form-control" placeholder="Doctor">
                          <option selected disabled value>Choose Doctor...</option>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                          <option data-toggle="tooltip" title="<?php echo $row['speciality_name']; ?>" value="<?php echo $row['id']; ?>"><?php echo 'Dr. ' . $row['firstname'] . ' ' . $row['lastname']; ?></option>
                        <?php endwhile; ?>
                      </select>
                    </div>


                    <div class="form-group">
                        <input type="hidden" name="patient_id" value="<?php echo $_SESSION['id']; ?>" class="form-control">
                    </div>


                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                        <label>Appointment Date</label>
                        <input type="date" name="app_date" required class="form-control" placeholder="Appointment Date">
                        </div>
                        <div class="col-sm-6">
                        <label>Appointment Time</label>
                        <input type="time" name="app_time" required class="form-control" placeholder="Appointment Time">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Purpose</label>
                        <select type="text" name="purpose" required class="form-control custom-select" onchange="checkOther(this);">
                            <option selected disabled value>Choose Purpose of appointment...</option>
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
                      <textarea class="form-control" name="message" rows="3"></textarea>
                    </div>
                    <div class="form-group" id="other-purpose">
                        <input type="hidden" name="status" class="form-control">
                    </div>

                    <button type="submit" name="save_appointments"  class="btn btn-info btn-user ml-2">Submit Appointment</button>
                </form>
                
            </div>
            </div>
        </div>
    </div>




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