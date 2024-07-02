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


    <!-- Content Row -->
    <div class="row justify-content-center"> 
<!-- Total of Earnings-->
    <div class="col-lg-8 col-sm-12 mt-1">
         <div class="card shadow shadow-sm">
              <div class="card-header">
                <h6 class="m-0 font-weight-bold text-info">Personal Informations</h6>
              </div>
              <div class="card-body">
                <?php

                // Get user_name from session
                $user_name = $_SESSION['user_name'];

                // SQL SELECT statement
                $sql = "SELECT * FROM doctors WHERE user_name = '$user_name'";

                // Execute SQL query
                $result = mysqli_query($conn, $sql);

                // Check if query returned any result
                if (mysqli_num_rows($result) === 1) {
                    // Access the row using mysqli_fetch_assoc() function
                    $row = mysqli_fetch_assoc($result);
                    
                    // Access values using column names
                ?>
        <div class="card shadow shadow-sm text-center mb-3">
            <div class="card-body py-0 px-0 bg-info">
                    <p class="h6 text-white mt-2 ml-1">     
          <!--   <i class="fa fa-user-circle fa-1x"></i> -->
            <?= $row['firstname'] . ' ' . $row['middlename'] . '. ' . $row['lastname']; ?>
                    </p>

            </div>
        </div>


                <form class="text-info">

                    <div class="form-group row">
                        <div class="col-sm-6 small">
                            <label>Age</label>
                            <p class="form-control">
                                <?=$row['age'];?>
                            </p>
                        </div>
                        <div class="col-sm-6 small">
                            <label>Gender</label>
                            <p class="form-control">
                                <?=$row['gender'];?>
                            </p>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-6 small">
                            <label>Address</label>
                            <p class="form-control">
                                <?=$row['address'];?>
                            </p>
                        </div>
                        <div class="col-sm-6 small">
                            <label>Contact Number</label>
                            <p class="form-control">
                                <?=$row['phone'];?>
                            </p>
                        </div>
                    </div>                  
                    <div class="form-group small">
                        <label>Email</label>
                        <p class="form-control">
                            <?=$row['email'];?>
                        </p>
                    </div> 
                </form>                          

                <div class="text-left">
                  <a class="btn btn-sm btn-outline-info mt-2 ml-auto" href="personal_info_edit.php?id=<?= $row['id']; ?>" 
                    data-toggle="tooltip" title='Edit Personal Informations' data-placement="top">
                    <i class="fa fa-edit fw-fa" aria-hidden="true"></i>
                    Edit
                  </a>
                  <form action="code.php" method="POST" class="d-inline">
                    <button type="submit" name="delete_account" value="<?=$row['id'];?>" class="btn btn-sm btn-outline-danger mt-2" onclick="msg()" 
                    data-toggle="tooltip" title='Delete your account' data-placement="top">
                    <i class="fa fa-trash fw-fa" aria-hidden="true"></i>
                    Delete this account
                    </button>
                    <script>
                        function msg(){
                            var result = confirm ('Are you sure you want to delete your account?');
                            if(result==false){
                                event.preventDefault();
                            }
                        }
                    </script>
                </form>
                </div>
              </div>

              <?php
                            } else {
                    // No user found with the given user_name
                    echo "User not found";
                }
                ?>
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