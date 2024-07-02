<?php 
session_start();
include('includes/header.php');
include('includes/navbar.php');
require 'db_conn.php';
if(isset($_POST['submit']))
  {
  	$id=$_GET['id'];
  	//getting the post values
  $ppic=$_FILES["image"]["name"];
   $oldppic=$_POST['oldpic']; 
$oldprofilepic="uploads"."/".$oldppic;
// get the image extension
$extension = substr($ppic,strlen($ppic)-4,strlen($ppic));
// allowed extensions
$allowed_extensions = array(".jpg","jpeg",".png",".gif");
// Validation for allowed extensions .in_array() function searches an array for a specific value.
if(!in_array($extension,$allowed_extensions))
{
echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
}
else
{
//rename the image file
$imgnewfile=md5($imgfile).time().$extension;
// Code for move image into directory
move_uploaded_file($_FILES["image"]["tmp_name"],"uploads/".$imgnewfile);
  // Query for data insertion
     $query=mysqli_query($conn, "update users set image='$imgnewfile' where id='$id' ");
    if ($query) {
    	//Old pic
    	unlink($oldprofilepic);
    echo "<script>alert('Image Updated Successfully');</script>";
    echo "<script type='text/javascript'> document.location ='profile.php'; </script>";
  }
  else
    {
      echo "<script>alert('Something Went Wrong. Please try again');</script>";
    }
}
}
?>

<!-- to not back when logout-->
<script type="text/javascript">
    window.history.forward();
    function noBack() {
        window.history.forward();
    }
</script>
<style>
  .rounded-image {
    border-radius: 50%; /* Make the image always rounded */
    width: 200px; /* Set a fixed width */
    height: 200px; /* Set a fixed height */
  }
  .upload-label {
  display: block;
  font-size: 18px;
  margin-bottom: 10px;
}

.file-upload {
  display: block;
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  font-size: 16px;
  color: #444;
  background-color: #f7f7f7;
}

.file-upload:focus {
  outline: none;
  border-color: #7c7cff;
}

.file-upload:hover {
  background-color: #f1f1f1;
}

.file-upload:active {
  background-color: #e6e6e6;
}

</style>
 <!-- Begin Page Content -->
 <div class="container-fluid">

<!-- Page Heading -->

</div>
<!-- /.container-fluid -->

<div class="row justify-content-center"> 

        <div class="col-xl-4 col-lg-9 col-md-5">
        <?php include('message.php'); ?>    
        <?php include('message_danger.php'); ?>

            <div class="card o-hidden border-0 shadow-lg">

            <div class="card-header py-3">

                <div class="d-sm-flex align-items-center justify-content-between py-2">
                <h6 class="m-0 font-weight-bold text-info"><i class="fa fa-camera fw-fa fa-1x text-gray-600 mr-1"></i>
       EDIT IMAGE</h6>
                 <a href="profile.php" class="btn btn-sm btn-info shadow-sm"><i
                        class="fa fa-arrow-left fa-sm text-white-100 mr-1"></i>Back</a>
                </div>
            </div>
            <div class="card-body">
                <form  method="POST" enctype="multipart/form-data">
 <?php
$id=$_GET['id'];
$ret=mysqli_query($conn,"select * from users where id='$id'");
while ($row=mysqli_fetch_array($ret)) {
?>
<input type="hidden" name="oldpic" value="<?php  echo $row['image'];?>">
	<div class="form-group text-center">
                <?php
if (!isset($row['image']) || empty($row['image'])) {
  $profile_picture = "img/woman.png";
} else {
  $profile_picture = "uploads/" . $row['image'];
}
?>

<img src="<?= $profile_picture ?>" alt="Profile Picture" class="mx-auto img-fluid rounded-image mb-3">
		</div>

         <div class="form-group">
         <input type="file" id="image" name="image" class="file-upload">
        	<span style="color:red; font-size:12px;">Only jpg / jpeg/ png /gif format allowed.</span>
        </div> 
		<div class="form-group">
            <button type="submit" class="btn btn-info btn-md" name="submit">Update</button>
        </div>
              <?php 
}?>
    </form>

            </div>
            </div>
        </div>
    </div>



</div>
<!-- End of Main Content -->

<?php
include('includes/scripts.php');
include('includes/footer.php');
?>