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
<!--         <a href="" class="btn btn-sm btn-info shadow-sm"><i
                class="fas fa-chart-pie fa-sm text-white mr-1"></i>Charts</a> -->
    </div>

    <!-- Content Row -->
    <div class="row">
<!-- Total of Earnings-->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info border-bottom-info shadow h-100 py-0">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        Weight Gain</div>
                    <div class="h6 mb-4 font-weight-bold">
                        <span class="h6 font-weight-bold text-gray-900">
                                                <?php
                        // Retrieve the patient ID from the session variable
                        $patient_id = $_SESSION['id'];

                        // Build the SQL query to retrieve the newest weight gain value
                        $sql = "SELECT weight_gain FROM pregnancy_records WHERE patient_id = '$patient_id' ORDER BY date_created DESC LIMIT 1";

                        // Execute the query and fetch the result
                        $result = mysqli_query($conn, $sql);
                        
                        if(mysqli_num_rows($result) > 0){
                            $newest_weight_gain = mysqli_fetch_assoc($result)['weight_gain'];
                        }else{
                            $newest_weight_gain = 0;
                        }

                        // Determine weight gain status based on guidelines
                        if ($newest_weight_gain < 25) {
                            $status = "Normal";
                            $badge_class = "badge-success";
                        } elseif ($newest_weight_gain >= 25 && $newest_weight_gain < 35) {
                            $status = "Not Normal";
                            $badge_class = "badge-warning";
                        } else {
                            $status = "Above Normal";
                            $badge_class = "badge-danger";
                        }

                        // Display the newest weight gain value and corresponding status badge to the user
                        echo $newest_weight_gain . '<span class="small font-weight-bold text-gray-700"> pounds</span>';
                        echo '</div>';
                        echo '<span class="badge badge-pill mt-1 ' . $badge_class . '">' . $status . '</span>';
                    ?>

                        </span>
                </div>
                <div class="col">
                    <img src="images/weight.png" class="card-img-top img-fluid mx-auto d-block image-animated" alt="...">
                </div>
            </div>
        </div>
    </div>
</div>


    <!--  Total of employees -->
<!--  Total of employees -->
<div class="col-xl-3 col-md-6 mb-4">
  <div class="card border-left-info border-bottom-info shadow h-100 py-0">
    <div class="card-body">
      <div class="row no-gutters align-items-center">
        <div class="col mr-2">
          <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
            Blood Pressure
          </div>
          <div class="h6 mb-4 font-weight-bold">
            <span class="h6 font-weight-bold text-gray-900">
              <?php
                // Retrieve the patient ID from the session variable
                $patient_id = $_SESSION['id'];

                // Build the SQL query to retrieve the newest blood pressure value
                $sql = "SELECT blood_pressure FROM pregnancy_records WHERE patient_id = '$patient_id' ORDER BY date_created DESC LIMIT 1";

                // Execute the query and fetch the result
                $result = mysqli_query($conn, $sql);

                // Check if a result was returned
                if (mysqli_num_rows($result) == 1) {
                  // A blood pressure value was found, so retrieve it and determine the status
                  $newest_blood_pressure = mysqli_fetch_assoc($result)['blood_pressure'];
                  list($systolic, $diastolic) = explode('/', $newest_blood_pressure);
                  if ($systolic < 120 && $diastolic < 80) {
                    $status = "Normal";
                    $badge_class = "badge-success";
                  } elseif (($systolic >= 120 && $systolic < 130) && ($diastolic < 80)) {
                    $status = "Above Normal";
                    $badge_class = "badge-warning";
                  } elseif (($systolic >= 130 && $systolic < 140) || ($diastolic >= 80 && $diastolic < 90)) {
                    $status = "Not Normal";
                    $badge_class = "badge-danger";
                  } elseif (($systolic >= 140) || ($diastolic >= 90)) {
                    $status = "Not Normal";
                    $badge_class = "badge-danger";
                  } else {
                    $status = "Invalid Input";
                    $badge_class = "badge-secondary";
                  }
                } else {
                  // No blood pressure value was found, so set the newest_blood_pressure variable to 0
                  $newest_blood_pressure = 0;
                  $status = "No Record Found";
                  $badge_class = "badge-secondary";
                }

                // Display the newest blood pressure value and corresponding status badge to the user
                echo $newest_blood_pressure;

              ?>
            </span>
            <span class="small font-weight-bold text-gray-700">mmHg</span>
                     </div> 
            <span class="badge badge-pill mt-1 <?php echo $badge_class; ?>"><?php echo $status; ?></span>
        </div>
        <div class="col">
          <img src="images/blood.png" class="card-img-top img-fluid mx-auto d-block image-animated" alt="...">
        </div>
      </div>
    </div>
  </div>
