<?php 
include("Home/header.php"); 

$message_obj = new Message($conn, $userloggedin);

?>
<style>
    html{
    background-color:#121313;}
   
   
</style>

<main>
    <div class="container">
       
        
       
            <div class="col-lg-3 postpicture" style="max-width: 200px;position: fixed; ">
                <div class="card postpics">
                    <div class="card-body ">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators bta">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class=""></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1" class=""></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2" class="active"></li>
                            </ol>
                            <div class="carousel-inner" style="border-radius: 65px; height: 135px;">
                                <div class="carousel-item">
                                    <a href="<?php echo $userloggedin; ?>"><img src="<?php echo $user['profile_pic']; ?>" class="d-block w-100" alt="..."></a>
                                </div>
                                <div class="carousel-item">
                                    <a href="<?php echo $userloggedin; ?>"><img src="<?php echo $user['profile_pic']; ?>" class="d-block w-100" alt="..."></a>
                                 </div>
                                <div class="carousel-item active">
                                    <a href="<?php echo $userloggedin; ?>"><img src="<?php echo $user['profile_pic']; ?>" class="d-block w-100" alt="..."></a>
                                </div>
                            </div>
                            <a class="carousel-control-prev bta" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next bta" href="#carouselExampleIndicators" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                     <li class="list-group-item bta">
                            <div class="h4"><a href="messages.php?u=new" style="text-decoration: none;"> <i class="fa fa-envelope-o" style="font-size: 30px; width: 75px; color: #41b0ff; height: 47px;"></i> </a></div>
                        </li>
                </div>
                   
                   <div class="card bta" style="top: -60px;">
                    <div class="card-body">
                       <div class="h5 "><a href="<?php echo $userloggedin; ?>" style="text-decoration: none;"> <?php
                        echo $user['firstname']." ".$user['lastname'];?></a></div>
                     <div class="h8 text-blue"><?php echo $user['username']; ?></div>
                        </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="h7 text-muted">Likes</div>
                            <div class="h8"><?php echo $user['num_likes']; ?></div>
                        </li>
                        <li class="list-group-item">
                            <div class="h7 text-muted">Otuoma</div>
                            <div class="h8"><?php echo $user['num_posts']; ?></div>
                        </li>
                        
                    </ul>
                </div>
                
            </div>
            <div class="col-lg-6 gedf-main postbody" style="">
                <!--- \\\\\\\Post-->
          
                <!-- Post /////-->
                <!--- \\\\\\\Post-->
                <div class="posts_area"></div>
    <img id="loading" src="asset/icon/loading.gif" style="width: 20%;">


                <!-- Post /////-->
                <!--- \\\\\\\Post-->
                 </div>
    
    <div class="col-lg-3 bta" style="position: fixed;right: 120px;max-width: 20%;top: 100px;">
    <div class="card social-timeline-card" style="width: 100%;height: 265px;overflow: auto;">
    <div class='card-header' style='height: 40px;'>
    <h4 class="card-title">Trending</h4>
    </div>
    <div class="card-body">
                       
                      
                       
		
    <div class="trends">
			<?php
			$query = mysqli_query($conn, "SELECT * FROM trends ORDER BY hits DESC LIMIT 9");

			foreach($query as $row){

                $id = $row['id'];
                $word = $row['title'];
                $hits = $row['hits'];
				$word_dot = strlen($word) >= 14 ? "..." : "";

				$trimmed_word = str_split($word, 14);
				$trimmed_word = $trimmed_word[0];

				echo "<a href='trend.php?title=$word'><div style='padding: 1px'>
				 $trimmed_word$word_dot <div style='float:right'> $hits
				</div></div></a>";


			}

			?>
		</div>
                            
                       
                    </div>   
       
</div>
        </div>

         
    <div class="col-lg-3 bta peopletoknow" style="
position: fixed;max-width: 20%;top: 368px;">
    <div class="card social-timeline-card" style="width: 100%;height: 265px;overflow: auto;">
    <div class='card-header' style='height: 40px;'>
    <h5 class="card-title">People you may know</h5>
    </div>
    <div class="card-body">
                        
                        <ul class="friend-list">
                        
                            
                        </ul>
                    </div>   
</div>
             
        </div>

        <div class="h4"><a href="#" class='active' id="opennow12" style="text-decoration: none; position: fixed; top: 550px; right: 20px;"> <i class="fa fa-paper-plane" style="font-size: 30px; width: 75px; color: #41b0ff; height: 47px;"></i> </a></div>
        <div class="modal-container12">
        <button type="button" class="closenow11"><i class="fa fa-window-close" aria-hidden="true"></i></button>
            
            <div class="card" style="overflow: auto; height: 400px;">
            <div class='card-header' style='background-color: #41b0ff;height: 35px;'>
            </div>
            <ul class="list-group list-group-flush">
                        <li class="list-group-item">
						 <?php echo $message_obj->getConvos(); ?>
				</li>
			</ul>   
                
                
            </div>
            
            
            
            
        </div>             
            
    
    </div>
    

</main>




              
<script>
    var userloggedin = '<?php echo $userloggedin; ?>';
    
    $(document). ready(function(){
        
        $('#loading').show();
        
        $.ajax({
            url: "Home/handlers/ajax_load_posts.php",
            type: "POST",
            data: "page=1&userloggedin=" + userloggedin,
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
            url: "Home/handlers/ajax_load_posts.php",
            type: "POST",
            data: "page=" + page + "&userloggedin=" + userloggedin,
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
  document.getElementById('opennow12').addEventListener('click', function(){
      document.querySelector('.modal-container12').style.display = 'flex';
  });
   
   document.querySelector('.closenow11').addEventListener('click', function(){
    document.querySelector('.modal-container12').style.display = 'none';
   });
    
</script>
 










</html> 


<!--$user_details_query = mysqli_query($conn, "SELECT * FROM register WHERE email='$userloggedin'");
    $user = mysqli_fetch_array($user_details_query);
        