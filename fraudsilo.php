<?php

function fraudsilo_MetaData()
{
    return array("DisplayName" => "FraudSilo", "SupportsRechecks" => true, "APIVersion" => "1.2");
}

function fraudsilo_getConfigArray()
{
    return array(
        "Enable" => array(
            "FriendlyName" => "Enable FraudSilo",
            "Type" => "yesno",
            "Description" => "Tick to enable FraudSilo"
        ),
        "FraudRecordEnable" => array(
            "FriendlyName" => "Enable FraudRecord Check",
            "Type" => "yesno",
            "Description" => "Tick to enable FraudRecord screening for Orders"
        ),
        "FraudRecordApiKey" => array(
            "FriendlyName" => "FraudRecord API Key",
            "Type" => "text",
            "Size" => "30",
            "Description" => "Your FraudRecord API key."
        ),
        "FraudRecordRejectScore" => array(
            "FriendlyName" => "FraudRecord Reject Score Threshold",
            "Type" => "text",
            "Size" => "2",
            "Default" => 5,
            "Description" => "Reject orders with a risk score higher than this value (1 -> 100)."
        ),
	"KickboxEnable" => array(
            "FriendlyName" => "Enable Kickbox Check",
            "Type" => "yesno",
            "Description" => "Tick to enable checking Email Addresses using Kickbox"
        ),
	"KickboxApiKey" => array(
            "FriendlyName" => "Kickbox API Key",
            "Type" => "text",
            "Size" => "30",
            "Description" => "Your Kickbox License key."
        ),
        "KickboxRejectDisposable" => array(
            "FriendlyName" => "Reject Disposable Email Addresses",
            "Type" => "yesno",
            "Description" => "Reject disposable email addresses (eg Mailinator, Trashmail)",
        ),
	"KickboxRejectFree" => array(
            "FriendlyName" => "Reject Free Email Addresses",
            "Type" => "yesno",
            "Description" => "Reject free email addresses (eg Gmail, Outlook.com, Yahoo)",
        ),
	"KickboxRejectRole" => array(
            "FriendlyName" => "Reject Role-based Email Addresses",
            "Type" => "yesno",
            "Description" => "Reject role-based email addresses (eg support@, info@)",
        ),
	"KickboxRejectDidYouMean" => array(
            "FriendlyName" => "Reject Orders when a 'Did You Mean' Suggestion appears for Email Addresses",
            "Type" => "yesno",
            "Description" => "Reject Orders when Kickbox suggests a 'Did You Mean' result for the address (eg customer types gamil.com instead of gmail.com)",
        ),
	"KickboxRejectUndeliverable" => array(
            "FriendlyName" => "Reject Orders for Undeliverable Email Addresses",
            "Type" => "yesno",
            "Description" => "Reject Orders when Kickbox determines an Email Address is Undeliverable",
        ),
	"FraudLabsProEnable" => array(
            "FriendlyName" => "Enable FraudLabs Pro Check",
            "Type" => "yesno",
            "Description" => "Tick to enable FraudLabs Pro screening for Orders"
        ),
	"FraudLabsProApiKey" => array(
            "FriendlyName" => "FraudLabs Pro License/API Key",
            "Type" => "text",
            "Size" => "30",
            "Description" => "Your FraudRecord License key."
        ),
	"FraudLabsProRejectScore" => array(
            "FriendlyName" => "FraudLabs Pro Reject Score Threshold",
            "Type" => "text",
            "Size" => "2",
            "Default" => 70,
            "Description" => "Reject orders with a risk score higher than this value (1 -> 100)."
        ),
	"FraudLabsProRejectProxy" => array(
            "FriendlyName" => "Reject All Orders from Proxy/VPN IPs",
            "Type" => "yesno",
            "Description" => "Tick to reject all orders marked as Proxy/VPN IP addresses by FraudLabs Pro"
        ),
	"FraudLabsProRejectDataCenter" => array(
            "FriendlyName" => "Reject All Orders from Data Center/Web Hosting IPs",
            "Type" => "yesno",
            "Description" => "Tick to reject all orders marked as Data Center/Web Hosting/Transit IP addresses by FraudLabs Pro"
        ),
        "FraudLabsProRejectIPMismatch" => array(
            "FriendlyName" => "Reject All Orders where IP Geolocation Country does not match Customer Country",
            "Type" => "yesno",
            "Description" => "Tick to reject all orders where IP Geolocation Country does not match Customer Country by FraudLabs Pro"
        ),
        "ErrorTitle" => array(
            "FriendlyName" => "Error Message - Title",
            "Type" => "text",
            "Size" => "30",
            "Description" => "Title for the error message when an order fails fraud review",
	    "Default" => "Your Order has been held for Manual Review"
        ),
        "ErrorMsg" => array (
            "FriendlyName" => "Error Message Content",
            "Type" => "textarea",
            "Rows" => "3",
            "Cols" => "50",
            "Description" => "Display this message when order is marked as fraud.",
            "Default" => "Your order is potentially high risk and therefore it has been stopped at this point. If you're using a VPN, please disconnect and attempt your order again. Otherwise, please open a ticket with our Sales and Billing team to have your order manually reviewed.",
        ),
    );
}

