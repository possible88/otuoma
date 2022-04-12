<?php 
require 'config/config.php'; 
include("Home/classes/User.php");
include("Home/classes/Post.php");
include("Home/classes/notice.php");
        


if(isset($_SESSION['username'])){
    $userloggedin = $_SESSION['username'];
    $user_details_query = mysqli_query($conn, "SELECT * FROM register WHERE email='$userloggedin' or username='$userloggedin' or phone='$userloggedin'");
    $user = mysqli_fetch_array($user_details_query);
    }
 else { 
     header("location:login.php");
 }
             
?>
  
   <html style="background-color:#121313;">
    <head>
        <title></title>
        
    </head>

    <body>
     
     <style type="text/css" >
         *{
             font-size: 11px;
             font-family: Arial, Helvetica, sans-serif;
         }
        
        
        </style>
      
      
       <script>
           function toggle(){
               var element = document.getElementById("comment_section");
               
               if(element.style.display == "block")
                   element.style.display = "none";
               else
                   element.style.display = "block";
           }
        
        </script>
        
        <?php  
        
        if(isset($_GET['post_id'])) {
            $post_id = $_GET['post_id'];
        }
        
        $user_query = mysqli_query($conn, "SELECT added_by, user_to FROM posts WHERE id='$post_id'");
        $row = mysqli_fetch_array($user_query);
        
        $posted_to = $row['added_by'];
        $user_to = $row['user_to'];
        
        if(isset($_POST['postComment' . $post_id])) {
           $post_body = $_POST ['post_body'];
           $post_body = mysqli_escape_string($conn, $post_body);
           $check_empty = preg_replace('/\s+/','', $post_body);
         
      if($check_empty != ""){
            $date_time_now = date("Y-m-d H:i:s");
            $insert_post = mysqli_query($conn, "INSERT INTO comments VALUES ('', '$post_body', '$userloggedin', '$posted_to', '$date_time_now', 'no', '$post_id')");
          
         if($posted_to != $userloggedin) {
              $notice = new Notice($conn, $userloggedin);
              $notice->insertNotice($post_id, $posted_to, "comment");
          } 
          if($user_to != 'none' && $user_to != $userloggedin){
           $notice = new Notice($conn, $userloggedin);
           $notice->insertNotice($post_id, $user_to, "profile_comment");   
          }
          
          $get_commenters = mysqli_query($conn, "SELECT * FROM comments WHERE post_id='$post_id'");
          $notice_users = array();
          while($row = mysqli_fetch_array($get_commenters)) {
          
        if($row['posted_by'] != $posted_to && $row['posted_by'] != $user_to && $row['posted_by'] != $userloggedin && !in_array($row['posted_by'], $notice_users)) {
              
           $notice = new Notice($conn, $userloggedin);
        $notice->insertNotice($post_id, $row['posted_by'], "comment_non_owner");  
              
              array_push($notice_users, $row['posted_by']);
          }
          }
        }
        }
        ?>
        
        <form action="comment_frame.php?post_id=<?php echo $post_id; ?>" id="comment_form" name="postComment<?php echo $post_id; ?>"  method="POST">
        <textarea name="post_body" style="width: 85%; height: 34px; border-radius: 20px; font-size: 14px; margin: 3px 3px 3px 5px; padding: 5px;"></textarea>
        <input type="submit" name="postComment<?php echo $post_id; ?>" value="otuoma" style="border:none; background-color: #00ffff29; color: aqua; width: 12%; position: absolute; margin-top: 3px; height: 30px; border-radius: 20px;">
        
        </form>
        
        <?php 
        $get_comments = mysqli_query($conn, "SELECT * FROM comments WHERE post_id='$post_id' ORDER BY id DESC");
        $count = mysqli_num_rows($get_comments);
        
        if ($count != 0) {
            
            while($comment = mysqli_fetch_array($get_comments)) {
                $id = $comment['id'];
                $comment_body = $comment['post_body'];
                $post_to = $comment['posted_to'];
                $posted_by = $comment['posted_by'];
                $date_added = $comment['date_added'];
                $romoved = $comment['removed'];

                ?>
<script>
function toggle<?php echo $id; ?>(){
               var element = document.getElementById("toggleReply<?php echo $id; ?>");
               
               if(element.style.display == "block")
                   element.style.display = "none";
               else
                   element.style.display = "block";
           }
</script>
                <?php

            $date_time_now = date("Y-m-d H:i:s");
            $start_date = new DateTime($date_added);
            $end_date = new DateTime($date_time_now);
            $interval = $start_date->diff($end_date);
            
            
            if($interval-> y >= 1) {
                if($interval == 1)
                    $time_message = $interval->y . " Y ";
                else
                    $time_message = $interval->y . " Y ";
                }
            else if ($interval-> m >= 1) {
                if($interval->d == 0){
                    $days = " ago";
                }
                else if($interval->d == 1) {
                    $days = $interval->d . " d ";
                }
                else {
                    $days = $interval->d . " d ";
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
                   $time_message = $interval->d . " d ";
                }
                }
            else if($interval->h >= 1) {
               if($interval->h == 1) {
                    $time_message = $interval->h . " h ";
                }
                else {
                    $time_message = $interval->h . " h ";
                } 
            }
            else if($interval->i >= 1) {
               if($interval->i == 1) {
                    $time_message = $interval->i . " min ";
                }
                else {
                    $time_message = $interval->i . " min ";
                } 
            }
            else {
               if($interval->s <30) {
                    $time_message = " Just now";
                }
                else {
                    $time_message = $interval->s . " sec ";
                } 
            }
                
            $user_obj = new User($conn, $posted_by);
            
            ?>
        <div class="comment_section" style= "padding: 0px 5px 5px 5px;" ></div>
            <a href="<?php echo $posted_by?>" target="_parent"><img src="<?php echo $user_obj->getProfilePic();?>" title="<?php echo $posted_by; ?>" style="float: left; border-radius:100px;" height="30"></a>&nbsp;&nbsp;&nbsp;
            <a href="<?php echo $posted_by?>" target="_parent" style="text-decoration: none;color: aqua;"> <b> <?php echo $user_obj->getFirstAndLastName(); ?> </b></a>
            &nbsp;&nbsp;&nbsp;<?php echo $time_message; ?> <br><br>&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $comment_body; ?>&nbsp;&nbsp;&nbsp;&nbsp;<br><br>
            <span class="card-link" onClick="javascript:toggle<?php echo $id; ?>()" style= "position: absolute; margin-left: 20px;color: #23506f;"><i class="fa fa-comment" style="color: #41b0ff;"></i>Reply</span>
            <div class="reply_comment" id="toggleReply<?php echo $id; ?>" style="display:none;">
            <iframe src="reply_frame.php?reply_id=<?php echo $id; ?>" id="comment_iframe" frameborder="0" style="width: 100%"></iframe>
            </div><br><br>
            <p style="border-bottom: 1px solid aqua;"></p>
            
            

            <?php
            }
        }
        else{
            echo "<center><br><br>No otuoma</center>";
        }
        ?>
        
       
        
              
    </body>
</html>