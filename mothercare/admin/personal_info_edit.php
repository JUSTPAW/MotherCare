<?php 
session_start();
 if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
include('includes/header.php');
include('includes/navbar.php');
require 'db_conn.php';
?>

<!-- // prevent going back when logged out -->
<script type="text/javascript">
    window.history.forward();
    function noBack() {
        window.history.forward();
    }
</script>

<?php 
// fetch doctor info based on id
if(isset($_GET['id'])) {
    $u_id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "SELECT * FROM admins WHERE id='$u_id'";
    $query_run = mysqli_query($conn, $sql);

    if(mysqli_num_rows($query_run) > 0) {
        while($row = mysqli_fetch_array($query_run)) {   
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-12">
            <div class="card o-hidden border-0 shadow-lg">
                <div class="card-header py-3">
                    <div class="d-sm-flex align-items-center justify-content-between py-2">
                        <h6 class="m-0 font-weight-bold text-info">
                            <i class="fa fa-edit fa-1x text-gray-600 mr-1"></i> Edit Personal Informations
                        </h6>
                        <a href="profile.php" class="btn btn-sm btn-info shadow-sm">
                            <i class="fa fa-arrow-left fa-sm text-white-100 mr-1"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form class="text-info small" action="code.php" method="POST">
                        <div class="form-group row">
                            <div class="col-sm-4">
                                <input type="hidden" name="id" value="<?= $row['id']; ?>" class="form-control">
                            </div>
                        </div>
                        <span class="text text-gray-700 font-weight-bold text-xs">Personal Details</span>

                        <div class="form-group row">                                
                            <div class="col-sm-4">
                                <label>First Name</label>
                                <input type="text" name="firstname" class="form-control form-control-user" id="firstname" value="<?=$row['firstname'];?>"   >
                            </div>
                            <div class="col-sm-4">
                                <label>Middle Initial</label>
                                <input type="text" name="middlename" class="form-control form-control-user" id="middlename" value="<?=$row['middlename'];?>"   >
                            </div>
                            <div class="col-sm-4">
                                <label>Last Name</label>
                                <input type="text" name="lastname" class="form-control form-control-user" id="lastname" value="<?=$row['lastname'];?>"   >
                            </div>
                        </div>

<div class="form-group row">
    <div class="col-sm-2">
        <label for="age">Age</label>
        <input type="number" name="age" class="form-control form-control-user" id="age" placeholder="Age" value="<?=$row['age'];?>">
    </div>

    <div class="col-sm-4">
        <label for="gender">Gender</label>
        <select name="gender" id="gender" class="form-control form-control-user" required>
            <option value="">Select a gender</option>
            <option value="Male" <?= ($row['gender'] == 'Male') ? 'selected' : ''; ?>>Male</option>
            <option value="Female" <?= ($row['gender'] == 'Female') ? 'selected' : ''; ?>>Female</option>
            <?php if (!empty($row['gender'])): ?>
            <option value="<?= $row['gender'] ?>" selected><?= $row['gender'] ?></option>
            <?php endif; ?>
        </select>
    </div>

    <div class="col-sm-6">
        <label for="address">Address</label>
        <input type="text" name="address" class="form-control form-control-user" id="address" placeholder="Address" value="<?=$row['address'];?>"   >
    </div>
</div>


                        <div class="form-group row">
                            <div class="col-sm-4">
                                <label for="phone">Phone</label>
                                <input type="tel" name="phone" class="form-control form-control-user" id="phone" placeholder="Phone" value="<?=$row['phone'];?>"   >
                            </div>
                            <div class="col-sm-8">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control form-control-user" id="email" placeholder="Email" value="<?=$row['email'];?>"   >
                            </div>
                        </div>
                        <hr>
                        <span class="text text-gray-700 font-weight-bold text-xs">Account Details</span>
                        <div class="form-group">
                            <label for="uname">Username</label>
                            <input type="text" name="user_name" class="form-control form-control-user" id="uname" placeholder="Username" value="<?=$row['user_name'];?>">
                            <span class="text text-gray-800 text-sm mt-1">Please note that you will need to log in again after changing your username.</span>
                        </div>


                        <button type="submit" name="user_update" class="btn btn-info btn-user">Update Information</button>
                    </form>
            <?php
                           }
    } else {
        echo "No results found.";
    }
}
            ?>
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