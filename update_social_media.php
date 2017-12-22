<?php


include("db_manager.php");

$order_shipped = $_GET["order_shipped"];
$order_resolved = $_GET["order_resolved"];
$order_cancelled = $_GET["order_cancelled"];
$order_on_hold = $_GET["order_on_hold"]; 
$order_disputed = $_GET["order_disputed"];
$order_in_process = $_GET["order_in_process"]; 
$twitter_integration = $_GET["twitter_integration"];
$facebook_integration = $_GET["facebook_integration"];

//echo $twitter_integration;

/*
if (!isset($order_shipped)) { $order_shipped = "off" }
if (!isset($order_resolved)) { $order_resolved = "off" }
if (!isset($order_cancelled)) { $order_cancelled = "off" }
if (!isset($order_on_hold)) { $order_on_hold = "off" }
if (!isset($order_disputed)) { $order_disputed = "off" }
if (!isset($order_in_process)) { $order_in_process = "off" }
if (!isset($twitter_integration)) { $twitter_integration = "off" }
*/
	
$order_parameters = array("order_shipped"=>$order_shipped, "order_resolved"=>$order_resolved, "order_cancelled"=>$order_cancelled, "order_on_hold"=>$order_on_hold, "order_disputed"=>$order_disputed, "order_in_process"=>$order_in_process, "twitter_integration"=>$twitter_integration, "facebook_integration"=>$facebook_integration);

//var_dump($order_parameters);
//echo("<br>");

update_social_network($order_parameters)

?>