function fraudsilo_doFraudCheck(array $params, $checkOnly = false)
{

$responseData=array('ip' => $params['ip'], 'hostname' => gethostbyaddr($params['ip']));

if (isset($params["FraudRecordEnable"]) && !empty($params['FraudRecordApiKey'])) {

$namehash = frecordhash(strtolower(str_replace(" ","",trim($params['clientsdetails']['firstname'].$params['clientsdetails']['lastname']))));

$email=$params['clientsdetails']['email'];

// update gmail to remove anything after + and any dots
if(strpos($email,"@gmail.com") !== false) {
  $emailtemp = substr($email0,strrpos($email,"@gmail.com"));
  if(strpos($email,"+") !== false)
    $emailtemp = substr($email,0,strpos($email,"+"));
    $email = str_replace(".","",$emailtemp)."@gmail.com";
}
if(strpos($email,"@googlemail.com") !== false) {
  $emailtemp = substr($email0,strrpos($email,"@gmail.com"));
  if(strpos($email,"+") !== false)
    $emailtemp = substr($email,0,strpos($email,"+"));
    $email = str_replace(".","",$emailtemp)."@gmail.com";
}

        $fields = array(
                '_api' => $params['FraudRecordApiKey'],
                '_action' => 'query',
                'name' => $namehash,
                'email' => frecordhash($email),
                'ip' => frecordhash($params['ip']),
        );

// add telephone if it exists
if ($params['clientsdetails']['telephoneNumber'] != "") { $fields['phone']=frecordhash($params['clientsdetails']['telephoneNumber']); }

// add address if it exists
$address = $params['clientsdetails']['address1'].$params['clientsdetails']['address2'].$params['clientsdetails']['city'].$params['clientsdetails']['state'];
$address = strtolower(str_replace(" ","",trim($address)));
if ($address != "") {
$fields['address'] = frecordhash($address);
}

        //set the url, number of POST vars, POST data
        $ch=curl_init("https://www.fraudrecord.com/api/");
        curl_setopt($ch,CURLOPT_POSTFIELDS,$fields);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,0);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
        $fraudresult = curl_exec($ch);
        preg_match("~\<report\>([0-9.\-a-f]+)\</report\>~",$fraudresult,$matches);
        $result_exp = explode("-",$matches[1]);


    if (curl_errno($ch)) {
        logActivity("FraudRecord Check - Connection Error: " . curl_error($ch));
        return array(
            "error" => array(
                "title" => "FraudRecord Error",
                "description" => "Unable to connect to FraudRecord API. Please check your configuration."
            )
        );
    }

    curl_close($ch);

    if(isset($result_exp[3]) && strlen($result_exp[3]) == 16) { } else {
        logActivity("FraudRecord Check - Invalid Response: " . $fraudresult. " - ".print_r($fields, 1));
        return array(
            "error" => array(
                "title" => "FraudRecord Error",
                "description" => "Received an invalid response from the FraudRecord API."
            )
        );
    }

    $FRriskScore = $result_exp[0];

    if ($FRriskScore >= $params["FraudRecordRejectScore"]) {
        $failfraud=true;
    }

$responseData['fraudrecord'] = true;
$responseData['fraudrecord_score'] = $FRriskScore;
$responseData['fraudrecord_count'] = $result_exp[1];
$responseData['fraudrecord_reliability'] = $result_exp[2];
$responseData['fraudrecord_details'] = $result_exp[3];

}

