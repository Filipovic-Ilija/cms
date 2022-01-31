<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>


<?php 



if(!isset($_GET['email']) && !isset($_GET['token'])){
    redirect('index');
}


   //$email = "peter@gmail.com";

   //$token = '4f7e13adb07b9fd32daaecb7c1d69a0344d471dc30d73944356ed9125ce9711a75677d1c3c7300b84166806f064ffc096901';

   if($stmt = mysqli_prepare($connection, 'SELECT username, user_email, token FROM users WHERE token=?')){

        mysqli_stmt_bind_param($stmt, "s", $_GET['token']);

        mysqli_stmt_execute($stmt);

        mysqli_stmt_bind_result($stmt, $username, $user_email, $token);

        mysqli_stmt_fetch($stmt);

        mysqli_stmt_close($stmt);

        //if($_GET['token'] !== $token || $_GET['email'] !== $email){
         //   redirect('index');
        //}

        if(isset($_POST['password']) && isset($_POST['confirmPassword'])){
                if($_POST['password'] === $_POST['confirmPassword']){
                    $password = $_POST['password'];
                    $hashedPassword = password_hash($password, PASSWORD_BCRYPT, array('cost'=>12));

                    if($stmt = mysqli_prepare($connection, "UPDATE users SET token='', user_password='{$hashedPassword}' WHERE user_email=?")){

                            mysqli_stmt_bind_param($stmt, "s", $_GET['email']);
                            mysqli_stmt_execute($stmt);

                            if(mysqli_stmt_affected_rows($stmt) >= 1) {

                                    header("Location: /cms/login.php");

                            }       
                            
                            mysqli_stmt_close($stmt);
                            

                    }          
                    
                }
        }

   }

?>

<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">

  

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Reset Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">

                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                    <div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
											<input id="password" name="password" type="password" class="form-control" placeholder="Enter Password">
										</div>
									</div>
                                    <div class="form-group">
										<div class="input-group">
											<span class="input-group-addon"><i class="glyphicon glyphicon-lock color-blue"></i></span>
											<input id="confirmPassword" name="confirmPassword" type="password" class="form-control" placeholder="Confirm Password">
										</div>
									</div>

                                    <div class="form-group">
                                    <input name="resetPassword" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                    </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                    </form>

                                </div><!-- Body-->

                                <h2>Please check your email</h2>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

     

    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->