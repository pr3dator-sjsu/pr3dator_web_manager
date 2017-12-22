<?php

function initialize_db()
{ 
	$servername = "localhost";
	$username = "root";
	$password = "1@mpr3dator";
	$dbname = "classicmodels";
	$conn = new mysqli($servername, $username, $password, $dbname);
	
	if ($conn->connect_error) 
	{
		die("Connection failed: " . $conn->connect_error);
	} else {
	    //echo("OK");
		return $conn; 
	}
}

function close_db($conn)
{
	$conn->close();	
}

function display_orders_to_update()
{	
	//echo("DONE");
	$conn = initialize_db();
	$sql = "SELECT
			  classicmodels.customers.customerNumber,
			  classicmodels.customers.customerName,
			  classicmodels.orders.orderNumber,
			  classicmodels.orders.orderDate,
			  classicmodels.orders.requiredDate,
			  classicmodels.orders.shippedDate,
			  classicmodels.orders.status
			FROM
			  classicmodels.orders
			INNER JOIN classicmodels.customers ON classicmodels.orders.customerNumber = classicmodels.customers.customerNumber";
			
	$result = $conn->query($sql);
	
	while($row = $result->fetch_assoc()) 
		{
			echo('<td align="center"><font color="#FFFFFF">' . $row["customerNumber"] . '</font></td>');
			echo('<td align="center"><font color="#FFFFFF">' . $row["customerName"] . '</font></td>');
			echo('<td align="center"><font color="#FFFFFF">' . $row["orderNumber"] . '</font></td>');
			echo('<td align="center"><font color="#FFFFFF">' . $row["orderDate"] . '</font></td>');
			echo('<td align="center"><font color="#FFFFFF">' . $row["requiredDate"] . '</font></td>');
			echo('<td align="center"><font color="#FFFFFF">' . $row["shippedDate"] . '</font></td>');
			echo('<td align="center"><font color="#FFFFFF">' . $row["status"] . '</font></td>');
			echo('<td align="center"><input type="radio" name="customer_number" value="' . $row["customerNumber"] . '" ></td></tr>');
		}
	
	close_db($conn);
}


function fetch_orders_configuration_data()
{
	$conn = initialize_db();
	$sql = "SELECT order_shipped, order_resolved, order_cancelled, order_on_hold, order_disputed, order_in_process, twitter_integration, facebook_integration FROM social_network_integration";
	$result = $conn->query($sql);
			
	$result = $conn->query($sql);
	
	while($row = $result->fetch_assoc()) 
		{
			
			$orders_config_data = Array("order_shipped"=>$row["order_shipped"], "order_resolved"=>$row["order_resolved"], "order_cancelled"=>$row["order_cancelled"], "order_on_hold"=>$row["order_on_hold"], "order_disputed"=>$row["order_disputed"], "order_in_process"=>$row["order_in_process"], "twitter_integration"=>$row["twitter_integration"], "facebook_integration"=>$row["facebook_integration"]); 
			
		}
	
	close_db($conn);
	return $orders_config_data;
}
	
function fetch_customer_data($customer_number)
{
	$conn = initialize_db();
	$sql = "SELECT
			  classicmodels.customers.customerNumber,
			  classicmodels.customers.customerName,
			  classicmodels.orders.orderNumber,
			  classicmodels.orders.orderDate,
			  classicmodels.orders.requiredDate,
			  classicmodels.orders.shippedDate,
			  classicmodels.orders.status
			FROM
			  classicmodels.orders
			INNER JOIN classicmodels.customers ON classicmodels.orders.customerNumber = classicmodels.customers.customerNumber
			WHERE classicmodels.customers.customerNumber = $customer_number";
			
	$result = $conn->query($sql);
	
	while($row = $result->fetch_assoc()) 
		{
			$customer_info = Array("customerNumber"=>$row["customerNumber"], "customerName"=>$row["customerName"], "orderNumber"=>$row["orderNumber"], "orderDate"=>$row["orderDate"], "requiredDate"=>$row["requiredDate"], "shippedDate"=>$row["shippedDate"], "status"=>$row["status"], "customerNumber"=>$row["customerNumber"]);
		}
	
	close_db($conn);
	return $customer_info;
}
	
