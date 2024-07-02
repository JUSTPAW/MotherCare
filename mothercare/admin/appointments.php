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
    <a href="row_report.php" class="btn btn-sm btn-info shadow-sm"><i
            class="fas fa-download fa-sm text-white"></i> Generate Report</a>
</div>

<?php include('message.php'); ?>

<!-- DataTables Start-->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="d-sm-flex align-items-center justify-content-between py-2">
        <h6 class="m-0 font-weight-bold text-info">Appointments History</h6>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive text-info">
            <table class="table-sm table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class='thead-light'>
                    <tr style="text-align:center">
                        <!-- <th>ID</th> -->
                        <th>No.</th>
                        <th>Doctor Name</th>
                        <th>Patient Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Purpose</th>
                        <th>Message</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tfoot class='thead-light'>
                    <tr style="text-align:center">
                        <!-- <th>ID</th> -->
                        <th>No.</th>
                        <th>Doctor Name</th>
                        <th>Patient Name</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Purpose</th>
                        <th>Message</th>
                        <th>Status</th>
                    </tr>
                </tfoot>
                <tbody>
                    <?php 
                    $no=1;
                    $user_id = $_SESSION['id']; // assuming the user id is stored in the session variable
                    $query = "SELECT appointments.id, doctors.firstname as doc_first, doctors.middlename as doc_middle, doctors.lastname as doc_last, appointments.app_date, appointments.app_time,  appointments.start_time,  appointments.end_time, appointments.purpose, appointments.message, appointments.status, users.firstname as user_first, users.middlename as user_middle, users.lastname as user_last
                    FROM appointments
                    INNER JOIN doctors ON appointments.doctor_id = doctors.id 
                    INNER JOIN users ON appointments.patient_id = users.id
                    WHERE appointments.patient_id = $user_id
                    ORDER BY appointments.app_date ASC, appointments.app_time ASC"; 

                    $query_run = mysqli_query($conn, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        foreach($query_run as $row)
                        {
                            ?>
                        <tr style="text-align:center">  
                            <!-- <td></td> -->
                            <td><?php echo $no; ?></td>
                              <td >Dr. <?= $row['doc_first']; ?> <?= $row['doc_middle']; ?>. <?= $row['doc_last']; ?></td>
                            <td ><?= $row['user_first']; ?> <?= $row['user_middle']; ?>. <?= $row['user_last']; ?></td> 
                            <td ><?= date('M d, Y', strtotime($row['app_date'])) ?></td>
                            <td class="small"><?= date('h:i', strtotime($row['start_time'])) ?>-<?= date('h:i A', strtotime($row['end_time'])) ?></td>
                            <td ><?= $row['purpose']; ?></td>
                            <td ><?= $row['message']; ?></td>
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

                            <!-- Example HTML code -->
                            <td><span class="badge badge-<?= $badgeClass ?>"><?= $row['status'] ?></span></td>
                        </tr>
                        <?php
                        $no++;
                    }
                }
                else
                {
                    echo "<h5> No Record Found </h5>";
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