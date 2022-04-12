<html>
    <head>
        <title></title>
        <link rel="stylesheet"  href="css/style.css">
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css" />
    </head>
    <body style="background-color: #121313;">
    
    <style type="text/css">
         *{
             font-size: 11px;
             font-family: Arial, Helvetica, sans-serif;
         }
        
        
        </style>
      
    
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
  
        if(isset($_GET['post_id'])) {
            $post_id = $_GET['post_id'];
        }
        
        $get_likes = mysqli_query($conn, "SELECT likes, added_by FROM posts WHERE id='$post_id'");
        $row = mysqli_fetch_array($get_likes);
        $total_likes = $row['likes'];
        $user_liked = $row['added_by'];
        
        $user_details_query = mysqli_query($conn, "SELECT * FROM register WHERE username='$user_liked'");
        $row = mysqli_fetch_array($user_details_query);
        $total_user_likes = $row['num_likes'];
        
        //like button
        if(isset($_POST['like_button'])) {
            $total_likes++;
            $query = mysqli_query($conn, "UPDATE posts SET likes='$total_likes' WHERE id='$post_id'");
            $total_user_likes++;
            $user_likes = mysqli_query($conn, "UPDATE register SET num_likes='$total_user_likes' WHERE username='$user_liked'");
            $inser_user = mysqli_query($conn, "INSERT INTO likes VALUES('', '$userloggedin', '$post_id')");
            
            if($user_liked != $userloggedin) {
              $notice = new Notice($conn, $userloggedin);
              $notice->insertNotice($post_id, $user_liked, "like");
          }
        }
        //unlike button
        if(isset($_POST['unlike_button'])) {
            $total_likes--;
            $query = mysqli_query($conn, "UPDATE posts SET likes='$total_likes' WHERE id='$post_id'");
            $total_user_likes--;
            $user_likes = mysqli_query($conn, "UPDATE register SET num_likes='$total_user_likes' WHERE username='$user_liked'");
            $inser_user = mysqli_query($conn, "DELETE FROM likes WHERE username='$userloggedin' AND post_id='$post_id'");
        }
        
        
        $check_query = mysqli_query($conn, "SELECT * FROM likes WHERE username='$userloggedin' AND post_id='$post_id'");
        $num_rows = mysqli_num_rows($check_query);
        
        if($num_rows > 0) {
            echo '<form action="like.php?post_id=' . $post_id . '" method="POST" >
            <input type="submit" class="h6 text-blue" name="unlike_button" value="Likes" style="border: none;font-size: 1.3rem; margin-top: 3px; background-color: #121313; color:aqua;">
            <div class="card-link" style="display: inline;color: #d22323; font-size:18px; background-color: #121313;"><i class="fa fa-gittip"></i>
        
            </div>
            </form>
            ';
        }
        else{
            echo '<form action="like.php?post_id=' . $post_id . '" method="POST" >
            <input type="submit" class="h6 text-muted" name="like_button" value="Like" style="border: none;font-size: 1.3rem; margin-top: 3px; background-color: #121313;  color:aqua;">
            <div class="card-link" style="display: inline;  color: #007bff; font-size:18px; background-color: #121313;"><i class="fa fa-gittip"></i>
            
            </div>
            </form>
            ';
        }
        
        
?>
   
   
    </body>
</html>










<script>
    $(document).ready(function () {

    $("#submitBtn").click(function () {

        var message_body = $("#message_body").val();
       

        if (message_body == '') {
            $("p").append('please fill all fields');
            return false;
        }

        $.ajax({
            type: "POST",
            url: "profile.php",
            data: {
                message_body: message_body
               
            },
            cache: false,
            success: function (data) {
               
                    $('p').append(data);
             
            },
            error: function (xhr, status, error) {
                console.error(xhr);
            }
        });

    });

});

</script>



<script>
    $(document).ready(function () {

    $("#submitBtn").click(function () {

        var message_body = $("#message_body").val();
       

        if (message_body == '') {
            $("p").append('please fill all fields');
            return false;
        }

        $.ajax({
            type: "POST",
            url: "profile.php",
            data: {
                message_body: message_body
               
            },
            cache: false,
            success: function (data) {
               
                    $('p').append(data);
             
            },
            error: function (xhr, status, error) {
                console.error(xhr);
            }
        });

    });

});

</script>