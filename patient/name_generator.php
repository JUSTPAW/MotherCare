<?php
session_start();
require 'db_conn.php';

if (isset($_POST['gender'], $_POST['length'], $_POST['name_type'])) {
    $gender = $_POST['gender'];
    $length = $_POST['length'];
    $name_type = $_POST['name_type'];

    if ($name_type == 'single') {
        $sql = "SELECT names FROM names WHERE gender='$gender' AND LENGTH(names)=$length ORDER BY RAND() LIMIT 1";
    } else {
        $sql = "SELECT CONCAT(t1.names, ' ', t2.names) AS names
                FROM names t1
                JOIN names t2 ON t1.gender = '$gender' AND t2.gender = '$gender'
                WHERE LENGTH(t1.names) + LENGTH(t2.names) = $length
                ORDER BY RAND() LIMIT 1";
    }

    $result = $conn->query($sql);
    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['names'];
        $message = "<div class='d-flex justify-content-between align-items-center'>
                        <div>Your baby's name could be: <strong class='font-weight-bold'>$name</strong></div>";

        $name_generated = true;
        if ($name_generated) {
            $message .= "<div class='ml-auto'>
                            <form method='post'>
                                <input type='hidden' name='name' value='$name'>
                                <button type='submit' name='set_as_baby_name' class='btn btn-success btn-sm'>
                                <i class='fas fa-check-circle mr-1'></i> Set as your baby's name
                                </button>
                            </form>
                        </div>";
        }
        $message .= "</div>";
    } else {
        $message = "No names found.";
    }
}

if (isset($_POST['set_as_baby_name'], $_POST['name'], $_SESSION['id'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $patient_id = $_SESSION['id'];

    $sql = "SELECT id FROM pregnancy_informations WHERE patient_id=$patient_id";
    $result = $conn->query($sql);
    if (!$result) {
        die("Query failed: " . $conn->error);
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $pregnancy_id = $row['id'];
        $sql = "UPDATE pregnancy_informations SET baby_name='$name' WHERE id=$pregnancy_id";
        if (!$conn->query($sql)) {
            die("Query failed: " . $conn->error);
        }
    } else {
        $sql = "INSERT INTO pregnancy_informations (patient_id, baby_name) VALUES ($patient_id, '$name')";
        if (!$conn->query($sql)) {
            die("Query failed: " . $conn->error);
        }
    }
    $message = "Baby's name has been set successfully!";
}

if (isset($_SESSION['id'], $_SESSION['user_name'])) {
    include 'includes/header.php';
    include 'includes/navbar.php';
?>

<script type="text/javascript">
    // Prevent going back to the previous page after logout
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
        <i class="fa fa-search fa-1x text-gray-600 mr-1"></i>
        Baby Name Generator
    </h1>
<!--         <a href="" class="btn btn-sm btn-info shadow-sm"><i
            class="fas fa-chart-pie fa-sm text-white mr-1"></i>Charts</a> -->
</div>

<div class="card shadow">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-info">Baby Name Generator</h5>
        </div>
  <div class="card-body">
       <!-- Display form and results -->
    <?php if (isset($message)) { ?>
        <div class="alert alert-info"><?php echo $message; ?></div>
    <?php } ?>


<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
<div class="form-group text-info small">
  <label for="gender">Gender:</label>
  <select class="form-control" name="gender" id="gender" onchange="updateLengthOptions()">
    <option class="small" value="" selected disabled>Select Gender</option>
    <option value="girl">Girl</option>
    <option value="boy">Boy</option>
  </select>
</div>
<div class="form-group text-info small">
  <label for="name_type">Name Type:</label>
  <select class="form-control" name="name_type" id="name_type" onchange="updateLengthOptions()">
    <option class="small" value="" selected disabled>Select Name Type</option>
    <option value="single">Single Name</option>
    <option value="combined">Combined Name</option>
  </select>
</div>
<div class="form-group text-info small">
  <label for="length">Length:</label>
  <select class="form-control" required name="length" id="length">
    <!-- Options will be dynamically added by the JavaScript function -->
  </select>
</div>
<script>
function updateLengthOptions() {
  var genderSelect = document.getElementById("gender");
  var nameTypeSelect = document.getElementById("name_type");
  var lengthSelect = document.getElementById("length");
  
  // Clear existing options
  lengthSelect.innerHTML = "";
  
  // Determine the range of options to add based on selected values
  var minLength = 2;
  var maxLength = 11;
  if (genderSelect.value == "girl" && nameTypeSelect.value == "combined") {
    minLength = 4;
    maxLength = 22;
  } else if (genderSelect.value == "boy" && nameTypeSelect.value == "single") {
    maxLength = 10;
  } else if (genderSelect.value == "boy" && nameTypeSelect.value == "combined") {
    minLength = 4;
    maxLength = 22;
  }
  
  // Add options to select element
  for (var i = minLength; i <= maxLength; i++) {
    var option = document.createElement("option");
    option.value = i;
    option.text = i;
    lengthSelect.appendChild(option);
  }
}
</script>


    <button type="submit" class="btn btn-info">Generate</button>  
</form>
</div>
</div>
</div>
</div>
<!-- /.container-fluid -->

<?php 
    include('includes/scripts.php');
    include('includes/footer.php');
    } else {
    header("Location: login.php");
    exit();
 }
 ?>