function update_order_status($customer_number, $order_type)
{
	$conn = initialize_db();
	
	
	$query = "UPDATE orders SET status = '$order_type' WHERE customerNumber = $customer_number";
	echo $query . "<br>";
	
	if ($conn->query($query) === TRUE) 
	{
		// Fetch data from customer to post on Twitter
		$customer_data = fetch_customer_data($customer_number);
		
		
		//Verify the current options saved by the admin.
		$orders_config_data = fetch_orders_configuration_data();
		
		var_dump($orders_config_data);		
		
		$data_maps = Array("SHIPPED"=>"order_shipped", "CANCELLED"=>"order_cancelled", "RESOLVED"=>"order_resolved", "ON HOLD"=>"order_on_hold", "DISPUTED"=>"order_disputed", "IN PROCESS"=>"order_in_process", "TWITTER_INTEGRATION"=>"twitter_integration", "FACEBOOK_INTEGRATION"=>"facebook_integration");
		
		
		$option = $data_maps[strtoupper($order_type)];
		//echo($option);
		
		switch ($option) {
			case "order_shipped":
				if ($orders_config_data["order_shipped"]) {
					$data = "(" . $customer_data["customerName"] . ") your order: " . $customer_data["orderNumber"] . " with date: " . $customer_data["orderDate"] . " has changed its status to: SHIPPED [PR3DATOR_WEB_MGR_v1.0]";
				}
				break;
				
			case "order_resolved":
				if ($orders_config_data["order_resolved"]) {
					$data = "(" . $customer_data["customerName"] . ") your order: " . $customer_data["orderNumber"] . " with date: " . $customer_data["orderDate"] . " has changed its status to: RESOLVED [PR3DATOR_WEB_MGR_v1.0]";
				}
				break;
				
			case "order_cancelled":		
				if ($orders_config_data["order_cancelled"]) {
					$data = "(" . $customer_data["customerName"] . ") your order: " . $customer_data["orderNumber"] . " with date: " . $customer_data["orderDate"] . " has changed its status to: CANCELLED [PR3DATOR_WEB_MGR_v1.0]";
				}
				break;
				
			case "order_on_hold":
				if ($orders_config_data["order_on_hold"]) {
					$data = "(" . $customer_data["customerName"] . ") your order: " . $customer_data["orderNumber"] . " with date: " . $customer_data["orderDate"] . " has changed its status to: ON HOLD [PR3DATOR_WEB_MGR_v1.0]";
				} 
				break;
				
			case "order_disputed":
				if ($orders_config_data["order_disputed"]) {
					$data = "(" . $customer_data["customerName"] . ") your order: " . $customer_data["orderNumber"] . " with date: " . $customer_data["orderDate"] . " has changed its status to: DISPUTED [PR3DATOR_WEB_MGR_v1.0]";
				} 
				break;
				
			case "order_in_process":
				if ($orders_config_data["order_in_process"]) {
					$data = "(" . $customer_data["customerName"] . ") your order: " . $customer_data["orderNumber"] . " with date: " . $customer_data["orderDate"] . " has changed its status to: IN PROCESS [PR3DATOR_WEB_MGR_v1.0]";	
				}
				break;

		} 
			
		
		echo "<h>" . $data . "<h>";
		
		// Check to use Twitter
		if ($orders_config_data["twitter_integration"] == 1) // && strlen($data) != 0)
		{
			echo ("TWITTER: ENABLED");
			post_twitter_msg(htmlspecialchars($data));
			
		} else {
			echo "<script>alert('TWITTER DISABLED')</script>";
		}
		
		if ($orders_config_data["facebook_integration"] == 1) // && strlen($data) != 0)
		{
			echo ("FACEBOOK: ENABLED");
			post_facebook_msg(htmlspecialchars($data));			
			
		} else {
			echo "<script>alert('FACEBOOK DISABLED')</script>";
		}
		
		echo "<script>window.location.href='order_status_update.php'</script>";
		
	} else {
		echo("Connection error: " . $conn->error);
		echo "<script>alert('Error updating record: " . $conn->error . ")</script>";
	}
	
	close_db($conn);
	
}

