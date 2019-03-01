<?php 
if(!session_id()) 
{
	session_start();
}
if(isset($_GET['shears_login_submit'])) 
{
 
	// date_default_timezone_set("Asia/Karachi");
	$shears_email = $_GET['shears_email'];
	$shears_password = $_GET['shears_password'];
	
	// validation
	$errors = 0;
    if (empty($shears_email)) 
    {
      $emailErr = "Email/User Login is required";
      $errors += 1;
    } 
    else 
    {
  		$shears_email = shears_test_input($shears_email);
      	// check if e-mail address is well-formed
		if (!filter_var($shears_email, FILTER_VALIDATE_EMAIL)) 
  		{
			// it's not a email
			$userlogin_emailStatus = true ;
    	
  		}
  		else
      	{
			// it's not a login
      		$userlogin_emailStatus = false;
      	}
    }

    //password
    if (empty($shears_password)) {
      $passwordErr = "Password is required";
      $errors += 1;
    }
    else 
    {
  		$shears_password = shears_test_input($shears_password);
    }
    // var_dump($emailErrSts);
    if($errors == 0) {
		//REMEMBER ME
		if(isset($_GET['shears_remember']))
		{
			$remember_me = true;
		}
		else
		{
			$remember_me = false;
		}

		if ( $userlogin_emailStatus == true ) {
			$get_user = get_user_by( 'login', $shears_email );
		}
		else
		{
			$get_user = get_user_by( 'email', $shears_email );
			
		}
		
		//$get_user = get_user_by( 'email', $shears_email );
		if($get_user != false) {
			$user_role = $get_user->roles[0];
			if($user_role == 'administrator'){
				$user_status = 1;
			}
			else
			{
				$user_status = get_user_meta( $get_user->ID, 'shears_user_status', true );
			}
			if($user_status == 2){
				$passwordErr = "Your request is still in progress.. Have Patience..!!!";
			}
			else if( $user_status == 1 )
			{

				if ( wp_check_password( $shears_password, $get_user->data->user_pass, $get_user->ID) )
				{
					$creds = array(
					    'user_login'    => $get_user->data->user_login,
					    'user_password' => $shears_password,
					    'remember'      => $remember_me
					);
	    			$user = wp_signon( $creds, false );
					if ( is_wp_error( $user ) ) {
						 $passwordErr = "Can't login";
					    //return $user->get_error_message();
					}
					else
					{	
						$redirect_dashboard = home_url( '/shears-dashboard' );
						wp_redirect( $redirect_dashboard );
					}	
				}
				else
				{
	   				$passwordErr = "Password is inncorrect";	
				}
			}
			elseif($user_status == 2){
				$passwordErr = "You are disabled by an admin. Contact to an admin.";
			}
			elseif($user_status == 3){
				$passwordErr = "You'r Account is off. Contact to an Admin.";
			}	
		}
		else 
		{
			$emailErr = "User with this email doesn't exists";
		}
    }

}
$current_user = wp_get_current_user();
if($current_user->ID == 0)
{ ?>
<div id="register_area">
		<h1>login</h1>
		<?php 
		if(isset($emailErr) || isset($passwordErr))
		{
			if(isset($emailErr)) 
			{
				$errMsg = $emailErr;
			}
			else if(isset($passwordErr))
			{
				$errMsg = $passwordErr;
			}

		?>
		<div class="clearfix" style="color: red;">
			<strong>Oops!</strong> <?php echo $errMsg; ?>
		</div>
  <?php } 


  ?>
	
		<form>
		<div class="filed">
			<i class="fa fa-user"></i>
			<input type="text" name="shears_email" id="shears_email" placeholder="User name" value="<?php echo isset($_GET['shears_email']) ? $_GET['shears_email'] : ''; ?>">
		</div>
		<div class="filed">
			<i class="fa fa-lock"></i>
			<input type="password" id="shears_password" name="shears_password" placeholder="password" value="<?php echo isset($_GET['shears_password']) ? $_GET['shears_password'] : ''; ?>">
		</div>
		<div class="field">
			<label class="containerform">Remember me
  			  	<input type="checkbox" id="shears_remember" name="shears_remember" <?php echo isset($_GET['shears_remember']) ? 'checked' : ''; ?> >
				<span class="checkmark"></span>
			</label>
			<a href="<?php echo wp_lostpassword_url(); ?>" class="forgot-pass">Forgot Password?</a>
			<div class="clearfix"></div>
		</div>
		<input type="hidden" name="shears_login_submit">
		<input type="submit" class="button-submit" value="Login" style="color: black">
	</form>
</div>

<?php 
}
else
{
	wp_redirect(home_url('/shears-dashboard'));						
}
?>
