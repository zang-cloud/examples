<?php

// Make sure that MIME type is set to XML. This will ensure that XML is rendered
// properly. Zang requires that InboundXML is a valid XML document.
header('Content-type: application/xml');

// Body will be passed under GET or POST. We're using REQUEST to capture both durring
// this example.
$message_body = $_REQUEST['Body'];

// Number from which SMS came. Same number now becomes destination number.
$destination_number = $_REQUEST['From'];

// Number to which SMS has been sent. Same number now becomes source number.
$sender_number = $_REQUEST['To'];

// Open main (required!) InboundXML tag
echo "<Response>";

if (strpos($message_body, 'HELP') !== false) {
	echo "<Sms from=\"{$sender_number}\" to=\"{$destination_number}\">Send STATUS {id} to get order status. Send HELP for more info.</Sms>"; 
} else if (strpos($message_body, 'STATUS') !== false) {
	// Actual order status calculation is requred.
	$order_status = "pending delivery";
	echo "<Sms from=\"{$sender_number}\" to=\"{$destination_number}\">Your order status is {$order_status}</Sms>";
} else {
	// You could say unsuported keyword here. We're going to just repeat HELP.
	echo "<Sms from=\"{$sender_number}\" to=\"{$destination_number}\">Send STATUS {id} to get order status. Send HELP for more info.</Sms>"; 
}

// Close main InboundXML tag
echo "</Response>";