function get_tweet_info_from_orders($customer_number)
{
	$conn = initialize_db();
	$sql = "SELECT
			  classicmodels.customers.customerNumber,
			  classicmodels.customers.customerName,
			  classicmodels.orders.orderNumber,
			  classicmodels.orders.orderDate,
			  classicmodels.orders.requiredDate,
			  classicmodels.orders.shippedDate,
			  classicmodels.orders.status
			FROM
			  classicmodels.orders
			INNER JOIN classicmodels.customers ON classicmodels.orders.customerNumber = classicmodels.customers.customerNumber";
			
	$result = $conn->query($sql);
	
	while($row = $result->fetch_assoc()) 
		{
			echo('<td align="center"><font color="#FFFFFF">' . $row["customerNumber"] . '</font></td>');
			echo('<td align="center"><font color="#FFFFFF">' . $row["customerName"] . '</font></td>');
			echo('<td align="center"><font color="#FFFFFF">' . $row["orderNumber"] . '</font></td>');
			echo('<td align="center"><font color="#FFFFFF">' . $row["orderDate"] . '</font></td>');
			echo('<td align="center"><font color="#FFFFFF">' . $row["requiredDate"] . '</font></td>');
			echo('<td align="center"><font color="#FFFFFF">' . $row["shippedDate"] . '</font></td>');
			echo('<td align="center"><font color="#FFFFFF">' . $row["status"] . '</font></td>');
			echo('<td align="center"><input type="radio" name="customer_number" value="' . $row["customerNumber"] . '" ></td></tr>');
			
		}
	
	close_db($conn);
}

function twitter_get_api_info()
{
	$conn = initialize_db();
	$query = "SELECT consumer_key, consumer_secret, access_token, access_token_secret FROM api_information WHERE api_name = 'TWITTER'";
	$result = $conn->query($query);
	
	if ($result->num_rows > 0) {
		
		while($row = $result->fetch_assoc()) {
			
			//echo $row["consumer_key"];
			
			$twitter_api_info = Array("consumer_key"=>$row["consumer_key"], "consumer_secret"=>$row["consumer_secret"], "access_token"=>$row["access_token"], "access_token_secret"=>$row["access_token_secret"]); 
		
		}
	}
	
	close_db($conn);
	
	var_dump($twitter_api_info);
	return $twitter_api_info;
	
}

function facebook_get_api_info()
{
	$conn = initialize_db();
	$query = "SELECT page_id, access_token FROM api_information WHERE api_name = 'FACEBOOK'";
	$result = $conn->query($query);
	
	if ($result->num_rows > 0) {
		
		while($row = $result->fetch_assoc()) {
						
			$facebook_api_info = Array("page_id"=>$row["page_id"], "access_token"=>$row["access_token"]); 
		
		}
	}
	
	close_db($conn);
	
	var_dump($facebook_api_info);
	return $facebook_api_info;
	
}

function post_facebook_msg($message)
{
	$facebook_api_info = facebook_get_api_info();
	
	// Execute facebook script
	$script_execution = 'python /home/pr3dator/pr3dator_web_manager/scripts/post_facebook.py ' . $facebook_api_info["page_id"] . " " . $facebook_api_info["access_token"] . " " . '"' . $message . '"';
	
	echo $script_execution;
	
	$run_script = shell_exec($script_execution);
}

function post_twitter_msg($message)
{
	$twitter_api_info = twitter_get_api_info();
	
	
	// Execute tweeter script
	$script_execution = 'python /home/pr3dator/pr3dator_web_manager/scripts/post_twitter.py ' . $twitter_api_info["consumer_key"] . " " . $twitter_api_info["consumer_secret"] . " " . $twitter_api_info["access_token"]  . " " . $twitter_api_info["access_token_secret"]  . " " . '"' . $message . '"';
	
	echo $script_execution;
	
	$run_script = shell_exec($script_execution);
}

