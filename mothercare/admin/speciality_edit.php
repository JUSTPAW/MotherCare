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
                <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-edit fw-fa fa-1x text-gray-600 mr-1"></i>
       EDIT SPECIALIZATION</h6>
                <a href="specialities.php" class="btn btn-sm btn-info shadow-sm"><i
                        class="fa fa-arrow-left fa-sm text-white-100 mr-1"></i>Back</a>
                </div>
            </div>
            <div class="card-body">
            <?php
                if(isset($_GET['id']))
                {
                    $Speciality_ID = mysqli_real_escape_string($conn, $_GET['id']);
                    $query = "SELECT * FROM specialities WHERE id='$Speciality_ID' ";
                    $query_run = mysqli_query($conn, $query);

                    if(mysqli_num_rows($query_run) > 0)
                    {
                        $row = mysqli_fetch_array($query_run);
            ?>
                
                <form class="user text-info small" action="code.php" method="POST">
                    <div class="form-group row">
                        <div class="col-sm-4 mb-3 mb-sm-0">
                        <input type="hidden" name="tool_id" value="<?= $row['id']; ?>" class="form-control">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Specialization</label>
                        <input type="text" name="speciality_name" value="<?= $row['speciality_name']; ?>" class="form-control" placeholder="Speciality">
                    </div>
                    <div class="form-group">
                        <label>Description</label>
                        <input type="text" name="description" value="<?= $row['description']; ?>" class="form-control" placeholder="Description">
                    </div>

                    
                    <button type="submit" name="update_speciality" class="btn btn-info btn-user ml-2">Update Specialty</button>
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