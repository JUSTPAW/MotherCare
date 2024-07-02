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
       Add Medical Record</h6>
                <a href="medical_records.php" class="btn btn-sm btn-info shadow-sm"><i
                        class="fa fa-arrow-left fa-sm text-white-100 mr-1"></i>Back</a>
                </div>
            </div>
            <div class="card-body">
                
                <form class="user text-info small" action="code.php" method="POST">
                    <?php
                    // Assuming you have a database connection established
                    $query = "SELECT id, firstname, middlename, lastname FROM users";
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


                    <div class="form-group">
                      <label>Record Type</label>
                      <select name="record_type" required class="form-control">
                        <option selected disabled value>Select a record type</option>
                        <option value="Obstetric history">Obstetric history</option>
                        <option value="Ultrasound">Ultrasound</option>
                        <option value="Blood test">Blood test</option>
                        <option value="Doctor's visit">Doctor's visit</option>
                        <option value="Medication">Medication</option>
                        <option value="Surgical procedure">Surgical procedure</option>
                        <option value="Fetal monitoring">Fetal monitoring</option>
                        <option value="Maternal monitoring">Maternal monitoring</option>
                        <option value="Nutritional counseling">Nutritional counseling</option>
                        <option value="Genetic testing">Genetic testing</option>
                        <option value="Psychological counseling">Psychological counseling</option>
                        <option value="Labor and delivery">Labor and delivery</option>
                        <option value="Postpartum care">Postpartum care</option>
                        <option value="Immunization">Immunization</option>
                        <option value="Referral to specialist">Referral to specialist</option>
                        <option value="Other">Other</option>
                      </select>
                    </div>

                    <div class="form-group">
                      <label>Description</label>
                      <textarea class="form-control" name="description" required rows="3"></textarea>
                    </div>

                    <button type="submit" name="save_medical_record"  class="btn btn-info ml-2">Submit Record</button>
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