<?php 
include("Home/header.php");

?>
<style>
html{
    background-color:#121313;}
</style>
 <div class="container" style="margin-top: -20px;">
    <div class="row">
        <div class="col-md-8 request" style="">
            <div class="people-nearby">
              <div class="nearby-user" style="margin-left: 80px;">
                <div class="row" id="profile_connect">
    
    <?php
    
    $query = mysqli_query($conn, "SELECT * FROM friend_requests WHERE user_to='$userloggedin'");
    if(mysqli_num_rows($query) == 0)
        echo "";
    else{
        
        while($row = mysqli_fetch_array($query)){
            $user_from = $row['user_from'];
            $user_from_obj = new User($conn, $user_from);
            ?>
            <div class="col-md-2 col-sm-2"><img src="<?php 
            echo $user_from_obj->getProfilePic();
            ?>" alt="user" class="profile-photo-lg">
            <div class="col-md-7 col-sm-7">
             <h5 style="width: 100px; margin-left: -20px;"><a href="<?php echo $user_from; ?>"class="profile-link">
            <?php 
            echo $user_from_obj->getFirstAndLastName();
            ?>
                 </a></h5><br>
            <?php
            $user_from_friend_array = $user_from_obj->getFriendArray();
            
            if(isset($_POST['accept_request' . $user_from ])) {
                $add_friend_query = mysqli_query($conn, "UPDATE register SET friend_array=CONCAT(friend_array, '$user_from,') WHERE username='$userloggedin'");
                
                $add_friend_query = mysqli_query($conn, "UPDATE register SET friend_array=CONCAT(friend_array, '$userloggedin,') WHERE username='$user_from'");
                
                $delete_query = mysqli_query($conn, "DELETE FROM friend_requests WHERE user_to='$userloggedin' AND user_from='$user_from'");
                echo "You are Connected";
                header("Location: request.php");
            }
            
            if(isset($_POST['ignore_request' . $user_from ])) {
              $delete_query = mysqli_query($conn, "DELETE FROM friend_requests WHERE user_to='$userloggedin' AND user_from='$user_from'");
                echo "Request ignored";
                header("Location: request.php");  
            }
            
            ?>
           
        <form action="request.php" method="POST">
        <div class="col-md-3 col-sm-3" style="right: 1px; margin-left: 500px; margin-top: -122px;"> 
       <input type="submit" name="accept_request<?php echo $user_from; ?>" id="accept_button" value="Accept" class="btn btn-primary pull-right">
            </div><br>
            <div class="col-md-3 col-sm-3" style="margin-left: 500px; position: absolute; margin-top: 18px;">  
       <input type="submit" name="ignore_request<?php echo $user_from; ?>" id="ignore_button" value="Ignore" class="btn btn-primary pull-right"> 
      </div>  
                </form> 
       <?php     
            
        }
    }
    
   ?>
   
                  </div>  
   </div>
</div>
   </div>
   </div>
      </div>
                
<style>
body{
    margin-top:20px;
    background:#FAFAFA;    
}
/*==================================================
  Nearby People CSS
  ==================================================*/

.people-nearby .google-maps{
  background: #f8f8f8;
  border-radius: 4px;
  border: 1px solid #f1f2f2;
  padding: 20px;
  margin-bottom: 20px;
}

.people-nearby .google-maps .map{
  height: 300px;
  width: 100%;
  border: none;
}

.people-nearby .nearby-user{
  padding: 20px 0;
  border-top: 1px solid #f1f2f2;
  border-bottom: 1px solid #f1f2f2;
  margin-bottom: 20px;
}

img.profile-photo-lg{
  height: 80px;
  width: 80px;
  border-radius: 50%;
}

</style>