</div>



        <!--  Total of employees -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info border-bottom-info shadow h-100 py-0">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Fetal growth</div>
                    <div class="h6 mb-4 font-weight-bold text-gray-900">
                    <?php
                        $patient_id = $_SESSION['id'];
                        $fetal_growth_query = "SELECT pr.fetal_growth, pi.due_date FROM pregnancy_records pr INNER JOIN pregnancy_informations pi ON pr.patient_id = pi.patient_id WHERE pr.patient_id = '$patient_id' ORDER BY pr.date_created DESC LIMIT 1";
                        $fetal_growth_result = mysqli_query($conn, $fetal_growth_query);
                        $fetal_growth_row = mysqli_fetch_assoc($fetal_growth_result);
                        $newest_fetal_growth = isset($fetal_growth_row['fetal_growth']) ? $fetal_growth_row['fetal_growth'] : 0;
                        $due_date = isset($fetal_growth_row['due_date']) ? $fetal_growth_row['due_date'] : '';
                        $gestational_age = !empty($due_date) ? round((strtotime(date('Y-m-d')) - strtotime($due_date)) / (60 * 60 * 24 * 7)) : 0;
                        $expected_min = !empty($gestational_age) ? round((6 + ($gestational_age * 0.5)) * 2.54) : 0;
                        $expected_max = !empty($gestational_age) ? round((34 + ($gestational_age * 0.6)) * 2.54) : 0;

                        if ($newest_fetal_growth >= $expected_min && $newest_fetal_growth <= $expected_max) {
                            echo $newest_fetal_growth . '<span class="small font-weight-bold text-gray-700"> inches</span>';
                            echo '</div>';
                        } else if ($newest_fetal_growth < $expected_min) {
                            echo $newest_fetal_growth . '<span class="small font-weight-bold text-gray-700"> inches</span>';
                            echo '</div>';
                        } else {
                            echo $newest_fetal_growth . '<span class="small font-weight-bold text-gray-700"> inches</span>';
                            echo '</div>';
                        }
                    ?>

                    <?php
                        if ($newest_fetal_growth >= $expected_min && $newest_fetal_growth <= $expected_max) {
                            echo '<span class="badge badge-success badge-pill mt-1">Normal</span>';
                        } else if ($newest_fetal_growth < $expected_min) {
                            echo '<span class="badge badge-warning badge-pill mt-1">Below normal</span>';
                        } else {
                            echo '<span class="badge badge-warning badge-pill mt-1">Above normal</span>';
                        }
                    ?>
                </div>
                <div class="col">
                    <img src="images/growth.png" class="card-img-top img-fluid mx-auto d-block image-animated" alt="...">
                </div>
            </div>
        </div>
    </div>
</div>



                <!--  Total of employees -->
<div class="col-xl-3 col-md-6 mb-4">
    <div class="card border-left-info border-bottom-info shadow h-100 py-0">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                        Glucose Level
                    </div>
                    <?php
                        // Retrieve the patient ID from the session variable
                        $patient_id = $_SESSION['id'];

                        // Build the SQL query to retrieve the most recent glucose level value
                        $glucose_query = "SELECT glucose_level FROM pregnancy_records WHERE patient_id = ? ORDER BY date_created DESC LIMIT 1";

                        // Use prepared statement to prevent SQL injection attacks
                        $stmt = mysqli_prepare($conn, $glucose_query);
                        mysqli_stmt_bind_param($stmt, "i", $patient_id);
                        mysqli_stmt_execute($stmt);
                        $glucose_result = mysqli_stmt_get_result($stmt);

                        // Fetch the result or set glucose level to 0 if no result
                        if(mysqli_num_rows($glucose_result) > 0) {
                            $glucose_row = mysqli_fetch_assoc($glucose_result);
                            $newest_glucose_level = $glucose_row['glucose_level'];
                        } else {
                            $newest_glucose_level = 0;
                        }
                    ?>
                    <div class="h6 mb-4 font-weight-bold">
                        <span class="h6 font-weight-bold text-gray-900">
                            <?php echo $newest_glucose_level; ?>
                        </span>
                        <span class="small font-weight-bold text-gray-700">
                            mg/dL
                        </span>
                    </div>
                    <?php
                        // Check glucose level and display appropriate badge
                        if ($newest_glucose_level >= 70 && $newest_glucose_level <= 130) {
                            echo '<span class="badge badge-success badge-pill mt-1">Normal</span>';
                        } else if ($newest_glucose_level < 70) {
                            echo '<span class="badge badge-warning badge-pill mt-1">Below Normal</span>';
                        } else {
                            echo '<span class="badge badge-warning badge-pill mt-1">Above Normal</span>';
                        }
                    ?>
                </div>
                <div class="col">
                    <img src="images/glucose.png" class="card-img-top img-fluid mx-auto d-block image-animated" alt="...">
                </div>
            </div>
        </div>
    </div>
