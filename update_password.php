<?php 
include("Home/header.php");
include("Home/handlers/settinghandler.php");

?>
<style>
html{
    background-color:#121313;}
</style>
<div class="container">
<div class="row">
        <div class="col-lg-4 pb-5">
            <!-- Account Sidebar-->
            <div class="author-card pb-3">
                <div class="author-card-cover"></div>
                <div class="author-card-profile">
                    <div class="author-card-avatar"><a href="<?php echo $userloggedin; ?>"><img src="<?php echo $user['profile_pic']; ?>" alt=""></a>
                    </div>
                    <div class="author-card-details">
                        <h5 class="author-card-name text-lg"><a href="<?php echo $userloggedin; ?>" style="text-decoration: none;">
                        <?php
                        echo $user['firstname']." ".$user['lastname'];
                         ?>
                     </a></h5><span class="author-card-position">Joined February 06, 2017</span>
                    </div>
                </div>
            </div>
            <div class="wizard">
                <nav class="list-group list-group-flush">
                    <a class="list-group-item" href="setting.php">
                        <div class="d-flex justify-content-between align-items-center">
                                <div class="d-inline-block font-weight-medium text-uppercase" style="margin-left: 9;">Update details</div>
                            </div><span class="badge badge-secondary"></span>
                    </a>
                    <a class="list-group-item" href="close_account.php"><i class="fe-icon-user"></i>Close Account</a>
                    <a class="list-group-item" href="#"><i class="fe-icon-map-pin text-muted"></i>About</a>
                    <a class="list-group-item" href="#">
                        <div class="d-flex justify-content-between align-items-center">
                            <div><i class="fe-icon-heart mr-1 text-muted"></i>
                                <div class="d-inline-block font-weight-medium text-uppercase">Terms & Condition</div>
                            </div><span class="badge badge-secondary"></span>
                        </div>
                    </a>
                    <a class="list-group-item" href="#">
                        <div class="d-flex justify-content-between align-items-center">
                            <div><i class="fe-icon-tag mr-1 text-muted"></i>
                                <div class="d-inline-block font-weight-medium text-uppercase">Help</div>
                            </div><span class="badge badge-secondary"></span>
                        </div>
                    </a>
                </nav>
            </div>
        </div>
        
        <div class="col-lg-8 pb-5">
         <form class="row" action="update_password.php" method="POST">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="account-pass">Current Password</label>
                        <input class="form-control" type="password" id="account-pass" name="oldpassword" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" maxlenght="100" required>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="account-confirm-pass">Confirm Password</label>
                        <input class="form-control" type="password" id="account-confirm-pass" name="confirmpassword" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" maxlenght="100" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="account-pass">New Password</label>
                        <input class="form-control" type="password" id="account-pass" name="newpassword" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" maxlenght="100" required>
                    </div>
                </div>
                
                <div class="col-12">
                    <hr class="mt-2 mb-3">
                    <?php  echo $password_message; ?>
                
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <input class="btn btn-style-1 btn-primary" type="submit" name="update-password" id="save_details" value="Update" data-toast="" data-toast-position="topRight" data-toast-type="success" data-toast-icon="fe-icon-check-circle" data-toast-title="Success!" data-toast-message="Your profile updated successfuly.">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>  