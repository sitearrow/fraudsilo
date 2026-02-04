<?php
/* 
FraudSilo fraud protection module for WHMCS
https://github.com/sitearrow/fraudsilo/
v2.0.0 - released 2025-02-03
New in v2.0: Private blocklist support, AI-powered fraud detection using Claude Haiku
*/
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
        "BlocklistEnable" => array(
            "FriendlyName" => "Enable Private Blocklist",
            "Type" => "yesno",
            "Description" => "Tick to enable checking against your private blocklist (fraudsilo_blocklist.php)"
        ),
        "BlocklistPath" => array(
            "FriendlyName" => "Blocklist File Path",
            "Type" => "text",
            "Size" => "60",
            "Default" => __DIR__ . '/fraudsilo_blocklist.php',
            "Description" => "Full path to your blocklist configuration file"
        ),
        "AICheckEnable" => array(
            "FriendlyName" => "Enable AI Fraud Detection",
            "Type" => "yesno",
            "Description" => "Use Claude Haiku AI to analyze orders for suspicious patterns"
        ),
        "AIApiKey" => array(
            "FriendlyName" => "Anthropic API Key",
            "Type" => "password",
            "Size" => "60",
            "Description" => "Your Anthropic API key for Claude"
        ),
        "AIModel" => array(
            "FriendlyName" => "AI Model",
            "Type" => "text",
            "Size" => "40",
            "Default" => "claude-haiku-4-5",
            "Description" => "Claude model to use (e.g., claude-haiku-4-5, claude-sonnet-4-5)"
        ),
        "AIRejectOnFlag" => array(
            "FriendlyName" => "Auto-reject AI Flagged Orders",
            "Type" => "yesno",
            "Description" => "Automatically reject orders that AI flags as likely fraudulent"
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
        "ErrorMsg" => array(
            "FriendlyName" => "Error Message Content",
            "Type" => "textarea",
            "Rows" => "3",
            "Cols" => "50",
            "Description" => "Display this message when order is marked as fraud.",
            "Default" => "Your order is potentially high risk and therefore it has been stopped at this point. If you're using a VPN, please disconnect and attempt your order again. Otherwise, please open a ticket with our Sales and Billing team to have your order manually reviewed.",
        ),
    );
}

/**
 * Load the private blocklist from the configuration file
 */
function fraudsilo_loadBlocklist($path)
{
    if (!file_exists($path)) {
        logActivity("FraudSilo Blocklist - File not found: " . $path);
        return null;
    }

    $blocklist = include $path;
    
    if (!is_array($blocklist)) {
        logActivity("FraudSilo Blocklist - Invalid format in: " . $path);
        return null;
    }

    return $blocklist;
}

/**
 * Check if an IP is within a CIDR range
 */
function fraudsilo_ipInCidr($ip, $cidr)
{
    if (strpos($cidr, '/') === false) {
        return $ip === $cidr;
    }

    list($subnet, $bits) = explode('/', $cidr);
    $ip = ip2long($ip);
    $subnet = ip2long($subnet);
    $mask = -1 << (32 - $bits);
    $subnet &= $mask;
    
    return ($ip & $mask) == $subnet;
}

/**
 * Check if an IP is within a range
 */
function fraudsilo_ipInRange($ip, $start, $end)
{
    $ip = ip2long($ip);
    $start = ip2long($start);
    $end = ip2long($end);
    
    return ($ip >= $start && $ip <= $end);
}

/**
 * Check order against private blocklist
 */
