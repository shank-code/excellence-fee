<?php
//get the theme id 

$url = 'https://deepak-1234.myshopify.com/admin/api/2019-04/themes.json';
 
//Your username.
$username = '4565387509c505eeeb73213072861663';

 
//Your password.
$password = '8c8e3c77e457d22f6cefbde986771522';
 
//Initiate cURL.
$ch = curl_init($url);
 
//Specify the username and password using the CURLOPT_USERPWD option.
curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);  
 
//Tell cURL to return the output as a string instead
//of dumping it to the browser.
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
//Execute the cURL request.
$response = curl_exec($ch);
 
//Check for errors.
if (curl_errno($ch)) {
    //If an error occured, throw an Exception.
    throw new Exception(curl_error($ch));
}
 
//Print out the response.
// echo $response;

$get_theme_id = json_decode($response, true);
$get_theme_id_data = $get_theme_id['themes']['0']['id'];





//get the data from index.liquid

$url = 'https://deepak-1234.myshopify.com/admin/api/2019-04/themes/'. $get_theme_id_data .'/assets.json?asset[key]=templates/index.liquid&theme_id=' . $get_theme_id_data . '%0A';
 
//Your username.
$username = '4565387509c505eeeb73213072861663';
 
//Your password.
$password = '8c8e3c77e457d22f6cefbde986771522';
 
//Initiate cURL.
$ch = curl_init($url);
 
//Specify the username and password using the CURLOPT_USERPWD option.
curl_setopt($ch, CURLOPT_USERPWD, $username . ":" . $password);  
 
//Tell cURL to return the output as a string instead
//of dumping it to the browser.
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
//Execute the cURL request.
$response = curl_exec($ch);
 
//Check for errors.
if (curl_errno($ch)) {
    //If an error occured, throw an Exception.
    throw new Exception(curl_error($ch));
}
 
//Print out the response.
// echo $response;

$res = json_decode($response, true);

//add the bx slider code existing index.liquid 
$res['asset']['value'] = $res['asset']['value'] . "{{'https://code.jquery.com/jquery-3.4.1.min.js' | script_tag}}{{'bxslider.js' | asset_url | script_tag}}";

// echo '<pre>';
// print_r($res);

$res = json_encode($res, true);


//put the data to index.liquid



$url = 'https://deepak-1234.myshopify.com/admin/api/2019-04/themes/' . $get_theme_id_data . '/assets.json';
 
//Your username.
$username = '4565387509c505eeeb73213072861663';
 
//Your password.
$password = '8c8e3c77e457d22f6cefbde986771522';

//$data = array("username" => "test"); // data u want to post                                                                   
$data_string = json_encode($data);
$api_key = "4565387509c505eeeb73213072861663";
$password = "8c8e3c77e457d22f6cefbde986771522";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $res);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERPWD, $api_key . ':' . $password);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Accept: application/json',
    'Content-Type: application/json'
));

if (curl_exec($ch) === false) {
    echo 'Curl error: ' . curl_error($ch);
}
$errors = curl_error($ch);
$result = curl_exec($ch);
$returnCode = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);
$returnCode;
// var_dump($errors);
json_decode($result, true);



