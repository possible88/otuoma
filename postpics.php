<?php 
include("Home/header.php"); 



if(isset($_POST['post'])){
    
   $upload = 1;
   $imageName = $_FILES['fileToUpload']['name'];
  if($imageName != "") {
        $targetDir = "asset/img/posts/image/";
        $imageName = $targetDir . uniqid() . basename($imageName);
        $imageFileType = pathinfo($imageName, PATHINFO_EXTENSION);
        
        if(strtolower($imageFileType) != "jpeg" && strtolower($imageFileType) != "png" && strtolower($imageFileType) != "jpg" && strtolower($imageFileType) != "gif") {
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
    
    if($upload) {
       $post = new Post($conn, $userloggedin);
       $post->submitPost($_POST['post_text'], 'none', $imageName, $videoName); 
    }
    else{
        echo "<div style='text-align:center;' class='error'>
             errorMessage
            </div>";
    }
    
}

?>
                    <div class="container">
       
        
        <div class="row" style="margin-right: -140px;">
                               <div class="col-lg-6 gedf-main" style="margin-left: 200px;max-width: 40%;">
 
                   <div class="card social-timeline-card" style="">
                    <div class="card-header card_headers card_headers1" style="">
                        <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                            <li class="nav-item" style="top: -25px;">
                                <button type="button" class="btn" style="right: -455px;position: absolute;top: -14px;"><a href="beginner.php" class="user-profile" style=" width: 20px;  "><i class="fa fa-window-close" aria-hidden="true"></i>
</a></button>
                            </li>
                                  
                        </ul>
                    </div>
                    <div class="card-body">     
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade active show" id="posts" role="tabpanel" aria-labelledby="posts-tab">
                                <div class="form-group">
                                    <label class="sr-only" for="message">post</label>
                                   
                                    
                <form class="post_form" action="postpics.php" method="POST" enctype="multipart/form-data">
                                   
               <input type="file" name="fileToUpload" onChange="displayImage(this)" id="profileImage" style="display:none ">
                                    <textarea name="post_text" class="form-control postwrite" id="emojimessage" rows="3" style="display:none;background-color: transparent; border: -1px solid; width:95%;" placeholder="What are you thinking?"></textarea>
                                    <img src="asset/img/profile_pic/default/images.jpg" alt="" class="user-profile" onClick="triggerClick()" id="profileDisplay" style="width: 50%;right: -242px;top: 0px;border-radius: 5px;position: absolute;">
                                    
                                    <button type="submit" name="post" id="post_button" value="" class="send_icon" style="top: 60px;"><i class="fa fa-send-o upload-button" style="font-size: 20px;color: #41b0ff;margin: -10px;"></i></button>
                                    </form>                              
                                   
                </div>
                </div>
                </div>
                </div>
                </div>
            </div>
                        </div>
</div>


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
   $(document).ready(function() {
       $("#emojimessage").emojioneArea({
           pickerPosition: "bottom"
       });
   })
   </script>

   <script>
    function triggerClick(e) {
  document.querySelector('#ImagePost').click();
}
function PostImage(e) {
  if (e.files[0]) {
    var reader = new FileReader();
    reader.onload = function(e){
      document.querySelector('#imageDisplay').setAttribute('src', e.target.result);
    }
    reader.readAsDataURL(e.files[0]);
  }
}
   </script>