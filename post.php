<?php   
include("Home/header.php");


if(isset($_GET['id'])) {
    $id = $_GET['id'];
}
else{
    $id = 0;
}
?>


    <html style="background-color:#121313;">

<div class="container">

        
        <div class="row">
        <div class="col-lg-6 gedf-main postbody" style="">
         
      
      <?php 
       $post = new Post($conn, $userloggedin);
       $post->getSinglePost($id);
       ?>
            </div>
            </div>
       </div>

       
 
      