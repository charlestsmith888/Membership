<?php
if( isset($_GET['shear-post-view']) ) {
	$post_status = $_GET['post_status'];  	
	$post_id = $_GET['post_id'];
	$post_user_ids = $_GET['post_user_ids'];

	$redirect_url = 
	home_url('/shears-single/?post_status='.$post_status.'&post_id='.$post_id.'&post_user_ids='.$post_user_ids);
	wp_redirect($redirect_url);
}
$current_user = wp_get_current_user();
if($current_user->ID != 0)
{ 
	$user_membership_status =get_user_meta( $current_user->ID, 'shears_membership_status', true);

	include 'include-file01.php';
?>	
	
	<div id="content-rhs">
	<!-- <h1>Lorem ipsum</h1> -->
		<div id="card">
			<table id="example" class="cell-border" style="width:100%">
        <thead>
            <tr>
             	<th>#</th>
	      		<th>Title</th>
		     	<th>Image</th>
		      	<th>More Info</th>
            </tr>
        </thead>
        <tbody>
       <?php
				$posts_per_page = -1;
				$args = array(
					'post_type' => 'shear_post',
					'posts_per_page' => $posts_per_page,
					'paged' => get_query_var('paged') ? get_query_var('paged') : 1
				);
				$shear_query = new WP_Query( $args );
				// The Loop
				if ( $shear_query->have_posts() ) {
					$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
					$offset = ( $page * $posts_per_page ) - $posts_per_page;
					while( $shear_query->have_posts() ) {
						$shear_query->the_post();
						
						$current_postID = get_the_ID();

						$post_user_idss = get_post_meta( $current_postID, 'shears_members_id', true );

						// free or paid
						$shears_options_status = get_post_meta( $current_postID, 'shears_options_status', true);
						
						if($user_status == $shears_options_status )
						{
							$post_user_ids = explode(",",$post_user_idss);
							if( count( $post_user_ids ) == 1 && in_array(0 , $post_user_ids) )
							{ ?>
								<tr>
						      		<td>
						      			<?php echo $offset+1; $offset++; ?>
					      			</td>
							      	<td><b><?php the_title(); ?></b></td>
							      	<td>
							      		<?php 
							      			$image = get_the_post_thumbnail_url( $current_postID );
							      			if($image != false){
							      				$post_img = $image;
							      			}
							      			else
							      			{
							      				$post_img = plugins_url('shears_membership/assets/images/empty.png');
							      			}
							      		?>

							      		<center><img src="<?php echo $post_img; ?>" width="150px" height="150px"></center>
							      	</td>
							      	<td>
							      	<center>
						      		<form method="get">
						      			<input type="hidden" name="post_id" value="<?php echo $current_postID; ?>">
							      		<input type="hidden" name="post_user_ids" value="<?php echo $post_user_idss; ?>">
							      		<input type="hidden" name="post_status" value="<?php echo $shears_options_status; ?>">
						      			<input type="hidden" name="shear-post-view">
		  								<button type="submit" class="view-btn">Submit</button>
									</form>
									</center>
							      	</td>
						    	</tr>

							<?php 
							}
							else if (in_array($current_user->ID, $post_user_ids))
						  	{ ?>
		  		 				<tr>
						      		<td>
						      			<?php echo $offset+1; $offset++; ?>
					      			</td>
							      	<td><b><?php the_title(); ?></b></td>
							      	<td>
							      		<?php 
							      			$image = get_the_post_thumbnail_url( $current_postID );
							      			if($image != false){
							      				$post_img = $image;
							      			}
							      			else
							      			{
							      				$post_img = plugins_url('shears_membership/assets/images/empty.png');
							      			}
							      		?>

							      		<center><img src="<?php echo $post_img; ?>" width="150px" height="150px"></center>
							      	</td>
							      	<td>
							      	<center>
							      		<form method="get">
							      			<input type="hidden" name="post_id" value="<?php echo $current_postID; ?>">
								      		<input type="hidden" name="post_user_ids" value="<?php echo $post_user_idss; ?>">
								      		<input type="hidden" name="post_status" value="<?php echo $shears_options_status; ?>">
							      			<input type="hidden" name="shear-post-view">
			  								<button type="submit" 	class="view-btn">Submit</button>
										</form>
									</center>
							      	</td>
						    	</tr>
	  						<?php 
		      				}
	      				}
	      				else{
	      					wp_redirect(home_url());	
	      				}
	      			} ?>
	
	      	

				<?php } // endif
				else
				{
					echo "Oops No records found...!!!";
				}
				// Reset Post Data
				wp_reset_postdata();
				?>
				  	</tbody>
        <tfoot>
        	  <tr>
             	<th>#</th>
	      		<th>Title</th>
		     	<th>Image</th>
		      	<th>More Info</th>
            </tr>
        </tfoot>
    </table>
			<div class="clearfix"></div>
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
else{
	wp_redirect(home_url());
}
 ?>