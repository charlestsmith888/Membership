<?php
// Include config file
require_once('includes/config.php');


// Min fields in paypal pro
// $request_params = array(
// 	'METHOD'        => 'DoDirectPayment',
// 	'USER'          => $api_username,
// 	'PWD'           => $api_password,
// 	'SIGNATURE'     => $api_signature,
// 	'VERSION'       => $api_version,
// 	'PAYMENTACTION' => 'Sale',
// 	'IPADDRESS'     => $_SERVER['REMOTE_ADDR'],
// 	'ACCT'          => $form['payment']['credit-card-number'],
// 	'EXPDATE'       => $form['payment']['expiration'],
// 	'CVV2'          => $form['payment']['cvv'],
// 	'FIRSTNAME'     => $form['first_name'],
// 	'LASTNAME'      => $form['last_name'],
// 	'COUNTRYCODE'   => 'AU',
// 	'AMT'           => $price,
// 	'CURRENCYCODE'  => 'USD',
// 	'DESC'          => $service_name,
// );


//'cardno' => '5110921864924447', 	
// 'EXPDATE' => '022020', 	
// 'CVV2' => '456', 
// 'STREET' => '707 W. Bay Drive', 
// 'CITY' => 'Largo', 
// 'STATE' => 'FL', 	
// 'COUNTRYCODE' => 'US',  
// 'ZIP' => '33770',


// Store request params in an array
$request_params = array(
	'METHOD'        => 'DoDirectPayment',
	'USER'          => $api_username,
	'PWD'           => $api_password,
	'SIGNATURE'     => $api_signature,
	'VERSION'       => $api_version,
	'PAYMENTACTION' => 'Sale',
	'IPADDRESS'     => $_SERVER['REMOTE_ADDR'],
	'ACCT'          => '51109218649244478',
	'EXPDATE'       => '022020',
	'CVV2'          => '456',
	'FIRSTNAME'     => 'Nimz',
	'LASTNAME'      => 'Peter',
	'COUNTRYCODE'   => 'AU',
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
$result_array = NVPToArray($result);

//echo '<pre />';
//print_r($result_array['ACK']);
//print_r($result_array);

// if(isset($result_array['L_LONGMESSAGE0'])){
// 	echo $result_array['L_LONGMESSAGE0'];
// 	echo $result_array['ACK'];
// }
// else{
// 	echo "Not Set";

// }

if( $result_array['ACK']== 'Failure'){
	echo "<br>Tum Naqam hogye";
}
else
{
	echo "<br>Tum Qamiyab Hue hogye";
}



// Function to convert NTP string to an array
// function NVPToArray($NVPString)
// {
// 	$proArray = array();
// 	while(strlen($NVPString))
// 	{
// 		// name
// 		$keypos= strpos($NVPString,'=');
// 		$keyval = substr($NVPString,0,$keypos);
// 		// value
// 		$valuepos = strpos($NVPString,'&') ? strpos($NVPString,'&'): strlen($NVPString);
// 		$valval = substr($NVPString,$keypos+1,$valuepos-$keypos-1);
// 		// decoding the respose
// 		$proArray[$keyval] = urldecode($valval);
// 		$NVPString = substr($NVPString,$valuepos+1,strlen($NVPString));
// 	}
// 	return $proArray;
// }