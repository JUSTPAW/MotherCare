<?php
session_start();
require_once 'db_conn.php';
include 'includes/header.php';
include 'includes/navbar.php';

// prevent going back when logged out
echo '<script type="text/javascript">
        window.history.forward();
        function noBack() {
            window.history.forward();
        }
    </script>';

// fetch doctor info based on id
if (isset($_GET['id'])) {
    $doc_id = mysqli_real_escape_string($conn, $_GET['id']);
    $query = "SELECT doctors.id, specialities.speciality_name, doctors.firstname, doctors.lastname, doctors.middlename, doctors.age, doctors.gender, doctors.phone, doctors.email, doctors.user_name, doctors.address, doctors.date_created, doctors.speciality_id
                        FROM doctors 
                        LEFT JOIN specialities ON doctors.speciality_id = specialities.id 
                        WHERE doctors.id='$doc_id' 
                        ORDER BY doctors.id ASC";
    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        $row = mysqli_fetch_assoc($query_run);
?>

<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg">
                <div class="card-header py-3">
                    <div class="d-sm-flex align-items-center justify-content-between py-2">
                        <h6 class="m-0 font-weight-bold text-info">
                            <i class="fa fa-eye fa-1x text-gray-600 mr-1"></i> DOCTOR INFORMATIONS
                        </h6>
                        <a href="doctors.php" class="btn btn-sm btn-info shadow-sm">
                            <i class="fa fa-arrow-left fa-sm text-white-100 mr-1"></i> Back
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <form class="text-info small" action="code.php" method="POST">
                        <span class="text text-gray-700 font-weight-bold text-xs">Personal Details</span>
                        <div class="form-group row">                                
                            <div class="col-sm-4">
                                <label>First Name</label>
                                <input type="text" name="firstname" class="form-control form-control-user" id="firstname" value="<?=$row['firstname'];?>" readonly>
                            </div>
                            <div class="col-sm-4">
                                <label>Middle Initial</label>
                                <input type="text" name="middlename" class="form-control form-control-user" id="middlename" value="<?=$row['middlename'];?>" readonly>
                            </div>
                            <div class="col-sm-4">
                                <label>Last Name</label>
                                <input type="text" name="lastname" class="form-control form-control-user" id="lastname" value="<?=$row['lastname'];?>" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-2">
                                <label for="age">Age</label>
                                <input type="number" name="age" class="form-control form-control-user" id="age" placeholder="Age" value="<?=$row['age'];?>" readonly>
                            </div>
                            <div class="col-sm-4">
                                <label for="gender">Gender</label>
                                <input type="text" name="gender" class="form-control form-control-user" id="gender" placeholder="Gender" value="<?=$row['gender'];?>" readonly>
                            </div>
                            <div class="col-sm-6">
                                <label for="address">Address</label>
                                <input type="text" name="address" class="form-control form-control-user" id="address" placeholder="Address" value="<?=$row['address'];?>" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-3">
                                <label for="phone">Phone</label>
                                <input type="tel" name="phone" class="form-control form-control-user" id="phone" placeholder="Phone" value="<?=$row['phone'];?>" readonly>
                            </div>
                            <div class="col-sm-5">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control form-control-user" id="email" placeholder="Email" value="<?=$row['email'];?>" readonly>
                            </div>
                          <div class="col-sm-4">
                            <label for="speciality_id">Specialization</label>
                            <?php
                            function getSpecialityName($conn, $id) {
                                $query = "SELECT speciality_name FROM specialities WHERE id = '$id'";
                                $result = mysqli_query($conn, $query);
                                if ($result && mysqli_num_rows($result) > 0) {
                                    $row = mysqli_fetch_assoc($result);
                                    return $row['speciality_name'];
                                } else {
                                    return 'Unknown';
                                }
                            }

                            $speciality_id = $row['speciality_id'];
                            $speciality_name = getSpecialityName($conn, $speciality_id);
                            ?>
                            <input type="text" name="speciality_name" class="form-control form-control-user" id="speciality_name" placeholder="Specialization" value="<?=$speciality_name;?>" readonly>
                        </div>


                        </div>
                        <span class="text text-gray-700 font-weight-bold text-xs">Account Details</span>
                        <div class="form-group">
                            <label for="uname">Username</label>
                            <input type="text" name="uname" class="form-control form-control-user" id="uname" placeholder="Username" value="<?=$row['user_name'];?>" readonly>
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