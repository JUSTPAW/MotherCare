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
<div class="d-sm-flex align-items-center justify-content-between mb-4 ml-2">
  <h1 class="h3 mb-0 text-gray-800">
        <i class="fa fa-envelope fa-1x text-gray-600 mr-1"></i>
        Messages
    </h1>
    <!-- <a href="emp_report.php" class="btn btn-sm btn-info shadow-sm">
        <i class="fas fa-plus fa-sm text-white mr-1"></i>Add Project</a> -->
</div>

<div class="row">
    <div class="col-md-5">
        <div class="card shadow-sm">
            <div class="card-header bg-light">
                <h6 class="text-gray-800 font-weight-bold">Inbox</h6>
            </div>
            <div class="card-body">
                <div class="list-group">
<?php 
$query = "SELECT m1.*, u.id AS user_id, u.firstname, u.lastname, u.middlename 
          FROM messages m1 
          JOIN users u ON m1.sender = u.id 
          WHERE m1.recipient = {$_SESSION['id']} 
          AND m1.date_created = (
              SELECT MAX(date_created) 
              FROM messages m2 
              WHERE m2.sender = m1.sender 
              AND m2.recipient = m1.recipient
          )
          ORDER BY m1.date_created DESC";


$query_run = mysqli_query($conn, $query);

if(mysqli_num_rows($query_run) > 0)
{
    foreach($query_run as $mes)
    {
        $date = $mes['date_created']; 
        $time = $mes['date_created'];
?>
        <a href="chats.php?id=<?= $mes['user_id']; ?>" class="list-group-item list-group-item-action" data-toggle="tooltip" title="Click to view this message!" data-placement="top">
            <div class="d-flex w-100 justify-content-between">
                <h6 class="mb-1 font-weight-bold"><?php echo $mes['firstname'] . ' ' . $mes['middlename'] . '. ' . $mes['lastname'] ?></h6>
            </div>
            <p class="mb-1 small text-truncate"><?= $mes['message']; ?></p>
        </a>
<?php
    }
}
else
{
    echo "<small><center> No Messages </center></small>";
}
?>


                </div>
            </div>
        </div>
    </div>








<div class="col-md-7">

<?php include('message.php'); ?>
                    

