<?php
session_start();
require 'db_conn.php';

// doctor account codes
if(isset($_POST['delete_account']))
{
    $id = mysqli_real_escape_string($conn, $_POST['delete_account']);

    $query = "DELETE FROM doctors WHERE id='$id' ";
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
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $user_name = mysqli_real_escape_string($conn, $_POST['user_name']);

    // Check if the username was updated
    $query_check_username = "SELECT user_name FROM doctors WHERE id='$id'";
    $query_check_username_run = mysqli_query($conn, $query_check_username);
    $row = mysqli_fetch_assoc($query_check_username_run);
    $old_user_name = $row['user_name'];

    // Update the user record in the database
    $query = "UPDATE doctors SET firstname='$firstname', lastname='$lastname', middlename='$middlename',user_name='$user_name', age='$age',
    gender='$gender',  address='$address',  phone='$phone',  email='$email' WHERE id='$id' ";
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


// Medical Records codes
if(isset($_POST['delete_medical_record']))
{
    $id = mysqli_real_escape_string($conn, $_POST['delete_medical_record']);

    $query = "DELETE FROM medical_records WHERE id='$id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Medical Record Deleted Successfully";
        header("Location: medical_records.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Medical Record Not Deleted";
        header("Location: medical_records.php");
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
if(isset($_POST['save_medical_record']))
{   
    $record_type = mysqli_real_escape_string($conn, $_POST['record_type']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $patient_id = mysqli_real_escape_string($conn, $_POST['patient_id']);

    $query = "INSERT INTO medical_records (record_type, description, patient_id)   
                    VALUES ('$record_type', '$description', '$patient_id')"; 

    $query_run = mysqli_query($conn, $query);
    if ($query_run){
        $_SESSION['message'] = "Medical Record Added Succesfully";
        header("Location: medical_record_create.php");
        exit(0);
    }else{
        $_SESSION['message'] = "Medical Record Not Added";
        header("Location: medical_record_create.php");
        exit(0);
    }
}





// Pregnancy Records codes
if(isset($_POST['delete_pregnancy_record']))
{
    $id = mysqli_real_escape_string($conn, $_POST['delete_pregnancy_record']);

    $query = "DELETE FROM pregnancy_records WHERE id='$id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Pregnancy Record Deleted Successfully";
        header("Location: pregnancy_records.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Pregnancy Record Not Deleted";
        header("Location: pregnancy_records.php");
        exit(0);
    }
}

if(isset($_POST['update_pregnancy_record']))
{
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    $weight_gain = mysqli_real_escape_string($conn, $_POST['weight_gain']);
    $blood_pressure = mysqli_real_escape_string($conn, $_POST['blood_pressure']);
    $fetal_growth = mysqli_real_escape_string($conn, $_POST['fetal_growth']);
    $glucose_level = mysqli_real_escape_string($conn, $_POST['glucose_level']);
    $patient_id  = mysqli_real_escape_string($conn, $_POST['patient_id']);

    $query = "UPDATE pregnancy_records SET weight_gain='$weight_gain', blood_pressure='$blood_pressure', fetal_growth='$fetal_growth', glucose_level='$glucose_level',
     patient_id='$patient_id' WHERE id='$id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Pregnancy Record Updated Succesfully";
        header("Location: pregnancy_records.php");
        exit(0);
    }
    else
    {
        $_SESSION['message'] = "Pregnancy Record Not Updated";
        header("Location: pregnancy_records.php");
        exit(0);
    }

}
if(isset($_POST['save_pregnancy_record']))
{   
    $weight_gain = mysqli_real_escape_string($conn, $_POST['weight_gain']);
    $blood_pressure = mysqli_real_escape_string($conn, $_POST['blood_pressure']);
    $fetal_growth = mysqli_real_escape_string($conn, $_POST['fetal_growth']);
    $glucose_level = mysqli_real_escape_string($conn, $_POST['glucose_level']);
    $patient_id  = mysqli_real_escape_string($conn, $_POST['patient_id']);

    $query = "INSERT INTO pregnancy_records (weight_gain, blood_pressure, fetal_growth, glucose_level, patient_id)   
            VALUES
        ('$weight_gain', '$blood_pressure', '$fetal_growth', '$glucose_level', '$patient_id')"; 

    $query_run = mysqli_query($conn, $query);
    if ($query_run){
        $_SESSION['message'] = "Pregnancy Record Added Succesfully";
        header("Location: pregnancy_record_create.php");
        exit(0);
    }else{
        $_SESSION['message'] = "Pregnancy Record Not Added";
        header("Location: pregnancy_record_create.php");
        exit(0);
    }
}


// appointments codes
if(isset($_POST['update_appointment'])) 
{
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    $query = "UPDATE appointments SET status='$status' WHERE id='$id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Appointment Status Updated Successfully";
        header("Location: appointments.php");
        exit(0);
        
    }
    else
    {
        $_SESSION['message_danger'] = "Appointment Status Not Updated";
        header("Location: appointments.php");
        exit(0);
    }

}
?>