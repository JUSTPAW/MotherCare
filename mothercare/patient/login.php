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

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block">
                            <img src="images/pregnancy.png" class="img-fluid img-responsive w-75 h-75 mt-5 ml-5" style="width:100%; height:100%" alt="...">
                            </div>
                            <div class="col-lg-6">
                            <a href="../account.php" type="button" class="btn btn-md btn-outline-default mt-2 mr-2" style="float: right;">
                            <i class="fa fa-times" aria-hidden="true"></i>
                            </a>
                                <div class="p-5">
                                    <div class="text-center">    
                                        <h1 class="h2 text-gray-900">Hello! Welcome back.</h1>
                                        <h1 class="small text-gray-900 mb-4">Please Login to your Account.</h1>
                                    </div>
                                    <?php include('message.php'); ?>
                                    <form class="user" action="log.php" method="post">
                                        <?php if (isset($_GET['error'])) { ?>

                                            <p class="error"><?php echo $_GET['error']; ?></p>

                                        <?php } ?>
                                        <?php if (isset($_GET['success'])) { ?>
                                            <p class="success"><?php echo $_GET['success']; ?></p>
                                        <?php } ?>

                                        <div class="form-group">
                                            <input type="text" name="uname" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Username">
                                        </div>
                                        
                                        <div class="form-group">
                                            <input type="password" name="password"class="form-control form-control-user"
                                                id="exampleInputPassword"  placeholder="Password">
                                        </div>
                                        <button type="submit" class="btn btn-info btn-user btn-block mt-2">Login</button>

                                    
                                    <hr>
                                    <!-- <a href="admin.php" class="btn btn-google btn-user btn-block">
                                        <i class="fab fa-google fa-fw"></i> Register with Google
                                    </a>
                                    <a href="admin.php" class="btn btn-facebook btn-user btn-block">
                                        <i class="fab fa-facebook-f fa-fw"></i> Register with Facebook
                                     </a>
                                    </form>
                                    <hr> -->    
                                    <!-- <div class="text-center">
                                        <a class="small" href="forgot-password.php">Forgot Password?</a>
                                    </div> -->
                                    <div class="text-center">
                                        <span class="small text-gray-900">Don't have an account? 
                                        <a class=" text-info" href="register.php">Signup</a></span>
                                        <br>
                                        <a class="small text-info text-center" href="forgot_password.php">Forgot Password?</a></span>
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