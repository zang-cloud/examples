<?php
// Make sure that MIME type is set to XML. This will ensure that XML is rendered
// properly. Zang requires that InboundXML is a valid XML document.
header('Content-type: application/xml');

// Zang number. Phone number purchased from Zang that will be used as initial call From number
// It should be in E.164 format
$zang_number = "";

// Number you wish to appear as
$custom_caller = $_REQUEST['caller_id'];

// Your own number. We're going to call you on that number to establish
// main leg (connection)
$origin_number = $_REQUEST['customer_origin_number'];

// Number that you wish to call with custom caller id displayed.
$destination_number = $_REQUEST['destination_number'];

// Your AccountSid. You can find it on your zang.io cloud dashboard
$account_sid = "";

// Your AuthToken. You can find it on your zang.io cloud dashboard
$auth_token = "";


// @TODO you shoud do various checks here that all the information are passed properly to you

/** InboundXML document that will be used as way how to establish custom caller id.
For testing purposes, you can freely use document that's defined bellow.

If you wish to create your own, use zang.io inboundxml editor and create new document with following
content. {{}} are used to replace QUERY STRING or POST parameters. This is feature that's provided by us
from zang.io website. It's not available generally outside of the zang.io website. You have to build
simillary capatibilities by yourself.

<Response>
  <Dial callerId="{{CustomCallerId}}">{{TargetDestination}}</Dial>
</Response>
**/
$voice_url = "http://www.zang.io/data/inboundxml/0046fbdb960591db7d54b526e70810f57eda1760?CustomCallerId={$custom_caller}&TargetDestination={$destination_number}"


if($resource = curl_init()) {
    $curl_opts = array(
        CURLOPT_URL            => "http://api.zang.io/v2/Accounts/{$account_sid}/Calls.json",
        CURLOPT_HEADER         => False,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_TIMEOUT        => 20,
        CURLOPT_USERPWD        => "{$account_sid}:{$auth_token}",
        CURLOPT_POST           => TRUE,
        CURLOPT_POSTFIELDS     => http_build_query(array(
          "From" => $zang_number,
          "To" => $origin_number,
          "Url" => $voice_url
        ))
    );

    curl_setopt_array($resource, $curl_opts)
    $response_exec  = curl_exec($resource);
    $response_error = curl_error($resource);

    if ($response_error) {
      die("Got error while attempting to make new call: " . $response_error);
    }

    // Will print back response given from Zang Cloud API.
    print_r($response_exec);
}
