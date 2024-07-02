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
        <i class="fa fa-stethoscope fa-1x text-gray-600 mr-1"></i>
        Appointments
    </h1>
    <!-- <a href="_report.php" class="btn btn-sm btn-info shadow-sm"><i
            class="fas fa-download fa-sm text-white"></i> Generate Report</a> -->
</div>

<?php include('message.php'); ?>

<!-- DataTables Start-->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="d-sm-flex align-items-center justify-content-between py-2">
        <h6 class="m-0 font-weight-bold text-info">Appointments History</h6>
        <!-- <a href="appointments_create.php" class="btn btn-sm btn-info shadow-sm"><i
                class="fa fa-plus fa-sm text-white mr-1"></i>Make an Appointment</a> -->
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive text-info">
            <table class="table-sm table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class='thead-light'>
                    <tr style="text-align:center">
                        <!-- <th>ID</th> -->
                        <th>No.</th>
                        <th>Patient Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Purpose</th>
                        <th>Status</th>
                        <th width="3%">Options</th>
                    </tr>
                </thead>
                <tfoot class='thead-light'>
                    <tr style="text-align:center">
                        <!-- <th>ID</th> -->
                        <th>No.</th>
                        <th>Patient Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Purpose</th>
                        <th>Status</th>
                        <th width="3%">Options</th>
                    </tr>
                </tfoot>
                <tbody>
               <?php 
$no=1;
$user_id = $_SESSION['id']; // assuming the user id is stored in the session variable
$query = "SELECT u.firstname, u.lastname, u.middlename, u.email, a.id, a.app_date, a.app_time,  a.start_time,  a.end_time, a.purpose, a.message, a.status 
FROM users u
JOIN appointments a ON u.id = a.patient_id
WHERE a.doctor_id = $user_id";
$query_run = mysqli_query($conn, $query);

if(mysqli_num_rows($query_run) > 0)
{
    foreach($query_run as $row)
    {
        ?>
        <tr style="text-align:center">  
            <td><?php echo $no; ?></td>
            <td><?php echo $row['firstname'].' '.$row['middlename'].'. '.$row['lastname']; ?></td>
            <td><?= date('M d, Y', strtotime($row['app_date'])) ?></td>
            <td class="small"><?= date('h:i', strtotime($row['start_time'])) ?>-<?= date('h:i A', strtotime($row['end_time'])) ?></td>
            <td><?php echo $row['purpose']; ?></td>
            <?php
                // Example PHP code
                $status = $row['status'];
                $badgeClass = '';
                if ($status == 'Ongoing') {
                    $badgeClass = 'dark';
                } else if ($status == 'Completed') {
                    $badgeClass = 'success';
                } else if ($status == 'Cancelled') {
                    $badgeClass = 'danger';
                } else if ($status == 'Scheduled') {
                    $badgeClass = 'primary';
                }
            ?>
            <td><span class="badge badge-<?= $badgeClass ?>"><?= $row['status'] ?></span></td>
            <td>
                <a class="btn btn-sm btn-outline-success" href="appointments_edit.php?id=<?= $row['id']; ?>"
                                data-toggle="tooltip" title="Respond to <?= $row['firstname']; ?> <?= $row['lastname']; ?>'s appointment request" data-placement="top">
                    <i class="fas fa-reply"></i>
<!--                 <span class="text text-xs mt-1">Respond</span> -->
                </a>
            </td>
        </tr>
        <?php
        $no++;
    }
}
?>

                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- DataTables End-->

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
<!-- to not back when logout-->
<script type="text/javascript">
    window.history.forward();
    function noBack() {
        window.history.forward();
    }
</script>