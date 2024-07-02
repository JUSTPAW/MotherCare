<?php 
session_start();
if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
    include('includes/header.php');
    include('includes/navbar.php');
    require 'db_conn.php';

    function updateDueDate($conn, $user_id, $due_date) {
        $sql = "SELECT * FROM pregnancy_informations WHERE patient_id=$user_id";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            // Update the due_date column in the pregnancy_informations table
            $sql = "UPDATE pregnancy_informations SET due_date='$due_date' WHERE patient_id=$user_id";
            mysqli_query($conn, $sql);
        } else {
            // Insert a new row into the pregnancy_informations table
            $sql = "INSERT INTO pregnancy_informations (patient_id, due_date) VALUES ($user_id, '$due_date')";
            mysqli_query($conn, $sql);
        }
    }

    $due_date_calculated = false;

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["option"]) && isset($_POST["date"])) {
        $option = $_POST["option"];
        $date = $_POST["date"];
        $due_date = "";

        if ($option == "last_period") {
            // Calculate due date based on first day of last period
            $due_date = date("Y-m-d", strtotime("+280 days", strtotime($date)));
        } elseif ($option == "due_date") {
            // Calculate first day of last period based on estimated due date
            $last_period = date("Y-m-d", strtotime("-280 days", strtotime($date)));
            $due_date = date("Y-m-d", strtotime("+280 days", strtotime($last_period)));
        } elseif ($option == "conception_date") {
            // Calculate due date based on date of conception
            $due_date = date("Y-m-d", strtotime("+266 days", strtotime($date)));
        }

        $formatted_due_date = date('M d, Y', strtotime($due_date . ' UTC+8'));
        $message = "Your due date is on: <strong class='font-weight-bold'>" . $formatted_due_date . "</strong>";

        // Set the $due_date_calculated variable to true
        $due_date_calculated = true;
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["due_date"])) {
        // Update the due_date column in the pregnancy_informations table
        $user_id = $_SESSION['id'];
        $due_date = $_POST["due_date"];
        updateDueDate($conn, $user_id, $due_date);
        $message = "Due date been successfully set to <strong class='font-weight-bold'>" . date('M d, Y', strtotime($due_date . ' UTC+8')) . "</strong>";
    }
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
                <i class="fa fa-calendar fa-1x text-gray-600 mr-1"></i>
                Due-Date Calculator
            </h1>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold text-info">Due Date Calculator</h5>
                    </div>
                    <div class="card-body">
                        <!-- Display form and results -->
                        <?php if (isset($message)) { ?>
                            <div class="alert alert-info d-flex align-items-center justify-content-between">
                                <span><?php echo $message; ?></span>
                                <?php if ($due_date_calculated) { ?>
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                                        <input type="hidden" name="due_date" value="<?php echo $due_date; ?>">
                                        <button type='submit' class="btn btn-success btn-sm">
                                            <i class='fas fa-check-circle mr-1'></i> Set as your Due Date
                                        </button>
                                    </form>
                                <?php } ?>
                            </div>
                        <?php } ?>

    <span class="m-0 font-weight-bold small text-gray-600">Select how you want to estimate your due date. You can change it at any time!</span>

        <form class="text-info small" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="option">Choose an option:</label>
                <select class="form-control" name="option" id="option">
                    <option class="small" value="" selected disabled>Select option</option>
                    <option value="last_period">First day of last period</option>
                    <option value="due_date">Estimated due date</option>
                    <option value="conception_date">Date of conception</option>
                </select>
            </div>
            <div class="form-group">
                <label for="date">Enter the date:</label>
                <input type="date" class="form-control" required name="date" id="date">
            </div>
            <button type="submit" class="btn btn-info">Calculate</button>
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