
<?php 
include("Home/header.php");

$message_obj = new Message($conn, $userloggedin);
$imageName="";
 $videoName="";
$logged_in_user_obj = new User($conn, $userloggedin);

$num_friends = "";

  

 
if(isset($_GET['profile_username'])) {
    $username = $_GET['profile_username'];
    $user_details_query = mysqli_query($conn, "SELECT * FROM register WHERE username='$username'");
    $user_array = mysqli_fetch_array($user_details_query);
    
    $num_friends = (substr_count($user_array['friend_array'],",")) - 1;        
}

if(isset($_POST['remove_friend'])) {
    $user = new User($conn, $userloggedin);
    $user->removeFriend($username);
}

if(isset($_POST['add_friend'])) {
    $user = new User($conn, $userloggedin);
    $user->sendRequest($username);
}

if(isset($_POST['respond_request'])) {
    header("Location: request.php");
}
if(isset($_POST['post'])){
    
    $posts = new Post($conn, $userloggedin);
         $posts->submitPost($_POST['post_text'], 'none', $imageName, $videoName); 
      }
      else{
          echo "<div style='text-align:center;' class='error'>
               errorMessage
              </div>";
      }

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
            $message_obj->sendMessage($username, $body, $date, $imageName, $videoName);
            
             }
        else{
            echo "<div style='text-align:center;' class='error'>
                 errorMessage
                </div>";
        }
        
        
    }

    }
      ?>

      


