<?php

require_once("db.php");
session_start();
if ( $_SESSION['logged_in'] == 1 ) {
	// Makes it easier to read
    $first_name = $_SESSION['first_name'];
    $last_name = $_SESSION['last_name'];
    $email = $_SESSION['email'];
    $active = $_SESSION['active'];
    $username = substr($email, 0, strpos($email, "@"));
}
else {
  $_SESSION['message'] = "You must log in before viewing your profile page!";
  header("location: error.php");

}
$target_dir = "users/$username/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  echo $imageFileType."<br>";
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check file size
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    $_SESSION['message'] = 'Sorry, only JPG, JPEG & PNG files are allowed!';
    header("location: error_profile.php");
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  $_SESSION['message'] = 'File is not an image. Sorry, your file was not uploaded!';
  header("location: error_profile.php");
// if everything is ok, try to upload file
} else {
  $files=glob('users/'.$username.'/*.jpg');
  foreach($files as $file){
    if(is_file($file)){
      unlink($file);
    }
  }
  $files1=glob('users/'.$username.'/*.png');
  foreach($files1 as $file){
    if(is_file($file)){
      unlink($file);
    }
  }
  $files2=glob('users/'.$username.'/*.jpeg');
  foreach($files2 as $file){
    if(is_file($file)){
      unlink($file);
    }
  }

  $temp1=glob('users/'.$username.'/*.jpeg');
  $temp2=glob('users/'.$username.'/*.jpg');
  $temp3=glob('users/'.$username.'/*.png');
  foreach($temp1 as $file){
    if(is_file($file)){
      unlink($file);
    }
  }
  foreach($temp2 as $file){
    if(is_file($file)){
      unlink($file);
    }
  }
  foreach($temp3 as $file){
    if(is_file($file)){
      unlink($file);
    }
  }
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir."img".time().".".$imageFileType)) {

        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded to $target_file.";
        header("location: profile.php");
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>