if (isset($params["KickboxEnable"]) && !empty($params['KickboxApiKey'])) {

$ch = curl_init("https://api.kickbox.com/v2/verify?email=".urlencode($params['clientsdetails']['email'])."&apikey=".$params['KickboxApiKey']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    if (curl_errno($ch)) {
        logActivity("Kickbox Check - Connection Error: " . curl_error($ch));
        return array(
            "error" => array(
                "title" => "Kickbox Error",
                "description" => "Unable to connect to Kickbox API. Please check your configuration."
            )
	);
    }

curl_close($ch);

if ($httpCode === 200) {
    $KickboxData = json_decode($response, 1);

if ($KickboxData['success'] == true) {

	if ($KickboxData['disposable'] == true && !empty($params['KickboxRejectDisposable'])) {
        $failfraud=true;
	}
        if ($KickboxData['free'] == true && !empty($params['KickboxRejectFree'])) {
        $failfraud=true;
        }
        if ($KickboxData['role'] == true && !empty($params['KickboxRejectRole'])) {
        $failfraud=true;
        }
	if ($KickboxData['did_you_mean'] != false && !empty($params['KickboxRejectDidYouMean'])) {
        $failfraud=true;
        }
	if ($KickboxData['result'] == "undeliverable" && !empty($params['KickboxRejectUndeliverable'])) {
        $failfraud=true;
        }

$responseData['kickbox'] = true;
$responseData['kickbox_disposable'] = $KickboxData['disposable'];
$responseData['kickbox_free'] = $KickboxData['free'];
$responseData['kickbox_role'] = $KickboxData['role'];
$responseData['kickbox_did_you_mean'] = $KickboxData['did_you_mean'];
$responseData['kickbox_result'] = $KickboxData['result'];
$responseData['kickbox_reason'] = $KickboxData['reason'];

    }
}

}

if (isset($params["FraudLabsProEnable"]) && !empty($params['FraudLabsProApiKey'])) {

$orderdata=array(
"first_name" => $params["clientsdetails"]["firstname"],
"last_name" => $params["clientsdetails"]["lastname"],
"bill_country" => $params["clientsdetails"]["country"],
"ip" => $params['ip'],
"format" => "json",
"email" => $params["clientsdetails"]["email"],
"user_order_id" => substr($params["order"]["order_number"], 0, 15), 
"amount" => $params["order"]["amount"],
"key" => $params['FraudLabsProApiKey'],
);
if ($params["clientsdetails"]["address1"]) { $orderdata["bill_addr"] = $params["clientsdetails"]["address1"]; }
if ($params["clientsdetails"]["city"]) { $orderdata["bill_city"] = $params["clientsdetails"]["city"]; }
if ($params["clientsdetails"]["state"]) { $orderdata["bill_state"] = $params["clientsdetails"]["state"]; }
if ($params["clientsdetails"]["postcode"]) { $orderdata["bill_zip_code"] = $params["clientsdetails"]["postcode"]; }
if ($params["clientsdetails"]["telephoneNumber"]) { $orderdata["user_phone"] = $params["clientsdetails"]["telephoneNumber"]; }

    $model = $params["clientsdetails"]["model"];
    if ($model instanceof WHMCS\User\Client) {
        $currencyCode = $model->currencyrel->code;
    } else {
        $currencyCode = $model->client->currencyrel->code;
    }
$orderdata['currency'] = $currencyCode;
$ch=curl_init("https://api.fraudlabspro.com/v2/order/screen");
curl_setopt($ch, CURLOPT_POSTFIELDS, $orderdata);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$fraudlabsdata=curl_exec($ch);
$fraudlabsresult=json_decode($fraudlabsdata, 1);
    if (curl_errno($ch)) {
        logActivity("FraudLabs Pro Check - Connection Error: " . curl_error($ch));
        return array(
            "error" => array(
                "title" => "FraudLabs Pro Error",
                "description" => "Unable to connect to FraudLabs Pro API. Please check your configuration."
            )
	);
    }

curl_close($ch);

if ($fraudlabsresult['user_order_id'] == substr($params["order"]["order_number"], 0, 15)) {

    if ($fraudlabsresult['fraudlabspro_score'] >= $params["FraudLabsProRejectScore"]) {
        $failfraud=true;
    }
    if ($fraudlabsresult['ip_geolocation']['is_proxy'] == true && !empty($params['FraudLabsProRejectProxy'])) {
        $failfraud=true;
    }
    if ($fraudlabsresult['ip_geolocation']['usage_type'] == "Data Center/Web Hosting/Transit" && !empty($params['FraudLabsProRejectDataCenter'])) {
        $failfraud=true;
    }
    if ($fraudlabsresult['ip_geolocation']['usage_type'] == "Content Delivery Network" && !empty($params['FraudLabsProRejectDataCenter'])) {
        $failfraud=true;
    }
    if ($fraudlabsresult['billing_address']['is_ip_country_match'] == false && !empty($params['FraudLabsProRejectIPMismatch'])) {
        $failfraud=true;
    }


$responseData['fraudlabspro'] = true;
$responseData['fraudlabspro_score'] = $fraudlabsresult['fraudlabspro_score'];
$responseData['fraudlabspro_status'] = $fraudlabsresult['fraudlabspro_status'];
$responseData['fraudlabspro_ipcity'] = $fraudlabsresult['ip_geolocation']['city'];
$responseData['fraudlabspro_ipcountry'] = $fraudlabsresult['ip_geolocation']['country_name'];
$responseData['fraudlabspro_iplat'] = $fraudlabsresult['ip_geolocation']['latitude'];
$responseData['fraudlabspro_iplong'] = $fraudlabsresult['ip_geolocation']['longitude'];
$responseData['fraudlabspro_ipowner'] = $fraudlabsresult['ip_geolocation']['isp_name'];
$responseData['fraudlabspro_ipdomain'] = $fraudlabsresult['ip_geolocation']['domain'];
$responseData['fraudlabspro_iptype'] = $fraudlabsresult['ip_geolocation']['usage_type'][0];
$responseData['fraudlabspro_ipproxy'] = $fraudlabsresult['ip_geolocation']['is_proxy'];
$responseData['fraudlabspro_ipdist'] = $fraudlabsresult['billing_address']['ip_distance_in_km'];
$responseData['fraudlabspro_ipmatch'] = $fraudlabsresult['billing_address']['is_ip_country_match'];
$responseData['fraudlabspro_id'] = $fraudlabsresult['fraudlabspro_id'];
$responseData['fraudlabspro_credits'] = $fraudlabsresult['remaining_credits'];
}

}

    if (isset($failfraud)) {
        $returnData["error"] = array("title" => $params['ErrorTitle'], "description" => $params['ErrorMsg']);
    }

   $returnData['data'] = $responseData;
    return $returnData;
}