</div>





        
    </div>


<?php
    // Check if the logged-in user has pregnancy information in the database
    $user_id = $_SESSION['id']; // or use any other method to get the user's ID
    $query = "SELECT due_date, baby_name, pregnancy_status FROM pregnancy_informations WHERE patient_id = $user_id";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    if ($row && $row['due_date']) {
        // Calculate the remaining days until the due date
        $due_date = strtotime($row['due_date']);
        $now = strtotime(date('Y-m-d'));
        $remaining_days = round(($due_date - $now) / (60 * 60 * 24));
                
        // Calculate the progress percentage based on the remaining days
        $progress_percent = 100 - round(($remaining_days / 280) * 100);
        
        // Get the baby name and pregnancy status from the row
        $baby_name = $row['baby_name'];
        $pregnancy_status = $row['pregnancy_status'];

        // Update the pregnancy status based on the remaining days
        if ($remaining_days <= 0) {
            $pregnancy_status = 'Due';
        } elseif ($remaining_days <= 14) {
            $pregnancy_status = 'Imminent';
        } elseif ($remaining_days <= 30) {
            $pregnancy_status = 'Third Trimester';
        } elseif ($remaining_days <= 90) {
            $pregnancy_status = 'Second Trimester';
        } else {
            $pregnancy_status = 'First Trimester';
        }

        // Update the database with the new pregnancy status
        $update_query = "UPDATE pregnancy_informations SET pregnancy_status = '$pregnancy_status' WHERE patient_id = $user_id";
        mysqli_query($conn, $update_query);

        // Display the progress bar and countdown
        echo '<div class="row">
                <div class="col-12">
                    <div class="card-body card shadow-sm">
                        <div class="mb-1 small text-gray-900">Pregnancy Progress</div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-animated progress-bar-animated bg-info" role="progressbar" style="width: ' . $progress_percent . '%" aria-valuenow="' . $progress_percent . '" aria-valuemin="0" aria-valuemax="100">';
        echo $progress_percent . '%';
        echo '</div>
                        </div>
                        <div class="countdown mt-3" data-due-date="' . date('Y-m-d', $due_date) . '">
                            <p class="countdown-text text-gray-800"></p>
                        </div>
                    </div>
                </div>
            </div>';
    }
?>



<?php
$user_id = $_SESSION['id']; // or use any other method to get the user's ID

// Retrieve the baby's name from the database
$query = "SELECT baby_name FROM pregnancy_informations WHERE patient_id = $user_id";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $baby_name = $row['baby_name'];
} else {
    $baby_name = "Unknown";
}
?>

<script>
  const countdownEl = document.querySelector('.countdown-text');
  const countdownDate = new Date(countdownEl.parentElement.dataset.dueDate);

  function updateCountdown() {
    const now = new Date().getTime();
    const distance = countdownDate.getTime() - now;
    
    const days = Math.floor(distance / (1000 * 60 * 60 * 24));
    const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    const seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    const countdownText = `Countdown to Baby <strong> ${"<?php echo $baby_name ?>"} </strong>: ${days}d ${hours}h ${minutes}m ${seconds}s. Get ready for the journey ahead!`;
    countdownEl.innerHTML = countdownText;
  }

  updateCountdown();
  setInterval(updateCountdown, 1000);
</script>

<style>
@keyframes progress-bar-animation {
  0% { width: 0%; }
}

.progress-animated {
  animation: progress-bar-animation 1s linear forwards;
}
</style>


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