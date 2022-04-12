

  

<?php 
require 'config/config.php'; 


    $userloggedin = $_SESSION['username'];
    

    if (isset($_POST['save_profile'])) {
    // for the database
    $profileImageName = time() . '-' . $_FILES["profile_pic"]["name"];
    // For image upload
    $target_dir = "asset/img/profile_pic/";
    $target_file = $target_dir . basename($profileImageName);
    // VALIDATION
    // validate image size. Size is calculated in Bytes
    if($_FILES['profile_pic']['size'] > 200000) {
      echo "Image size should not be greated than 200Kb";
     
    }
    // check if file exists
    if(file_exists($target_file)) {
      echo "File already exists";
      
    }
    // Upload image only if no errors
    if (empty($error)) {
      if(move_uploaded_file($_FILES["profile_pic"]["tmp_name"], $target_file)) {
        $sql = "UPDATE register SET profile_pic='$target_file' WHERE username= '$userloggedin' ";
        if(mysqli_query($conn, $sql)){
          echo header("location:beginner.php");
          
        } else 
            echo "There was an error in the database";
         
        }else 
          echo "There was an erro uploading the file";
        
      }
    }
  
?>








