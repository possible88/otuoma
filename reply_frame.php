<?php 
require 'config/config.php'; 
include("Home/classes/User.php");  
        


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
        <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css"> 
          
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
               var element = document.getElementById("reply_section");
               
               if(element.style.display == "block")
                   element.style.display = "none";
               else
                   element.style.display = "block";
           }
        
        </script>

<?php  
        
        if(isset($_GET['reply_id'])) {
            $reply_id = $_GET['reply_id'];
        }
        
        $users_query = mysqli_query($conn, "SELECT posted_by, posted_to FROM comments WHERE id='$reply_id'");
        $user_row = mysqli_fetch_array($users_query);
        
        $replyed_to = $user_row['posted_by'];
        $replyed_to = $user_row['posted_to'];

        if(isset($_POST['replyComment' . $reply_id])) {
            $reply_body = $_POST ['reply_body'];
            $reply_body = mysqli_escape_string($conn, $reply_body);
            $check_empty = preg_replace('/\s+/','', $reply_body);

            if($check_empty != ""){
            $date_time_now = date("Y-m-d H:i:s");
             $insert_posts = mysqli_query($conn, "INSERT INTO reply VALUES ('', '$reply_body', '$userloggedin', '$replyed_to', '$date_time_now', 'no', '$reply_id')");
          

            }   
        }


?>

<form action="reply_frame.php?reply_id=<?php echo $reply_id; ?>" id="reply_form" name="replyComment<?php echo $reply_id; ?>"  method="POST" style="margin-top: 15px;">
<textarea name="reply_body" style="width: 85%; height: 34px; border-radius: 20px; font-size: 14px; margin: 3px 3px 3px 5px; padding: 5px;"></textarea>
        <input type="submit" name="replyComment<?php echo $reply_id; ?>" value="otuoma" style="border:none; background-color: #00ffff29; color: aqua; width: 12%; position: absolute; margin-top: 3px; height: 30px; border-radius: 20px;">
            
        </form>

        <?php 
        $get_replys = mysqli_query($conn, "SELECT * FROM reply WHERE reply_id='$reply_id' ORDER BY id DESC");
        $count = mysqli_num_rows($get_replys);
        
        if ($count != 0) {
            
            while($reply = mysqli_fetch_array($get_replys)) {
                $id = $reply['id'];
                $replys_body = $reply['reply_body'];
                $post_to = $reply['replyed_to'];
                $posted_by = $reply['replyed_by'];
                $date_added = $reply['date_added'];
                $romoved = $reply['removed'];


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
            &nbsp;&nbsp;&nbsp;<?php echo $time_message . "<br><br>&nbsp;&nbsp;&nbsp;&nbsp;"  . $replys_body; ?>&nbsp;&nbsp;&nbsp;&nbsp;<br>
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