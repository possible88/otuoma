<?php 
include("Home/header.php");

$message_obj = new Message($conn, $userloggedin);

if(isset($_GET['u']))
    $user_to = $_GET['u'];
else{
    $user_to = $message_obj->getMostRecentUser();
    if($user_to == false)
        $user_to = 'new';
}

if($user_to != "new")
    $user_to_obj = new User($conn, $user_to);


if(isset($_POST['post_message'])) {
    if(isset($_POST['message_body'])) {
        
        $upload = 1;
   $imageName = $_FILES['fileToUpload']['name'];
   $videoName = $_FILES['fileToUploads']['name'];
    
    if($imageName != "") {
        $targetDir = "asset/img/message/image/";
        $imageName = $targetDir . uniqid() . basename($imageName);
        $imageFileType = pathinfo($imageName, PATHINFO_EXTENSION);
        
        if(strtolower($imageFileType) != "jpeg" && strtolower($imageFileType) != "png" && strtolower($imageFileType) != "jpg") {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $upload = 0;
        }

        // Check if file already exists
       if (file_exists($imageName)) {
        echo "Sorry, file already exists.";
       $upload = 0;
  }

  // Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your file is too large.";
    $upload = 0;
  }
        
        if($upload) {
            if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $imageName)) {
                
            }
            else{
                $upload = 0;
            }
        }
        
    }

    if($videoName != "") {
        $targetDirs = "asset/img/message/video/";
        $videoName = $targetDirs . uniqid() . basename($videoName);
        $videoFileType = pathinfo($videoName, PATHINFO_EXTENSION);
        
        if(strtolower($videoFileType) != "mp4" && strtolower($videoFileType) != "avi" && strtolower($videoFileType) != "3gp" && strtolower($videoFileType) != "mov" && strtolower($videoFileType) != "mpeg") {
        echo "Sorry, only MP4, AVI, 3GP, MPEG & MOV files are allowed.";
        $upload = 0;
        }

        // Check if file already exists
       if (file_exists($videoName)) {
        echo "Sorry, file already exists.";
       $upload = 0;
  }

  // Check file size
  if(($_FILES["fileToUploads"]["size"] >= 5242880) || ($_FILES["fileToUploads"]["size"] == 0)) {
    echo "File too large. File must be less than 5MB.";
    $upload = 0;
  }
  
        
        if($upload) {
            if(move_uploaded_file($_FILES['fileToUploads']['tmp_name'], $videoName)) {
                
            }
            else{
                $upload = 0;
            }
        }
        
    }
    
    if($upload) {
        
        $body = mysqli_real_escape_string($conn, $_POST['message_body']);
        $date = date("Y-m-d H:i:s");
        $message_obj->sendMessage($user_to, $body, $date, $imageName, $videoName);
        
         }
    else{
        echo "<div style='text-align:center;' class='error'>
             errorMessage
            </div>";
    }
    
    
}
}

?> 







<!DOCTYPE html><html class='' style="background-color:#121313; color: #121313;">
<body>
<!-- 

A concept for a chat interface. 

Try writing a new message! :)


Follow me here:
Twitter: https://twitter.com/thatguyemil
Codepen: https://codepen.io/emilcarlsson/
Website: http://emilcarlsson.se/

-->

