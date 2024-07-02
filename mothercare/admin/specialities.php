<?php 
session_start();
include('includes/header.php');
include('includes/navbar.php');
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
        <i class="fa fa-hospital fa-1x text-gray-600 mr-1"></i>
        Doctor Specialization
    </h1>
</div>

    <div class="row justify-content-center"> 

        <div class="col-xl-12 col-lg-12 col-md-9">
       
        <?php include('message.php'); ?>
        <?php include('message_danger.php'); ?>
    
                <form class="text-info small" action="code.php" method="POST">

                  <div class="form-row align-items-center">
                    <div class="col-5">
                        <div class="form-group">
                        <input type="text" name="speciality_name" required class="form-control form-control-user" id="speciality_name"
                            placeholder="Specialty">
                        </div>
                    </div>
                    <div class="col-5">
                        <div class="form-group">
                        <input type="text" name="description" required class="form-control form-control-user" id="description"
                            placeholder="Description">
                        </div>
                    </div>
                    <div class="col-auto">
                      <div class="mb-3">
                         <button type="submit" name="save_speciality" class="btn btn-info btn-user float-center ml-2">Add Specialization</button>
                    </div>

                </form>
        </div>
    </div>


<!-- DataTables Start-->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <div class="d-sm-flex align-items-center justify-content-between py-2">
        <h6 class="m-0 font-weight-bold text-info">List of Doctor Specialization</h6>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive text-info">
            <table class="table-sm table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                <thead class='thead-light'>
                    <tr style="text-align:center">
                        <!-- <th>ID</th> -->
                        <th>No.</th>
                        <th>Specialization</th>
                        <th>Description</th>
                        <th width="12%">Options</th>
                    </tr>
                </thead>
                <tfoot class='thead-light'>
                    <tr style="text-align:center">
                        <!-- <th>ID</th> -->
                        <th>No.</th>
                        <th>Specialization</th>
                        <th>Description</th>
                        <th>Options</th>
                    </tr>
                </tfoot>
                <tbody>
                <?php 
                $no=1;
                $query = "SELECT * FROM specialities";
                $query_run = mysqli_query($conn, $query);

                if(mysqli_num_rows($query_run) > 0)
                {
                    foreach($query_run as $row)
                    {
                        ?>
                        <tr style="text-align:center">  
                            <!-- <td></td> -->
                            <td><?php echo $no; ?></td>
                            <td><?= $row['speciality_name']; ?></td>
                            <td><?= $row['description']; ?></td>
                            <td>
                                        <a class="btn btn-sm btn-outline-success" href="speciality_edit.php?id=<?= $row['id']; ?>"
                                        data-toggle="tooltip" title='Edit Specialization "<?= $row['speciality_name']; ?>"!' data-placement="top">
                                        <i class="fa fa-edit fw-fa" aria-hidden="true"></i>
                                        <!-- Edit -->
                                        </a>

                                        <form action="code.php" method="POST" class="d-inline">
                                            <button type="submit" name="delete_speciality" value="<?=$row['id'];?>" class="btn btn-sm btn-outline-danger" onclick="msg()" 
                                            data-toggle="tooltip" title='Delete Specialization "<?= $row['speciality_name']; ?>"!' data-placement="top">
                                            <i class="fa fa-trash fw-fa" aria-hidden="true"></i>
                                            <!-- Delete -->
                                            </button>
                                            <script>
                                                function msg(){
                                                    var result = confirm ('Are you sure you want to delete this Specialization?');
                                                    if(result==false){
                                                        event.preventDefault();
                                                    }
                                                }
                                            </script>
                                        </form>
                            </td>
                        </tr>
                        <?php
                        $no++;
                    }
                }
                else
                {
                    echo "<h5> No Record Found </h5>";
                }
            ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- DataTables End-->



</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>