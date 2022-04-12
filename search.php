
<style>
* {box-sizing: border-box}
body {font-family: "Lato", sans-serif;}

/* Style the tab */
.tab {
    float: left;
border: none;
background-color: #121313;
width: 10%;
height: 300px;
}

/* Style the buttons inside the tab */
.tab button {
  display: block;
  background-color: inherit;
  color: black;
  padding: 22px 16px;
  width: 80%;
  border: none;
  outline: none;
  text-align: left;
  cursor: pointer;
  transition: 0.3s;
  font-size: 17px;
}

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: #ddd;
}

/* Create an active/current "tab button" class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
    float: left;
padding: 0px 12px;
border: none;
width: 70%;
border-left: none;
height: 550px;
overflow: auto;
}
</style>

            

<?php  
include("Home/header.php"); 
        

if(isset($_GET['q'])){
$query = $_GET['q'];
}

else{
    $query = "";
}

if(isset($_GET['q'])){
$querys = $_GET['q'];
}

else{
    $querys = "";
}

if(isset($_GET['type'])){
$type = $_GET['type'];
}

else{
    $type = "name";
}

if(isset($_GET['type'])){
$types = $_GET['type'];
}

else{
    $types = "post";
}
?>

<div class="container" style="">
               
                    
<div class="tab">
  <button class="tablinks" onclick="openCity(event, 'Names')" id="defaultOpen">Names</button>
  <button class="tablinks" onclick="openCity(event, 'Posts')">Posts</button>
</div>

<div id="Names" class="tabcontent"  style='overflow: auto; height: 500px;'>
   <?php 


    
    if($query == "")
        echo "Required";
    else{
        
  
if($type == "username") 
    $usersReturned = mysqli_query($conn, "SELECT * FROM register WHERE username LIKE '$query%' AND user_closed='no' LIMIT 8");
else{
    
    $names = explode(" ", $query);

    
if(count($names) == 3) 
    $usersReturned = mysqli_query($conn, "SELECT * FROM register WHERE (firstname LIKE '%$names[0]%' AND lastname LIKE '%$names[2]%') AND user_closed='no'");

else if(count($names) == 2) 
    $usersReturned = mysqli_query($conn, "SELECT * FROM register WHERE (firstname LIKE '%$names[0]%' OR lastname LIKE '%$names[1]%') AND user_closed='no'");
else
    $usersReturned = mysqli_query($conn, "SELECT * FROM register WHERE (firstname LIKE '%$names[0]%' OR lastname LIKE '%$names[0]%') AND user_closed='no'"); 
}
    

 if(mysqli_num_rows($usersReturned) == 0)
     echo "Not available " . $type . " like: " .$query;
    else
        echo mysqli_num_rows($usersReturned) . " results Found:";

    while($row = mysqli_fetch_array($usersReturned)) {
        
        $user_obj = new User($conn, $user['username']);
        
        if($row['username'] != $userloggedin) {
            $mutual_friends= $user_obj->getMutualFriends($row['username']) . " friends in common";
        }
        else{
           $mutual_friends = ""; 
        }
        
        $button = "";
        
     if($user['username'] != $row['username']){
         
          if($user_obj-> isFriend($row['username'])) 
               $button = "<button type='submit' name='" . $row['username'] . "' class='danger btn btn-primary' value='Disconnect'><i class='fa
                fa-user-times' aria-hidden='true'></i></button><br>";
          
        else if ($user_obj->didReceiveRequest($row['username'])) 
             $button = "<input type='submit' name='" . $row['username'] . "' class='warning btn btn-primary' value='Request'><br>";  
           
           else if ($user_obj->didSendRequest($row['username']))
             $button = "<input type='submit' class='default btn btn-primary' value='Request Sent'><br>";  
           
           
           else 
               $button = "<button type='submit' name='" . $row['username'] . "' class='success btn btn-primary' value='Connect'><i class='fa fa-user-plus' aria-hidden='true'></i>
               </button><br>";  
         
         if(isset($_POST[$row['username']])) {
             
             if($user_obj->isFriend($row['username'])) {
                 $user_obj->removeFriend($row['username']);
                 header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
             }
             else if($user_obj->didReceiveRequest($row['username'])) {
                 header("Location: request.php");
             }
             else if($user_obj->didSendRequest($row['username'])) {
                 
             }
             else{
                 $user_obj->sendRequest($row['username']);
                header("Location: http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
             
             }
         }
             
           }
       
     
   
        echo "<div class= 'card'><ul class='list-group pull-down searchfriend' id='contact-list' style='margin-left: 1px;width: 100%;'>
        <li class='list-group-item'>
          <div class='row w-100'>
          <div class='col-md-2 col-sm-3 col-xs-4' align='right' style='position: absolute; right: 27px;'>
          <form action='' method='POST'>
             " . $button . "
             <br>
             </form>
             <i style='font-size: 0.8rem;'>".$mutual_friends ."</i>
          </div>
          <a href= '" . $row['username'] . "' style='color: #000;    text-decoration: none;'>
          <div class='col-12 col-sm-6 col-md-3 px-0 searchpic' style=''>
          <img src='". $row['profile_pic'] . "' class='rounded-circle mx-auto d-block img-fluid' style='height: 100px;'>
          </div>
          
          <div class='col-md-9 col-sm-6 col-xs-5' style='margin-left: 50px;'>
          <div class='wrapper-box-title'>
          ".$row['firstname'] . " " . $row['lastname']."
          <h2 style='font-size: 0.6rem;'>". $row['username'] . " </h2></div>
          </div>
          </a>
          </div></li></ul></div><hr>";
          
    }
    }
    ?>
    </div>
  
    <div id="Posts" class="tabcontent" style='overflow: auto; height: 500px;'>
    <?php
        
        if($querys == "")
        echo "Required";
    else{
        
        if($types == "added_by") 
    $usersposts = mysqli_query($conn, "SELECT * FROM posts WHERE added_by LIKE '$querys%' AND user_closed='no' LIMIT 8");
else{
    
    $bodys = explode(" ", $querys);

    
if(count($bodys) == 3) 
    $usersposts = mysqli_query($conn, "SELECT * FROM posts WHERE (body LIKE '%$bodys[0]%' AND body LIKE '%$bodys[2]%') AND user_closed='no'");

else if(count($bodys) == 2) 
    $usersposts = mysqli_query($conn, "SELECT * FROM posts WHERE (body LIKE '%$bodys[0]%' OR body LIKE '%$bodys[1]%') AND user_closed='no'");
else
    $usersposts = mysqli_query($conn, "SELECT * FROM posts WHERE (body LIKE '%$bodys[0]%' OR body LIKE '%$bodys[0]%') AND user_closed='no'"); 
}

        if(mysqli_num_rows($usersposts) == 0)
     echo "Not available " . $types . " like: " .$querys;
    else
        echo mysqli_num_rows($usersposts) . " results Found:";

    while($rowposts = mysqli_fetch_array($usersposts)) {
        
        $id = $rowposts['id'];
            $body = $rowposts['body'];
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
                                 
                                 <video src='$videoPath' type='video/mp4' controls width='100%' height='300px' style='margin-left: -35px;'  >
                     </div>";               
                   }  
                    else{
                        $videoDiv="";
                       }  

                    

                
        
               echo "<div class='card social-timeline-card posttingss' style=''>
                    <div class='card-header'>
                        <div class='d-flex justify-content-between align-items-center'>
                            <div class='d-flex justify-content-between align-items-center'>
                                <div class='mr-2'>
                                    <img class='rounded-circle' width='45' src='$profile_pic' alt=''>
                                </div>
                                <div class='ml-2'>
                                <div class='h5 text-muted'><a href='$added_by' style='text-decoration: none;'> $firstname $lastname </a>  $user_to</div>
                                    <div class='h7 m-0 text-blue'>$username</div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='card-body'>
                        <div class='text-muted h7 mb-2'> <i class='fa fa-clock-o'></i>$time_message</div>
                        <spna class='card-link'>
                            <h6 class='card-asset'>$body<br> $imageDiv$videoDiv</h6>
                        </span>
                    </div>
                    <div class='card-footer'>
                    <div class='card-footer' style='background-color: transparent; border: none;'>
                    <div class='h11 text-muted' style='margin-top: -20px; font-size: 10px;'>Likes $likes_check_num</div>
<div class='h11 text-muted' style='margin-top: -15px; font-size: 10px;margin-left: 130px;'>Otuoma $comment_check_num</div>
                    </div>
                        <iframe src='like.php?post_id=$id' class='card-link' scrolling='no' style='height: 37px; margin-top: -12px; width: 102px; border: none;'></iframe>
                         <span class='card-link' onClick='javascript:toggle$id()' style= 'margin-top: -13px; position: absolute;'><i class='fa fa-comment' style='color: #41b0ff;'></i> Otuoma</span>
                        $delete_button
                    </div>
                </div>
                <div class='post_commentss' id='toggleComment$id' style='display:none;'>
                     <iframe src='comment_frame.php?post_id=$id' id='comment_iframes' frameborder='0'></iframe>
                     </div>";
           
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