<style>
html{
    background-color:#121313;}

   @import url(https://fonts.googleapis.com/icon?family=Material+Icons);
@import url("https://fonts.googleapis.com/css?family=Raleway");

.wrappers {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: horizontal;
  -webkit-box-direction: normal;
      -ms-flex-direction: row;
          flex-direction: row;
  -ms-flex-wrap: wrap;
      flex-wrap: wrap;
  -webkit-box-align: center;
      -ms-flex-align: center;
          align-items: center;
  -webkit-box-pack: center;
      -ms-flex-pack: center;
          justify-content: center;
}


h1 {
  font-family: inherit;
  margin: 0 0 .75em 0;
  color: #728c8d;
  text-align: center;
}

.box {
  display: block;
  min-width: 300px;
  height: 300px;
  margin: 10px;
  background-color: white;
  border-radius: 5px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
  -webkit-transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
  transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
  overflow: hidden;
}

.chat-popup {
  display: none;
  position: fixed;
  bottom: -30;
  right: 15px;
  z-index: 12;
  background-color:#121313;
  right: 55px;
}

    
    .nav {
   
border: none;
background-color: #121313;

}

/* Style the buttons inside the tab */
.nav button {
  display: block;
  background-color: inherit;
  color: black;
  padding: 22px 16px;
  border: none;
  outline: none;
  text-align: left;
  cursor: pointer;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.nav button:hover {
  background-color: #ddd;
}

/* Create an active/current "tab button" class */
.nav button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
    float: left;
padding: 0px 12px;
border: none;
width: 85%;
border-left: none;
height: 550px;
overflow: auto;
}

</style>



<main>
    <div class="container">
        
        <div class="card cardpropics" style="position: fixed;background-color:#ffffffe6;z-index: 11;">
            <div class="card-body">
                <div class="wrapper" >
                        <img src="<?php echo $user_array['profile_pic']; ?>" alt="#" class="user-profile" id="opennow2" style="float: left;width: 190px;height: 180px;">
                        <div class="modal_container">
            <div class="wrappers" style="position: absolute; top: 30px; left: 50px;">
            <button type="button" class="closenow2"><i class="fa fa-window-close" aria-hidden="true"></i></button>
                
                         <form method="POST" action="upload_pic.php" enctype='multipart/form-data'>
             <img src="<?php echo $user_array['profile_pic']; ?>" alt="" class="box" onClick="triggerClick()" id="profileDisplay">
                    
                 <?php  
    if($userloggedin == $username) {  
          
      echo '<input type= "file" name="profile_pic" onChange="displayImage(this)" id="profileImage" class="image-upload" style="display: none;" accept="image/*"/>';
      echo '<button type="submit" name="save_profile" class="btn btn-primary btn-block" ><i class="fa fa-camera upload-button"></i>upload</button>';

       
   
   }
  ?>
                    </form> 
                          
                    </div>            
                    </div>
                    
                </div>

                

                       
                 
            </div>
        </div>
        
    
        <div class="row" style="margin-right: -120px; ">
            
            
            
            <div class="card bta" style="padding: 20px 20px; top:328px;position: fixed; width: 17%;left: 122px;" >
            
                    <h3><a href="<?php echo $username; ?>" class=""style=''>
    <?php
      echo $user_array['firstname']." ".$user_array['lastname'];
    ?>
    </a></h3>
                    <p class=""style=""><?php
      echo $user_array['username']; 
    ?></p> 

<p class=""style=""><?php 
    if($userloggedin != $username) {
        echo '<div class="">';
        echo $logged_in_user_obj->getMutualFriends($username) . "  Mutual Connection";
        echo '</div>';
    }
    
    ?></p> 
       
                            
                    
                   
            </div>
            <div class="col-lg-6 gedf-main posttexted" style="">
            
            <?php
            if($userloggedin == $username) {
            echo '<div class="card social-timeline-card posttext posttexts" style="">
                    <div class="card-header card_headers card_headers1" style="">
                        <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                            <li class="nav-item" style="top: -25px;">
                                <button type="button" class="btn propics" style=" position: absolute; top: -20px;"><a href="postpics.php" class="user-profile"style=" width: 20px;  "><i class="fa fa-camera" aria-hidden="true" style="color: #41b0ff;"></i>
</a></button>
<button type="button" class="btn provideos" style=" position: absolute; top: -20px;"><a href="postvideo.php" class="user-profile" style=" width: 20px;  "><i class="fa fa-video-camera" aria-hidden="true" style="color: #41b0ff;"></i>
</a></button>
                            
                            </li>
                                  
                        </ul>
                    </div>
                    <div class="card-body">     
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade active show" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                                <div class="form-group">
                                    <label class="sr-only" for="message">post</label>
                                   <form class="post_form" action="" method="POST" enctype="multipart/form-data">
                                    <textarea name="post_text" class="form-control postwrite" id="emojimessage" rows="3" style="background-color: transparent; border: -1px solid; width:95%;padding: 9px; display:none" placeholder="What are you thinking?"></textarea>
                                    <button type="submit" name="post" id="post_button" value="" class="send_icon"><i class="fa fa-send-o upload-button" style="font-size: 20px;color: #41b0ff;margin: -10px;"></i></button>
                                    </form>
                             </div>
                            </div>
                            </div>
                    </div>
                </div>';
                }
                ?>
                
                
                <!--- \\\\\\\Post-->
                <div class="nav">
  <button class="tablinks" onclick="openCity(event, 'Posts')" id="defaultOpen" button type="button"><i class='fa fa-comments-o' style='font-size: 30px; width: 100%;color: #41b0ff;'></i></button>
  <button class="tablinks" onclick="openCity(event, 'About')" button type="button"><i class='fa fa-user'style='font-size: 30px; width: 100%;color: #41b0ff;' ></i></button>
    <button class="tablinks" onclick="openCity(event, 'Connection')" button type="button"><i class='fa fa-users' style='font-size: 30px; width: 100%;color: #41b0ff;'></i></button>
</div>
                <div id="Posts" class="tabcontent">
                <div class="posts_area"></div>
    <img id="loading" src="asset/icon/loading.gif" style="width: 20%;">
                </div>
                
                <div id="About" class="tabcontent">
                <ul class="list-group list-group-flush">
                <li class="list-group-item">
                    <hi>Contact Info</hi></li>
               
                <li class="list-group-item">
               <div class="h7 text-muted">Names</div>
             <p style="color: aqua;"><a href="<?php echo $username; ?>" style='text-decoration: none;'>
            <?php
      echo $user_array['firstname']." ".$user_array['lastname'];
    ?>
                 </a></p></li>
                   <li class="list-group-item">
                   <div class="h7 text-muted">Username</div>
                            
                    <p style="color: aqua;"><?php
      echo $user_array['username']; 
                        ?></p></li>
               <li class="list-group-item">
               <div class="h7 text-muted">Email</div>
                            
                <p style="color: aqua;"><?php
      echo $user_array['email']; 
                    ?></p></li>
               <li class="list-group-item">
               <div class="h7 text-muted">Likes</div>
                            
                <p style="color: aqua;"><?php
      echo $user_array['num_likes']; 
                    ?></p></li>
               <li class="list-group-item">
               <div class="h7 text-muted">Otuoma</div>
                            
                <p style="color: aqua;"><?php
      echo $user_array['num_posts']; 
                    ?></p></li>
               <li class="list-group-item">
               <div class="h7 text-muted">Connection</div>
                <p style="color: aqua;"><?php
      echo $num_friends 
                    ?></p></li>
               
                </ul>
                </div>
                <div id="Connection" class="tabcontent">
                  <ul class="friend-list">
                
                <?php

$friendsArray = "";
$countFriends = "";
$friendsArray12 = "";
$selectFriendsQuery = mysqli_query($conn, "SELECT friend_array FROM register WHERE username='$username'");
$friendRow = mysqli_fetch_array($selectFriendsQuery);
$friendsArray = $friendRow['friend_array'];
if ($friendsArray != "") {
    $friendsArray = explode(",",$friendsArray);
    $friendquery12 = array_splice($friendsArray, 0, 12);

   $i = 0;
echo '<div id="profileFriends">';
if ($num_friends != 0) {
    foreach ($friendquery12 as $key => $value) {
        $i++;
        $getFriendQuery = mysqli_query ($conn, "SELECT firstname, lastname, username, profile_pic FROM register WHERE username='$value' LIMIT 1");
        if($getFriendRow = mysqli_fetch_array($getFriendQuery))
        {

            $user_obj = new User($conn, $user['username']);
        
            if($getFriendRow['username'] != $userloggedin) {
                $mutual_friends= $user_obj->getMutualFriends($getFriendRow['username']) . " friends in common";
            }
            else{
               $mutual_friends = ""; 
            }
            $friendusername = $getFriendRow['username'];
        $friendProfilePic = $getFriendRow['profile_pic'];
        $friendfirstname = $getFriendRow['firstname'];
        $friendlastname = $getFriendRow['lastname'];

        echo "<div class='resultDisplay'>

<a href= '" .  $friendusername . "' style='color: #000;    text-decoration: none;'>
<div class='liveSearchProfilePic'>
<img src='". $friendProfilePic . "' style='width:15%;margin-top: 15px;'>
</div><br>

<div class='liveSearchText' style='margin-left: 100px;font-size: 20px;'>
".$friendfirstname . " " . $friendlastname."
<p style='font-size: 10px;'>".  $friendusername . " </p>
<p id='grey'>".$mutual_friends ."</p>
</div>
</a>
</div><hr>";  

    }

    }
}  
else
echo $username." has no friends yet.";  
}  
?>
       </ul>        
                    
                </div>
                
                
  </div>
                <!-- Post /////-->
                <!--- \\\\\\\Post-->
                
                <!-- Post /////-->
            
                
</div>

            <div class="col-lg-3 profilemedia" style="position: fixed;z-index: 10;">
                <div class="card social-timeline-card" style="right: 30px;border: none;">
                    <div class="card-body">

                    <form action="<?php echo $username; ?>" method="POST">
   <?php 
      $profile_user_obj = new User($conn, $username);
      if($profile_user_obj->isClosed()) {
          header("Location: user_closed.php");
      }
      
   
      if($userloggedin != $username) {
          
          if($logged_in_user_obj-> isFriend($username)) {
              echo '<input type="submit" name="remove_friend" class="danger profileremove" style="" value="Disconnect"><br>';
          }
       else if ($logged_in_user_obj->didReceiveRequest($username)) {
            echo '<input type="submit" name="respond_request" class="warning profileremove" style="" value="Request"><br>';  
          }
          else if ($logged_in_user_obj->didSendRequest($username)){
            echo '<input type="submit" name="" class="default profileremove" style="" value="Request Sent"><br>';  
          }
          
          else 
              echo '<input type="submit" name="add_friend" class="success profileremove" style="" value="Connect"><br>';  
          }
      
      
      
      ?>
      
    </form>
             
                    
<?php
                           if($userloggedin != $username) {
                   echo "<button type='button' class='btn'  style='margin-left: 200px; margin-top: -23px;' ><a href='#' onclick='openForm()'><i class='fa fa-envelope-o' style='font-size: 30px; width: 100%;color: #41b0ff;'></i><p  style='font-size: 10px;margin-left: 3px;'>Message</p></a></button>";
                           }
                                ?>  
 </div>
                </div>
            </div>

            <div class="col-lg-3 bta" style="position: fixed;right: 60px;top: 235px;">
    <div class="card social-timeline-card sow" style="">
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
      
        
                       <div class="chat-popup col-lg-3" id="myForm" >
                       <div class="card" style="height: 430px;" >
                                <div class="card-header" style="margin-top: 25px;height: 20px;">
                                <ul class="nav nav-tabs card-header-tabs" style="">
                            <li class="nav-item" style="top: -35px;width: 80%;">
                                <?php 
      
          echo "<a href='".$username."'><img src='" . $profile_user_obj->getProfilePic() ."' style='width: 10%;border-radius: 5%;'>&nbsp;&nbsp; " . $profile_user_obj->getFirstAndLastName() . "</a>";
    
            ?>
        </li>
            <button type="button" class="btn cancel" onclick="closeForm()" style="position: absolute;right: 0;top: 0;"><i class="fa fa-window-close" aria-hidden="true"></i></button>
             </ul>
             </div>
		 <div class="card-body" style="overflow: auto;" id="scroll_messages" > 
			<ul>
				<li class="sent">
				<?php echo $message_obj->getMessages($username); ?>
					 </li>
		
			</ul>
             </div>
		<div class="card-footer" style="height: 95px;">
                                  
		<form action="" method="POST" enctype="multipart/form-data">
           
              
                  <img src='asset/icon/index1.jpg' alt='' class='user-profile' onClick='triggerClick()' id='profileDisplay' style=  ' width: 20px;'>
                  <input type='file' name='fileToUpload' onChange='displayImage(this)' id='profileImage' style='display:none'>
                  
                  <img src='asset/icon/video.png' alt='' class='user-profile' onClick='triggerClicks()' id='profileDisplays' style=  ' width: 20px;'>
                 <input type='file' name='fileToUploads' onChange='displayImages(this)' id='profileImages' style='display:none'>
                  
                  <textarea name='message_body' class='form-control ' id='massage_textarea' style='background-color: transparent; border: -1px solid; height: 55px;'placeholder='Write your message ...'></textarea><br>
                 <button type='submit' name='post_message' class='send_icons' id='message_submit' style='width: 35px;right: -15px;' value=''><i class='fa fa-send-o upload-button' style='font-size: 20px;color: #41b0ff;'></i></button>
              
           
              </form>
			</div>
            
		
            
		 
                                
</div>  
                        </div>  
        
        </div>
  
    </main>
     

    
    <script>
    var userloggedin = '<?php echo $userloggedin; ?>';
    var profileUsername = '<?php echo $username; ?>';
          
    $(document). ready(function(){
        
        $('#loading').show();
        
        $.ajax({
            url: "Home/handlers/ajax_load_profile_posts.php",
            type: "POST",
            data: "page=1&userloggedin=" + userloggedin + "&profileUsername=" + profileUsername,
            cache: false,
            
            success: function(data) {
            $('#loading').hide();
            $('.posts_area').html(data);
        }
        });
        
        $(window).scroll(function(){
            var height = $('.posts_area').height();
            var scroll_top = $(this).scrollTop();
            var page = $('.posts_area').find('.nextPage').val();
            var noMorePosts = $('.posts_area').find('.noMorePosts').val();
            
            if ((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && noMorePosts == 'false') {
                $('#loading').show();
                
            var ajaxReq = $.ajax({
            url: "Home/handlers/ajax_load_profile_posts.php",
            type: "POST",
            data: "page=" + page + "&userloggedin=" + userloggedin + "&profileUsername=" + profileUsername,
            cache: false,
            
            success: function(data) {
            $('.posts_area').find('.nextPage').remove();
            $('.posts_area').find('.noMorePosts').remove();
            
                
                $('#loading').hide();
            $('.posts_area').append(data);
        }
        });
                
                
            }//end if
            
            return false;
       
        });//end
        
    });

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
  document.getElementById('opennow').addEventListener('click', function(){
      document.querySelector('.modal-container').style.display = 'flex';
  });
   
   document.querySelector('.closenow').addEventListener('click', function(){
    document.querySelector('.modal-container').style.display = 'none';
   });
    
</script>

<script>
  document.getElementById('opennow2').addEventListener('click', function(){
      document.querySelector('.modal_container').style.display = 'flex';
  });
   
   document.querySelector('.closenow2').addEventListener('click', function(){
    document.querySelector('.modal_container').style.display = 'none';
   });
    
</script>

<script>
  document.getElementById('opennow1').addEventListener('click', function(){
      document.querySelector('.modal-container2').style.display = 'flex';
  });
   
   document.querySelector('.closenow1').addEventListener('click', function(){
    document.querySelector('.modal-container2').style.display = 'none';
   });
    
</script>

<script>
  document.getElementById('opennowimage').addEventListener('click', function(){
      document.querySelector('.modalimage').style.display = 'flex';
  });
   
   document.querySelector('.closenowimage').addEventListener('click', function(){
    document.querySelector('.modalimage').style.display = 'none';
   });
    
</script>
<script>
function getUser(value, user){ 
       $.post("Home/handlers/ajax_profile_friend_search.php", {query:value, userloggedin:user}, function(data){
           $(".results").html(data);
       });
    }
</script>

<script>
function openForm() {
  document.getElementById("myForm").style.display = "block";
}

function closeForm() {
  document.getElementById("myForm").style.display = "none";
}
</script>

<script>
          var div = document.getElementById("scroll_messages");
          div.scrollTop = div.scrollHeight;
      </script>

<script>
   $(document).ready(function() {
       $("#emojimessage").emojioneArea({
           pickerPosition: "bottom"
       });
   })
</script>

<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}

// Get the element with id="defaultOpen" and click on it
document.getElementById("defaultOpen").click();
</script>



    










</body>
</html> 

