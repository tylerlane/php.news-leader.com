<?php
require_once 'include/4Info_Gateway.php';
	
	
//Define some constants to use with the various tests of the Gateway API
$TEST_PHONE_NUMBER          = '+14177331581';
$CLIENT_ID                  = '748';
$CLIENT_KEY                 = '6E57F2C8E7B63D16';
$SHORT_CODE                 = '446364';
	
	
////////////////////////////////////////////////////////////////////////////
//Instantiate a new Gateway object with the test credentials
////////////////////////////////////////////////////////////////////////////
$gateway = new _4Info_Gateway($CLIENT_ID, $CLIENT_KEY);
	
	
////////////////////////////////////////////////////////////////////////////
//Test a carrier lookup
////////////////////////////////////////////////////////////////////////////
$gateway = new _4Info_Gateway($CLIENT_ID, $CLIENT_KEY);
$carriers = $gateway->getCarriers();
if($carriers) print_r($carriers);
	
	
////////////////////////////////////////////////////////////////////////////
//Test sending a validation sms
////////////////////////////////////////////////////////////////////////////
$gateway = new _4Info_Gateway($CLIENT_ID, $CLIENT_KEY);
$response = $gateway->sendValidationRequest($TEST_PHONE_NUMBER);
if($response) print_r($response);
	
	
////////////////////////////////////////////////////////////////////////////
//Test sending an sms
////////////////////////////////////////////////////////////////////////////
$gateway = new _4Info_Gateway($CLIENT_ID, $CLIENT_KEY);
$sender = new _4Info_Gateway_Address($SHORT_CODE);
$recipient = new _4Info_Gateway_Address($TEST_PHONE_NUMBER);
$message = 'Test Message';
$sms = new _4Info_Gateway_Sms($sender, $recipient, $message);
$response = $gateway->sendMessageRequest($sms);	
if($response) print_r($response);

	
////////////////////////////////////////////////////////////////////////////
//Test sending an unblock request
////////////////////////////////////////////////////////////////////////////
$gateway = new _4Info_Gateway($CLIENT_ID, $CLIENT_KEY);
$response = $gateway->sendUnblockRequest($TEST_PHONE_NUMBER);
if($response) print_r($response);
		

////////////////////////////////////////////////////////////////////////////
//Test parsing an MO SMS
////////////////////////////////////////////////////////////////////////////
$moXml  = '<?xml version="1.0" ?>';
$moXml .= '<request type="MESSAGE">';
$moXml .= '<message id="F81D4FAE-7DEC-11D0-A765-00A0C91E6BF6">';
$moXml .= '<recipient>';
$moXml .= '<type>6</type>';
$moXml .= '<id>12345</id>';
$moXml .= '</recipient>';
$moXml .= '<sender>';
$moXml .= '<type>5</type>';
$moXml .= '<id>+16505551212</id>';
$moXml .= '<property>';
$moXml .= '<name>CARRIER</name>';
$moXml .= '<value>5</value>';
$moXml .= '</property>';
$moXml .= '</sender>';
$moXml .= '<text>Test message.</text>';
$moXml .= '</message>';
$moXml .= '</request>'; 
$mo = _4Info_Gateway::parseSms($moXml);
if($mo) print_r($mo);


////////////////////////////////////////////////////////////////////////////
//Test parsing a blacklist callback request
////////////////////////////////////////////////////////////////////////////
$blockXml  = '<?xml version="1.0" ?>';
$blockXml .= '<request type="BLOCK">';
$blockXml .= '<block>';
$blockXml .= '<recipient>';
$blockXml .= '<type>5</type>';
$blockXml .= '<id>+16505551212</id>';
$blockXml .= '<property>';
$blockXml .= '<name>CARRIER</name>';
$blockXml .= '<value>3</value>';
$blockXml .= '</property>';
$blockXml .= '</recipient>';
$blockXml .= '</block>';
$blockXml .= '</request>';
$blacklist = _4Info_Gateway::parseBlock($blockXml);
if($blacklist) print_r($blacklist);

////////////////////////////////////////////////////////////////////////////
//Test parsing a receipt callback request
////////////////////////////////////////////////////////////////////////////
$receiptXml  = '<?xml version="1.0" ?>';
$receiptXml .= '<request type="RECEIPT">';
$receiptXml .= '<receipt>';
$receiptXml .= '<requestId>31246d80-7657-4be9-ba8e-ababa3793eee</requestId>';
$receiptXml .= '<status>';
$receiptXml .= '<id>10</id>';
$receiptXml .= '<message>Handset+receipt+acknowledgement.</message>';
$receiptXml .= '</status>';
$receiptXml .= '</receipt>';
$receiptXml .= '</request>';
$receipt = _4Info_Gateway::parseReceipt($receiptXml);
if($receipt) print_r($receipt);

?>
