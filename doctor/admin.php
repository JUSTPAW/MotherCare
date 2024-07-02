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
            <i class="fa fa-tachometer-alt fa-1x text-gray-600 mr-1"></i>
            Dashboard
        </h1>
        <a href="charts.php" class="btn btn-sm btn-info shadow-sm"><i
                class="fas fa-chart-pie fa-sm text-white mr-1"></i>Charts</a>
    </div>

    <!-- Content Row -->
    <div class="row">
<!-- Total of Earnings-->
    <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-info border-bottom-info shadow h-100 py-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                          <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Pregnant Patients</div>
                            <div class="h6 mb-4 font-weight-bold">

<span class="h4 font-weight-bold text-gray-900">
<?php
                                
$query = "SELECT * FROM users WHERE doctor_id = '{$_SESSION['id']}' ORDER BY id";
$query_run = mysqli_query($conn, $query);

$row = mysqli_num_rows($query_run);

echo $row ;

?>
</span>
                            
                            </div>

                        </div>

                        <div class="col">
                          <img src="images/patient.png" class="img-fluid img-responsive rounded float-right mx-auto d-block w-50 h-70 image-animated" alt="...">
                                                     
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-auto">
                            <a href="patients.php" class="btn btn-info btn-icon-split btn-sm">
                                <span class="icon text-white-50">
                                    <i class="fas fa-arrow-right"></i>
                                </span>
                                <span class="text text-xs mt-1">View Details</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!--  Total of employees -->
    <div class="col-xl-6 col-md-6 mb-4">
            <div class="card border-left-info border-bottom-info shadow h-100 py-0">
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                          <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Appointments</div>
                            <div class="h6 mb-4 font-weight-bold">

<span class="h4 font-weight-bold text-gray-900">
<?php
                                
$query = "SELECT COUNT(*) as appointment_count
        FROM appointments
        WHERE doctor_id = '{$_SESSION['id']}'";
$query_run = mysqli_query($conn, $query);

$row = mysqli_num_rows($query_run);

echo $row ;

?>
</span>
                            
                            </div>

                        </div>

                        <div class="col">
                          <img src="images/appointment.png" class="img-fluid img-responsive rounded float-right mx-auto d-block w-50 h-70 image-animated" alt="...">
                                                     
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-auto">
                            <a href="appointments.php" class="btn btn-info btn-icon-split btn-sm">
                                <span class="icon text-white-50">
                                    <i class="fas fa-arrow-right"></i>
                                </span>
                                <span class="text text-xs mt-1">View Details</span>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

       

<style>
@keyframes press {
  0% { transform: translate(0, 0) scale(1); }
  25% { transform: translate(-4px, 0) scale(0.70); }
  50% { transform: translate(4px, 0) scale(1.05); }
  75% { transform: translate(-2px, 0) scale(0.97); }
  100% { transform: translate(0, 0) scale(1); }
}

.image-animated {
  animation: press 0.4s;
  animation-iteration-count: 1;
}
</style>    

        
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