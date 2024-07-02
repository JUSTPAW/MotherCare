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

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4 ml-3">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fa fa-tachometer-alt fa-1x text-gray-600 mr-1"></i>
            Dashboard
        </h1>
<!--         <a href="" class="btn btn-sm btn-info shadow-sm"><i
                class="fas fa-chart-pie fa-sm text-white mr-1"></i>Charts</a> -->
    </div>

    <!-- Content Row -->
    <div class="row">
<!-- Total of Earnings-->
    <div class="col-12">



    <h1 class="text-center my-4">Baby Kick Counter</h1>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="input-kick-count">Kick count:</label>
                        <input type="number" id="input-kick-count" class="form-control">
                    </div>
                    <button type="button" id="btn-add-kick" class="btn btn-primary">Add Kick</button>
                    <button type="button" id="btn-reset" class="btn btn-danger">Reset</button>
                    <hr>
                    <h5>Kick Count History:</h5>
                    <ul id="kick-count-history"></ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    var kickCount = 0;

    // Add kick button click event
    $('#btn-add-kick').click(function() {
        kickCount++;
        $('#input-kick-count').val(kickCount);
        
        // Add current date and time to kick count history list item
        var now = new Date();
        var formattedDateTime = now.toLocaleString();
        $('#kick-count-history').append('<li>' + kickCount + ' kicks - ' + formattedDateTime + '</li>');
    });

    // Reset button click event
    $('#btn-reset').click(function() {
        kickCount = 0;
        $('#input-kick-count').val(kickCount);
        $('#kick-count-history').empty();
    });
});

</script>
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