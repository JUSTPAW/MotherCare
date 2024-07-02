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
                                        <h1 class="h4 text-gray-900 mb-2">Forgot Your Password?</h1>
                                        <p class="mb-4">We get it, stuff happens. Just enter your email address below
                                            and we'll send you a link to reset your password!</p>
                                    </div>
                                    <form class="user">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user"
                                                id="exampleInputEmail" aria-describedby="emailHelp"
                                                placeholder="Enter Email Address...">
                                        </div>
                                        <a href="login.php" class="btn btn-info btn-user btn-block">
                                            Reset Password
                                        </a>
                                    </form>
                            <hr>
                            <!-- <div class="text-center">
                                <a class="small" href="forgot-password.php">Forgot Password?</a>
                            </div> -->
                            <div class="text-center">
                                <span class="small text-gray-900">Don't have an account? 
                                        <a class=" text-info" href="register.php">Signup</a></span>
                                        <br>
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