<?php
// Make sure that MIME type is set to XML. This will ensure that XML is rendered
// properly. Zang requires that InboundXML is a valid XML document.
header('Content-type: application/xml');

// Number from which SMS came. Same number now becomes destination number.
$destination_number = $_REQUEST['From'];
// Number to which SMS has been sent. Same number now becomes source number.
$sender_number = $_REQUEST['To'];
// Open main (required!) InboundXML tag
echo "<Response>";

switch (@$_REQUEST['Digits']) {

	case 1:  // Keynote:  Caller will be attending
		echo "<Say>Thats great news!  Let us check availability and we will send you a confirmation shortly</Say>";
		echo "<Sms from=\"{$sender_number}\" to=\"{$destination_number}\">Good news! Your seat has been reserved for the Keynote.</Sms>"; 
		break;

	case 2: // Keynote:  Caller will note be attending
		echo "<Say>Sorry you cant make it.  We will be sending you a confirmation of your decision shortly.</Say>";
		echo "<Sms from=\"{$sender_number}\" to=\"{$destination_number}\">Ok. Maybe next time.  Your Keynote seat has not been reserved.</Sms>"; 
		break;

	case 3: //Keynote:  Caller would like more information
		echo "<Say>So your still considering, thats good.  We are sending you more Keynote details now.</Say>";
		echo "<Sms from=\"{$sender_number}\" to=\"{$destination_number}\">Here are your Keynote details: www.zang.io  Please consider coming.</Sms>"; 
		break;

	default: //Try again! Timeout passed or invalid digit is provided.
		echo "<Say>Oh, it looks like you pressed " . htmlspecialchars($_REQUEST['Digits']) . ", lets try this again</Say>";
		echo "<Redirect>http://back-to-main-gather-ivr-document.xml</Redirect>";
		break;

}


// Close main InboundXML tag
echo "</Response>";
