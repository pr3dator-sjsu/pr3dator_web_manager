<?php


$twitter_consumer_key = $_GET["twitter_consumer_key"];
$twitter_consumer_secret = $_GET["twitter_consumer_secret"];
$twitter_access_token = $_GET["twitter_access_token"];
$twitter_access_token_secret = $_GET["twitter_access_token_secret"];
$facebook_page_id = $_GET["facebook_page_id"];
$facebook_access_token = $_GET["facebook_access_token"];
$github_repository = $_GET["github_repository"];
$github_api_key = $_GET["github_api_key"];
$github_username = $_GET["github_username"];

include("db_manager.php");
	
$api_information_parameters = array("twitter_consumer_key"=>$twitter_consumer_key, "twitter_consumer_secret"=>$twitter_consumer_secret, "twitter_access_token"=>$twitter_access_token, "twitter_access_token_secret"=>$twitter_access_token_secret, "facebook_page_id"=>$facebook_page_id, "facebook_access_token"=>$facebook_access_token, "github_repository"=>$github_repository, "github_api_key"=>$github_api_key, "github_username"=>$github_username);

var_dump($api_information_parameters);
//echo("<br>");

//update_social_network($order_parameters)


?>