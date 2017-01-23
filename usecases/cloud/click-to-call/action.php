<?php
// Make sure that MIME type is set to XML. This will ensure that XML is rendered
// properly. Zang requires that InboundXML is a valid XML document.
header('Content-type: application/xml');

// Zang number. Phone number purchased from Zang that will be used as initial call From number
// It should be in E.164 format
$zang_number = "Number purchased from Zang Cloud in E.164 format";

// Your own number. We're going to call you on that number to establish
// main leg (connection)
$origin_number = "your number in E.164 format";

// Number that you wish to call with custom caller id displayed.
$destination_number = "Destination number you wish to call in E.164 format";

// Your AccountSid. You can find it on your zang.io cloud dashboard
$account_sid = "";

// Your AuthToken. You can find it on your zang.io cloud dashboard
$auth_token = "";


// @TODO you shoud do various checks here that all the information are passed properly to you

/** InboundXML document that will be used as way how to establish common conference.
For testing purposes, you can freely use document that's defined bellow.

If you wish to create your own, use zang.io inboundxml editor and create new document with following
content.

<Response>
  <Dial>
    <Conference>ClickToCallExample</Conference>
  </Dial>
</Response>
**/
$voice_url = "http://www.zang.io/data/inboundxml/1495400fb9d45145c9c1a890004a948c4952d7cb"

// Following call to call_party will initiate REST API make call to you. Uppon answer
// you are going to be placed into the conference.
call_party($account_sid, $auth_token, $zang_number, $origin_number, $voice_url);

// This call to call_party will initiate as well REST API make call but from will be
// your number and destination will be your choosen destination number. Uppon answer
// he or she will be placed into conference with you.
call_party($account_sid, $auth_token, $origin_number, $destination_number, $voice_url);


// Method that executes REST API call towards Zang Cloud API
function call_party($account_sid, $auth_token, $from, $to, $voice_url) {
  if($resource = curl_init()) {
      $curl_opts = array(
          CURLOPT_URL            => "http://api.zang.io/v2/Accounts/{$account_sid}/Calls.json",
          CURLOPT_HEADER         => False,
          CURLOPT_RETURNTRANSFER => TRUE,
          CURLOPT_TIMEOUT        => 20,
          CURLOPT_USERPWD        => "{$account_sid}:{$auth_token}",
          CURLOPT_POST           => TRUE,
          CURLOPT_POSTFIELDS     => http_build_query(array(
            "From" => $from,
            "To" => $to,
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
}
