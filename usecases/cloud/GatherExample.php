<?php

// Make sure that MIME type is set to XML. This will ensure that XML is rendered
// properly. Zang requires that InboundXML is a valid XML document.
header('Content-type: application/xml');

// Customer Service Department Phone Number.
// Please make sure to use E.164 number format
$customer_service_number = "";

// Techical Support Phone Number.
// Please make sure to use E.164 number format
$techical_support_number = "";

// Sales Department Phone Number.
// Please make sure to use E.164 number format
$sales_number = "";

echo "<Response>";

switch(@$_REQUEST['Digits']) {
	// Customer Service Department IVR
	case 1:
		echo "<Say>We are about to connect you with customer service department. Please wait for a moment.</Say>";
		echo "<Dial>{$customer_service_number}</Dial>";
		break;
	// Technical support IVR
	case 2:
		echo "<Say>We are about to connect you with techical support. Please wait for a moment.</Say>";
		echo "<Dial>{$techical_support_number}</Dial>";
		break;
	// Sales Department IVR
	case 3:
		echo "<Say>We are about to connect you with sales department. Please wait for a moment.</Say>";
		echo "<Dial>{$sales_number}</Dial>";
		break;
	// Will trigger IVR for default (when none of the options are passed) 
	// and any other case, including 4
	default:
		echo "<Redirect>http://path-to-original-gather-inboundxml-document</Redirect>";
		break;
}

echo "</Response>";
