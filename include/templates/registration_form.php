<?php 


if(isset($_GET['shears_registration_submit'])) 
{
	
	// date_default_timezone_set("Asia/Karachi");
	$shears_username = $_GET['shears_username'];
	$shears_email = $_GET['shears_email'];
	$shears_password = $_GET['shears_password'];
	$shears_subscription = $_GET['shears_subscription'];
	$shears_subscription_status = $_GET['shears_subscription_status'];


	//if a user selects "paid" option

	$shears_paypal_cardno = $_GET['paypal_cardno'];	// getting paypal cardno
	$shears_paypal_expdate = $_GET['paypal_expdate']; // getting payapl expiry date
	$shears_paypal_cvv2 = $_GET['paypal_cvv2'];	// getting paypal cvv2
	$sheaRs_paypal_countrycode = $_GET['paypal_countrycode']; // paypal country code
	
	// validation
	$errors = 0;

	if($shears_subscription_status == '0' || $shears_subscription == 'select subscription')
 	{
		$subscriptionErr ='Kindly select subscription first';
		$errors += 1;
 	}
	if($shears_subscription_status != '0' && $shears_subscription == '2')
 	{
 		if($shears_paypal_cardno == 0 || $shears_paypal_expdate == 0 || $shears_paypal_cvv2 == 0 )
 		{
 			$subscriptionErr ='It seems,You are not entering all the fields of paypal.';
			$errors += 1;
 		}
 	}

	//username
    if (empty( $shears_username )) {
      $nameErr = "Username is required";
      $errors += 1;
    }
    else {
      $shears_username = shears_test_input( $shears_username ); 
      if(strlen($shears_username) > 60) {
        $nameErr = "Can't exceed more than 60";
        $errors += 1;
      }
    }

    // email
 	if (empty($shears_email)) {
      $emailErr = "Email is required";
      $errors += 1;
    } 
    else {
      $shears_email = shears_test_input($shears_email);
      // check if e-mail address is well-formed
      if (!filter_var($shears_email, FILTER_VALIDATE_EMAIL)) {
        $emailErr = "Invalid email format";
        $errors += 1; 
      }
    }

    //password
    if (empty($shears_password)) 
    {
      $passwordErr = "Password is required";
      $errors += 1;
    }
    else {
      $shears_password = shears_test_input($shears_password);
    }


    if($errors == 0) {

    	if($shears_subscription == '2')
    	{

    		$old_ppath = plugin_dir_path( __FILE__ );
    		$neww_path =  str_replace("templates","lib",$old_ppath);
    		
    		//including paypal pro
			include $neww_path.'paypal-pro/process-credit-card01.php';
			$user_cardnumber =	$shears_paypal_cardno;  //= $_GET['paypal_cardno'];	// getting paypal cardno
			$user_country_code = $shears_paypal_countrycode;	// getting paypal cvv2
			$card_expirydate = $shears_paypal_expdate;
			$card_cvv_number = $shears_paypal_cvv2;  //$_GET['paypal_expdate']; // getting payapl expiry date
			$res = user_credientials($user_cardnumber,$user_country_code,$card_expirydate,$card_cvv_number);
			if( $res['ACK'] == 'Success')
			{

				$userdata = array(
		      		'user_login'  => $shears_username,
		      		'user_pass'   =>  $shears_password,  // When creating a new user, `user_pass` is expected.
		      		'user_email' => $shears_email,
		      		'role' => 'shears_membership_user'
	      		);
	  			$user_id = wp_insert_user( $userdata ) ;
		      	//On success
		  		if ( ! is_wp_error( $user_id ) ) {

					add_user_meta( $user_id, 'shears_membership_status',$shears_subscription, true );
					add_user_meta( $user_id, 'shears_user_status',1, true );
					add_user_meta( $user_id, 'TRANSACTIONID',$res['TRANSACTIONID'], true );

					$redirect_url = home_url('/shears-registration/?user_status=User%20Successfully%20Created');
					wp_redirect($redirect_url);
					
		    	}
		      	else 
		      	{
	      			$redirect_url = home_url('/shears-registration/?user_status=User%20is%20not%20created.It%20seems%20,%20user%20exists%20with%20this%20email');
					wp_redirect($redirect_url);
		        	
		      	}
			}
			else
			{
				if(isset($res['L_LONGMESSAGE0']))
				{
					$paypal_msg = $res['L_LONGMESSAGE0'];
					$paypal_msg = rawurlencode($paypal_msg);
					$redirect_url = home_url('/shears-registration/?user_status='.$paypal_msg );
					wp_redirect($redirect_url);
				}
				else
				{
					$paypal_msg = 'Invalid%20data%20is%20proceed.';
					$redirect_url = home_url('/shears-registration/?user_status='.$paypal_msg );
					wp_redirect($redirect_url);
				}
				
				
			}
			
    	}
    	else
    	{
			$userdata = array(
	      		'user_login'  => $shears_username,
	      		'user_pass'   =>  $shears_password,  // When creating a new user, `user_pass` is expected.
	      		'user_email' => $shears_email,
	      		'role' => 'shears_membership_user'
	      	);
	  		$user_id = wp_insert_user( $userdata ) ;
	      	//On success
	  		if ( ! is_wp_error( $user_id ) ) {

				add_user_meta( $user_id, 'shears_membership_status',$shears_subscription, true );
				add_user_meta( $user_id, 'shears_user_status',1, true );
				$redirect_url = home_url('/shears-registration/?user_status=User%20Successfully%20Created');
				wp_redirect($redirect_url);
				
	    	}
	      	else 
	      	{
      			$redirect_url = home_url('/shears-registration/?user_status=User%20is%20not%20created.It%20seems%20,%20user%20exists%20with%20this%20email');
				wp_redirect($redirect_url);
	        	
	      	}
    	}
    }

}