function fraudsilo_checkBlocklist(array $params, array $blocklist)
{
    $result = [
        'blocked' => false,
        'reasons' => [],
        'matched_rules' => []
    ];

    $email = strtolower(trim($params['clientsdetails']['email']));
    $emailDomain = substr($email, strpos($email, '@') + 1);
    $fullName = strtolower(trim($params['clientsdetails']['firstname'] . ' ' . $params['clientsdetails']['lastname']));
    $ip = $params['ip'];
    $phone = preg_replace('/[^0-9]/', '', $params['clientsdetails']['telephoneNumber'] ?? '');
    $country = strtoupper($params['clientsdetails']['country'] ?? '');

    // Check blocked emails
    if (!empty($blocklist['blocked_emails'])) {
        foreach ($blocklist['blocked_emails'] as $blockedEmail) {
            if (strtolower($blockedEmail) === $email) {
                $result['blocked'] = true;
                $result['reasons'][] = "Email address is on blocklist";
                $result['matched_rules'][] = ['type' => 'email', 'value' => $blockedEmail];
            }
        }
    }

    // Check blocked email domains
    if (!empty($blocklist['blocked_email_domains'])) {
        foreach ($blocklist['blocked_email_domains'] as $blockedDomain) {
            if (strtolower($blockedDomain) === $emailDomain) {
                $result['blocked'] = true;
                $result['reasons'][] = "Email domain is on blocklist";
                $result['matched_rules'][] = ['type' => 'email_domain', 'value' => $blockedDomain];
            }
        }
    }

    // Check blocked names (partial match)
    if (!empty($blocklist['blocked_names'])) {
        foreach ($blocklist['blocked_names'] as $blockedName) {
            if (stripos($fullName, strtolower($blockedName)) !== false) {
                $result['blocked'] = true;
                $result['reasons'][] = "Name matches blocklist pattern";
                $result['matched_rules'][] = ['type' => 'name_partial', 'value' => $blockedName];
            }
        }
    }

    // Check blocked names (exact match)
    if (!empty($blocklist['blocked_names_exact'])) {
        foreach ($blocklist['blocked_names_exact'] as $blockedName) {
            if (strtolower($blockedName) === $fullName) {
                $result['blocked'] = true;
                $result['reasons'][] = "Name exactly matches blocklist";
                $result['matched_rules'][] = ['type' => 'name_exact', 'value' => $blockedName];
            }
        }
    }

    // Check blocked IPs
    if (!empty($blocklist['blocked_ips'])) {
        foreach ($blocklist['blocked_ips'] as $blockedIp) {
            if (fraudsilo_ipInCidr($ip, $blockedIp)) {
                $result['blocked'] = true;
                $result['reasons'][] = "IP address is on blocklist";
                $result['matched_rules'][] = ['type' => 'ip', 'value' => $blockedIp];
            }
        }
    }

    // Check blocked IP ranges
    if (!empty($blocklist['blocked_ip_ranges'])) {
        foreach ($blocklist['blocked_ip_ranges'] as $range) {
            if (fraudsilo_ipInRange($ip, $range['start'], $range['end'])) {
                $result['blocked'] = true;
                $result['reasons'][] = "IP address is in blocked range";
                $result['matched_rules'][] = ['type' => 'ip_range', 'value' => $range['start'] . '-' . $range['end']];
            }
        }
    }

    // Check blocked phones
    if (!empty($blocklist['blocked_phones']) && !empty($phone)) {
        foreach ($blocklist['blocked_phones'] as $blockedPhone) {
            $normalizedBlocked = preg_replace('/[^0-9]/', '', $blockedPhone);
            if ($normalizedBlocked === $phone) {
                $result['blocked'] = true;
                $result['reasons'][] = "Phone number is on blocklist";
                $result['matched_rules'][] = ['type' => 'phone', 'value' => $blockedPhone];
            }
        }
    }

    // Check blocked countries
    if (!empty($blocklist['blocked_countries']) && !empty($country)) {
        foreach ($blocklist['blocked_countries'] as $blockedCountry) {
            if (strtoupper($blockedCountry) === $country) {
                $result['blocked'] = true;
                $result['reasons'][] = "Country is on blocklist";
                $result['matched_rules'][] = ['type' => 'country', 'value' => $blockedCountry];
            }
        }
    }

    // Check email patterns
    if (!empty($blocklist['blocked_email_patterns'])) {
        foreach ($blocklist['blocked_email_patterns'] as $pattern) {
            if (preg_match($pattern, $email)) {
                $result['blocked'] = true;
                $result['reasons'][] = "Email matches blocked pattern";
                $result['matched_rules'][] = ['type' => 'email_pattern', 'value' => $pattern];
            }
        }
    }

    // Check name patterns
    if (!empty($blocklist['blocked_name_patterns'])) {
        foreach ($blocklist['blocked_name_patterns'] as $pattern) {
            if (preg_match($pattern, $fullName)) {
                $result['blocked'] = true;
                $result['reasons'][] = "Name matches blocked pattern";
                $result['matched_rules'][] = ['type' => 'name_pattern', 'value' => $pattern];
            }
        }
    }

    return $result;
}

