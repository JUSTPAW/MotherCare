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

    <div class="row justify-content-center"> 

        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg">

            <div class="card-header py-3">

                <div class="d-sm-flex align-items-center justify-content-between py-2">
                <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-edit fw-fa fa-1x text-gray-600 mr-1"></i>
       Create Doctor Account</h6>
                <a href="doctors.php" class="btn btn-sm btn-info shadow-sm"><i
                        class="fa fa-arrow-left fa-sm text-white-100 mr-1"></i>Back</a>
                </div>
            </div>
            <div class="card-body">

<form class="small text-info" action="signup.php" method="post">

                                <?php if (isset($_GET['error'])) { ?>
                                    <p class="error"><?php echo $_GET['error']; ?></p>
                                <?php } ?>

                                <?php if (isset($_GET['success'])) { ?>
                                    <p class="success"><?php echo $_GET['success']; ?></p>
                                <?php } ?>

<span class="text text-gray-700 font-weight-bold text-xs">Personal Details</span>

                                <div class="form-group row">                                
                                <?php if (isset($_GET['firstname'])) { ?>
                                    <div class="col-sm-4">
                                        <label>First Name</label>
                                            <input type="text" name="firstname" class="form-control form-control-user" id="firstname"
                                                placeholder="First Name" value="<?php echo $_GET['firstname']; ?>">
                                    </div>
                                <?php }else{ ?>
                                    <div class="col-sm-4">
                                        <label>First Name</label>
                                            <input type="text" name="firstname" class="form-control form-control-user" id="firstname"
                                                placeholder="First name">
                                    </div>
                                <?php }?>

                                <?php if (isset($_GET['middlename'])) { ?>
                                    <div class="col-sm-4">
                                        <label>Middle Initial</label>
                                            <input type="text" name="middlename" class="form-control form-control-user" id="middlename"
                                                placeholder="Middle Initial" value="<?php echo $_GET['middlename']; ?>">
                                    </div>
                                <?php }else{ ?>
                                    <div class="col-sm-4">
                                        <label>Middle Initial</label>
                                            <input type="text" name="middlename" class="form-control form-control-user" id="middlename"
                                                placeholder="Middle Initial">
                                    </div>
                                <?php }?>

                                <?php if (isset($_GET['lastname'])) { ?>
                                    <div class="col-sm-4">
                                        <label>Last Name</label>
                                            <input type="text" name="lastname" class="form-control form-control-user" id="lastname"
                                                placeholder="Last Name" value="<?php echo $_GET['lastname']; ?>">
                                    </div>
                                <?php }else{ ?>
                                    <div class="col-sm-4">
                                        <label>Last Name</label>
                                            <input type="text" name="lastname" class="form-control form-control-user" id="lastname"
                                                placeholder="Last Name">
                                    </div>
                                <?php }?>
                                </div>

                                <div class="form-group row">                                
                                <?php if (isset($_GET['age'])) { ?>
                                    <div class="col-sm-2">
                                        <label>Age</label>
                                            <input type="number" name="age" class="form-control form-control-user" id="age"
                                                placeholder="Age" value="<?php echo $_GET['age']; ?>">
                                    </div>
                                <?php }else{ ?>
                                    <div class="col-sm-2">
                                        <label>Age</label>
                                            <input type="number" name="age" class="form-control form-control-user" id="age"
                                                placeholder="Age">
                                    </div>
                                <?php }?>

                                <?php if (isset($_GET['gender'])) { ?>
                                    <div class="col-sm-4">
                                        <label>Gender</label>
                                        <select name="gender" class="form-control form-control-user" id="gender">
                                            <option value="">Select a gender</option>
                                            <option value="male" <?php echo isset($_GET['gender']) && $_GET['gender'] == 'male' ? 'selected' : ''; ?>>Male</option>
                                            <option value="female" <?php echo isset($_GET['gender']) && $_GET['gender'] == 'female' ? 'selected' : ''; ?>>Female</option>
                                        </select>
                                    </div>

                                <?php }else{ ?>
                                    <div class="col-sm-4">
                                        <label>Gender</label>
                                        <select name="gender" class="form-control form-control-user" id="gender">
                                            <option value="">Select a gender</option>
                                            <option value="male">Male</option>
                                            <option value="female">Female</option>
                                        </select>
                                    </div>
                                <?php }?>

                                <?php if (isset($_GET['address'])) { ?>
                                    <div class="col-sm-6">
                                        <label>Address</label>
                                            <input type="text" name="address" class="form-control form-control-user" id="address"
                                                placeholder="Address" value="<?php echo $_GET['address']; ?>">
                                    </div>
                                <?php }else{ ?>
                                    <div class="col-sm-6">
                                        <label>Address</label>
                                            <input type="text" name="address" class="form-control form-control-user" id="address"
                                                placeholder="Address">
                                    </div>
                                <?php }?>
                                </div>



                                <div class="form-group row">                                
                                <?php if (isset($_GET['phone'])) { ?>
                                    <div class="col-sm-3">
                                        <label>Phone</label>
                                        <input type="tel" name="phone" class="form-control form-control-user" id="phone"
                                            placeholder="Phone" value="<?php echo $_GET['phone']; ?>"
                                            maxlength="11" pattern="[0-9]{11}"
                                            title="Phone">
                                    </div>
                                <?php }else{ ?>
                                    <div class="col-sm-3">
                                        <label>Phone</label>
                                        <input type="tel" name="phone" class="form-control form-control-user" id="phone"
                                            placeholder="Phone"
                                            maxlength="11" pattern="[0-9]{11}"
                                            title="Phone">
                                    </div>
                                <?php }?>

                                <?php if (isset($_GET['email'])) { ?>
                                    <div class="col-sm-5   ">
                                        <label>Email</label>
                                            <input type="text" name="email" class="form-control form-control-user" id="email"
                                                placeholder="Email" value="<?php echo $_GET['email']; ?>">
                                    </div>
                                <?php }else{ ?>
                                    <div class="col-sm-5  ">
                                        <label>Email</label>
                                            <input type="text" name="email" class="form-control form-control-user" id="email"
                                                placeholder="Email">
                                    </div>
                                <?php }?>

                                <?php if (isset($_GET['speciality_id'])) { ?>
                                    <?php
                                    // Assuming $conn is the database connection object
                                    $sql = "SELECT id, speciality_name FROM specialities";
                                    $result = mysqli_query($conn, $sql);
                                    ?>

                                    <div class="col-sm-4">
                                        <label>Specialization</label>
                                        <select name="speciality_id" class="form-control form-control-user" id="speciality_id" placeholder="Speciality">
                                            <option value="">Select Specialization</option>
                                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                                <option value="<?php echo $row['id']; ?>" <?php if (isset($_GET['speciality_id']) && $_GET['speciality_id'] == $row['id']) echo 'selected'; ?>>
                                                    <?php echo $row['speciality_name']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                <?php }else{ ?>
<?php
                                    // Assuming $conn is the database connection object
                                    $sql = "SELECT id, speciality_name FROM specialities";
                                    $result = mysqli_query($conn, $sql);
                                    ?>

                                    <div class="col-sm-4">
                                        <label>Specialization</label>
                                        <select name="speciality_id" class="form-control form-control-user" id="speciality_id" placeholder="Speciality">
                                            <option value="">Select Specialization</option>
                                            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                                <option value="<?php echo $row['id']; ?>" <?php if (isset($_GET['speciality_id']) && $_GET['speciality_id'] == $row['id']) echo 'selected'; ?>>
                                                    <?php echo $row['speciality_name']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                <?php }?>
                                </div>

<span class="text text-gray-700 font-weight-bold text-xs">Account Details</span>
                                <?php if (isset($_GET['uname'])) { ?>
                                    <div class="form-group">
                                        <label>Username</label>
                                            <input type="text" name="uname" class="form-control form-control-user" id="uname"
                                                placeholder="Username" value="<?php echo $_GET['uname']; ?>">
                                    </div>

                                <?php }else{ ?>
                                    <div class="form-group">
                                        <label>Username</label>
                                            <input type="text" name="uname" class="form-control form-control-user" id="uname"
                                                placeholder="Username">
                                    </div>
                                <?php }?>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <label>Password</label>
                                        <input type="password" name="password"class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Password">
                                    </div>
                                
                                    <div class="col-sm-6">
                                        <label>Repeat Password</label>
                                        <input type="password" name="re_password"class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Repeat Password">
                                    </div>
                                </div>

                                <button type="submit" name="save_doctor" class="btn btn-info btn-user ml-2">Save Doctor Account</button>
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