function fraudsilo_processResultsForDisplay(array $params)
{
    $responseData = json_decode($params['data'], 1);
$output="";
if (isset($responseData['fraudlabspro'])) {
    $score = htmlspecialchars($responseData['fraudlabspro_score']);
    $scoreImageUrl = "https://cdn.fraudlabspro.com/assets/img/scores/meter-" . $score . ".png";

    $output .= "
    <h4>FraudLabs Pro Results:</h4>
<table style='border-collapse: collapse; width: 100%; text-align: left;' class='table'>
    <!-- Row for Score, Status, and Image -->
    <tr>
        <td rowspan='6' style='text-align: center; width: 12%; padding: 8px; vertical-align: top;'>
            <img src='" . $scoreImageUrl . "' alt='FraudLabs Pro Score Meter' style='max-width: 150px; max-height: 80px; margin-bottom: 10px;'><br><h4>
            <strong>Score:</strong> " . $score . "<br>
            <strong>Status:</strong> " . htmlspecialchars($responseData['fraudlabspro_status']) . "</h4>
        </td>
        <th style='width: 14%; padding: 8px;'>IP City</th>
        <td style='width: 30%; padding: 8px;'>" . htmlspecialchars($responseData['fraudlabspro_ipcity']) . "</td>
        <th style='width: 14%; padding: 8px;'>IP Country</th>
        <td style='width: 30%; padding: 8px;'>" . htmlspecialchars($responseData['fraudlabspro_ipcountry']) . "</td>
    </tr>
    <!-- Row for IP Location and Reverse Hostname -->
    <tr>
        <th style='padding: 8px;'>IP Location</th>
        <td style='padding: 8px;'>
            <a href='https://www.google.com/maps/place/" . htmlspecialchars($responseData['fraudlabspro_iplat']) . "," . htmlspecialchars($responseData['fraudlabspro_iplong']) . "' target='_blank'>" . htmlspecialchars($responseData['fraudlabspro_iplat']) . ", " . htmlspecialchars($responseData['fraudlabspro_iplong']) . "</a>
        </td>
        <th style='padding: 8px;'>IP & Reverse Hostname</th>
        <td style='padding: 8px;'><a href='https://ipinfo.io/" . htmlspecialchars($responseData['ip']) . "' target='_blank'>".htmlspecialchars($responseData['ip'])."</a> (" . htmlspecialchars($responseData['hostname']) . ")</td>
    </tr>
    <!-- Row for IP Owner and IP Domain -->
    <tr>
        <th style='padding: 8px;'>IP Owner</th>
        <td style='padding: 8px;'>" . htmlspecialchars($responseData['fraudlabspro_ipowner']) . "</td>
        <th style='padding: 8px;'>IP Domain</th>
        <td style='padding: 8px;'>" . htmlspecialchars($responseData['fraudlabspro_ipdomain']) . "</td>
    </tr>
    <!-- Row for IP Type and IP Proxy -->
    <tr>
        <th style='padding: 8px;'>IP Type</th>
        <td style='padding: 8px;'>" . htmlspecialchars($responseData['fraudlabspro_iptype']) . "</td>
        <th style='padding: 8px;'>IP Proxy</th>
        <td style='padding: 8px;'>" . htmlspecialchars($responseData['fraudlabspro_ipproxy'] ? 'Yes 🚨' : 'No') . "</td>
    </tr>
    <!-- Row for IP Distance and IP Country Match -->
    <tr>
        <th style='padding: 8px;'>IP Distance (km)</th>
        <td style='padding: 8px;'>" . htmlspecialchars($responseData['fraudlabspro_ipdist']) . "</td>
        <th style='padding: 8px;'>IP Country Match</th>
        <td style='padding: 8px;'>" . htmlspecialchars($responseData['fraudlabspro_ipmatch'] ? 'Yes' : 'No 🚨') . "</td>
    </tr>
    <!-- Row for FraudLabs Pro ID and Credits Remaining -->
    <tr>
        <th style='padding: 8px;'>FraudLabs Pro ID</th>
        <td style='padding: 8px;'>
            <a href='https://www.fraudlabspro.com/merchant/transaction-details/" . htmlspecialchars($responseData['fraudlabspro_id']) . "' target='_blank'>" . htmlspecialchars($responseData['fraudlabspro_id']) . "</a>
        </td>
        <th style='padding: 8px;'>Credits Remaining</th>
        <td style='padding: 8px;'>" . htmlspecialchars($responseData['fraudlabspro_credits']) . "</td>
    </tr>
</table>
    ";
}

if (isset($responseData['fraudrecord']) && isset($responseData['kickbox'])) {

$output .= "
<table style='border-collapse: collapse; width: 100%; text-align: left; padding: 8px;' class='table'>
    <tr>
        <th colspan='2' style='text-align: left; width: 50%;'><h4>FraudRecord Results:</h4></th>
        <th colspan='2' style='text-align: left;'><h4>Kickbox Results:</h4></th>
    </tr>
    <tr>
        <td style='width:15%;'><strong>Risk Score</strong></td>
        <td style='width:35%;'>" . htmlspecialchars($responseData["fraudrecord_score"]) . "</td>
        <td style='width:15%;'><strong>Disposable Email Address</strong></td>
        <td style='width:35%;'>" . htmlspecialchars($responseData['kickbox_disposable'] ? 'Yes 🚨' : 'No') . "</td>
    </tr>
    <tr>
        <td><strong>Count</strong></td>
        <td>" . htmlspecialchars($responseData["fraudrecord_count"]) . "</td>
        <td><strong>Free Email Address</strong></td>
        <td>" . htmlspecialchars($responseData['kickbox_free'] ? 'Yes ⚠️' : 'No') . "</td>
    </tr>
    <tr>
        <td><strong>Reliability</strong></td>
        <td>" . htmlspecialchars($responseData["fraudrecord_reliability"]) . "</td>
        <td><strong>Role-based Email Address</strong></td>
        <td>" . htmlspecialchars($responseData['kickbox_role'] ? 'Yes ⚠️' : 'No') . "</td>
    </tr>
    <tr>
        <td><strong>Details</strong></td>
        <td><a href='https://www.fraudrecord.com/api/?showreport=" . htmlspecialchars($responseData["fraudrecord_details"]) . "' target='_blank'>Show Report</a></td>
        <td><strong>Did You Mean?</strong></td>
        <td>" . htmlspecialchars($responseData['kickbox_did_you_mean'] ? 'Yes ⚠️' : 'No') . "</td>
    </tr>
    <tr>
        <td colspan='2'></td>
        <td><strong>Delivery Result and Reason</strong></td>
        <td>" . htmlspecialchars(ucfirst($responseData['kickbox_result'])) . " (" . htmlspecialchars($responseData['kickbox_reason']) . ")</td>
    </tr>
</table>
";

}

if (isset($responseData['fraudrecord']) && !isset($responseData['kickbox'])) {
    $output .= "
    <h4>FraudRecord Results:</h4>
    <table style='border-collapse: collapse; width: 100%; text-align: left;  padding: 8px;' class='table'>
        <tr>
            <th style='width: 50%;'>Risk Score</th>
            <td>" . htmlspecialchars($responseData["fraudrecord_score"]) . "</td>
        </tr>
	<tr>
            <th>Count</th>
            <td>" . htmlspecialchars($responseData["fraudrecord_count"]) . "</td>
        </tr>
	<tr>
            <th>Reliability</th>
            <td>" . htmlspecialchars($responseData["fraudrecord_reliability"]) . "</td>
        </tr>
	<tr>
            <th>Details</th>
            <td><a href='https://www.fraudrecord.com/api/?showreport=" . htmlspecialchars($responseData["fraudrecord_details"]) . "' target='_blank'>Show Report</a></td>
        </tr>
    </table>
    ";
}

if (isset($responseData['kickbox']) && !isset($responseData['fraudrecord'])) {
    $output .= "
    <h4>Kickbox Results:</h4>
    <table style='border-collapse: collapse; width: 100%; text-align: left;  padding: 8px;' class='table'>
        <tr>
            <th style='width:50%;'>Disposable Email Address</th>
	    <td>" . htmlspecialchars($responseData['kickbox_disposable'] ? 'Yes 🚨' : 'No') . "</td>
        </tr>
        <tr>
            <th>Free Email Address</th>
            <td>" . htmlspecialchars($responseData['kickbox_free'] ? 'Yes ⚠️' : 'No') . "</td>
	</tr>
        <tr>
            <th>Role-based Email Address</th>
            <td>" . htmlspecialchars($responseData['kickbox_role'] ? 'Yes ⚠️' : 'No') . "</td>
        </tr>
	<tr>
            <th>Did You Mean?</th>
            <td>" . htmlspecialchars($responseData['kickbox_did_you_mean'] ? 'Yes ⚠️' : 'No') . "</td>
        </tr>
        <tr>
	    <th>Delivery Result and Reason</th>
            <td>" . htmlspecialchars(ucfirst($responseData['kickbox_result'])) . " (" . htmlspecialchars($responseData['kickbox_reason']) . ")</td>
        </tr>
    </table>
    ";
}

    $output.="<h2>Fraud Protection by <a href=\"https://fraudsilo.com\" target=\"_blank\">FraudSilo</a></h2>";

return $output;
}

function frecordhash($value)
{
        for($i = 0; $i < 32000; $i++)
                $value = sha1("fraudrecord-".$value);
        return $value;
}

