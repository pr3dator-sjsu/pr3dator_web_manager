<?php

//GET http://pr3dator-sjsu.ml/pr3dator_web_manager/update_order_status_update.php?customer_number=141&order_type=disputed HTTP/1.1

include("db_manager.php");

$customer_number = $_GET["customer_number"];
$order_type = $_GET["order_type"];

//$customer_name = $_GET["customerName"];
//$order_number = $_GET["orderNumber"];
//$customer_name, $order_number,

update_order_status($customer_number, $order_type)

?>