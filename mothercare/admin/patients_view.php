<?php 
session_start();
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

    <div class="row justify-content-center"> 

        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg">

            <div class="card-header py-3">

                <div class="d-sm-flex align-items-center justify-content-between py-2">
                <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-eye fa-1x text-gray-600 mr-1"></i>
        Patient Informations</h6>
                <a href="pregnant_patient.php" class="btn btn-sm btn-info shadow-sm"><i
                        class="fa fa-arrow-left fa-sm text-white-100 mr-1"></i>Back</a>
                </div>
            </div>
            <div class="card-body">
            <?php
                if(isset($_GET['id']))
                {
                    $user_id = mysqli_real_escape_string($conn, $_GET['id']);
                    $query = "SELECT users.*, pregnancy_informations.due_date, pregnancy_informations.pregnancy_status 
                              FROM users 
                              JOIN pregnancy_informations ON users.id = pregnancy_informations.patient_id 
                              WHERE users.id='$user_id'";
                    $query_run = mysqli_query($conn, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        $row = mysqli_fetch_array($query_run);
            ?>
                
                <form class="user text-info" action="code.php" method="POST">
                    <div class="form-group row">
                        <div class="col-sm-4 mb-3 mb-sm-0">
                        <input type="hidden" name="id" value="<?= $row['id']; ?>" class="form-control">
                        </div>
                    </div>
                      <p class="text-gray-600">Personal Informations</p> 
                    <div class="form-group row small">
                        <div class="col-sm-4 mb-3 mb-sm-0">
                            <label>First Name</label>
                            <input type="text" name="firstname" value = "<?=$row['firstname'];?>" required class="form-control" placeholder="First Name" readonly>
                        </div>
                        <div class="col-sm-4">
                            <label>Middle Initial</label>
                            <input type="text" name="middlename" value = "<?=$row['middlename'];?>" required class="form-control" placeholder="Last Name" readonly>
                        </div>
                        <div class="col-sm-4">
                            <label>Last Name</label>
                            <input type="text" name="lastname" value = "<?=$row['lastname'];?>" required class="form-control" placeholder="Middle Initial" readonly>
                        </div>
                    </div>

                    <div class="form-group row small">
                        <div class="col-sm-4">
                        <label>Age</label>
                        <input type="number" name="age" value = "<?=$row['age'];?>" class="form-control" placeholder="Age" readonly>
                        </div>
                        <div class="col-sm-8">
                        <label>Address</label>
                        <input type="text" name="address" value = "<?=$row['address'];?>" class="form-control" placeholder="Address" readonly>
                        </div>
                    </div>
                    <div class="form-group row small">
                        <div class="col-sm-4">
                        <label>Contact Number</label>
                        <input type="number" name="phone" value = "<?=$row['phone'];?>" data-pattern="****-***-****" 
                        placeholder="0000-000-0000" maxlength="13" minlength="13" class="form-control" maxlength="11" readonly>
                        </div>
                        <div class="col-sm-8">
                        <label>Email</label>
                        <input type="email" name="email" value = "<?=$row['email'];?>" class="form-control" placeholder="Email" readonly>
                        </div>
                    </div>
                    <p class="text-gray-600 mb-3">Pregnancy Informations</p>
                    <div class="form-group row small">
                        <div class="col-sm-6">
                            <label>Due Date</label>
                            <?php
                            $due_date = $row['due_date'];
                            $formatted_date = date('F d, Y', strtotime($due_date));
                            ?>
                            <input type="text" name="pregnancy_status" value="<?=$formatted_date;?>" class="form-control" placeholder="Due Date" readonly>
                        </div>
                        <div class="col-sm-6">
                        <label>Pregnancy Status</label>
                        <input type="text" name="pregnancy_status" value = "<?=$row['pregnancy_status'];?>" class="form-control" placeholder="Pregnancy Status" readonly>
                        </div>
                    </div>
                    </form>
            <?php
                    }
                    else
                    {
                        echo "<h4>No Such Id Found</h4>";
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
include('includes/scripts.php');
include('includes/footer.php');
?>