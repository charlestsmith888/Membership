<?php

function user_credientials($account_num, $country_code,$expiry_date,$cvv_no)
{
	// Include config file
	require_once('includes/config.php');
	// Store request params in an array
	$request_params = array(
		'METHOD'        => 'DoDirectPayment',
		'USER'          => $api_username,
		'PWD'           => $api_password,
		'SIGNATURE'     => $api_signature,
		'VERSION'       => $api_version,
		'PAYMENTACTION' => 'Sale',
		'IPADDRESS'     => $_SERVER['REMOTE_ADDR'],
		'ACCT'          => $account_num,
		'EXPDATE'       => $expiry_date,
		'CVV2'          => $cvv_no,
		'FIRSTNAME'     => 'Nimz',
		'LASTNAME'      => 'Peter',
		'COUNTRYCODE'   => $country_code,
		'AMT'           => '19.95',
		'CURRENCYCODE'  => 'USD',
		'DESC'          => 'ShearRee Form Registration'
	);


	// Loop through $request_params array to generate the NVP string.
	$nvp_string = '';
	foreach($request_params as $var=>$val)
	{
		$nvp_string .= '&'.$var.'='.urlencode($val);	
	}

	// Send NVP string to PayPal and store response
	$curl = curl_init();
	curl_setopt($curl, CURLOPT_VERBOSE, 1);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
	curl_setopt($curl, CURLOPT_TIMEOUT, 30);
	curl_setopt($curl, CURLOPT_URL, $api_endpoint);
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $nvp_string);

	$result = curl_exec($curl);
	//echo $result.'<br /><br />';
	curl_close($curl);

	// Parse the API response
	return $result_array = NVPToArray($result);

}

	// $user_cardnumber =	$shears_paypal_cardno;  //= $_GET['paypal_cardno'];	// getting paypal cardno
	// $user_country_code = $shears_paypal_countrycode;	// getting paypal cvv2
	// $card_expirydate = $shears_paypal_expdate;
	// $card_cvv_number = $shears_paypal_cvv2;  //$_GET['paypal_expdate']; // getting payapl expiry date
	
	
	// $res  =  user_credientials($user_cardnumber,$user_country_code,$card_expirydate,$card_cvv_number);
	//$res  =  user_credientials('234234','AU','022020','1993');
	//echo '<pre />';
	//print_r($res['ACK']);
	//print_r($res);





