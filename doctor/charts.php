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
                    <i class="fa fa-chart-pie fa-1x text-gray-600 mr-1"></i>
                    Charts
                </h1>
                    <a href="admin.php" class="btn btn-sm btn-info shadow-sm" value="print" onclick="PrintDiv();">
                    <i class="fas fa-tachometer-alt fa-sm text-white-60 mr-1"></i>
                    Dashboard
                </a>
                </div>
                <form action="" method="GET" >
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="text-info">From Date</label>
                                                <input type="date" name="from_date" required value="<?php if(isset($_GET['from_date'])){ echo $_GET['from_date']; } ?>" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label class="text-info">To Date</label>
                                                <input type="date" name="to_date" required value="<?php if(isset($_GET['to_date'])){ echo $_GET['to_date']; } ?>" class="form-control">
                                            </div>
                                        </div>
                                       
                                        <div class="col-md-2">
                                            <div class="form-group">
                                                <label class="text-info">Click to Filter</label> <br>
                                            <button type="submit" class="btn btn-info btn-md px-5"><i class="fas fa-filter fa-sm text-white-60 mr-2"></i>Filter</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
              

                    <!-- Top 10 Highest Purpose of Making Appointments -->
                    <div class="row mb-4">
                        <!-- Tools Charts Start-->
                        <div class="col-sm-6">
                        <?php
                            include('db_conn.php');

                            if(isset($_GET['from_date']) && isset($_GET['to_date']))
                            {
                                $from_date = $_GET['from_date'];
                                $to_date = $_GET['to_date'];
                              
                                $sql =  "SELECT purpose, COUNT(*) AS num_appointments
                                        FROM appointments
                                        WHERE date_created BETWEEN '$from_date' AND '$to_date'
                                        GROUP BY purpose
                                        ORDER BY num_appointments DESC
                                        LIMIT 5;
                                        ";
                                $result = mysqli_query($conn,$sql);
                                $charts="";
                                while ($row = mysqli_fetch_array($result)) { 
                                    $high_purpose[]  = $row['purpose']  ;
                                    $high_num_appointments[] = $row['num_appointments'];
                                }
                            }
                            else {

                                $to_date = date('Y-m-d'); // Today's date
                                $from_date = date('Y-m-d', strtotime('-1 month', strtotime($to_date))); // One month before today

                                $sql =  "SELECT purpose, COUNT(*) AS num_appointments
                                        FROM appointments
                                        WHERE date_created BETWEEN '$from_date' AND '$to_date'
                                        GROUP BY purpose
                                        ORDER BY num_appointments DESC
                                        LIMIT 5;
                                        ";
                                $result = mysqli_query($conn,$sql);
                                $charts="";
                                while ($row = mysqli_fetch_array($result)) { 
                                    $high_purpose[]  = $row['purpose']  ;
                                    $high_num_appointments[] = $row['num_appointments'];
                            }
                            }
                        ?>

                        <div class="card border-left-info border-bottom-info shadow h-300 py-0" style="height: 21rem;">
                            <div class="card-header text-info">
                                Most Common Appointment Purposes
                            </div>
                            <div class="card-body">
                                <div class="chart-wrapper" style="position: relative; height: 100%;">
                                    <div class="chart-container" style="position: relative; height: 100%; width: 100%;">
                                        <canvas id="high_purpose"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="appointments.php" class="btn btn-info btn-icon-split btn-sm" style="float: right;">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-arrow-right"></i>
                                    </span>
                                    <span class="text text-xs mt-1">View Details</span>
                                </a>
                            </div>
                        </div>

                        <script type="text/javascript">
                            var ctx = document.getElementById("high_purpose").getContext('2d');
                            var myChart = new Chart (ctx, {
                                type: 'horizontalBar',
                                data: {
                                    labels: <?php echo json_encode($high_purpose); ?>,
                                    datasets: [{
                                        label: 'Number of Appointments',
                                       backgroundColor: [
                                        "#fcd1d8", // light pink
                                        "#d1e1fc", // baby blue
                                        "#cefcd7", // mint green
                                        "#fcebda", // peach
                                        "#6be9d6"  // light teal green
                                        ],
                                    data: <?php echo json_encode($high_num_appointments); ?>,
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        xAxes: [{
                                            ticks: {
                                                beginAtZero: true,
                                                fontSize: 14
                                            }
                                        }],
                                        yAxes: [{
                                            ticks: {
                                                fontSize: 10
                                            }
                                        }]
                                    },
                                    legend: {
                                        display: false
                                    },
                                    plugins: {
                                        datalabels: {
                                            anchor: 'end',
                                            align: 'end'
                                        }
                                    }
                                }
                            });
                        </script>


                        </div>
                        <!-- Top 10 Highest Purpose of Making Appointments -->
                        
                        <!-- Top 10 Lowest Purpose of Making Appointments -->
                        <div class="col-sm-6">
                        <?php
                            include('db_conn.php');

                            if(isset($_GET['from_date']) && isset($_GET['to_date']))
                            {
                                $from_date = $_GET['from_date'];
                                $to_date = $_GET['to_date'];
                              
                                $sql =  "SELECT purpose, COUNT(*) AS num_appointments
                                        FROM appointments
                                        WHERE date_created BETWEEN '$from_date' AND '$to_date'
                                        GROUP BY purpose
                                        ORDER BY num_appointments ASC
                                        LIMIT 5;
                                        ;
                                        ";
                                $result = mysqli_query($conn,$sql);
                                $charts="";
                                while ($row = mysqli_fetch_array($result)) { 
                                    $low_purpose[]  = $row['purpose']  ;
                                    $low_num_appointments[] = $row['num_appointments'];
                                }
                            }
                            else {

                                $to_date = date('Y-m-d'); // Today's date
                                $from_date = date('Y-m-d', strtotime('-1 month', strtotime($to_date))); // One month before today

                                $sql =  "SELECT purpose, COUNT(*) AS num_appointments
                                        FROM appointments
                                        WHERE date_created BETWEEN '$from_date' AND '$to_date'
                                        GROUP BY purpose
                                        ORDER BY num_appointments ASC
                                        LIMIT 5;
                                        ";
                                $result = mysqli_query($conn,$sql);
                                $charts="";
                                while ($row = mysqli_fetch_array($result)) { 
                                    $low_purpose[]  = $row['purpose']  ;
                                    $low_num_appointments[] = $row['num_appointments'];
                            }
                            }
                        ?>
                        
                        <div class="card border-left-info border-bottom-info shadow h-200 py-0" style="height: 21rem;">
                            <div class="card-header text-info">
                                Appointment Purposes with Least Demand
                            </div>
                            <div class="card-body">
                                <div class="chart-container" style="position: relative; height: 100%; width: 100%;">
                                    <canvas id="low_purpose" style="height: 100%; width: 100%;"></canvas> 
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="appointments.php" class="btn btn-info btn-icon-split btn-sm" style="float: right;">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-arrow-right"></i>
                                    </span>
                                    <span class="text text-xs mt-1">View Details</span>
                                </a>
                            </div>
                        </div>

                        <script type="text/javascript">
                            var ctx = document.getElementById("low_purpose").getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'pie',
                                data: {
                                    labels: <?php echo json_encode($low_purpose); ?>,
                                    datasets: [{
                                    backgroundColor: [
                                        "#fcd1d8", // light pink
                                        "#d1e1fc", // baby blue
                                        "#cefcd7", // mint green
                                        "#fcebda", // peach
                                        "#6be9d6"  // light teal green
                                    ],
                                        data: <?php echo json_encode($low_num_appointments); ?>,
                                    }]
                                },
                                options: {
                                    legend: {
                                        display: true,
                                        position: 'right', // set the legend position to right
                                        labels: {
                                            fontColor: '#71748d',
                                            fontFamily: 'Circular Std Book',
                                            fontSize: 14,
                                        }
                                    },
                                    cutoutPercentage: 50, // controls the size of the hole in the middle of the pie chart
                                    maintainAspectRatio: false // set to false to make the chart fit within the container
                                }
                            });
                        </script>

                        </div>
                         <!-- Top 10 Lowest Purpose of Making Appointments -->
                   
                    </div>   
                     <!-- End Row -->




                    <!-- "Patient User Growth Over Time" -->
                    <div class="row mb-4">
                        <!-- Tools Charts Start-->
                        <div class="col-sm-6">
                        <?php
                            include('db_conn.php');

                            if(isset($_GET['from_date']) && isset($_GET['to_date']))
                            {
                                $from_date = $_GET['from_date'];
                                $to_date = $_GET['to_date'];
                              
                                $sql =  "SELECT DATE_FORMAT(date_created, '%Y-%m-%d') AS day, COUNT(*) AS num_users
                                        FROM users
                                        WHERE date_created BETWEEN '$from_date' AND '$to_date'
                                        GROUP BY day
                                        ORDER BY day ASC;
                                        ";
                                $result = mysqli_query($conn,$sql);
                                $charts="";
                                while ($row = mysqli_fetch_array($result)) { 
                                    $day[] = date('M d', strtotime($row['day']));
                                    $num_users[] = $row['num_users'];
                                }
                            }
                            else {

                                $to_date = date('Y-m-d'); // Today's date
                                $from_date = date('Y-m-d', strtotime('-1 month', strtotime($to_date))); // One month before today

                                $sql =  "SELECT DATE_FORMAT(date_created, '%Y-%m-%d') AS day, COUNT(*) AS num_users
                                        FROM users
                                        WHERE date_created BETWEEN '$from_date' AND '$to_date'
                                        GROUP BY date_created
                                        ORDER BY day ASC;

                                        ";
                                $result = mysqli_query($conn,$sql);
                                $charts="";
                                while ($row = mysqli_fetch_array($result)) { 
                                    $day[] = date('M d', strtotime($row['day']));
                                    $num_users[] = $row['num_users'];
                            }
                            }
                        ?>

                        <div class="card border-left-info border-bottom-info shadow h-300 py-0" style="height: 21rem;">
                            <div class="card-header text-info">
                                Patient User Growth Over Time
                            </div>
                            <div class="card-body">
                                <div class="chart-wrapper" style="position: relative; height: 100%;">
                                    <div class="chart-container" style="position: relative; height: 100%; width: 100%;">
                                        <canvas id="users_per_day"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="patients.php" class="btn btn-info btn-icon-split btn-sm" style="float: right;">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-arrow-right"></i>
                                    </span>
                                    <span class="text text-xs mt-1">View Details</span>
                                </a>
                            </div>
                        </div>

                        <script type="text/javascript">
                            var ctx = document.getElementById("users_per_day").getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'line',
                                data: {
                                    labels:<?php echo json_encode($day); ?>,
                                    datasets: [{
                                        label: 'Number of Appointments',
                                        backgroundColor: "#6be9d6",
                                        borderColor: "#6be9d6",
                                        fill: false,
                                        data:<?php echo json_encode($num_users); ?>,
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    scales: {
                                        xAxes: [{
                                            ticks: {
                                                beginAtZero: true,
                                                fontSize: 14
                                            }
                                        }],
                                        yAxes: [{
                                            ticks: {
                                                fontSize: 10
                                            }
                                        }]
                                    },
                                    legend: {
                                        display: false,
                                    },
                                    plugins: {
                                        datalabels: {
                                            anchor: 'end',
                                            align: 'end'
                                        }
                                    }
                                }
                            });
                        </script>

                        </div>
                        <!-- Patient User Growth Over Time -->
                        
                        <!-- Number of Users with Pregnancy Due Dates per Month -->
                        <div class="col-sm-6">
                        <?php
                            include('db_conn.php');

                            if(isset($_GET['from_date']) && isset($_GET['to_date']))
                            {
                                $from_date = $_GET['from_date'];
                                $to_date = $_GET['to_date'];              
                              
                                $sql = "SELECT COUNT(DISTINCT u.id) AS num_users, DATE_FORMAT(p.due_date, '%Y-%m') AS month
                                FROM pregnancy_informations p
                                INNER JOIN users u ON p.patient_id = u.id
                                WHERE p.due_date BETWEEN '$from_date' AND '$to_date'
                                GROUP BY month
                                ORDER BY month ASC
                                LIMIT 5
                                ";

                                $result = mysqli_query($conn,$sql);
                                $charts="";
                                while ($row = mysqli_fetch_array($result)) { 
                                    $due_per_month[]  = date('M', strtotime($row['month']));
                                    $due_num_users[] = $row['num_users'];
                                }
                            }
                            else {

                               $to_date = date('Y-m-d', strtotime('+1 year')); // One year from today's date
                               $from_date = date('Y-m-d', strtotime('-1 year', strtotime($to_date))); // One year before today's date


                                $sql =  "SELECT COUNT(*) AS num_users, MONTH(p.due_date) AS month
                                        FROM pregnancy_informations p
                                        INNER JOIN users u ON p.patient_id = u.id
                                        GROUP BY MONTH(p.due_date)
                                        ORDER BY month ASC
                                        LIMIT 5;
                                        ";
                                $result = mysqli_query($conn,$sql);
                                $charts="";
                                while ($row = mysqli_fetch_array($result)) { 
                                    $due_per_month[]  = date('M', strtotime($row['month']));
                                    $due_num_users[] = $row['num_users'];
                            }
                            }
                        ?>
                        
                        <div class="card border-left-info border-bottom-info shadow h-200 py-0" style="height: 21rem;">
                            <div class="card-header text-info">
                                Number of Users with Pregnancy Due Dates per Month
                            </div>
                            <div class="card-body">
                                <div class="chart-container" style="position: relative; height: 100%; width: 100%;">
                                    <canvas id="due_date_per_month" style="height: 100%; width: 100%;"></canvas> 
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="patients.php" class="btn btn-info btn-icon-split btn-sm" style="float: right;">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-arrow-right"></i>
                                    </span>
                                    <span class="text text-xs mt-1">View Details</span>
                                </a>
                            </div>
                        </div>

                        <script type="text/javascript">
                            var ctx = document.getElementById("due_date_per_month").getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'bar',
                                data: {
                                    labels: <?php echo json_encode($due_per_month); ?>,
                                    datasets: [{
                                        backgroundColor: [
                                        "#fcd1d8", // light pink
                                        "#d1e1fc", // baby blue
                                        "#cefcd7", // mint green
                                        "#fcebda", // peach
                                        "#6be9d6"  // light teal green
                                    ],
                                        data: <?php echo json_encode($due_num_users); ?>,
                                    }]
                                },
                                options: {
                                    legend: {
                                        display: false, // remove the legend
                                    },
                                    maintainAspectRatio: false, // set to false to make the chart fit within the container
                                    scales: {
                                        yAxes: [{
                                            ticks: {
                                                beginAtZero: true // start the y-axis at 0
                                            }
                                        }],
                                        xAxes: [{
                                            ticks: {
                                                fontColor: '#71748d',
                                                fontFamily: 'Circular Std Book',
                                                fontSize: 14,
                                            }
                                        }]
                                    }
                                }
                            });
                        </script>


                        </div>
                         <!-- Number of Users with Pregnancy Due Dates per Month -->
                   
                    </div>   
                     <!-- End Row -->



            
                </span>

               
                           
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