/**
 * Perform AI-powered fraud analysis using Claude Haiku
 */
function fraudsilo_aiCheck(array $params)
{
    $result = [
        'checked' => false,
        'flagged' => false,
        'risk_level' => 'unknown',
        'risk_score' => 0,
        'reasons' => [],
        'analysis' => '',
        'error' => null
    ];

    // Gather order data for analysis
    $firstName = $params['clientsdetails']['firstname'];
    $lastName = $params['clientsdetails']['lastname'];
    $email = $params['clientsdetails']['email'];
    $company = $params['clientsdetails']['companyname'] ?? '';
    $address = trim($params['clientsdetails']['address1'] . ' ' . ($params['clientsdetails']['address2'] ?? ''));
    $city = $params['clientsdetails']['city'];
    $state = $params['clientsdetails']['state'];
    $country = $params['clientsdetails']['country'];
    $phone = $params['clientsdetails']['telephoneNumber'] ?? '';
    
    // Get ordered domains/products via WHMCS Internal API
    $orderedDomains = [];
    $orderedProducts = [];
    
    if (!empty($params['order']['id'])) {
        $orderResult = localAPI('GetOrders', array('id' => $params['order']['id']));
        
        if ($orderResult['result'] === 'success' && !empty($orderResult['orders']['order'][0])) {
            $orderData = $orderResult['orders']['order'][0];
            
            // Get domains from order
            if (!empty($orderData['lineitems']['lineitem'])) {
                foreach ($orderData['lineitems']['lineitem'] as $item) {
                    if (!empty($item['domain'])) {
                        $orderedDomains[] = $item['domain'];
                    }
                    if (!empty($item['product'])) {
                        $orderedProducts[] = $item['product'];
                    }
                }
            }
        }
    }

    
    // Build the analysis prompt
    $prompt = "You are a fraud detection analyst for a web hosting company. Analyze this order for potential fraud indicators.

ORDER DETAILS:
- Customer Name: {$firstName} {$lastName}
- Email: {$email}
- Company: " . ($company ?: 'Not provided') . "
- Address: {$address}, {$city}, {$state}, {$country}
- Phone: " . ($phone ?: 'Not provided') . " (Note: +CC.number format like +1.4019394798 is standard for this system. However, the country code should match the selected billing country)
- Ordered Domains: " . (empty($orderedDomains) ? 'None' : implode(', ', $orderedDomains)) . "
- Ordered Products: " . (empty($orderedProducts) ? 'None' : implode(', ', $orderedProducts)) . "

Analyze for these fraud indicators:
1. NAME-EMAIL MISMATCH: Does the name match what you'd expect from the email? (e.g., john.smith@email.com should be John Smith, not Jane Doe)
2. SUSPICIOUS DOMAINS: Are any ordered domains random characters, keyboard patterns, or look like phishing attempts (e.g., paypa1-secure.com, amaz0n-verify.net)?
3. FAKE/PLACEHOLDER DATA: Does the data look like test data, keyboard mashing, or obvious fakes?
4. SUSPICIOUS PATTERNS: Single-character names, email username entirely numeric, company name doesn't match other details
5. PHISHING INDICATORS: Domains mimicking well-known brands with typos or number substitutions
6. JUNK/GARBAGE ADDRESS: Address contains repeated text, nonsensical strings, copy-paste errors, or text that doesn't form a valid address (e.g., same words repeated multiple times, random characters, city name appearing in street address multiple times)
7. COUNTRY MISMATCH: Does the phone country code match the selected country? Does the city/address clearly belong to a different country than selected? (e.g., selecting US but city is 'MARRAKECH' which is clearly Morocco)

Respond in this exact JSON format:
{
    \"risk_level\": \"low|medium|high|critical\",
    \"risk_score\": <number 0-100>,
    \"flagged\": <true if risk_level is high or critical, false otherwise>,
    \"reasons\": [\"reason1\", \"reason2\"],
    \"analysis\": \"Brief explanation of findings\"
}

Be practical - not every mismatch is fraud. Focus on clear indicators. Low risk for normal-looking orders.";



    // Make API call to Claude
    $model = $params['AIModel'] ?? 'claude-haiku-4-5';
    $ch = curl_init('https://api.anthropic.com/v1/messages');
    
    $requestBody = json_encode([
        'model' => $model,
        'max_tokens' => 500,
        'messages' => [
            ['role' => 'user', 'content' => $prompt]
        ]
    ]);

    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $requestBody,
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'x-api-key: ' . $params['AIApiKey'],
            'anthropic-version: 2023-06-01'
        ],
        CURLOPT_TIMEOUT => 30
    ]);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($curlError) {
        logActivity("FraudSilo AI Check - Connection Error: " . $curlError);
        $result['error'] = "Unable to connect to AI service";
        return $result;
    }

    if ($httpCode !== 200) {
        logActivity("FraudSilo AI Check - API Error (HTTP {$httpCode}): " . $response);
        $result['error'] = "AI service returned error (HTTP {$httpCode})";
        return $result;
    }

    $responseData = json_decode($response, true);
    
    if (!isset($responseData['content'][0]['text'])) {
        logActivity("FraudSilo AI Check - Invalid response format: " . $response);
        $result['error'] = "Invalid response from AI service";
        return $result;
    }

    // Parse the AI response
    $aiText = $responseData['content'][0]['text'];
    
    // Extract JSON from response (handle potential markdown code blocks)
    if (preg_match('/\{[\s\S]*\}/', $aiText, $matches)) {
        $aiResult = json_decode($matches[0], true);
        
        if ($aiResult) {
            $result['checked'] = true;
            $result['risk_level'] = $aiResult['risk_level'] ?? 'unknown';
            $result['risk_score'] = (int)($aiResult['risk_score'] ?? 0);
            $result['flagged'] = (bool)($aiResult['flagged'] ?? false);
            $result['reasons'] = $aiResult['reasons'] ?? [];
            $result['analysis'] = $aiResult['analysis'] ?? '';
        } else {
            logActivity("FraudSilo AI Check - Failed to parse JSON: " . $aiText);
            $result['error'] = "Failed to parse AI response";
        }
    } else {
        logActivity("FraudSilo AI Check - No JSON found in response: " . $aiText);
        $result['error'] = "No valid analysis in AI response";
    }

    return $result;
}

