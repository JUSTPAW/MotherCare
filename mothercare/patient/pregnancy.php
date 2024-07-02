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

<div class="row">

    <div class="col-lg-12 col-sm-12 mt-1">
      
        <div class="card shadow shadow-sm">
          <div class="card-header">
              <h6 class="m-0 font-weight-bold text-info">Pregnancy Informations</h5>
          </div>

            <div class="card-body">
               <!--  <h5 class="card-title">Special title treatment</h5> -->
            <form class="text-info mt-1">
            <?php
            // Assuming we have already connected to the database and retrieved the data
            // We will retrieve the patient's information based on the ID of the currently logged in user
            $user_id = $_SESSION['id'];

            // Retrieve the patient's information from the database
            $query = "SELECT pi.due_date, pi.baby_name, pi.pregnancy_status
                      FROM pregnancy_informations pi
                      INNER JOIN users u ON pi.patient_id = u.id
                      WHERE pi.patient_id = $user_id";
            $result = mysqli_query($conn, $query);

            // Check if the query returned any results
            if(mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $due_date = isset($row['due_date']) ? $row['due_date'] : '';
                $baby_name = isset($row['baby_name']) ? $row['baby_name'] : '';
                $pregnancy_status = isset($row['pregnancy_status']) ? $row['pregnancy_status'] : '';
            } else {
                $due_date = '';
                $baby_name = '';
                $pregnancy_status = '';
            }
            ?>

<div class="form-group row">
    <div class="col-sm-4 small">
        <label>Baby's Name</label>
        <div class="input-group">
            <input type="text" class="form-control" value="<?php echo $baby_name; ?>" readonly>
        </div>
    </div>
    <div class="col-sm-4 small">
        <label>Due Date</label>
        <div class="input-group">
            <?php if(isset($due_date) && $due_date > 0) { ?>
                <input type="text" class="form-control" value="<?php echo date('F d, Y', strtotime($due_date)); ?>" readonly>
            <?php } else { ?>
                <input type="text" class="form-control" readonly>
            <?php } ?>
        </div>
    </div>
    <div class="col-sm-4 small">
        <label>Pregnancy Status</label>
        <div class="input-group">
            <input type="text" class="form-control" value="<?php echo $pregnancy_status; ?>" readonly>
        </div>
    </div>
</div>



            </div>
        </div>
    </div>
</div>

<div class="row mt-2">

    <div class="col-lg-12 col-sm-12 mt-1">
      
        <div class="card shadow shadow-sm">
            <div class="card-header">
              <h6 class="m-0 font-weight-bold text-info">Pregnancy Records History</h5>
          </div>

            <div class="card-body">
        <div class="table-responsive text-info">
            <table class="table-sm table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class='thead-light'>
                    <tr style="text-align:center">
                        <!-- <th>ID</th> -->
                        <th>Weight Gain</th>
                        <th>Blood Pressure</th>
                        <th>Fetal Growth</th>
                        <th>Glucose Level</th>
                        <th>Date Created</th>
                    </tr>
                </thead>
                <tfoot class='thead-light'>
                    <tr style="text-align:center">
                        <th>Weight Gain</th>
                        <th>Blood Pressure</th>
                        <th>Fetal Growth</th>
                        <th>Glucose Level</th>
                        <th>Date Created</th>
                    </tr>
                </tfoot>
                <tbody>
<?php 
$user_id = $_SESSION['id'];
$query = "SELECT *
          FROM pregnancy_records
          WHERE patient_id = $user_id
          ORDER BY date_created DESC"; // order by date_created in descending order

$query_run = mysqli_query($conn, $query);
$num_rows = mysqli_num_rows($query_run);
$count = 0;

if ($num_rows > 0) {
    foreach ($query_run as $row) {
        $count++;
        $class = ($count == 1) ? 'table-success' : ''; // highlight the first record in green (i.e., the newest record)
        ?>
        <tr style="text-align:center" class="<?= $class ?>">  
            <td><?= $row['weight_gain']; ?></td>
            <td><?= $row['blood_pressure']; ?></td>
            <td><?= $row['fetal_growth']; ?></td>
            <td><?= $row['glucose_level']; ?></td>
            <td><?php echo date('F d, Y', strtotime($row['date_created'])); ?></td>
        </tr>
        <?php
    }
} else {
    echo "<h5> No Record Found </h5>";
}
?>







                </tbody>

            </table>
        </div>

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