$current_user = wp_get_current_user();
if($current_user->ID == 0)
{ ?>
	<div id="register_area">
		<h1>register</h1>
	  	<?php 
	    if(isset($_GET['user_status'])) 
	    {
    		if($_GET['user_status'] == 'User Successfully Created')
    		{ ?>
			<div class="clearfix" style="color: green;">
				<strong>Weldone!</strong> <?php echo $_GET['user_status'];   ?>
			</div>
			
    	<?php
    		}
    		else
			{ ?>
			<div class="clearfix" style="color: red;">
				<strong>Oh !</strong> <?php echo $_GET['user_status']; ?>
			</div>
      <?php } 
		} ?>
		<form>
			<div class="filed">
				<i class="fa fa-user"></i>
				<input type="text" name="shears_username" id="shears_username" placeholder="User name" value="<?php echo isset($shears_username) ? $shears_username : ''  ?>">
				<small style="color: red">
    				<?php echo isset($nameErr) ? $nameErr : ''  ?>
				</small>
			</div>
			<div class="filed">
				<i class="fa fa-envelope"></i>
				<input type="email" name="shears_email" id="shears_email" placeholder="Email" value="<?php echo isset($shears_email) ? $shears_email : ''  ?>">
				<small style="color: red">
					<?php echo isset($emailErr) ? $emailErr : ''  ?>
				</small>
			</div>
			<div class="filed">
				<i class="fa fa-lock"></i>
				<input type="password" name="shears_password" id="shears_password" placeholder="password" value="<?php echo isset($shears_password) ? $shears_password : ''  ?>">
				<small style="color: red">
    				<?php echo isset($passwordErr) ? $passwordErr : ''  ?>
				</small>
			</div>
			<div class="filed">
				<select class="form-three" id="shears_subscription" name="shears_subscription">
					<option value="select subscription" selected="selected">Select Subscription</option>
					<option value="1">Free</option>
					<option value="2">Paid</option>
				</select>
				<small class="form-text text-muted">When You select paid subscription. You will get the more right information.</small>
				<small style="color: red">
    				<?php echo isset($subscriptionErr) ? $subscriptionErr : ''  ?>
				</small>
			</div>
			<input type="hidden" name="shears_subscription_status" value="0">

			<!-- Paid  Subscription Parameters -->
			<input type="hidden" name="paypal_cardno" value="0">
			<input type="hidden" name="paypal_expdate" value="0">
			<input type="hidden" name="paypal_cvv2" value="0">
			<input type="hidden" name="paypal_countrycode" value="0">

			<!-- <input type="hidden" name="paypal_street" value="0">
			<input type="hidden" name="paypal_city" value="0">
			<input type="hidden" name="paypal_state" value="0">
			<input type="hidden" name="paypal_zipcode" value="0"> -->


			<input type="hidden" name="shears_registration_submit">	
			<input type="submit" class="button-submit" style="color: black" value="Register">
		</form>
		<small class="filed"> 
			<a style="color: blue;" href="<?php  echo home_url('/shears-login/') ?>">Make a login</a>
		</small>
	</div>

<!-- The Modal -->
	<div id="dialog-free" title="FREE MEMBER">
	 	<p>
			Register now to freely get information updates of the Shear'Ree Edition Muscle Truck. And, if you want to secure a place on the - sales list - make sure you "GET ON THE LIST" by registering your enrollment.
		</p>
		<input type="checkbox" name="shears_subscription_free" value="Free Membership"> Agree
		<button class="shears_subscription_ok_free" style="display: block;  background-color: #F8F8FF; margin: 10px 0 0 0;">OK</button>
	</div>
	<div id="dialog-paid" title="PAID MEMBER">
	 	<p>
			Shear’Ree Edition Certificate  – Terms and Conditions
			The purchase of this “Get On The List” certificate ensures the certificate holder a place on the sales list of the production, of the Shear’Ree Edition Muscle Truck, which, may, or may not, be produced in a given model year, or produced at all. The monies paid by the certificate holder, for this certificate, is purely for the purchase of the certificate, itself, and the certificate only. 
			
			All sales of certificates are final. There are no refunds. The stated intent of purchasing the certificate, is to document the certificate holder will be on the sales list.

			The certificates are all numbered, to allow the registration of the certificate, and the original certificate holder. The numbering has absolutely nothing to do with any ordering position, unit production sequence, or any other form of the Shear’Ree Edition Muscle Trucks being manufactured or produced.

			The certificate is straightforwardly, only assures the certificate holder, a place on the sales list, of which, the certificate holder, holds all rights to give, sell or auction their certificate, and transfer all rights of their certificate to the transferred person or entity.
		</p>
		<input type="checkbox" name="shears_subscription_paid" value="Paid Membership"> Agree
		<button class="shears_subscription_ok_paid" style="display: block;  background-color: #F8F8FF; margin: 10px 0 0 0;">OK</button>
	</div>

	<div id="dialog-paid-textboxes" title="PAID MEMBERS FIELDS">
		<h3>CARD INFORMATION</h3>
	 	Card No : <input type="number" min="1" name="client_cardno" placeholder="Enter Your Card No">
	 	<br>
	 	Expiry Date : <input type="month" name="card_expirydate" placeholder="Enter Expiry Date">
	 	<br>
	 	CVV2 : <input type="number" min="1" name="card_cvv" placeholder="Enter CVV2 number">
	 	<br>
	 	Country Code : <select name="country_code">
			<option value="AF">Afghanistan</option>
			<option value="AX">Åland Islands</option>
			<option value="AL">Albania</option>
			<option value="DZ">Algeria</option>
			<option value="AS">American Samoa</option>
			<option value="AD">Andorra</option>
			<option value="AO">Angola</option>
			<option value="AI">Anguilla</option>
			<option value="AQ">Antarctica</option>
			<option value="AG">Antigua and Barbuda</option>
			<option value="AR">Argentina</option>
			<option value="AM">Armenia</option>
			<option value="AW">Aruba</option>
			<option value="AU">Australia</option>
			<option value="AT">Austria</option>
			<option value="AZ">Azerbaijan</option>
			<option value="BS">Bahamas</option>
			<option value="BH">Bahrain</option>
			<option value="BD">Bangladesh</option>
			<option value="BB">Barbados</option>
			<option value="BY">Belarus</option>
			<option value="BE">Belgium</option>
			<option value="BZ">Belize</option>
			<option value="BJ">Benin</option>
			<option value="BM">Bermuda</option>
			<option value="BT">Bhutan</option>
			<option value="BO">Bolivia, Plurinational State of</option>
			<option value="BQ">Bonaire, Sint Eustatius and Saba</option>
			<option value="BA">Bosnia and Herzegovina</option>
			<option value="BW">Botswana</option>
			<option value="BV">Bouvet Island</option>
			<option value="BR">Brazil</option>
			<option value="IO">British Indian Ocean Territory</option>
			<option value="BN">Brunei Darussalam</option>
			<option value="BG">Bulgaria</option>
			<option value="BF">Burkina Faso</option>
			<option value="BI">Burundi</option>
			<option value="KH">Cambodia</option>
			<option value="CM">Cameroon</option>
			<option value="CA">Canada</option>
			<option value="CV">Cape Verde</option>
			<option value="KY">Cayman Islands</option>
			<option value="CF">Central African Republic</option>
			<option value="TD">Chad</option>
			<option value="CL">Chile</option>
			<option value="CN">China</option>
			<option value="CX">Christmas Island</option>
			<option value="CC">Cocos (Keeling) Islands</option>
			<option value="CO">Colombia</option>
			<option value="KM">Comoros</option>
			<option value="CG">Congo</option>
			<option value="CD">Congo, the Democratic Republic of the</option>
			<option value="CK">Cook Islands</option>
			<option value="CR">Costa Rica</option>
			<option value="CI">Côte d'Ivoire</option>
			<option value="HR">Croatia</option>
			<option value="CU">Cuba</option>
			<option value="CW">Curaçao</option>
			<option value="CY">Cyprus</option>
			<option value="CZ">Czech Republic</option>
			<option value="DK">Denmark</option>
			<option value="DJ">Djibouti</option>
			<option value="DM">Dominica</option>
			<option value="DO">Dominican Republic</option>
			<option value="EC">Ecuador</option>
			<option value="EG">Egypt</option>
			<option value="SV">El Salvador</option>
			<option value="GQ">Equatorial Guinea</option>
			<option value="ER">Eritrea</option>
			<option value="EE">Estonia</option>
			<option value="ET">Ethiopia</option>
			<option value="FK">Falkland Islands (Malvinas)</option>
			<option value="FO">Faroe Islands</option>
			<option value="FJ">Fiji</option>
			<option value="FI">Finland</option>
			<option value="FR">France</option>
			<option value="GF">French Guiana</option>
			<option value="PF">French Polynesia</option>
			<option value="TF">French Southern Territories</option>
			<option value="GA">Gabon</option>
			<option value="GM">Gambia</option>
			<option value="GE">Georgia</option>
			<option value="DE">Germany</option>
			<option value="GH">Ghana</option>
			<option value="GI">Gibraltar</option>
			<option value="GR">Greece</option>
			<option value="GL">Greenland</option>
			<option value="GD">Grenada</option>
			<option value="GP">Guadeloupe</option>
			<option value="GU">Guam</option>
			<option value="GT">Guatemala</option>
			<option value="GG">Guernsey</option>
			<option value="GN">Guinea</option>
			<option value="GW">Guinea-Bissau</option>
			<option value="GY">Guyana</option>
			<option value="HT">Haiti</option>
			<option value="HM">Heard Island and McDonald Islands</option>
			<option value="VA">Holy See (Vatican City State)</option>
			<option value="HN">Honduras</option>
			<option value="HK">Hong Kong</option>
			<option value="HU">Hungary</option>
			<option value="IS">Iceland</option>
			<option value="IN">India</option>
			<option value="ID">Indonesia</option>
			<option value="IR">Iran, Islamic Republic of</option>
			<option value="IQ">Iraq</option>
			<option value="IE">Ireland</option>
			<option value="IM">Isle of Man</option>
			<option value="IL">Israel</option>
			<option value="IT">Italy</option>
			<option value="JM">Jamaica</option>
			<option value="JP">Japan</option>
			<option value="JE">Jersey</option>
			<option value="JO">Jordan</option>
			<option value="KZ">Kazakhstan</option>
			<option value="KE">Kenya</option>
			<option value="KI">Kiribati</option>
			<option value="KP">Korea, Democratic People's Republic of</option>
			<option value="KR">Korea, Republic of</option>
			<option value="KW">Kuwait</option>
			<option value="KG">Kyrgyzstan</option>
			<option value="LA">Lao People's Democratic Republic</option>
			<option value="LV">Latvia</option>
			<option value="LB">Lebanon</option>
			<option value="LS">Lesotho</option>
			<option value="LR">Liberia</option>
			<option value="LY">Libya</option>
			<option value="LI">Liechtenstein</option>
			<option value="LT">Lithuania</option>
			<option value="LU">Luxembourg</option>
			<option value="MO">Macao</option>
			<option value="MK">Macedonia, the former Yugoslav Republic of</option>
			<option value="MG">Madagascar</option>
			<option value="MW">Malawi</option>
			<option value="MY">Malaysia</option>
			<option value="MV">Maldives</option>
			<option value="ML">Mali</option>
			<option value="MT">Malta</option>
			<option value="MH">Marshall Islands</option>
			<option value="MQ">Martinique</option>
			<option value="MR">Mauritania</option>
			<option value="MU">Mauritius</option>
			<option value="YT">Mayotte</option>
			<option value="MX">Mexico</option>
			<option value="FM">Micronesia, Federated States of</option>
			<option value="MD">Moldova, Republic of</option>
			<option value="MC">Monaco</option>
			<option value="MN">Mongolia</option>
			<option value="ME">Montenegro</option>
			<option value="MS">Montserrat</option>
			<option value="MA">Morocco</option>
			<option value="MZ">Mozambique</option>
			<option value="MM">Myanmar</option>
			<option value="NA">Namibia</option>
			<option value="NR">Nauru</option>
			<option value="NP">Nepal</option>
			<option value="NL">Netherlands</option>
			<option value="NC">New Caledonia</option>
			<option value="NZ">New Zealand</option>
			<option value="NI">Nicaragua</option>
			<option value="NE">Niger</option>
			<option value="NG">Nigeria</option>
			<option value="NU">Niue</option>
			<option value="NF">Norfolk Island</option>
			<option value="MP">Northern Mariana Islands</option>
			<option value="NO">Norway</option>
			<option value="OM">Oman</option>
			<option value="PK">Pakistan</option>
			<option value="PW">Palau</option>
			<option value="PS">Palestinian Territory, Occupied</option>
			<option value="PA">Panama</option>
			<option value="PG">Papua New Guinea</option>
			<option value="PY">Paraguay</option>
			<option value="PE">Peru</option>
			<option value="PH">Philippines</option>
			<option value="PN">Pitcairn</option>
			<option value="PL">Poland</option>
			<option value="PT">Portugal</option>
			<option value="PR">Puerto Rico</option>
			<option value="QA">Qatar</option>
			<option value="RE">Réunion</option>
			<option value="RO">Romania</option>
			<option value="RU">Russian Federation</option>
			<option value="RW">Rwanda</option>
			<option value="BL">Saint Barthélemy</option>
			<option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
			<option value="KN">Saint Kitts and Nevis</option>
			<option value="LC">Saint Lucia</option>
			<option value="MF">Saint Martin (French part)</option>
			<option value="PM">Saint Pierre and Miquelon</option>
			<option value="VC">Saint Vincent and the Grenadines</option>
			<option value="WS">Samoa</option>
			<option value="SM">San Marino</option>
			<option value="ST">Sao Tome and Principe</option>
			<option value="SA">Saudi Arabia</option>
			<option value="SN">Senegal</option>
			<option value="RS">Serbia</option>
			<option value="SC">Seychelles</option>
			<option value="SL">Sierra Leone</option>
			<option value="SG">Singapore</option>
			<option value="SX">Sint Maarten (Dutch part)</option>
			<option value="SK">Slovakia</option>
			<option value="SI">Slovenia</option>
			<option value="SB">Solomon Islands</option>
			<option value="SO">Somalia</option>
			<option value="ZA">South Africa</option>
			<option value="GS">South Georgia and the South Sandwich Islands</option>
			<option value="SS">South Sudan</option>
			<option value="ES">Spain</option>
			<option value="LK">Sri Lanka</option>
			<option value="SD">Sudan</option>
			<option value="SR">Suriname</option>
			<option value="SJ">Svalbard and Jan Mayen</option>
			<option value="SZ">Swaziland</option>
			<option value="SE">Sweden</option>
			<option value="CH">Switzerland</option>
			<option value="SY">Syrian Arab Republic</option>
			<option value="TW">Taiwan, Province of China</option>
			<option value="TJ">Tajikistan</option>
			<option value="TZ">Tanzania, United Republic of</option>
			<option value="TH">Thailand</option>
			<option value="TL">Timor-Leste</option>
			<option value="TG">Togo</option>
			<option value="TK">Tokelau</option>
			<option value="TO">Tonga</option>
			<option value="TT">Trinidad and Tobago</option>
			<option value="TN">Tunisia</option>
			<option value="TR">Turkey</option>
			<option value="TM">Turkmenistan</option>
			<option value="TC">Turks and Caicos Islands</option>
			<option value="TV">Tuvalu</option>
			<option value="UG">Uganda</option>
			<option value="UA">Ukraine</option>
			<option value="AE">United Arab Emirates</option>
			<option value="GB">United Kingdom</option>
			<option value="US" selected="selected">United States</option>
			<option value="UM">United States Minor Outlying Islands</option>
			<option value="UY">Uruguay</option>
			<option value="UZ">Uzbekistan</option>
			<option value="VU">Vanuatu</option>
			<option value="VE">Venezuela, Bolivarian Republic of</option>
			<option value="VN">Viet Nam</option>
			<option value="VG">Virgin Islands, British</option>
			<option value="VI">Virgin Islands, U.S.</option>
			<option value="WF">Wallis and Futuna</option>
			<option value="EH">Western Sahara</option>
			<option value="YE">Yemen</option>
			<option value="ZM">Zambia</option>
			<option value="ZW">Zimbabwe</option>
	 	</select>
	 	<!-- Street : <textarea name="client_street" rows="4" cols="50" placeholder="Enter your street"></textarea>
	 	<br> 
	 	City : <input type="text" name="client_city" placeholder="Enter Your City">
	 	<br>
	 	State : <input type="text" name="client_state" placeholder="Enter Your State"> -->
		<button class="shears_subscription_paid_fields" style="display: block;  background-color: #F8F8FF; margin: 10px 0 0 0;">OK</button>
	</div>
<?php
}
else
{
	wp_redirect(home_url('/shears-dashboard'));					
}
?>