function display_social_network_information()
{	
	$conn = initialize_db();
	$sql = "SELECT order_shipped, order_resolved, order_cancelled, order_on_hold, order_disputed, order_in_process, twitter_integration, facebook_integration FROM social_network_integration";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) {
		
		while($row = $result->fetch_assoc()) {
			//echo "order_posted: " . $row["order_posted"] . " order_shipped: " . $row["order_shipped"] . " order_placed: " . $row["order_placed"] . " product_added: " . $row["product_added"] . " twitter_integration: " . $row["twitter_integration"] . "<br>";

		if ($row["order_shipped"] == 1)
			{
				echo('<input type="checkbox" name="order_shipped" checked>AN ORDER HAS BEEN SHIPPED</p><p style="margin-top: 0; margin-bottom: 0">&nbsp;</p><p style="margin-top: 0; margin-bottom: 0">');
			} else {
			   echo('<input type="checkbox" name="order_shipped">AN ORDER HAS BEEN SHIPPED</p><p style="margin-top: 0; margin-bottom: 0">&nbsp;</p><p style="margin-top: 0; margin-bottom: 0">');
			}

		if ($row["order_resolved"] == 1)
			{
				echo('<input type="checkbox" name="order_resolved" checked>AN ORDER IS RESOLVED</p><p style="margin-top: 0; margin-bottom: 0">&nbsp;</p><p style="margin-top: 0; margin-bottom: 0">');
			} else {
			   echo('<input type="checkbox" name="order_resolved">AN ORDER IS RESOLVED</p><p style="margin-top: 0; margin-bottom: 0">&nbsp;</p><p style="margin-top: 0; margin-bottom: 0">');
			}
			
		if ($row["order_cancelled"] == 1)
			{
				echo('<input type="checkbox" name="order_cancelled" checked></font></span>AN ORDER HAS BEEN CANCELLED</p><p style="margin-top: 0; margin-bottom: 0">&nbsp;</p><p style="margin-top: 0; margin-bottom: 0">');
			} else {
				echo('<input type="checkbox" name="order_cancelled"></font></span>AN ORDER HAS BEEN CANCELLED</p><p style="margin-top: 0; margin-bottom: 0">&nbsp;</p><p style="margin-top: 0; margin-bottom: 0">');
			}

		if ($row["order_on_hold"] == 1)
			{
				echo('<input type="checkbox" name="order_on_hold" checked>AN ORDER IS ON HOLD</p><p style="margin-top: 0; margin-bottom: 0">&nbsp;</p><p style="margin-top: 0; margin-bottom: 0">');
			} else {
			   echo('<input type="checkbox" name="order_on_hold">AN ORDER IS ON HOLD</p><p style="margin-top: 0; margin-bottom: 0">&nbsp;</p><p style="margin-top: 0; margin-bottom: 0">');
			}

		if ($row["order_disputed"] == 1)
			{
				echo('<input type="checkbox" name="order_disputed" checked>AN ORDER IS DISPUTED</p><p style="margin-top: 0; margin-bottom: 0">&nbsp;</p><p style="margin-top: 0; margin-bottom: 0">');
			} else {
			   echo('<input type="checkbox" name="order_disputed">AN ORDER IS DISPUTED</p><p style="margin-top: 0; margin-bottom: 0">&nbsp;</p><p style="margin-top: 0; margin-bottom: 0">');
			}
			
		if ($row["order_in_process"] == 1)
			{
				echo('<input type="checkbox" name="order_in_process" checked>AN ORDER IS IN PROCESS</p><p style="margin-top: 0; margin-bottom: 0">&nbsp;</p><p style="margin-top: 0; margin-bottom: 0">');
			} else {
			   echo('<input type="checkbox" name="order_in_process">AN ORDER IS IN PROCESS</p><p style="margin-top: 0; margin-bottom: 0">&nbsp;</p><p style="margin-top: 0; margin-bottom: 0">');
			}
			

		if ($row["twitter_integration"] == 1)
			{
			
				echo('<legend><font color="#FF0000"><b>AVAILABLE SOCIAL MEDIA INTEGRATION</b></font></legend><p style="margin-top: 0; margin-bottom: 0">&nbsp;<p style="margin-top: 0; margin-bottom: 0">');
				echo('<input type="checkbox" name="twitter_integration" checked><img border="0" src="twitter.png" width="100" height="47" align="middle"></p><p style="margin-top: 0; margin-bottom: 0">&nbsp;</p><p style="margin-top: 0; margin-bottom: 0">');
			} else {
				echo('<legend><font color="#FF0000"><b>AVAILABLE SOCIAL MEDIA INTEGRATION</b></font></legend><p style="margin-top: 0; margin-bottom: 0">&nbsp;<p style="margin-top: 0; margin-bottom: 0">');
				echo('<input type="checkbox" name="twitter_integration"><img border="0" src="twitter.png" width="100" height="47" align="middle"></p><p style="margin-top: 0; margin-bottom: 0">&nbsp;</p><p style="margin-top: 0; margin-bottom: 0">');
			}
			
			
		if ($row["facebook_integration"] == 1)
			{
			
				echo('<p style="margin-top: 0; margin-bottom: 0">&nbsp;<p style="margin-top: 0; margin-bottom: 0">');
				echo('<input type="checkbox" name="facebook_integration" checked><img border="0" src="facebook.png" width="100" height="47" align="middle"></p><p style="margin-top: 0; margin-bottom: 0">&nbsp;</p><p style="margin-top: 0; margin-bottom: 0">');
			} else {
				echo('<p style="margin-top: 0; margin-bottom: 0">&nbsp;<p style="margin-top: 0; margin-bottom: 0">');
				echo('<input type="checkbox" name="facebook_integration"><img border="0" src="facebook.png" width="100" height="47" align="middle"></p><p style="margin-top: 0; margin-bottom: 0">&nbsp;</p><p style="margin-top: 0; margin-bottom: 0">');
			}
	
		}
	} else { 
		echo "0 results";
	}
	
	close_db($conn);
}