function fraudsilo_doFraudCheck(array $params, $checkOnly = false)
{
    // Debug: Log incoming params
//    logActivity("FraudSilo Debug - doFraudCheck called. Params keys: " . implode(', ', array_keys($params)));
//    logActivity("FraudSilo Debug - BlocklistEnable: " . ($params['BlocklistEnable'] ?? 'not set'));
//    logActivity("FraudSilo Debug - AICheckEnable: " . ($params['AICheckEnable'] ?? 'not set'));
//    logActivity("FraudSilo Debug - FraudRecordEnable: " . ($params['FraudRecordEnable'] ?? 'not set'));
    
    $returnData = array();
    $responseData = array(
        'ip' => $params['ip'],
        'hostname' => gethostbyaddr($params['ip'])
    );
    $failfraud = false;

    // --- Private Blocklist Check ---
    if (!empty($params["BlocklistEnable"])) {
        $blocklistPath = $params['BlocklistPath'] ?? __DIR__ . '/fraudsilo_blocklist.php';
        $blocklist = fraudsilo_loadBlocklist($blocklistPath);
        
        if ($blocklist) {
            $blocklistResult = fraudsilo_checkBlocklist($params, $blocklist);
            
            $responseData['blocklist'] = true;
            $responseData['blocklist_blocked'] = $blocklistResult['blocked'];
            $responseData['blocklist_reasons'] = $blocklistResult['reasons'];
            $responseData['blocklist_matched_rules'] = $blocklistResult['matched_rules'];
            
            if ($blocklistResult['blocked']) {
                $failfraud = true;
                logActivity("FraudSilo Blocklist - Order blocked: " . implode(', ', $blocklistResult['reasons']));
            }
        } else {
            $responseData['errors'][] = [
                "title" => "Blocklist Error",
                "description" => "Unable to load blocklist configuration file."
            ];
        }
    }

    // --- AI Fraud Detection Check ---
    if (!empty($params["AICheckEnable"]) && !empty($params['AIApiKey'])) {
        $aiResult = fraudsilo_aiCheck($params);
        
        $responseData['ai_check'] = true;
        $responseData['ai_model'] = $params['AIModel'] ?? 'claude-haiku-4-20250414';
        $responseData['ai_checked'] = $aiResult['checked'];
        $responseData['ai_flagged'] = $aiResult['flagged'];
        $responseData['ai_risk_level'] = $aiResult['risk_level'];
        $responseData['ai_risk_score'] = $aiResult['risk_score'];
        $responseData['ai_reasons'] = $aiResult['reasons'];
        $responseData['ai_analysis'] = $aiResult['analysis'];
        
        if ($aiResult['error']) {
            $responseData['errors'][] = [
                "title" => "AI Check Error",
                "description" => $aiResult['error']
            ];
        }
        
        if ($aiResult['flagged'] && !empty($params['AIRejectOnFlag'])) {
            $failfraud = true;
            // logActivity("FraudSilo AI Check - Order flagged as " . $aiResult['risk_level'] . " risk: " . $aiResult['analysis']);
        }
    }

    // --- FraudRecord Check ---
    if (isset($params["FraudRecordEnable"]) && !empty($params['FraudRecordApiKey'])) {

        $namehash = frecordhash(strtolower(str_replace(" ", "", trim($params['clientsdetails']['firstname'] . $params['clientsdetails']['lastname']))));
        $email = $params['clientsdetails']['email'];

        // Normalize Gmail address
        if (strpos($email, "@gmail.com") !== false || strpos($email, "@googlemail.com") !== false) {
            $emailtemp = $email;
            if (strpos($email, "+") !== false) {
                $emailtemp = substr($email, 0, strpos($email, "+"));
            }
            $email = str_replace(".", "", $emailtemp) . "@gmail.com";
        }

        $fields = [
            '_api'    => $params['FraudRecordApiKey'],
            '_action' => 'query',
            'name'    => $namehash,
            'email'   => frecordhash($email),
            'ip'      => frecordhash($params['ip']),
        ];

        if (!empty($params['clientsdetails']['telephoneNumber'])) {
            $fields['phone'] = frecordhash($params['clientsdetails']['telephoneNumber']);
        }

        $address = strtolower(str_replace(" ", "", trim(
            $params['clientsdetails']['address1'] .
            $params['clientsdetails']['address2'] .
            $params['clientsdetails']['city'] .
            $params['clientsdetails']['state']
        )));
        if (!empty($address)) {
            $fields['address'] = frecordhash($address);
        }

        $ch = curl_init("https://www.fraudrecord.com/api/");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $fraudresult = curl_exec($ch);

        if (curl_errno($ch)) {
            logActivity("FraudRecord Check - Connection Error: " . curl_error($ch));
            curl_close($ch);
            $responseData['errors'][] = [
                "title" => "FraudRecord Error",
                "description" => "Unable to connect to FraudRecord API. Please check your configuration."
            ];
        } else {
            curl_close($ch);

            if (stripos($fraudresult, "<html") !== false) {
                logActivity("FraudRecord Check - Invalid HTML Response: " . $fraudresult);
                $responseData['errors'][] = [
                    "title" => "FraudRecord Error",
                    "description" => "FraudRecord returned an invalid response (HTML or unexpected content). API may be temporarily unavailable."
                ];
            } elseif (!preg_match("~<report>([0-9.\-a-f]+)</report>~", $fraudresult, $matches)) {
                logActivity("FraudRecord Check - Invalid Response: " . $fraudresult . " - " . print_r($fields, 1));
                $responseData['errors'][] = [
                    "title" => "FraudRecord Error",
                    "description" => "Received a malformed response from the FraudRecord API."
                ];
            } else {
                $result_exp = explode("-", $matches[1]);

                if (isset($result_exp[3]) && strlen($result_exp[3]) == 16) {
                    $FRriskScore = $result_exp[0];

                    if ($FRriskScore >= $params["FraudRecordRejectScore"]) {
                        $failfraud = true;
                    }

                    $responseData['fraudrecord'] = true;
                    $responseData['fraudrecord_score'] = $FRriskScore;
                    $responseData['fraudrecord_count'] = $result_exp[1];
                    $responseData['fraudrecord_reliability'] = $result_exp[2];
                    $responseData['fraudrecord_details'] = $result_exp[3];
                } else {
                    logActivity("FraudRecord Check - Invalid Format: " . $fraudresult);
                    $responseData['errors'][] = [
                        "title" => "FraudRecord Error",
                        "description" => "FraudRecord response was incomplete or improperly formatted."
                    ];
                }
            }
        }
    }

    // --- Kickbox Check ---
    if (!empty($params["KickboxEnable"]) && !empty($params['KickboxApiKey'])) {
        $ch = curl_init("https://api.kickbox.com/v2/verify?email=" . urlencode($params['clientsdetails']['email']) . "&apikey=" . $params['KickboxApiKey']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if (curl_errno($ch) || !$response || $httpCode !== 200) {
            logActivity("Kickbox Check - Connection Error: " . curl_error($ch));
            $responseData['errors'][] = [
                "title" => "Kickbox Error",
                "description" => "Unable to connect to Kickbox API. Please check your configuration."
            ];
        } else {
            $KickboxData = json_decode($response, 1);
            if ($KickboxData['success'] === true) {
                if (!empty($params['KickboxRejectDisposable']) && $KickboxData['disposable']) $failfraud = true;
                if (!empty($params['KickboxRejectFree']) && $KickboxData['free']) $failfraud = true;
                if (!empty($params['KickboxRejectRole']) && $KickboxData['role']) $failfraud = true;
                if (!empty($params['KickboxRejectDidYouMean']) && $KickboxData['did_you_mean']) $failfraud = true;
                if (!empty($params['KickboxRejectUndeliverable']) && $KickboxData['result'] === "undeliverable") $failfraud = true;

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

    // --- FraudLabs Pro Check ---
    if (!empty($params["FraudLabsProEnable"]) && !empty($params['FraudLabsProApiKey'])) {
        $orderdata = [
            "first_name"    => $params["clientsdetails"]["firstname"],
            "last_name"     => $params["clientsdetails"]["lastname"],
            "bill_country"  => $params["clientsdetails"]["country"],
            "ip"            => $params['ip'],
            "format"        => "json",
            "email"         => $params["clientsdetails"]["email"],
            "user_order_id" => substr($params["order"]["order_number"], 0, 15),
            "amount"        => $params["order"]["amount"],
            "key"           => $params['FraudLabsProApiKey']
        ];
        if ($params["clientsdetails"]["address1"]) $orderdata["bill_addr"] = $params["clientsdetails"]["address1"];
        if ($params["clientsdetails"]["city"]) $orderdata["bill_city"] = $params["clientsdetails"]["city"];
        if ($params["clientsdetails"]["state"]) $orderdata["bill_state"] = $params["clientsdetails"]["state"];
        if ($params["clientsdetails"]["postcode"]) $orderdata["bill_zip_code"] = $params["clientsdetails"]["postcode"];
        if ($params["clientsdetails"]["telephoneNumber"]) $orderdata["user_phone"] = $params["clientsdetails"]["telephoneNumber"];

        $model = $params["clientsdetails"]["model"];
        $currencyCode = ($model instanceof WHMCS\User\Client) ? $model->currencyrel->code : $model->client->currencyrel->code;
        $orderdata['currency'] = $currencyCode;

        $ch = curl_init("https://api.fraudlabspro.com/v2/order/screen");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $orderdata);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $fraudlabsdata = curl_exec($ch);
        curl_close($ch);

        if (curl_errno($ch) || !$fraudlabsdata) {
            logActivity("FraudLabs Pro Check - Connection Error: " . curl_error($ch));
            $responseData['errors'][] = [
                "title" => "FraudLabs Pro Error",
                "description" => "Unable to connect to FraudLabs Pro API. Please check your configuration."
            ];
        } else {
            $fraudlabsresult = json_decode($fraudlabsdata, 1);
            if ($fraudlabsresult['user_order_id'] === substr($params["order"]["order_number"], 0, 15)) {
                if ((int)$fraudlabsresult['fraudlabspro_score'] >= (int)$params["FraudLabsProRejectScore"]) $failfraud = true;
                if (!empty($params['FraudLabsProRejectProxy']) && $fraudlabsresult['ip_geolocation']['is_proxy']) $failfraud = true;
                if (!empty($params['FraudLabsProRejectDataCenter']) && in_array($fraudlabsresult['ip_geolocation']['usage_type'], ["Data Center/Web Hosting/Transit", "Content Delivery Network"])) $failfraud = true;
                if (!empty($params['FraudLabsProRejectIPMismatch']) && !$fraudlabsresult['billing_address']['is_ip_country_match']) $failfraud = true;

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
    }

    if ($failfraud) {
        $returnData['error'] = [
            "title"       => $params['ErrorTitle'],
            "description" => $params['ErrorMsg']
        ];
    }

    $returnData['data'] = $responseData;
    
    // Debug: Log what we're returning
    //logActivity("FraudSilo Debug - Returning data: " . json_encode($responseData));
    
    return $returnData;
}

function fraudsilo_processResultsForDisplay(array $params)
{
    $responseData = json_decode($params['data'], 1);
    $output = "";

    // --- AI Check Results ---
    if (isset($responseData['ai_check'])) {
        $riskLevel = htmlspecialchars($responseData['ai_risk_level']);
        $riskScore = (int)$responseData['ai_risk_score'];
        $flagged = $responseData['ai_flagged'];
        
        // Color coding based on risk level
        $riskColors = [
            'low' => '#28a745',
            'medium' => '#ffc107',
            'high' => '#fd7e14',
            'critical' => '#dc3545',
            'unknown' => '#6c757d'
        ];
        $riskColor = $riskColors[$riskLevel] ?? '#6c757d';
        $modelName = htmlspecialchars($responseData['ai_model'] ?? 'unknown');
        
        $output .= "
        <h4>🤖 AI Fraud Analysis Results <small style='font-weight: normal; color: #666;'>({$modelName})</small>:</h4>
        <table style='border-collapse: collapse; width: 100%; text-align: left;' class='table'>
            <tr>
                <td style='width: 20%; padding: 8px; vertical-align: top;'>
                    <div style='text-align: center; padding: 15px; background: {$riskColor}; color: white; border-radius: 8px;'>
                        <div style='font-size: 24px; font-weight: bold;'>" . strtoupper($riskLevel) . "</div>
                        <div style='font-size: 14px;'>Risk Level</div>
                        <div style='font-size: 32px; font-weight: bold; margin-top: 5px;'>{$riskScore}</div>
                        <div style='font-size: 12px;'>Score (0-100)</div>
                    </div>
                </td>
                <td style='padding: 8px; vertical-align: top;'>
                    <strong>Status:</strong> " . ($flagged ? '🚨 Flagged for Review' : '✅ Passed') . "<br><br>
                    <strong>Analysis:</strong><br>" . htmlspecialchars($responseData['ai_analysis']) . "
                    " . (!empty($responseData['ai_reasons']) ? "<br><br><strong>Risk Indicators:</strong><ul style='margin: 5px 0; padding-left: 20px;'>" . implode('', array_map(function($r) { return "<li>" . htmlspecialchars($r) . "</li>"; }, $responseData['ai_reasons'])) . "</ul>" : "") . "
                </td>
            </tr>
        </table>
        ";
    }

    // --- Blocklist Results ---
    if (isset($responseData['blocklist'])) {
        $blocked = $responseData['blocklist_blocked'];
        $output .= "
        <h4>📋 Private Blocklist Results:</h4>
        <table style='border-collapse: collapse; width: 100%; text-align: left;' class='table'>
            <tr>
                <th style='width: 30%; padding: 8px;'>Status</th>
                <td style='padding: 8px;'>" . ($blocked ? '🚨 <strong style=\"color: #dc3545;\">BLOCKED</strong>' : '✅ <strong style=\"color: #28a745;\">Clear</strong>') . "</td>
            </tr>";
        
        if ($blocked && !empty($responseData['blocklist_reasons'])) {
            $output .= "
            <tr>
                <th style='padding: 8px;'>Block Reasons</th>
                <td style='padding: 8px;'>" . htmlspecialchars(implode(', ', $responseData['blocklist_reasons'])) . "</td>
            </tr>";
        }
        
        if ($blocked && !empty($responseData['blocklist_matched_rules'])) {
            $rulesHtml = array_map(function($rule) {
                return htmlspecialchars($rule['type'] . ': ' . $rule['value']);
            }, $responseData['blocklist_matched_rules']);
            $output .= "
            <tr>
                <th style='padding: 8px;'>Matched Rules</th>
                <td style='padding: 8px;'>" . implode('<br>', $rulesHtml) . "</td>
            </tr>";
        }
        
        $output .= "</table>";
    }

    // --- FraudLabs Pro Results ---
    if (isset($responseData['fraudlabspro'])) {
        $score = htmlspecialchars($responseData['fraudlabspro_score']);
        $scoreImageUrl = "https://www.fraudlabspro.com/assets/img/scores/meter-" . $score . ".png";

        $output .= "
        <h4>FraudLabs Pro Results:</h4>
        <table style='border-collapse: collapse; width: 100%; text-align: left;' class='table'>
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
            <tr>
                <th style='padding: 8px;'>IP Location</th>
                <td style='padding: 8px;'>
                    <a href='https://www.google.com/maps/place/" . htmlspecialchars($responseData['fraudlabspro_iplat']) . "," . htmlspecialchars($responseData['fraudlabspro_iplong']) . "' target='_blank'>" . htmlspecialchars($responseData['fraudlabspro_iplat']) . ", " . htmlspecialchars($responseData['fraudlabspro_iplong']) . "</a>
                </td>
                <th style='padding: 8px;'>IP & Reverse Hostname</th>
                <td style='padding: 8px;'><a href='https://ipinfo.io/" . htmlspecialchars($responseData['ip']) . "' target='_blank'>" . htmlspecialchars($responseData['ip']) . "</a> (" . htmlspecialchars($responseData['hostname']) . ")</td>
            </tr>
            <tr>
                <th style='padding: 8px;'>IP Owner</th>
                <td style='padding: 8px;'>" . htmlspecialchars($responseData['fraudlabspro_ipowner']) . "</td>
                <th style='padding: 8px;'>IP Domain</th>
                <td style='padding: 8px;'>" . htmlspecialchars($responseData['fraudlabspro_ipdomain']) . "</td>
            </tr>
            <tr>
                <th style='padding: 8px;'>IP Type</th>
                <td style='padding: 8px;'>" . htmlspecialchars($responseData['fraudlabspro_iptype']) . "</td>
                <th style='padding: 8px;'>IP Proxy</th>
                <td style='padding: 8px;'>" . htmlspecialchars($responseData['fraudlabspro_ipproxy'] ? 'Yes 🚨' : 'No') . "</td>
            </tr>
            <tr>
                <th style='padding: 8px;'>IP Distance (km)</th>
                <td style='padding: 8px;'>" . htmlspecialchars($responseData['fraudlabspro_ipdist']) . "</td>
                <th style='padding: 8px;'>IP Country Match</th>
                <td style='padding: 8px;'>" . htmlspecialchars($responseData['fraudlabspro_ipmatch'] ? 'Yes' : 'No 🚨') . "</td>
            </tr>
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

    // --- FraudRecord + Kickbox Combined ---
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

    // --- FraudRecord Only ---
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

    // --- Kickbox Only ---
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

    $output .= "<h2>Fraud Protection by <a href=\"https://fraudsilo.com\" target=\"_blank\">FraudSilo</a></h2>";

    return $output;
}

function frecordhash($value)
{
    for ($i = 0; $i < 32000; $i++)
        $value = sha1("fraudrecord-" . $value);
    return $value;
}
