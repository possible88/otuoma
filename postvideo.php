<?php 
include("Home/header.php"); 



if(isset($_POST['post'])){
    
   $upload = 1;
  $videoName = $_FILES['fileToUploads']['name'];
  
     if($videoName != "") {
        $targetDirs = "asset/img/posts/video/";
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


  
        
        if($upload) {
            if(move_uploaded_file($_FILES['fileToUploads']['tmp_name'], $videoName)) {
                
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
                                   
                                    
                <form class="post_form" action="postvideo.php" method="POST" enctype="multipart/form-data">
                                   
                <input type="file" name="fileToUploads" onChange="displayImages(this)" id="profileImages" style="display:none">
                                    <textarea name="post_text" class="form-control postwrite" id="emojimessage" rows="3" style="background-color: transparent; border: -1px solid; width:95%;display:none" placeholder="What are you thinking?"></textarea>
                                    <button type="submit" name="post" id="post_button" value="" class="send_icon" style="top: 60px;"><i class="fa fa-send-o upload-button" style="font-size: 20px;color: #41b0ff;margin: -10px;"></i></button>
                                   
                                     <video src="asset/img/posts/video/5f52353b4bbe4VID-20200508-WA0003.mp4" alt="" class="user-profile" onClick="triggerClicks()" id="profileDisplays" style="width: 50%;right: -242px;top: 0px;border-radius: 5px;position: absolute;"/>
                                    
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
       $("#emojimessage").emojioneArea({
           pickerPosition: "bottom"
       });
   })
   </script>