function update_social_query($query)
{
	$conn = initialize_db();
	echo("<br>query: " . $query . "<br>");
	
	if ($conn->query($query) === TRUE) 
		{
			//echo("OK </br>");
			//echo "<script>alert('Record updated successfully')</script>";
			echo "<script>window.location.href='social_media_intg.php'</script>";
		} else {
			//echo("ERROR" . $conn->error . "<br>");
			echo "<script>alert('Error updating record: " . $conn->error . ")</script>";
		}
	
	close_db($conn);
}
	

function update_social_network($order_parameters)
{		

	foreach ($order_parameters as $order_type => $order_status)
	{
		
		#echo(strlen($order_status));
		
		echo "<br>" . $order_type . "=>" . $order_status . "<br>";
		
		
		if (strlen($order_status) == 2)
		{
			$query = "UPDATE social_network_integration SET $order_type = 1";
		    echo $query;
			update_social_query($query);
			
		} else {
			$query = "UPDATE social_network_integration SET $order_type = 0";				
		    echo $query;
			update_social_query($query);			
		}
		
		
	}	
	
}

function display_twitter_api_information()
{	
	$conn = initialize_db();
	$sql = "SELECT
			  classicmodels.api_information.consumer_key,
			  classicmodels.api_information.consumer_secret,
			  classicmodels.api_information.access_token,
			  classicmodels.api_information.access_token_secret
			FROM
			  classicmodels.api_information
			WHERE api_name = 'TWITTER'";
			
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) 
		{
		
			while($row = $result->fetch_assoc()) {
				
				$twitter_consumer_key = $row["consumer_key"];
				$twitter_consumer_secret = $row["consumer_secret"];
				$twitter_access_token = $row["access_token"];
				$twitter_access_token_secret = $row["access_token_secret"];
			
			}
		
		echo('<p style="margin-top: 0; margin-bottom: 0"><font color="#FFFF00"><b>TWITTER API INFORMATION</b></font></p>
			<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
			<p style="margin-top: 0; margin-bottom: 0">CONSUMER KEY</p>
			<p style="margin-top: 0; margin-bottom: 0">
			<input type="text" value="' . $twitter_consumer_key . '" name="twitter_consumer_key" size="165"></p>
			<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
			<p style="margin-top: 0; margin-bottom: 0">CONSUMER SECRET</p>
			<p style="margin-top: 0; margin-bottom: 0">
			<input type="text" value="' . $twitter_consumer_secret . '" name="twitter_consumer_secret" size="165"></p>
			<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
			<p style="margin-top: 0; margin-bottom: 0">ACCESS TOKEN</p>
			<p style="margin-top: 0; margin-bottom: 0">
			<input type="text" value="' . $twitter_access_token . '" name="twitter_access_token" size="165"></p>
			<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
			<p style="margin-top: 0; margin-bottom: 0">ACCESS TOKEN SECRET</p>
			<p style="margin-top: 0; margin-bottom: 0">
			<input type="text" value="' . $twitter_access_token_secret . '" name="twitter_access_token_secret" size="165"></p>
			<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>');
			
		}
}


