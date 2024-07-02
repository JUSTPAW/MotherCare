<?php
session_start();
require 'db_conn.php';

// message codes

if(isset($_POST['delete_message']))
{
    $id = mysqli_real_escape_string($conn, $_POST['delete_message']);

    $query = "DELETE FROM messages WHERE id='$id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Messages Deleted Successfully";
        header("Location: chats.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Messages Not Deleted";
        header("Location: chats.php");
        exit(0);
    }
}

if(isset($_POST['update_medical_record']))
{
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    $record_type = mysqli_real_escape_string($conn, $_POST['record_type']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $patient_id = mysqli_real_escape_string($conn, $_POST['patient_id']);

    $query = "UPDATE medical_records SET record_type='$record_type', description='$description', patient_id='$patient_id' WHERE id='$id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Medical Record Updated Succesfully";
        header("Location: medical_records.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Medical Record Not Updated";
        header("Location: medical_records.php");
        exit(0);
    }

}
if(isset($_POST['send_message']))
{   
    $sender = mysqli_real_escape_string($conn, $_POST['sender']);
    $recipient = mysqli_real_escape_string($conn, $_POST['recipient']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    $query = "INSERT INTO messages (sender, recipient, message)   
                    VALUES ('$sender', '$recipient', '$message')"; 

    $query_run = mysqli_query($conn, $query);
    if ($query_run){
        $_SESSION['message'] = "Message Sent Succesfully";
        header("Location: chats.php");
        exit(0);
    }else{
        $_SESSION['message'] = "Medical Sent Not Added";
        header("Location: chats.php");
        exit(0);
    }
}

// pregnant patient account codes
if(isset($_POST['delete_account']))
{
    $id = mysqli_real_escape_string($conn, $_POST['delete_account']);

    $query = "DELETE FROM users WHERE id='$id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Account Deleted Successfully";
        header("Location: login.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Account Not Deleted";
        header("Location: login.php");
        exit(0);
    }
}

if(isset($_POST['update_user']))
{
    // Get the values of the form fields and sanitize them
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $middlename = mysqli_real_escape_string($conn, $_POST['middlename']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);

    // Check if the username was updated
    $query_check_username = "SELECT user_name FROM users WHERE id='$id'";
    $query_check_username_run = mysqli_query($conn, $query_check_username);
    $row = mysqli_fetch_assoc($query_check_username_run);
    $old_user_name = $row['user_name'];

    // Update the user record in the database
    $query = "UPDATE users SET firstname='$firstname', lastname='$lastname', middlename='$middlename',user_name='$user_name', age='$age', address='$address',  phone='$phone',  email='$email' WHERE id='$id' ";
    $query_run = mysqli_query($conn, $query);

    // Check if the query was successful
    if($query_run)
    {
        if ($user_name == $old_user_name) {
            // If the username was not updated, redirect to profile.php
            $_SESSION['message'] = "Personal Information Updated Successfully";
            header("Location: profile.php");
            exit(0);
        } else {
            // If the username was updated, redirect to login.php
            $_SESSION['message'] = "Personal Information Updated Successfully";
            header("Location: login.php");
            exit(0);
        }
    }
    else
    {
        // If the query was not successful, redirect to profile.php
        $_SESSION['message'] = "Personal Information Not Updated";
        header("Location: profile.php");
        exit(0);
    }
}

// appointments codes
if(isset($_POST['delete_appointment']))
{
    $id = mysqli_real_escape_string($conn, $_POST['delete_appointment']);

    $query = "DELETE FROM appointments WHERE id='$id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Appointment Deleted Successfully";
        header("Location: appointments.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Appointment Not Deleted";
        header("Location: appointments.php");
        exit(0);
    }
}



if(isset($_POST['update_appointment'])) 
{
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    $doctor_id = mysqli_real_escape_string($conn, $_POST['doctor_id']);
    $patient_id = mysqli_real_escape_string($conn, $_POST['patient_id']);
    $app_date = mysqli_real_escape_string($conn, $_POST['app_date']);
    $app_time = mysqli_real_escape_string($conn, $_POST['app_time']);
    $purpose = mysqli_real_escape_string($conn, $_POST['purpose']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $status = "Ongoing";
    if ($purpose === "Others") {
        $other_purpose = mysqli_real_escape_string($conn, $_POST['other_purpose']);
        $purpose = $other_purpose;
    }

    // Calculate appointment end time
    $duration = 30; // Appointment duration in minutes
    $start_time = strtotime($app_time);
    $end_time = strtotime('+'.$duration.' minutes', $start_time);
    $start_time = date('H:i:s', $start_time);
    $end_time = date('H:i:s', $end_time);

    // Check for existing appointments within 30-minute window of current appointment
    $query = "SELECT * FROM appointments WHERE doctor_id = '$doctor_id' AND app_date = '$app_date' AND TIME(app_time) < ADDTIME('$app_time', '00:30:00') AND TIME(app_time) > SUBTIME('$app_time', '00:30:00')";
    $result = mysqli_query($conn, $query);
    $num_rows = mysqli_num_rows($result);

    if ($num_rows > 0) {
        $_SESSION['message_danger'] = "Appointment cannot be scheduled within 30 minutes of an existing appointment.";
        header("Location: appointments.php");
        exit(0);
    }

    // count the number of appointments for the selected date and doctor
    $query = "SELECT COUNT(*) as count FROM appointments WHERE app_date = '$app_date' AND doctor_id = '$doctor_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $count = $row['count'];

    if ($count < 10) {
        $query = "UPDATE appointments SET doctor_id='$doctor_id', patient_id='$patient_id', app_date='$app_date', app_time='$app_time', start_time='$start_time', end_time='$end_time', purpose='$purpose',  message='$message',  status='$status' WHERE id='$id' ";
        $query_run = mysqli_query($conn, $query);

        if($query_run)
        {
            $_SESSION['message'] = "Appointment Added Successfully";
            header("Location: appointments.php");
            exit(0);
        }
        else
        {
            $_SESSION['message_danger'] = "Appointment Not Added";
            header("Location: appointments.php");
            exit(0);
        }
    }
    else {
        $_SESSION['message_danger'] = "Appointment limit reached for the selected date and doctor. Please choose another date.";
        header("Location: appointments.php");
        exit(0);
    }
}




if(isset($_POST['save_appointments'])) 
{
    $doctor_id = mysqli_real_escape_string($conn, $_POST['doctor_id']);
    $patient_id = mysqli_real_escape_string($conn, $_POST['patient_id']);
    $app_date = mysqli_real_escape_string($conn, $_POST['app_date']);
    $app_time = mysqli_real_escape_string($conn, $_POST['app_time']);
    $purpose = mysqli_real_escape_string($conn, $_POST['purpose']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $status = "Ongoing";
    if ($purpose === "Others") {
        $other_purpose = mysqli_real_escape_string($conn, $_POST['other_purpose']);
        $purpose = $other_purpose;
    }

    // Calculate appointment end time
    $duration = 30; // Appointment duration in minutes
    $start_time = strtotime($app_time);
    $end_time = strtotime('+'.$duration.' minutes', $start_time);
    $start_time = date('H:i:s', $start_time);
    $end_time = date('H:i:s', $end_time);

    // Check for existing appointments within 30-minute window of current appointment
    $query = "SELECT * FROM appointments WHERE doctor_id = '$doctor_id' AND app_date = '$app_date' AND TIME(app_time) < ADDTIME('$app_time', '00:30:00') AND TIME(app_time) > SUBTIME('$app_time', '00:30:00')";
    $result = mysqli_query($conn, $query);
    $num_rows = mysqli_num_rows($result);

    if ($num_rows > 0) {
        $_SESSION['message_danger'] = "Appointment cannot be scheduled within 30 minutes of an existing appointment.";
        header("Location: appointments_create.php");
        exit(0);
    }

    // count the number of appointments for the selected date and doctor
    $query = "SELECT COUNT(*) as count FROM appointments WHERE app_date = '$app_date' AND doctor_id = '$doctor_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $count = $row['count'];

    if ($count < 10) {
        $query = "INSERT INTO appointments (doctor_id, patient_id, app_date, app_time, start_time, end_time, purpose, message, status) VALUES ('$doctor_id', '$patient_id', '$app_date', '$app_time', '$start_time', '$end_time', '$purpose', '$message', '$status')";
        $query_run = mysqli_query($conn, $query);

        if($query_run)
        {
            $_SESSION['message'] = "Appointment Added Successfully";
            header("Location: appointments_create.php");
            exit(0);
        }
        else
        {
            $_SESSION['message_danger'] = "Appointment Not Added";
            header("Location: appointments_create.php");
            exit(0);
        }
    }
    else {
        $_SESSION['message_danger'] = "Appointment limit reached for the selected date and doctor. Please choose another date.";
        header("Location: appointments_create.php");
        exit(0);
    }
} 

?>