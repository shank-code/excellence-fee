<?php

session_start();
require 'shopify.php';
	/* Define your APP`s key and secret*/

	define('SHOPIFY_API_KEY', 'caa5875cac243d3f7250096eb375c1c0');
	define('SHOPIFY_SECRET', 'bb37bb32733c4d07cb9b2c3b391bd732');
	
	/* Define requested scope (access rights) - checkout https://docs.shopify.com/api/authentication/oauth#scopes 	*/
	define('SHOPIFY_SCOPE','read_orders,write_orders');	//eg: define('SHOPIFY_SCOPE','read_orders,write_orders');
	
	if (isset($_GET['code'])) 
	{ 			
		// if the code param has been sent to this page... we are in Step 2
		// Step 2: do a form POST to get the access token
		$shopifyClient = new ShopifyClient($_GET['shop'], "", SHOPIFY_API_KEY, SHOPIFY_SECRET);
		// session_unset();
		
		// Now, request the token and store it in your session.
		$_SESSION['token'] = $shopifyClient->getAccessToken($_GET['code']);
		if ($_SESSION['token'] != '')
			$_SESSION['shop'] = $_GET['shop'];
			///Define get, put Api
			if($_SESSION['shop'] != "" && $_SESSION['count'] == "1" ){

				// GET theme id api
				$url = 'https://'. $_SESSION['shop'] .'/admin/api/2019-04/themes.json';
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
				$get_theme_id = json_decode($response, true);
				$get_theme_id_data = $get_theme_id['themes']['0']['id'];



				//get the data from index.liquiq
				$url = 'https://' . $_SESSION['shop'] . '/admin/api/2019-04/themes/' . $get_theme_id_data . '/assets.json?asset[key]=templates/index.liquid&theme_id=' . $get_theme_id_data . '%0A';
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
				$res = json_decode($response, true);
				//add the bx slider code existing index.liquid 
				$res['asset']['value'] = $res['asset']['value'] . "{{'https://code.jquery.com/jquery-3.4.1.min.js' | script_tag}}{{'https://plivo1.demo.xmagestore.com/shopify_shoes_app/bx_slider.js' | script_tag}}";
				$res = json_encode($res, true);



				//put the data to index.liquid
				$url = 'https://' . $_SESSION['shop'] . '/admin/api/2019-04/themes/' . $get_theme_id_data . '/assets.json';
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
				$_SESSION['count'] = "2";
				header("Location: dashboard.php?shop=" . $_SESSION['shop']);
				exit;			
			}else {		
				header("Location: dashboard.php?shop=" . $_SESSION['shop']);
				die;
			}
		}
		// if they posted the form with the shop name
		else{
			$_SESSION['shop'] = $_GET['shop'];
			if (isset($_SESSION['shop'])) {
				echo "aaaaa";
				header("Location: dashboard.php?shop=" . $_SESSION['shop']);
			}

			
			// Step 1: get the shopname from the user and redirect the user to the
			// shopify authorization page where they can choose to authorize this app
			$shop = isset($_POST['shop']) ? $_POST['shop'] : $_GET['shop'];
			$shopifyClient = new ShopifyClient($shop, "", SHOPIFY_API_KEY, SHOPIFY_SECRET);
		
			// get the URL to the current page
			$pageURL = 'http';
			if ($_SERVER["HTTPS"] == "on") { $pageURL .= "s"; }
			$pageURL .= "://";
			if ($_SERVER["SERVER_PORT"] != "80") {
				$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["SCRIPT_NAME"];
			} else {
				$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"];
			}

		// redirect to authorize url

		header("Location: " . $shopifyClient->getAuthorizeUrl(SHOPIFY_SCOPE, $pageURL));
		exit;
		}

?>
	<p>Install this app in a shop to get access to its private admin data.</p> 
 
	<p style="padding-bottom: 1em;">
		<span class="hint">Don&rsquo;t have a shop to install your app in handy? <a href="https://app.shopify.com/services/partners/api_clients/test_shops">Create a test shop.</a></span>
	</p> 
	 
	<form action="" method="post">
	  <label for='shop'><strong>The URL of the Shop</strong> 
	    <span class="hint">(enter it exactly like this: myshop.myshopify.com)</span> 
	  </label> 
	  <p> 
	    <input id="shop" name="shop" size="45" type="text" value="" /> 
	    <input name="commit" type="submit" value="Install" /> 
	  </p> 
	</form>

	