<?php
    if(isset($_GET['id']))
    {
        $customer_ID = mysqli_real_escape_string($conn, $_GET['id']);
        $query = "SELECT * FROM messages WHERE sender='$customer_ID' AND recipient='{$_SESSION['id']}'";

        $query_run = mysqli_query($conn, $query);

        if(mysqli_num_rows($query_run) > 0)
        {
            $date = $mes['date_created']; 
            $time = $mes['date_created'];

            $mes = mysqli_fetch_array($query_run);
?>
    
    <div class="card shadow-sm">
    <div class="card-header text-primary d-sm-flex align-items-center justify-content-between">
        <h1 class="h5 mb-0 text-info">
            <?php
              $id = $_GET['id'];
              $sql = "SELECT firstname, middlename, lastname FROM users WHERE id = $id";
              $result = mysqli_query($conn, $sql);
              if ($result) {
                  $row = mysqli_fetch_assoc($result);
                  $name = $row['firstname'] . ' ' . substr($row['middlename'], 0, 1) . '. ' . $row['lastname'];
                  echo $name;
                }
              ?>
        </h1>
        <a href="chats.php" class="btn btn-sm btn-outline-default">
            <i class="fas fa-times"></i></a>
    </div>

                <div class="card-body" style="height: 300px; overflow-y: scroll;" id="message-container">
                  <?php
                    $sql = "SELECT * FROM messages WHERE (sender = '" . $_GET['id'] . "' AND recipient = '" . $_SESSION['id'] . "') OR (sender = '" . $_SESSION['id'] . "' AND recipient = '" . $_GET['id'] . "')";

                    // Execute the SQL query
                    $result = mysqli_query($conn, $sql);

                    // Loop through the messages and generate the HTML markup for each message
                    while ($row = mysqli_fetch_assoc($result)) {
                      $messageContent = htmlspecialchars($row['message']);
                      date_default_timezone_set('Asia/Manila');
                      // Assuming $row['date_created'] is a string in the format "Y-m-d H:i:s"
                      $date_created = strtotime($row['date_created']);
                      $now = time();
                      if (date('Y-m-d', $date_created) == date('Y-m-d', $now)) {
                        // The date_created value is today
                        $timestamp = date('g:i A', $date_created);
                      } else {
                        // The date_created value is in the past
                        $timestamp = date('M d, g:i A', $date_created);
                      }
                      if ($row['sender'] == $_SESSION['id']) {
                        // Message sent by current user
                        echo '<div class="row">
                                <div class="col-md-6 offset-md-6">
                                  <div class="p-1 rounded text-left">
                                    <div class="d-flex align-items-end justify-content-end">
                                      <div class="flex-grow-1">
                                        <div class="bg-gray-100 rounded px-3 py-2 float-right" style="word-break: break-word;">
                                          <p class="mb-0 message">' . $messageContent . '</p>
                                          <small class="text-muted text-end timestamp">' . $timestamp . '</small>
                                          <div class="mt-2 buttons" style="display: none;">
                                            <form action="code.php" method="POST" class="d-inline">
                                              <button type="submit" name="delete_message" value="' . $row['id'] . '" class="btn btn-sm btn-outline-danger" onclick="msg()" 
                                              data-toggle="tooltip" title="Delete this message" data-placement="top">
                                                <i class="fa fa-trash fw-fa" aria-hidden="true"></i>
                                                <!-- Delete -->
                                              </button>
                                              <script>
                                                function msg(){
                                                  var result = confirm("Are you sure you want to delete this Message?");
                                                  if (result == false){
                                                    event.preventDefault();
                                                  }
                                                }
                                              </script>
                                            </form>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>';
                      } else {
                        // Message sent by other user
                        echo '<div class="row">
                                <div class="col-md-6">
                                  <div class="p-1 rounded text-left">
                                    <div class="d-flex align-items-start">
                                      <div class="flex-shrink-0 me-2 mt-1">
                                      <i class="fas fa-user fa-1x mr-2"></i>
                                      </div>
                                      <div class="flex-grow-1">
                                        <div class="bg-gray-100 rounded px-3 py-2 float-left" style="word-break: break-word;">
                                          <p class="mb-0">' . $messageContent . '</p>
                                          <small class="text-muted">' . $timestamp . '</small>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>';
                      }
                    }
                    ?>
                    <script>
                    const messageContainer = document.querySelector('#message-container');
                    messageContainer.scrollTop = messageContainer.scrollHeight;
                    </script>


                    <script>
                    const messageElements = document.querySelectorAll('.message');

                    messageElements.forEach((messageElement) => {
                      messageElement.addEventListener('click', () => {
                        const buttonsElement = messageElement.parentElement.querySelector('.buttons');
                        buttonsElement.style.display = (buttonsElement.style.display === 'none') ? 'block' : 'none';
                      });
                    });

                    </script>

                    </div>
                    <div class="card-footer">
                    <!-- Use consistent naming conventions for input names and values -->
                    <form action="code.php" method="POST">
                      <input type="hidden" name="sender" value="<?php echo $_SESSION['id']; ?>">
                      <input type="hidden" name="recipient" value="<?=$_GET['id'];?>">
                      <div class="input-group">
                        <input type="text" name="message" required class="form-control" placeholder="Type your message">
                        <div class="input-group-append">
                          <button type="submit" name="send_message" class="btn btn-info d-flex align-items-center">
                            <i class="fas fa-paper-plane"></i>
                            <span class="d-none d-lg-inline ml-2">Send</span>
                          </button>
                        </div>
                      </div>
                    </form>
                    </div>
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