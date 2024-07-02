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
        <i class="fa fa-wheelchair fa-1x text-gray-600 mr-1"></i>
        Pregnant Patients
    </h1>
    <a href="patient_report.php" class="btn btn-sm btn-info shadow-sm"><i
            class="fas fa-download fa-sm text-white"></i> Generate Report</a>
</div>

<?php include('message.php'); ?>

<!-- DataTables Start-->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="d-sm-flex align-items-center justify-content-between py-2">
        <h6 class="m-0 font-weight-bold text-info">List of Pregnant Patient(s)</h6>
        <!-- <a href="rowloyee_create.php" class="btn btn-sm btn-info shadow-sm"><i
                class="fa fa-plus fa-sm text-white mr-1"></i>Add rowloyee</a> -->
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
                        <th>Due Date</th>
                        <th>Pregnancy Status</th>
                        <th>Pregnancy Progress</th>
                        <th width="12%">Options</th>
                    </tr>
                </thead>
                <tfoot class='thead-light'>
                    <tr style="text-align:center">
                        <!-- <th>ID</th> -->
                        <th>No.</th>
                        <th>Patient Name</th>
                        <th>Due Date</th>
                        <th>Pregnancy Status</th>
                        <th>Pregnancy Progress</th>
                        <th width="12%">Options</th>
                    </tr>
                </tfoot>
                <tbody>
                <?php 
                $no=1;
                $query = "SELECT u.*, p.due_date, p.pregnancy_status 
                          FROM users u 
                          INNER JOIN pregnancy_informations p ON u.id = p.patient_id 
                          WHERE u.doctor_id = '{$_SESSION['id']}'";
                $query_run = mysqli_query($conn, $query);

                if(mysqli_num_rows($query_run) > 0)
                {
                    foreach($query_run as $row)
                    {
                        ?>
                        <tr style="text-align:center">	
                            <!-- <td></td> -->
                            <td><?php echo $no; ?></td>
                            <td ><?= $row['firstname']; ?> <?= $row['middlename']; ?>. <?= $row['lastname']; ?></td>
                            <td><?php echo date('F d, Y', strtotime($row['due_date'])); ?></td>
                            <td>
                                <?php
                                    $status = $row['pregnancy_status'];
                                    switch ($status) {
                                        case 'Due':
                                            $color_class = 'badge-danger';
                                            break;
                                        case 'Imminent':
                                            $color_class = 'badge-warning';
                                            break;
                                        case 'Third Trimester':
                                            $color_class = 'badge-info';
                                            break;
                                        case 'Second Trimester':
                                            $color_class = 'badge-success';
                                            break;
                                        case 'First Trimester':
                                            $color_class = 'badge-primary';
                                            break;
                                        default:
                                            $color_class = 'badge-secondary';
                                            break;
                                    }
                                ?>
                                <span class="badge <?php echo $color_class; ?>"><?php echo $status; ?></span>
                            </td>
                            <td class="text-center">
                                <?php
                                $due_date = strtotime($row['due_date']);
                                $current_date = strtotime(date('Y-m-d'));
                                $days_remaining = floor(($due_date - $current_date) / (60 * 60 * 24));
                                $percent_complete = 100 - round(($days_remaining / 280) * 100);
                                ?>
                                <div class="progress mt-1">
                                    <div class="progress-bar bg-info" role="progressbar" style="width: <?= $percent_complete ?>%" aria-valuenow="<?= $percent_complete ?>" aria-valuemin="0" aria-valuemax="100"><?= $percent_complete ?>%</div>
                                </div>
                            </td>
                            <td>
                                        <a class="btn btn-sm btn-outline-primary" href="patients_view.php?id=<?= $row['id']; ?>"
                                        data-toggle="tooltip" title='View Patient "<?= $row['firstname']; ?>"!' data-placement="top">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                        <!-- View -->
                                        </a>                                   
                            </td>
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