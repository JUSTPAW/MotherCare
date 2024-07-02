<?php 
include('includes/header.php');
?>


<body>
  
<style type="text/css">
        body{
            background-image: url('images/slides-03.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            min-height: 100vh;
            width: 100%;
            background: linear-gradient(to top, rgba(0, 0, 0, 0.5)50%, rgba(0, 0, 0, 0.5)), url(images/slides-03.jpg);
            background-position: top;
            background-size: cover;
            position: relative;
    }
    </style>

    <div class="container">
        
        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-8 col-lg-12 col-md-12">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                            <a href="login.php" type="button" class="btn btn-md btn-outline-default mt-2 mr-2" style="float: right;">
                            <i class="fa fa-times" aria-hidden="true"></i>
                            </a>
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h2 text-gray-900">Start your Pregnancy Journey with us.</h1>
                                        <h1 class="small text-gray-900 mb-4">Please Create an Account.</h1>
                                    </div> 

                            <form class="user mt-2" action="signup.php" method="post">

                                <?php if (isset($_GET['error'])) { ?>
                                    <p class="error"><?php echo $_GET['error']; ?></p>
                                <?php } ?>

                                <?php if (isset($_GET['success'])) { ?>
                                    <p class="success"><?php echo $_GET['success']; ?></p>
                                <?php } ?>

<span class="text text-info text-xs mt-1">Personal Details</span>

                                <div class="form-group row">                                
                                <?php if (isset($_GET['firstname'])) { ?>
                                    <div class="col-sm-4 mt-3">
                                            <input type="text" name="firstname" class="form-control form-control-user" id="firstname"
                                                placeholder="First Name" value="<?php echo $_GET['firstname']; ?>">
                                    </div>
                                <?php }else{ ?>
                                    <div class="col-sm-4 mt-3">
                                            <input type="text" name="firstname" class="form-control form-control-user" id="firstname"
                                                placeholder="First name">
                                    </div>
                                <?php }?>

                                <?php if (isset($_GET['middlename'])) { ?>
                                    <div class="col-sm-4 mt-3">
                                            <input type="text" name="middlename" class="form-control form-control-user" id="middlename"
                                                placeholder="Middle Initial" value="<?php echo $_GET['middlename']; ?>">
                                    </div>
                                <?php }else{ ?>
                                    <div class="col-sm-4 mt-3">
                                            <input type="text" name="middlename" class="form-control form-control-user" id="middlename"
                                                placeholder="Middle Initial">
                                    </div>
                                <?php }?>

                                <?php if (isset($_GET['lastname'])) { ?>
                                    <div class="col-sm-4 mt-3">
                                            <input type="text" name="lastname" class="form-control form-control-user" id="lastname"
                                                placeholder="Last Name" value="<?php echo $_GET['lastname']; ?>">
                                    </div>
                                <?php }else{ ?>
                                    <div class="col-sm-4 mt-3">
                                            <input type="text" name="lastname" class="form-control form-control-user" id="lastname"
                                                placeholder="Last Name">
                                    </div>
                                <?php }?>
                                </div>

                                <?php if (isset($_GET['age'])) { ?>
                                    <div class="col-sm-4 mt-3">
                                            <input type="hidden" name="age" class="form-control form-control-user" id="age"
                                                placeholder="Age" value="<?php echo $_GET['age']; ?>">
                                    </div>
                                <?php }else{ ?>
                                    <div class="col-sm-4 mt-3">
                                            <input type="hidden" name="age" class="form-control form-control-user" id="age"
                                                placeholder="Age">
                                    </div>
                                <?php }?>
                                                       
                                <?php if (isset($_GET['address'])) { ?>
                                    <div class="col-sm-4 mt-3">
                                            <input type="hidden" name="address" class="form-control form-control-user" id="address"
                                                placeholder="Address" value="<?php echo $_GET['address']; ?>">
                                    </div>
                                <?php }else{ ?>
                                    <div class="col-sm-4 mt-3">
                                            <input type="hidden" name="address" class="form-control form-control-user" id="address"
                                                placeholder="Address">
                                    </div>
                                <?php }?>

                                <?php if (isset($_GET['phone'])) { ?>
                                    <div class="col-sm-4 mt-3">
                                            <input type="hidden" name="phone" class="form-control form-control-user" id="phone"
                                                placeholder="Phone" value="<?php echo $_GET['phone']; ?>">
                                    </div>
                                <?php }else{ ?>
                                    <div class="col-sm-4 mt-3">
                                            <input type="hidden" name="phone" class="form-control form-control-user" id="phone"
                                                placeholder="Phone">
                                    </div>

                                <?php if (isset($_GET['email'])) { ?>
                                    <div class="col-sm-4 mt-3">
                                            <input type="hidden" name="email" class="form-control form-control-user" id="email"
                                                placeholder="Email" value="<?php echo $_GET['email']; ?>">
                                    </div>
                                <?php }else{ ?>
                                    <div class="col-sm-4 mt-3">
                                            <input type="hidden" name="email" class="form-control form-control-user" id="email"
                                                placeholder="email">
                                    </div>
                                <?php }?>

                                <?php }?>

<span class="text text-info text-xs mt-1">Account Details</span>
                                <?php if (isset($_GET['uname'])) { ?>
                                    <div class="form-group mt-3">
                                            <input type="text" name="uname" class="form-control form-control-user" id="uname"
                                                placeholder="Username" value="<?php echo $_GET['uname']; ?>">
                                    </div>

                                <?php }else{ ?>
                                    <div class="form-group  mt-3">
                                            <input type="text" name="uname" class="form-control form-control-user" id="uname"
                                                placeholder="Username">
                                    </div>
                                <?php }?>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input type="password" name="password"class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Password">
                                    </div>
                                
                                    <div class="col-sm-6">
                                        <input type="password" name="re_password"class="form-control form-control-user"
                                            id="exampleInputPassword" placeholder="Repeat Password">
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-info btn-user btn-block">Sign Up Now</button>
                               
                                
                                <!-- <a href="admin.php" class="btn btn-google btn-user btn-block">
                                    <i class="fab fa-google fa-fw"></i> Register with Google
                                </a>
                                <a href="admin.php" class="btn btn-facebook btn-user btn-block">
                                    <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                                </a> -->
                            </form>
                            <hr>
                            <!-- <div class="text-center">
                                <a class="small" href="forgot-password.php">Forgot Password?</a>
                            </div> -->
                            <div class="text-center">
                                <span class="small text-gray-900">Already have an account? 
                                        <a class=" text-info" href="login.php">Login</a></span>
                            </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

<?php 
include('includes/scripts.php');
?>