<div class="container">
		
        <div class="col-lg-3" style="top: 0px;" >
		 <div class="card ">
		 <div class="card-body ">
				<a href="<?php echo $userloggedin; ?>"><img id="profile-img" src="<?php echo $user['profile_pic']; ?>" style="width: 34%; border-radius: 100%;" class="online" alt=""/></a>&nbsp;&nbsp;
				<a href="<?php echo $userloggedin; ?>" style="text-decoration: none;"><?php echo $user['firstname']." ".$user['lastname']; ?></a>
				
             </div>
		<div class="card" style="overflow: auto; height: 400px;">
			<ul class="list-group list-group-flush">
                        <li class="list-group-item">
						 <?php echo $message_obj->getConvos(); ?>
				</li>
			</ul>
             </div>
            </div>
            </div>
	<div class="col-lg-6 gedf-main" style="top: 0px;right: 100;position: absolute;">
		 <div class="card social-timeline-card">
		 <div class="card-header">
    <ul class="nav nav-tabs card-header-tabs" style="height: 55px;" id="myTab" role="tablist">
                            <li class="nav-item" style="top: -35px;">
     <?php 
      if($user_to != "new"){
          echo "<a href='$user_to'><img src='" . $user_to_obj->getProfilePic() ."' style='width: 10%;border-radius: 5%;'>&nbsp;&nbsp; " . $user_to_obj->getFirstAndLastName() . "</a>";
      }
            ?>
        </li>
             </ul>
             </div>
		 <div class="card-body" style="height: 400px; overflow: auto;" id="scroll_messages"> 
			<ul>
				<li class="sent">
				<?php echo $message_obj->getMessages($user_to); ?>
					 </li>
		
			</ul>
             </div>
		<div class="card-footer" style="height: 125px;">
                                  
		<form action="" method="POST" enctype="multipart/form-data">
             <?php 
              if($user_to == "new") {
                 
                 }
              else{
                  echo "<img src='asset/icon/index1.jpg' alt='' class='user-profile' onClick='triggerClick()' id='profileDisplay' style=  ' width: 20px;'>";
                  echo "<input type='file' name='fileToUpload' onChange='displayImage(this)' id='profileImage' style='display:none'>";
                  
                  echo "<img src='asset/icon/video.png' alt='' class='user-profile' onClick='triggerClicks()' id='profileDisplays' style=  ' width: 20px;'>";
                  echo "<input type='file' name='fileToUploads' onChange='displayImages(this)' id='profileImages' style='display:none'>";
                  
                  echo "<textarea name='message_body' class='form-control ' id='massage_textarea' style='background-color: transparent; border: -1px solid; width:95%; display:none'placeholder='Write your message ...'></textarea><br>";
                  echo "<button type='submit' name='post_message' class='send_icons' id='message_submit' value=''><i class='fa fa-send-o upload-button' style='font-size: 20px;color: #41b0ff;'></i></button>";
              }
              ?>
              </form>
			</div>
            
		
             </div>
		 <script>
          var div = document.getElementById("scroll_messages");
          div.scrollTop = div.scrollHeight;
      </script>
     
     
        <script>
function getUser(value, user){ 
       $.post("Home/handlers/ajax_friend_search.php", {query:value, userloggedin:user}, function(data){
           $(".results").html(data);
       });
    }
</script>
     
     <script>
    function triggerClick(e) {
  document.querySelector('#profileImage').click();
}
function displayImage(e) {
  if (e.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e){
      document.querySelector('#profileDisplay').setAttribute('src', e.target.result);
    }
    reader.readAsDataURL(e.files[0]);
  }
}
   </script> 
 
 <script>
    function triggerClicks(e) {
  document.querySelector('#profileImages').click();
}
function displayImages(e) {
  if (e.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e){
      document.querySelector('#profileDisplays').setAttribute('src', e.target.result);
    }
    reader.readAsDataURL(e.files[0]);
  }
}
   </script>


      <script>
   $(document).ready(function() {
       $("#massage_textarea").emojioneArea({
           pickerPosition: "bottom"
       });
   })
   </script>
	</div>
            </div>
<div class="col-lg-3 bta" style="position: absolute;right: 0;top: -45;">
    <div class="card social-timeline-card sow" style="width: 120%;">
    <div class="card-body">
                        <h5 class="card-title">Search Friends</h5>
                        <ul class="friend-list">
                        <div id="search">
		    
			<input type='text' onkeyup='getUser(this.value, "<?php echo $userloggedin; ?>")' name='q' placeholder='@' autocomplete='off' id='search_text_input'>
         <div class='results'></div>
                       </div>      
                        </ul>
                      
</div>
    </div>       
        </div>
  
  
</body></html>