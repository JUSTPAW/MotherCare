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

    <div class="row justify-content-center"> 

        <div class="col-xl-10 col-lg-12 col-md-9">

        <?php include('message.php'); ?>
        <?php include('message_danger.php'); ?>

            <div class="card o-hidden border-0 shadow-lg">

            <div class="card-header py-3">

                <div class="d-sm-flex align-items-center justify-content-between py-2">
                <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-key fa-1x text-gray-600 mr-1"></i>
       Change Password</h6>
                <a href="profile.php" class="btn btn-sm btn-info shadow-sm"><i
                        class="fa fa-arrow-left fa-sm text-white-100 mr-1"></i>Back</a>
                </div>
            </div>
            <div class="card-body">
                
			<form class="text-info small" method="post" action="cp_code.php">
			  <div class="form-group">
			    <label for="current-password">Current Password:</label>
			    <input type="password" class="form-control" id="current-password" required name="current_password" placeholder="Current Password">
			  </div>
			  <div class="form-group">
			    <label for="new-password">New Password:</label>
			    <input type="password" class="form-control" id="new-password" name="new_password" required placeholder="New Password">
			  </div>
			  <div class="form-group">
			    <label for="confirm-password">Confirm Password:</label>
			    <input type="password" class="form-control" id="confirm-password" name="confirm_password" required placeholder="Confirm Password">
			    			  <span class="text text-gray-800 text-sm">Please note that you will need to log in again after changing your password.</span> 
			  </div>
  
			  <button type="submit" class="btn btn-info">Submit</button>
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
<!-- to not back when logout-->
<script type="text/javascript">
    window.history.forward();
    function noBack() {
        window.history.forward();
    }
</script>