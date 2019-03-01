<?php
 	
$current_user = wp_get_current_user();

if($current_user->ID == 0)
{
	wp_redirect(home_url('/shears-login'));
}
if( current_user_can('administrator')) {
   	wp_redirect(home_url());	
}

if( isset( $_GET['post_status'] ) && isset( $_GET['post_id'] ) && isset( $_GET['post_user_ids'] ) )
{
	$post_status = $_GET['post_status'];
	$post_id = $_GET['post_id'];
	$get_user_idss = $_GET['post_user_ids'];

	$user_membership_status =get_user_meta( $current_user->ID, 'shears_membership_status', true);
	if( $user_membership_status != '')
	{
		if($user_membership_status == 1){
			$user_status = 'free';
		}
		else
		{
			$user_status = 'paid';
		}

		//echo $post_status;
		if($user_status == $post_status )
		{
			$single_post = get_post($post_id);
			$image = get_the_post_thumbnail_url( $post_id );
			if($image != false){
				$post_img = $image;
			}
			else
			{
				$post_img = plugins_url('shears_membership/assets/images/empty.png');
			}
		 include 'include-file01.php'; 
		?>
	
				<div id="content-rhs">
				<!-- <h1>Lorem ipsum</h1> -->
					<div id="card">
						<h3><?php echo $single_post->post_title; ?></h3>
						<p><?php echo $single_post->post_content; ?></p>
						<img src="<?php echo $post_img; ?>" width="500px" height="500px">
					</div>
				</div>
			</div>
			<script type="text/javascript">
					function myFunction() {
			  			document.getElementById("myDropdown").classList.toggle("show");
					}
			</script>		
	<?php 
		}
		else
		{
			wp_redirect(home_url('/shears-dashboard'));
		}
  	}
  	else
  	{
		wp_redirect(home_url('/shears-dashboard'));
  	}			
	      			
}
else
{
	wp_redirect(home_url('/shears-dashboard'));
}
