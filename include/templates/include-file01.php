<div id="header-top">
	<div id="logo">
		<h3><a href="<?php echo home_url('/shears-dashboard'); ?>">SHEAR'REE</a> </h3>
	</div>
	<div id="toggle-area">
		<div class="dropdown">
			<button onclick="myFunction()" class="dropbtn">Admin <i class="fa fa-caret-down"></i></button>
			<div id="myDropdown" class="dropdown-content">
				<a href="<?php echo home_url(); ?>">Home</a>
				<a href="<?php echo home_url('/shears-dashboard'); ?>">Dashboard</a>
				<a href="<?php echo wp_logout_url(); ?>">Logout</a>
			</div>
		</div>
	</div>
	<div class="clearfix"></div>
</div>
<div id="main-area">
	<div id="content-lhs">
		<img src="<?php echo plugins_url('shears_membership/assets/images/profile-pic.jpg'); ?>">
		<a href="#" class="profilename"><?php echo $current_user->user_login;  ?></a>
			<?php
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
			}
			?>
		<span class="status"><strong>Status</strong> : <?php echo $user_status; ?></span>
		<ul class="bulletss">
		<li><a href="<?php echo home_url('/shears-dashboard'); ?>">Posts <!-- <small>(204)</small> --></a></li>
		</ul>
		<a class="logout" href="<?php echo wp_logout_url(); ?>">Logout</a>
	</div>