function display_facebook_api_information()
{	
	$conn = initialize_db();
	$sql = "SELECT
			  classicmodels.api_information.access_token,
			  classicmodels.api_information.page_id
			FROM
			  classicmodels.api_information
			WHERE api_name = 'FACEBOOK'";
			
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) 
		{
		
			while($row = $result->fetch_assoc()) {
				
				$facebook_page_id = $row["page_id"];
				$facebook_access_token = $row["access_token"];
			
			}
		
		echo('
				<p style="margin-top: 0; margin-bottom: 0"><font color="#FFFF00"><b>FACEBOOK 
				API INFORMATION</b></font></p>
				<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
				<p style="margin-top: 0; margin-bottom: 0">PAGE ID</p>
				<p style="margin-top: 0; margin-bottom: 0">
				<input type="text" value="' . $facebook_page_id . '" name="facebook_page_id" size="165"></p>
				<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
				<p style="margin-top: 0; margin-bottom: 0">ACCESS TOKEN</p>
				<p style="margin-top: 0; margin-bottom: 0">
				<input type="text" value="' . $facebook_access_token . '" name="facebook_access_token" size="165"></p>
				<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>');
			
		}
}

function display_github_api_information()
{	
	$conn = initialize_db();
	$sql = "SELECT
			  classicmodels.api_information.github_repository,
			  classicmodels.api_information.github_username,
			  classicmodels.api_information.github_api_key
			FROM
			  classicmodels.api_information
			WHERE api_name = 'GITHUB'";
	$result = $conn->query($sql);
	
	if ($result->num_rows > 0) 
		{
		
			while($row = $result->fetch_assoc()) {
				
				$github_repository = $row["github_repository"];
				$github_api_key = $row["github_api_key"];
				$github_username = $row["github_username"];
			}
		
		echo('
			<p style="margin-top: 0; margin-bottom: 0"><font color="#FFFF00"><b>GITHUB 
			API INFORMATION</b></font></p>
			<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
			<p style="margin-top: 0; margin-bottom: 0">URI</p>
			<p style="margin-top: 0; margin-bottom: 0">
			<input type="text" value="' . $github_repository . '" name="github_repository" size="165"></p>
			<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
			<p style="margin-top: 0; margin-bottom: 0">API KEY</p>
			<p style="margin-top: 0; margin-bottom: 0">
			<input type="text" value="' . $github_api_key . '" name="github_api_key" size="165"></p>
			<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
			<p style="margin-top: 0; margin-bottom: 0">USERNAME</p>
			<p style="margin-top: 0; margin-bottom: 0">
			<input type="text" value="' . $github_username . '" name="github_username" size="165"></p>
			<p style="margin-top: 0; margin-bottom: 0">&nbsp;</p>
			<p style="margin-top: 0; margin-bottom: 0">
			&nbsp;</p>');
			
		}
}

?>

