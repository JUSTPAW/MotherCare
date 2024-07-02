<?php
session_start();
require 'db_conn.php';

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

// pregnant patient account codes
if(isset($_POST['delete_account']))
{
    $id = mysqli_real_escape_string($conn, $_POST['delete_account']);

    $query = "DELETE FROM admins WHERE id='$id' ";
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

if(isset($_POST['user_update']))
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
    $query_check_username = "SELECT user_name FROM admins WHERE id='$id'";
    $query_check_username_run = mysqli_query($conn, $query_check_username);
    $row = mysqli_fetch_assoc($query_check_username_run);
    $old_user_name = $row['user_name'];

    // Update the user record in the database
    $query = "UPDATE admins SET firstname='$firstname', lastname='$lastname', middlename='$middlename',user_name='$user_name', age='$age', gender='$gender', address='$address',  phone='$phone',  email='$email' WHERE id='$id' ";
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



// Doctor Codes
if(isset($_POST['delete_doctor']))
{
    $id = mysqli_real_escape_string($conn, $_POST['delete_doctor']);

    $query = "DELETE FROM doctors WHERE id='$id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Doctor Deleted Successfully";
        header("Location: doctors.php");
        exit(0);
    }
    else
    {
        $_SESSION['message_danger'] = "Doctor Not Deleted";
        header("Location: doctors.php");
        exit(0);
    }
}

$id = mysqli_real_escape_string($conn, $_POST['id']);
$firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
$middlename = mysqli_real_escape_string($conn, $_POST['middlename']);
$lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
$user_name = mysqli_real_escape_string($conn, $_POST['user_name']);
$age = mysqli_real_escape_string($conn, $_POST['age']);
$gender = mysqli_real_escape_string($conn, $_POST['gender']);
$address = mysqli_real_escape_string($conn, $_POST['address']);
$phone = mysqli_real_escape_string($conn, $_POST['phone']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$speciality_id = mysqli_real_escape_string($conn, $_POST['speciality_id']);

$sql = "SELECT * FROM doctors WHERE user_name='$user_name' AND id!='$id' ";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $_SESSION['message_danger'] = "User Name Is Already In Use";
    header("Location: doctors.php");
    exit(0);
} else {

    if(isset($_POST['update_doctor'])) {
    
        // check if the new username is different from the old one
        $old_user_name_sql = "SELECT user_name FROM doctors WHERE id='$id' ";
        $old_user_name_result = mysqli_query($conn, $old_user_name_sql);
        $old_user_name_row = mysqli_fetch_assoc($old_user_name_result);
        $old_user_name = $old_user_name_row['user_name'];
        
        if($user_name != $old_user_name) {
            $query = "UPDATE doctors SET firstname='$firstname', middlename='$middlename', lastname='$lastname', user_name='$user_name', age='$age', gender='$gender',  address='$address', phone='$phone', email='$email', speciality_id='$speciality_id' WHERE id='$id' ";
        } else {
            $query = "UPDATE doctors SET firstname='$firstname', middlename='$middlename', lastname='$lastname', age='$age', gender='$gender',  address='$address', phone='$phone', email='$email', speciality_id='$speciality_id' WHERE id='$id' ";
        }
        
        $query_run = mysqli_query($conn, $query);

        if($query_run) {
            $_SESSION['message'] = "Doctors Information Updated Successfully";
            header("Location: doctors.php");
            exit(0);
        } else {
            $_SESSION['message_danger'] = "Doctors Information Not Updated";
            header("Location: doctors.php");
            exit(0);
        }
    }
}


// Patient Codes
if(isset($_POST['delete_patient']))
{
    $id = mysqli_real_escape_string($conn, $_POST['delete_patient']);

    $query = "DELETE FROM users WHERE id='$id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Patient Deleted Successfully";
        header("Location: pregnant_patient.php");
        exit(0);
    }
    else
    {
        $_SESSION['message_danger'] = "Patient Not Deleted";
        header("Location: pregnant_patient.php");
        exit(0);
    }
}

if(isset($_POST['delete_patient_user']))
{
    $id = mysqli_real_escape_string($conn, $_POST['delete_patient_user']);

    $query = "DELETE FROM users WHERE id='$id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['message'] = "User Deleted Successfully";
        header("Location: patients.php");
        exit(0);
    }
    else
    {
        $_SESSION['message_danger'] = "User Not Deleted";
        header("Location: patients.php");
        exit(0);
    }
}


// Speciality Codes
if(isset($_POST['delete_speciality']))
{
    $id = mysqli_real_escape_string($conn, $_POST['delete_speciality']);

    $query = "DELETE FROM specialities WHERE id='$id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Speciality Deleted Successfully";
        header("Location: specialities.php");
        exit(0);
    }
    else
    {
        $_SESSION['message_danger'] = "Speciality Not Deleted";
        header("Location: specialities.php");
        exit(0);
    }
}



$speciality_name = mysqli_real_escape_string($conn, $_POST['speciality_name']);
$description = mysqli_real_escape_string($conn, $_POST['description']);

$sql = "SELECT * FROM specialities WHERE speciality_name='$speciality_name' ";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $_SESSION['message_danger'] = "Speciality Is Already Added";
        header("Location: specialities.php");
        exit(0);
}else {

if(isset($_POST['update_speciality']))
{
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    $speciality_name = mysqli_real_escape_string($conn, $_POST['speciality_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);

    $query = "UPDATE specialities SET speciality_name='$speciality_name', description='$description'
     WHERE id='$id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Speciality Updated Successfully";
        header("Location: specialities.php");
        exit(0);
    }
    else
    {
        $_SESSION['message_danger'] = "Speciality Not Updated";
        header("Location: specialities.php");
        exit(0);
    }

}
}


$speciality_name = mysqli_real_escape_string($conn, $_POST['speciality_name']);
$description = mysqli_real_escape_string($conn, $_POST['description']);

$sql = "SELECT * FROM specialities WHERE speciality_name='$speciality_name' ";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $_SESSION['message_danger'] = "Specialty Is Already Added";
        header("Location: specialities.php");
        exit(0);
}else {

if(isset($_POST['save_speciality']))
{
    $query = "INSERT INTO specialities (speciality_name, description) VALUES ('$speciality_name', '$description')"; 

    $query_run = mysqli_query($conn, $query);
    if ($query_run){
        $_SESSION['message'] = "Specialty Added Succesfully";
        header("Location: specialities.php");
        exit(0);
    }else{
        $_SESSION['message_danger'] = "Specialty Not Added";
        header("Location: specialities.php");
        exit(0);
    }
}
}

// Doctors Codes
if(isset($_POST['delete_doctor_account']))
{
    $id = mysqli_real_escape_string($conn, $_POST['delete_doctor_account']);

    $query = "DELETE FROM doctors WHERE id='$id' ";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $_SESSION['message'] = "Doctor Account Deleted Successfully";
        header("Location: doctors.php");
        exit(0);
    }
    else
    {
        $_SESSION['message_danger'] = "Doctor Account Not Deleted";
        header("Location: doctors.php");
        exit(0);
    }
}

?>