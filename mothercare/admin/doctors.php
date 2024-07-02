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
        <i class="fa fa-user-md fa-1x text-gray-600 mr-1"></i>
        Doctors
    </h1>
    <a href="doctor_report.php" class="btn btn-sm btn-info shadow-sm"><i
            class="fas fa-download fa-sm text-white"></i> Generate Report</a>
</div>

<?php include('message.php'); ?>
<?php include('message_danger.php'); ?>

<!-- DataTables Start-->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="d-sm-flex align-items-center justify-content-between py-2">
        <h6 class="m-0 font-weight-bold text-info">List of Doctor(s)</h6>
        <a href="register.php" class="btn btn-sm btn-info shadow-sm"><i
                class="fa fa-plus fa-sm text-white mr-1"></i>Add Doctor</a>
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
                        <th>Specialization</th>
                        <th>Date Created</th>

                        <th width="12%">Options</th>
                    </tr>
                </thead>
                <tfoot class='thead-light'>
                    <tr style="text-align:center">
                        <!-- <th>ID</th> -->
                        <th>No.</th>
                        <th>Doctor Name</th>
                        <th>Specialization</th>
                        <th>Date Created</th>

                        <th width="12%">Options</th>
                    </tr>
                </tfoot>
                <tbody>
                <?php 
                $no=1;
                $query = "SELECT doctors.id, specialities.speciality_name, doctors.firstname, doctors.lastname, doctors.middlename, doctors.address, doctors.date_created 
                        FROM doctors 
                        LEFT JOIN specialities ON doctors.speciality_id = specialities.id 
                        ORDER BY doctors.id ASC";
                $query_run = mysqli_query($conn, $query);

                if(mysqli_num_rows($query_run) > 0)
                {
                    foreach($query_run as $row)
                    {
                        ?>
                        <tr style="text-align:center">  
                            <!-- <td></td> -->
                            <td><?php echo $no; ?></td>
                            <td >Dr. <?= $row['firstname']; ?> <?= $row['middlename']; ?>. <?= $row['lastname']; ?></td>
                            <td ><?= $row['speciality_name']; ?></td>
                            <td><?= date('M d, Y', strtotime($row['date_created'] . ' UTC+8')) ?></td>



                            <td>
                                        <a class="btn btn-sm btn-outline-primary" href="doctors_view.php?id=<?= $row['id']; ?>" 
                                        data-toggle="tooltip" title="View Dr. <?= $row['lastname']; ?>'s account!" data-placement="top">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                        <!-- View -->
                                        </a>

                                        <a class="btn btn-sm btn-outline-success" href="doctors_edit.php?id=<?= $row['id']; ?>" 
                                        data-toggle="tooltip" title="Edit Dr. <?= $row['lastname']; ?>'s account!" data-placement="top">
                                        <i class="fa fa-edit fw-fa" aria-hidden="true"></i>
                                        <!-- Edit -->
                                        </a>


                                        <form action="code.php" method="POST" class="d-inline">
                                            <button type="submit" name="delete_doctor" value="<?=$row['id'];?>" class="btn btn-sm btn-outline-danger" onclick="msg()" 
                                            data-toggle="tooltip" title="Delete Dr. <?= $row['lastname']; ?>'s account!" data-placement="top">
                                            <i class="fa fa-trash fw-fa" aria-hidden="true"></i>
                                            <!-- Delete -->
                                            </button>
                                            <script>
                                                function msg(){
                                                    var result = confirm ('Are you sure you want to delete this account?');
                                                    if(result==false){
                                                        event.preventDefault();
                                                    }
                                                }
                                            </script>
                                        </form>
                                   
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