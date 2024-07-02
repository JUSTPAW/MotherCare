<?php 
session_start();
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
            <div class="card o-hidden border-0 shadow-lg">

            <div class="card-header py-3">

                <div class="d-sm-flex align-items-center justify-content-between py-2">
                <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-edit fw-fa fa-1x text-gray-600 mr-1"></i>
       Edit Pregnancy Record</h6>
                <a href="pregnancy_records.php" class="btn btn-sm btn-info shadow-sm"><i class="fa fa-arrow-left fa-sm text-white-100 mr-1"></i>Back</a>
                </div>
            </div>
            <div class="card-body">
<?php
if(isset($_GET['id']))
{
    $pr_ID = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT * FROM pregnancy_records WHERE id='$pr_ID' ";
    $query_run = mysqli_query($conn, $query);

    if(mysqli_num_rows($query_run) > 0)
    {
        $row = mysqli_fetch_assoc($query_run);    
?>

<form class="text-info" action="code.php" method="POST">
    <div class="form-group row">
        <div class="col-sm-4 mb-3 mb-sm-0">
            <input type="hidden" name="id" value="<?= $row['id']; ?>" class="form-control">
        </div>
    </div>

    <div class="form-group">
        <label>Pregnant Patient</label>
        <select name="patient_id" required class="form-control" placeholder="Doctor">
            <option selected disabled value>Choose Pregnant Patient...</option>
            <?php
                // Assuming you have a database connection established
                $query = "SELECT id, firstname, middlename, lastname FROM users WHERE doctor_id = {$_SESSION['id']}";
                $result = mysqli_query($conn, $query);

                while($patient = mysqli_fetch_assoc($result)):
                    $selected = ($patient['id'] == $row['patient_id']) ? 'selected' : '';
            ?>
                <option value="<?= $patient['id']; ?>" <?= $selected; ?>>
                    <?= $patient['firstname'] . ' ' . $patient['middlename'] . '. ' . $patient['lastname']; ?>
                </option>
            <?php endwhile; ?>
        </select>
    </div>

    <div class="form-group row">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <label>Weight Gain</label>
            <input type="text" name="weight_gain" value="<?= $row['weight_gain']; ?>" required class="form-control" placeholder="Weight Gain">
        </div>
        <div class="col-sm-6">
            <label>Blood Pressure</label>
            <input type="text" name="blood_pressure" value="<?= $row['blood_pressure']; ?>" required class="form-control" placeholder="Blood Pressure">
        </div>
    </div>

    <div class="form-group row">
        <div class="col-sm-6 mb-3 mb-sm-0">
            <label>Fetal Growth</label>
            <input type="text" name="fetal_growth" value="<?= $row['fetal_growth']; ?>" required class="form-control" placeholder="Fetal Growth">
        </div>
        <div class="col-sm-6">
            <label>Glucose Level</label>
            <input type="text" name="glucose_level" value="<?= $row['glucose_level']; ?>" required class="form-control" placeholder="Glucose Level">
        </div>
    </div>

    <button type="submit" name="update_pregnancy_record" class="btn btn-info ml-2">Update Record</button>
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