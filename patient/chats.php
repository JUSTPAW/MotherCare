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
        <i class="fa fa-envelope fa-1x text-gray-600 mr-1"></i>
        Message
    </h1>
</div>

<?php include('message.php'); ?>
<?php include('message_danger.php'); ?>

        <div class="row">
            <div class="col-md-12">
                <!-- Chat -->
                <div class="card shadow mb-4">
                    <div class="card-header">
                        <?php
                            // Retrieve the logged-in user's ID
                            $user_id = $_SESSION['id'];
                            // Build the SQL query
                            $sql = "SELECT firstname, middlename, lastname
                                    FROM doctors
                                    WHERE id = (SELECT doctor_id FROM users WHERE id = $user_id)";
                            // Execute the query and retrieve the result
                            $result = mysqli_query($conn, $sql);
                            // Check if the query was successful and if there is at least one result
                            if ($result && mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                $doctor_name = $row['firstname'] . ' ' . $row['middlename'] . '. ' . $row['lastname'];
                                echo '<h6 class="font-weight-bold text-info">Dr. ' . $doctor_name . '</h6>';
                            } else {
                                echo 'Please Select Your Doctor First';
                            }
                            ?>
                    </div>
                   <div class="card-body" style="height: 300px; overflow-y: scroll;" id="message-container">
                    <?php

                    // Fetch the messages from the database
                    $sql = "SELECT m.id, m.message, m.sender, m.date_created
                            FROM messages m
                            WHERE m.sender = ? OR m.sender IN (SELECT doctor_id FROM users WHERE id = ? AND doctor_id = m.sender)
                            ORDER BY m.date_created ASC";
                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_bind_param($stmt, "ii", $_SESSION['id'], $_SESSION['id']);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

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
                                        <i class="fas fa-user-md fa-1x mr-2"></i>
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

<?php
// Retrieve doctor_id from database based on user_id
$user_id = $_SESSION['id'];
$sql = "SELECT doctor_id FROM users WHERE id = '$user_id'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
  $row = mysqli_fetch_assoc($result);
  $doctor_id = $row['doctor_id'];
}
?>
<!-- Use consistent naming conventions for input names and values -->
<form action="code.php" method="POST">
  <input type="hidden" name="sender" value="<?php echo $_SESSION['id']; ?>">
  <input type="hidden" name="recipient" value="<?php echo $doctor_id; ?>">
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
                </div>
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