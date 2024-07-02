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
       Add Pregnancy Record</h6>
                <a href="pregnancy_records.php" class="btn btn-sm btn-info shadow-sm"><i
                        class="fa fa-arrow-left fa-sm text-white-100 mr-1"></i>Back</a>
                </div>
            </div>
            <div class="card-body">
                
                <form class="user text-info small" action="code.php" method="POST">
                    <?php
                    // Assuming you have a database connection established
                    $query = "SELECT id, firstname, middlename, lastname FROM users WHERE doctor_id = {$_SESSION['id']}";
                    $result = mysqli_query($conn, $query);
                    ?>
                    <div class="form-group">
                      <label>Pregnant Patient</label>
                      <select name="patient_id" required class="form-control" placeholder="Doctor">
                          <option selected disabled value>Choose Pregnant Patient...</option>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                          <option value="<?php echo $row['id']; ?>"><?php echo $row['firstname'] . ' ' . $row['middlename'] . '. ' . $row['lastname']; ?></option>
                        <?php endwhile; ?>
                      </select>
                    </div>


                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                        <label>Weight Gain</label>
                        <input type="text" name="weight_gain" required class="form-control" placeholder="Weight Gain">
                        </div>
                        <div class="col-sm-6">
                        <label>Blood Pressure</label>
                        <input type="text" name="blood_pressure" required class="form-control" placeholder="Blood Pressure">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                        <label>Fetal Growth</label>
                        <input type="text" name="fetal_growth" required class="form-control" placeholder="Fetal Growth">
                        </div>
                        <div class="col-sm-6">
                        <label>Glocuse Level</label>
                        <input type="text" name="glucose_level" required class="form-control" placeholder="Glocuse Level">
                        </div>
                    </div>

                    <button type="submit" name="save_pregnancy_record"  class="btn btn-info ml-2">Submit Record</button>
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