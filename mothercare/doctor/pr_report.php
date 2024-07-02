<?php 
session_start();
 if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) {
include('includes/header.php');
include('includes/navbar.php');
require 'db_conn.php';
?>

 <!-- Begin Page Content -->
 <div class="container-fluid">

 <!-- Page Heading -->
 <div class="d-sm-flex align-items-center justify-content-between mb-4 ml-1">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-fw fa-list-alt"></i> 
        Pregnancy Records
    </h1>
    <a href="pr_report.php" class="btn btn-sm btn-info shadow-sm" value="print" onclick="PrintDiv();">
        <i class="fas fa-print fa-sm text-white-60 mr-1"></i>
        Print Report
    </a>
    
</div>
<hr>

<div class="row justify-content-center">
            <div class="col-md-12">
             
                    
                        <form action="" method="GET">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="text-info">Patient Name</label>
                                        <select name="name_id" class="form-control">
                                            <option value="">Select a name</option>
                                            <?php
                                            $query = "SELECT CONCAT(firstname, ' ', middlename, '. ', lastname) AS name, id FROM users";
                                            $result = mysqli_query($conn, $query);

                                            // Loop through the results and create an option for each name
                                            while ($row = mysqli_fetch_assoc($result)) {
                                                $selected = '';
                                                if (isset($_GET['name_id']) && $_GET['name_id'] == $row['id']) {
                                                    $selected = 'selected';
                                                }
                                                echo "<option value='{$row['id']}' {$selected}>{$row['name']}</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="text-info">From Date</label>
                                        <input type="date" name="from_date" required value="<?php if(isset($_GET['from_date'])){ echo $_GET['from_date']; } ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="text-info">To Date</label>
                                        <input type="date" name="to_date" required value="<?php if(isset($_GET['to_date'])){ echo $_GET['to_date']; } ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="text-info">Click to Filter</label> <br>
                                      <button type="submit" class="btn btn-info px-5"><i class="fas fa-filter fa-sm text-white-60 mr-2"></i>Filter</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                 



                <span id="divToPrint" style="width: 100%;">
            <div class="card shadow">  
                <div class="card-header">
                <hr>
                    <center>
                    <h3><b>MotherCare</b></h3>
                    <h5><i>Pregnancy Records</i></h5>
                    <small>List for the period of 
                        <?php 
                    if(isset($_GET['from_date']))
                    { 
                        $from = $_GET['from_date']; 
                        echo  date('M d, Y', strtotime($from));
                    } 
                    ?> to
                     <?php
                      if(isset($_GET['to_date']))
                      { 
                        $to = $_GET['to_date']; 
                        echo  date('M d, Y', strtotime($to));
                      } 
                      ?>
                      </small>
                    </center>
                </div>
                 <br>
                <div class="card-body py-0">
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered table-hover" width="100%" cellspacing="0">
                            <thead class='thead-light' style="text-align:center">
                                    <th>No.</th>
                                    <th>Patient Name</th>
                                    <th>Weight Gain</th>
                                    <th>Blood Pressure</th>
                                    <th>Fetal Growth</th>
                                    <th>Glucose Level</th>
                                    <th>Date Recorded</th>
                            </thead>
                            <tbody>
                            <?php 
                                if(isset($_GET['from_date']) && isset($_GET['to_date']))
                                {
                                    function dateDifference($from_date, $to_date)
                                    {
                                        // calulating the difference in timestamps 
                                        $diff = strtotime($from_date) - strtotime($to_date);
                                        
                                        // 1 day = 24 hours 
                                        // 24 * 60 * 60 = 86400 seconds
                                        return ceil(abs($diff / 86400));
                                    }
                                    $from_date = $_GET['from_date'];
                                    $to_date = $_GET['to_date'];
                                    $dateDiff = dateDifference($from_date, $to_date);
                                    $namefilter = "AND u.id = '{$_GET['name_id']}'";

                                    $no=1;
                                   $query = "SELECT u.*, pr.* 
                                              FROM users u 
                                              INNER JOIN pregnancy_records pr ON u.id = pr.patient_id 
                                              WHERE u.doctor_id = '{$_SESSION['id']}'";

                                    if (isset($_GET['name_id']) && $_GET['name_id'] !== '') {
                                        $namefilter = "AND u.id = '{$_GET['name_id']}'";
                                        $query .= " $namefilter";
                                    }

                                    if (isset($_GET['from_date']) && isset($_GET['to_date'])) {
                                        $from_date = $_GET['from_date'];
                                        $to_date = $_GET['to_date'];
                                        $query .= " AND pr.date_created BETWEEN '$from_date' AND '$to_date'";
                                    }


                                    $query_run = mysqli_query($conn, $query);

                                    if(mysqli_num_rows($query_run) > 0)
                                    {
                                        foreach($query_run as $row)
                                        {
                                            ?>
                                            <tr style="text-align:center">
                                                <td><?php echo $no; ?></td>
                                                <td><?= $row['firstname']; ?> <?= $row['middlename']; ?>. <?= $row['lastname']; ?></td>
                                                <td><?= $row['weight_gain']; ?> pounds</td>
                                                <td><?= $row['blood_pressure']; ?> mmHg</td>
                                                <td><?= $row['fetal_growth']; ?> inches</td>
                                                <td><?= $row['glucose_level']; ?> mg/dL</td>
                                                <td><?php echo date('F d, Y', strtotime($row['date_created'])); ?></td>
                                            </tr>
                                            <?php
                                            $no++;
                                        }
                                    }
                                    else
                                    {
                                        echo "No Record Found";
                                    }
                                }
                                else {
                                    $no=1;
                                    $query = "SELECT u.*, pr.* 
                                              FROM users u 
                                              INNER JOIN pregnancy_records pr ON u.id = pr.patient_id 
                                              WHERE u.doctor_id = '{$_SESSION['id']}'";
                                              
                                    if (isset($_GET['name_id']) && $_GET['name_id'] !== '') {
                                        $namefilter = "AND u.id = '{$_GET['name_id']}'";
                                        $query .= " WHERE 1=1 $namefilter";
                                    }

                                    $query_run = mysqli_query($conn, $query);

                                    if(mysqli_num_rows($query_run) > 0)
                                    {
                                        foreach($query_run as $row)
                                        {
                                            ?>
                                            <tr style="text-align:center">
                                                <td><?php echo $no; ?></td>
                                                <td><?= $row['firstname']; ?> <?= $row['middlename']; ?>. <?= $row['lastname']; ?></td>
                                                <td><?= $row['weight_gain']; ?> pounds</td>
                                                <td><?= $row['blood_pressure']; ?> mmHg</td>
                                                <td><?= $row['fetal_growth']; ?> inches</td>
                                                <td><?= $row['glucose_level']; ?> mg/dL</td>
                                                <td><?php echo date('F d, Y', strtotime($row['date_created'])); ?></td>
                                            </tr>
                                                           <?php
                                            $no++;
                                        }
                                    }
                                    else
                                    {
                                        echo "No Record Found";
                                    }
                                }
                                ?>

                            </tbody>    
                        </table>
                    </div>
                </div>
            </div>
        </span>

                            </tbody>
                        </table>
                    </div>
                

                <script type="text/javascript">     
                    function PrintDiv() {    
                    var divToPrint = document.getElementById('divToPrint');
                    var popupWin = window.open('', '_blank', 'width=800,height=800');
                    popupWin.document.open();
                    popupWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</html>');
                    popupWin.document.close();
                            }
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

<!-- to not back when logout-->
<script type="text/javascript">
    window.history.forward();
    function noBack() {
        window.history.forward();
    }
</script>