<?php  
include("Home/header.php"); 

if(isset($_GET['image'])){
$image = $_GET['image'];
}

$trend_query = mysqli_query($conn, "SELECT image FROM posts WHERE image='$image'");
$trend_row = mysqli_fetch_array($trend_query);
$trend_images = $trend_row['image'];

?>

<div class="container" style="">
                <div class="row">
                    <div class="col-md-12">
                    


   <?php 

if($trend_images == "")
echo "Required";
else{
 
 $trend_image = explode(" ",$trend_images);

    
if(count($trend_image) == 3) 
    $trend_post = mysqli_query($conn, "SELECT * FROM posts WHERE (image LIKE '%$trend_image[0]%' AND image LIKE '%$trend_image[2]%') AND user_closed='no'");

else if(count($trend_image) == 2) 
    $trend_post = mysqli_query($conn, "SELECT * FROM posts WHERE (image LIKE '%$trend_image[0]%' OR image LIKE '%$trend_image[1]%') AND user_closed='no'");
else
    $trend_post = mysqli_query($conn, "SELECT * FROM posts WHERE (image LIKE '%$trend_image[0]%' OR image LIKE '%$trend_image[0]%') AND user_closed='no'"); 


        if(mysqli_num_rows($trend_post) == 0)
     echo "Not available " . $trend_image;
    else
        echo mysqli_num_rows($trend_post) . " results Found:";

    while($rowposts = mysqli_fetch_array($trend_post)) {
        
        $id = $rowposts['id'];
            $trend_image = $rowposts['image'];
            $added_by = $rowposts['added_by'];
            $date_time = $rowposts['date_added'];
             $imagePath =  $rowposts['image'];
             $videoPath =  $rowposts['video'];
            
            if($rowposts['user_to'] == "none") {
                $user_to = "";
            }
            else{
                $user_to_obj = new User($conn, $rowposts['user_to']);
                $user_to_name = $user_to_obj->getFirstAndLastName();
                $user_to = "to <a href='". $rowposts['user_to']."'>" . $user_to_name . "</a>";
            }
            
             $added_by_obj = new User($conn, $added_by);
            if($added_by_obj->isClosed()) {
                return;
            }
            
                
            if($userloggedin == $added_by)
                $delete_button = "<button class='delete_button' id='post$id' style='border: none; background-color: transparent; float: right; margin-top: -13px;'><i class='fa fa-mail-forward'></i>delete</button>";
                else
                    $delete_button = "";
                
                
            $user_details_query = mysqli_query($conn, "SELECT firstname, lastname, username, profile_pic FROM register WHERE username='$added_by'");
            
                $user_row = mysqli_fetch_array($user_details_query);
            $firstname = $user_row['firstname'];
            $lastname = $user_row['lastname'];
            $profile_pic = $user_row['profile_pic'];
            $username=$user_row['username'];
            
            ?>
             <script>
                function toggle<?php echo $id; ?>() {
               
                var target = $(event.target);
                if (!target.is("a")) {
                  var element = document.getElementById("toggleComment<?php echo $id; ?>");
               
                  if(element.style.display == "block")
                   element.style.display = "none";
                   else
                   element.style.display = "block";   
                }
                
           }
             </script>  
            
               
            <?php
                
            $comments_check = mysqli_query($conn, "SELECT * FROM comments WHERE post_id='$id'");
            $comment_check_num = mysqli_num_rows($comments_check);

            $likes_check = mysqli_query($conn, "SELECT * FROM likes WHERE post_id='$id'");
            $likes_check_num = mysqli_num_rows($likes_check);
             
                
                
            $date_time_now = date("Y-m-d H:i:s");
            $start_date = new DateTime($date_time);
            $end_date = new DateTime($date_time_now);
            $interval = $start_date->diff($end_date);
            
            
            if($interval-> y >= 1) {
                if($interval == 1)
                    $time_message = $interval->y . "Y";
                else
                    $time_message = $interval->y . "Y";
                }
            else if ($interval-> m >= 1) {
                if($interval->d == 0){
                    $days = " ago";
                }
                else if($interval->d == 1) {
                    $days = $interval->d . " d";
                }
                else {
                    $days = $interval->d . " d";
                }
            
               if($interval->m == 1) {
                    $time_message = $interval->m . " mth";
                }
                else {
                    $time_message = $interval->m . " mth";
                }
            }
            else if($interval->d >= 1) {
                if($interval->d == 1) {
            $time_message = " Yesterday";
                }
                else {
                   $time_message = $interval->d . " d";
                }
                }
            else if($interval->h >= 1) {
               if($interval->h == 1) {
                    $time_message = $interval->h . " h";
                }
                else {
                    $time_message = $interval->h . " h";
                } 
            }
            else if($interval->i >= 1) {
               if($interval->i == 1) {
                    $time_message = $interval->i . " min";
                }
                else {
                    $time_message = $interval->i . " min";
                } 
            }
            else {
               if($interval->s <30) {
                    $time_message = " Just now";
                }
                else {
                    $time_message = $interval->s . " sec";
                } 
            }
                
            if($imagePath != "") {
                $imageDiv= "<div class='postedImage'>
                            
                            <image src='$imagePath' controls width='320px' height='200px' style='margin-left: -35px;'  >
                </div>";               
              }  
               else{
                   $imageDiv="";
                  }  
 
                  if($videoPath != "") {
                     $videoDiv= "<div class='postedImage'>
                                 
                                 <video src='$videoPath' image='video/mp4' controls width='100%' height='300px' style='margin-left: -35px;'  >
                     </div>";               
                   }  
                    else{
                        $videoDiv="";
                       }  

                    

                
        
               echo "<div class='col-lg-6 gedf-main' style='margin-left: 280px;max-width: 50%;'><div class='card social-timeline-card postting' style='top: 0px;width: 100%; left: 0px;'>
               <div class='card-header'>
                   <div class='d-flex justify-content-between align-items-center'>
                       <div class='d-flex justify-content-between align-items-center'>
                           <div class='mr-2'>
                               <img class='rounded-circle' width='45' src='$profile_pic' alt=''>
                           </div>
                           <div class='ml-2'>
                           <div class='h5 text-muted'><a href='$added_by' style='text-decoration: none;'> $firstname $lastname </a></div>
                               <div class='h7 m-0 text-blue'>$username</div>
                               
                           </div>
                       </div>
                   </div>
               </div>
               <div class='card-image'>
                   <div class='text-muted h7 mb-2'> <i class='fa fa-clock-o'></i>$time_message</div>
                   <spna class='card-link'>
                       <h5 class='card-image'>$trend_image<br> $imageDiv$videoDiv</h5>
                   </span>
               </div>
               <div class='card-footer'>
               <div class='card-footer' style='background-color: transparent; border: none;'>
               <div class='h11 text-muted' style='margin-top: -20px; font-size: 10px;'>Likes $likes_check_num</div>
<div class='h11 text-muted' style='margin-top: -15px; font-size: 10px;margin-left: 80px;'>Otuoma $comment_check_num</div>
               </div>
                   <iframe src='like.php?post_id=$id' class='card-link' scrolling='no'  style='height: 37px; margin-top: -12px; width: 102px; border: none;'></iframe>
                    <span class='card-link' onClick='javascript:toggle$id()' style= 'margin-top: -13px; position: absolute;'><i class='fa fa-comment' style='color: #41b0ff;'></i> Otuoma</span>
                   $delete_button
               </div>
           </div>
           <div class='post_comments' id='toggleComment$id' style='display:none;margin-top: -30px;width: 100%;'>
                <iframe src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder='0'></iframe>
                </div></div>";
       
           
            ?>
            <script>
                $(document).ready(function() {
                    
                    $('#post<?php echo $id; ?>').on('click', function() {
                        bootbox.confirm("Delete Otuoma?", function(result) {
                            $.post("Home/Rconfig/delete_post.php?post_id=<?php echo $id; ?>", {result:result});
                            
                            if(result)
                                location.reload();
                        });
                    });
                });

</script>


            <?php   
                }
       
        
            
            }

    
    
    
    ?> 
    
 
</div>
</div>
</div>



















