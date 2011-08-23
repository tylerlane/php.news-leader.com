<?php

/**
 * 4Info Messaging Gateway
 *
 * The 4Info Messaging Gateway allows third parties to use 4Info’s SMS delivery platform to send 
 * text messages to end consumers over the 4Info short code (44636), and to send and receive text 
 * messages over their own short code. Immediate applications for this Gateway include phone 
 * number validation and delivery of general content messaging to end users. The Gateway can also 
 * use the 4Info advertisement server to include ads in messages.
 */	
	

/**
 * _4Info_Gateway
 *
 * The _4Info_Gateway class provides access to all gateway services.  To access services of the
 * 4Info Messaging Gateway, create an instance of this class passing in your client credentials.
 * Client credentials are given to you when you successfully register as a Gateway Partner.
 * 
 * The _4Info_Gateway class makes use of the pecl http library (http://www.php.net/manual/en/http.install.php) 
 * for submitting http requests and php's simplexml functions (http://us2.php.net/simplexml) for
 * parsing xml data.
 * 
 * pecl http library
 * This » PECL extension is not bundled with PHP.  Information for installing this PECL extension 
 * may be found in the manual chapter titled Installation of PECL extensions 
 * (http://php.oregonstate.edu/manual/en/install.pecl.php). Additional 
 * information such as new releases, downloads, source files, maintainer information, and a 
 * CHANGELOG, can be located here: » http://pecl.php.net/package/pecl_http.
 * 
 * simplexml functions (http://us2.php.net/simplexml)
 * The SimpleXML extension provides a very simple and easily usable toolset to convert XML to 
 * an object that can be processed with normal property selectors and array iterators.
 * The SimpleXML extension is enabled by default. To disable it, use the --disable-simplexml
 * configure option.
 */
class _4Info_Gateway
{
  const DEFAULT_CARRIER_LIST_URL	= 'http://gateway.4info.net/list';
  const DEFAULT_MESSAGE_REQUEST_URL	= 'http://gateway.4info.net/msg';
  const DEFAULT_SHORT_CODE			= '44636';
		
  private $carrierListUrl;
  private $messageRequestUrl;
  private $clientId;
  private $clientKey;
		
  private $carriers;
		
		
  /**
   * Default constructor of a 4Info Gateway object.  The constructor should be passed
   * gateway credentials, including a clientId and clientKey.  If desired, a
   * carrier list url and a message request url can be specified, otherwise the default
   * 4Info gateway values will be used.
   */
  public function __construct($clientId = false, $clientKey = false, $carrierListUrl = self::DEFAULT_CARRIER_LIST_URL, $messageRequestUrl = self::DEFAULT_MESSAGE_REQUEST_URL)
  {
    $this->clientId = $clientId;
    $this->clientKey = $clientKey;
    $this->carrierListUrl = $carrierListUrl;
    $this->messageRequestUrl = $messageRequestUrl;
  }
		
  public function __destruct()
  {
			
  }
		
		
  public function setClientId($clientId)
  {
    $this->clientId = $clientId;
  }
		
		
  public function setClientKey($clientKey)
  {
    $this->clientKey = $clientKey;
  }
		
		
  public function setCarrierListUrl($carrierListUrl = self::DEFAULT_CARRIER_LIST_URL)
  {
    $this->carrierListUrl = $carrierListUrl;
  }
		
		
  public function setMessageRequestUrl($messageRequestUrl = self::DEFAULT_MESSAGE_REQUEST_URL)
  {
    $this->messageRequestUrl = $messageRequestUrl;
  }
		
  public function setCarrierList(&$carriers)
  {
    $this->carriers = $carriers;
  }
		
		
  /**
   * Carrier List Request
   * 
   * This service returns a list of supported carriers and their associated identifies for 
   * use in phone number validation and text message delivery can be queried using a GET 
   * over HTTP. Customers should cache this list, but it is important to refresh it 
   * periodically (at least once a day).
   */
  public function getCarriers($shortCode = self::DEFAULT_SHORT_CODE)
  {
    //use cached copy if it exists
    if($this->carriers)
      return $this->carriers;
			
    //Get the carrier list XML string
    if(!($xml = file_get_contents($this->carrierListUrl . '?clientId=' . $this->clientId . '&clientKey=' . $this->clientKey . '&shortCode=' . $shortCode)))
      return false;
			
    //convert the xml into a simple xml data element
    $data = new SimpleXMLElement($xml);
			
    //return false if the xml doesn't look right
    if(!$data || !isset($data->carrier))
      return false;
			
    $carriers = array();
    foreach($data->carrier AS $c) {
      $carrier = new _4Info_Gateway_Carrier($c['id'] . '', $c . '');
      $carriers[$carrier->id] = $carrier;
    }
			
    if(count($carriers)) {
      $this->carriers = $carriers;
      return $carriers;
    }
	        
    return false;
  }
		
		
		
  /**
   * Phone Number Validation
   * 
   * 4Info provides a convenience for partners wishing to validate the telephone numbers of its 
   * users. Requiring the user to input a validation code sent to the phone is one way for the 
   * partner to enforce the opt-in process required by wireless providers. The phone validation 
   * service is an XML web service available for credentialed partners over HTTP POST.
   * 
   * After a phone validation request is submitted to the Messaging Gateway, 4Info delivers an 
   * SMS to the MSISDN provided which contains the same confirmation code returned to the partner 
   * in the HTTP response. Once the user receives the message, they submit the confirmation code 
   * to the third party for match verification. If the codes match, the partner considers the 
   * MSISDN confirmed and permits the end user to receive SMS content thereafter. If the codes 
   * do not match, the third party notifies the user. If need be, another confirmation code can 
   * be sent to the MSISDN by restarting the phone validation above.
   * 
   * This function submits a phone number validation request to the 4INFO Messaging Gateway
   * using the phone number passed in. A _4Info_Gateway_Response object is returned 
   * from this function call.  The returned _4Info_Gateway_Response object includes the 
   * success/failure status of the validation request and, if successful, the 5 digit 
   * confirmation code that was sent to the user.
   */
  public function sendValidationRequest($phoneNumber)
  {
    $xml  = '<?xml version="1.0"?>';
    $xml .= '<request clientId="' . $this->clientId . '" clientKey="' . $this->clientKey . '" type="VALIDATION">';
    $xml .= '<validation>';
    $xml .= '<recipient>';
    $xml .= '<type>' . _4INFO_Gateway_Address::PHONE_NUMBER_TYPE . '</type>';
    $xml .= '<id>' . $phoneNumber . '</id>';
    $xml .= '</recipient>';
    $xml .= '</validation>';
    $xml .= '</request>';
	         
    return $this->makeRemoteCall($this->messageRequestUrl, $xml);
  }
		
		
		
  /**
   * Text Message Delivery
   * 
   * 4Info provides the ability for partners to send MT SMS messages to its users. This is 
   * available for credentialed partners as an XML web service over HTTP POST. The request adds 
   * the message to the 4Info Messaging Gateway queue, where an optional advertisement is appended 
   * to the message, and it is prepared for dispatch to the wireless operators. While this process 
   * is usually immediate, partners are not guaranteed that the message will be delivered at the 
   * time of request. Because of the asynchronous nature of the wireless operators' SMS 
   * infrastructure, delivery can be confirmed by the a status request at a later time.
   * 
   * This function accepts a _4Info_Gateway_Sms object, which contains the qualified address of 
   * the message sender, the qualified address of the message recipient, and the text to be
   * contained in the SMS message.  Using the credentials associated with this gateway instance,
   * the SMS message is posted to the 4Info mobile gateway for delivery.  The gateway's response
   * is encapsulated in a _4Info_Gateway_Response object and returned.  The
   * _4Info_Gateway_Response object includes the success/failure status of the attempted message
   * delivery and, if successful, includes a request ID that may subsequently be utilized by 
   * to query for the status of the response.
   */
  public function sendMessageRequest($sms)
  {
    $xml  = '<?xml version="1.0"?>';
    $xml .= '<request clientId="' . $this->clientId . '" clientKey="' . $this->clientKey . '" type="MESSAGE">';
    $xml .= '<message receipt="' . $sms->handsetDeliveryReceipt . '">';
    $xml .= '<sender>';
    $xml .= '<type>' . _4INFO_Gateway_Address::SHORT_CODE_TYPE . '</type>';
    $xml .= '<id>' . $sms->sender->phoneNumber . '</id>';
    $xml .= '</sender>';
    $xml .= '<recipient>';
    $xml .= '<type>' . _4INFO_Gateway_Address::PHONE_NUMBER_TYPE . '</type>';
    $xml .= '<id>' . $sms->recipient->phoneNumber . '</id>';
    $xml .= '</recipient>';
    $xml .= '<text>' . $sms->message . '</text>';
    $xml .= '</message>';
    $xml .= '</request>';

    return $this->makeRemoteCall($this->messageRequestUrl, $xml);
  }
		
		
  /**
   * Unblock Request - Blacklist Management
   * 
   * In order to enforce compliance with wireless operators' and MMA guidelines, 
   * 4Info has implemented “STOP” functionality for any end users using 4Info or 
   * partner services. When a user sends a “STOP” message in response to a partner 
   * message, 4Info stores the number in a blacklist for this partner. MT SMS messages 
   * in the future will be refused by the Messaging Gateway with status message BLOCKED_USER.
   * 
   * In order to facilitate a good user experience, partners may register a URL where 
   * 4Info will POST phone numbers that have been blacklisted and/or “STOP”ped by the user. 
   * This allows the partner to correctly update the user's validation status in their own 
   * system, and potentially prompt the user to revalidate the same phone, or validate a 
   * new phone. Upon successful revalidation, the partner may activate the user's phone 
   * number again, and remove it from the blacklist.
   * 
   * This function sends an unblock request to the 4Info mobile gateway for the phone
   * number specified.  Using the credentials associated with this gateway instance,
   * the phone number is posted to the 4Info mobile gateway in an attempt to remove it from
   * the unblocked list.  The gateway's response is encapsulated in a _4Info_Gateway_Response 
   * object and returned.  The _4Info_Gateway_Response object includes the success/failure 
   * status of the unblock request.
   */
  public function sendUnblockRequest($phoneNumber)
  {
    $xml  = '<?xml version="1.0"?>';
    $xml .= '<request clientId="' . $this->clientId . '" clientKey="' . $this->clientKey . '" type="UNBLOCK">';
    $xml .= '<unblock>';
    $xml .= '<recipient>';
    $xml .= '<type>' . _4INFO_Gateway_Address::PHONE_NUMBER_TYPE . '</type>';
    $xml .= '<id>' . $phoneNumber . '</id>';
    $xml .= '</recipient>';
    $xml .= '</unblock>';
    $xml .= '</request>';

    return $this->makeRemoteCall($this->messageRequestUrl, $xml); 

  }
	    
		
  /**
   * makeRemoteCall
   * 
   * This helper function is used to post XML data to a specified url.  It is
   * assumed the url being posted to will return an xml response formated as a
   * 4Info gateway response.  The passed in XML data string is POSTed over HTTP to 
   * the specified url using the PECL Http extension.  This extension will need to be
   * install for this function to work.
   * 
   * http://www.php.net/manual/en/http.install.php
   */
  private static function makeRemoteCall($url, $xml)
  {
    $request = new HttpRequest($url, HttpRequest::METH_POST);
			
    $request->setRawPostData($xml);
			
    $request->send();
			
    if($request->getResponseCode() == 200) {
      //Parse the response
      $response = $request->getResponseBody();
      return self::parseResponse($response);
    }
						
    return false;
  }


  /**
   * This helper function parses a _4Info_Gateway_Response object from the passed
   * in XML data string.
   */
  private static function parseResponse($xml)
  {
    //convert the xml into a simple xml data element
    $data = new SimpleXMLElement($xml);
			
    //return false if the xml doesn't look right
    if(!$data)
      return false;
			
    //Extract the response message
    $response = new _4Info_Gateway_Response();
    $response->requestId = $data->requestId . '';
    $response->confCode = $data->confCode . '';
    $response->statusId	= $data->status->id . '';
    $response->statusMessage = $data->status->message . '';
			
    //Validate that the response was received appropriately
    if($response->statusId)
      return $response;
			    
    return false;
  }
		
		
  /**
   * This helper function parses a _4Info_Gateway_Sms object from the passed
   * in XML data string.
   */
  public static function parseSms($xml)
  {
    //convert the xml into a simple xml data element
    $data = new SimpleXMLElement($xml);
			
    //return false if the xml doesn't look right
    if(!$data || !isset($data['type']) || $data['type'] != 'MESSAGE')
      return false;
			
    //Extract the SMS message
    $sms = new _4Info_Gateway_Sms();
    $sms->sender	= new _4INFO_Gateway_Address($data->message->sender->id . '', $data->message->sender->type . '', new _4INFO_Gateway_Carrier($data->message->sender->property->value . ''));
    $sms->recipient	= new _4INFO_Gateway_Address($data->message->recipient->id . '', $data->message->recipient->type . '');
    $sms->requestId = $data->message['id'] . '';
    $sms->message	= $data->message->text . '';
			
    //Validate that the SMS message was extracted appropriately
    if($sms->recipient && $sms->sender && $sms->message)
      return $sms;
				
    return false;
  }
		
		
  /**
   * This helper function parses a _4Info_Gateway_Address object from the passed
   * in XML data string.
   */
  public static function parseBlock($xml)
  {
    //convert the xml into a simple xml data element
    $data = new SimpleXMLElement($xml);
			
    //return false if the xml doesn't look right
    if(!$data || !isset($data['type']) || $data['type'] != 'BLOCK')
      return false;
	
    //extract the address data
    $address = new _4Info_Gateway_Address();
    $address->phoneNumber = $data->block->recipient->id . '';
    $address->addressType = $data->block->recipient->type . '';
    $address->carrier = new _4INFO_Gateway_Carrier($data->block->recipient->property->value . '');
			
    //Validate that the address was received appropriately
    if($address->phoneNumber)
      return $address;
			
    return false;
  }
		
  /**
   * This helper function parses a _4Info_Gateway_Receipt object from the passed
   * in XML data string.
   */
  public static function parseReceipt($xml)
  {
    //convert the xml into a simple xml data element
    $data = new SimpleXMLElement($xml);
			
    //return false if the xml doesn't look right
    if(!$data || !isset($data['type']) || $data['type'] != 'RECEIPT')
      return false;
	
    //extract the address data
    $receipt = new _4Info_Gateway_Receipt();
    $receipt->requestId = $data->receipt->requestId . '';
    $receipt->status['id'] = $data->receipt->status->id . '';
    $receipt->status['message'] = $data->receipt->status->message . '';
			
    //Validate that the receipt was received appropriately
    if($receipt->requestId)
      return $receipt;
			
    return false;
  }
		
		
  /**
   * A helper function which can be used retrieve XML data posted to the current script.
   * There are two implementions for this function and you can use either depending
   * on preferences.  If you set the passed in parameter "useGlobals" to true, this function
   * will attempt to use the PHP global variable HTTP_RAW_POST_DATA to retrieve the POSTed
   * XML.  This is a memory intensive implementation that requires the always_populate_raw_post_data
   * php.ini directive to be set to true (http://www.php.net/manual/en/ini.core.php#ini.always-populate-raw-post-data).
   * If the parameter useGlobals is not set or set to false, this function uses PHP input stream
   * wrappers to retrieve the POSTed XML data.  This method is preferred and requires no
   * php.ini directives to be set.
   */
  public static function getPostedXML($useGlobals = false)
  {
    //Two options of setting up a servlet to accept raw xml data posted to it, use
    //your preferred method
			
    // 1) Use HTTP_RAW_POST_DATA (memory intensive and requires php.ini directives set)
    if($useGlobals) {
      if(!isset($GLOBALS['HTTP_RAW_POST_DATA'])) {
	return false;
      }
      return trim($GLOBALS['HTTP_RAW_POST_DATA']);
    }
			
    //2) Use PHP input stream wrapper (requires PHP 4.3.0+, http://www.php.net/manual/en/wrappers.php)
    if(!$useGlobals) {
      return file_get_contents("php://input");
    }
  }

}


/**
 * _4Info_Gateway_Sms
 * 
 * An SMS message.  SMS messages have a sender address, a recipient address,
 * a message body, and a requestId that uniquely identifies the message.
 */
class _4Info_Gateway_Sms
{
  public $sender;
  public $recipient;
  public $message;
  public $requestId;
  public $handsetDeliveryReceipt;
		
  public function __construct($sender = false, $recipient = false, $message = false, $requestId = false, $handsetDeliveryReceipt = false)
  {
    $this->sender = $sender;
	
	//Set default sender shortcode if it wasn't passed in
	if (empty($this->sender->phoneNumber))
	  $this->sender->phoneNumber = _4Info_Gateway::DEFAULT_SHORT_CODE;
	  
    $this->recipient = $recipient;
    $this->message = $message;
    $this->requestId = $requestId;
	$this->handsetDeliveryReceipt = $handsetDeliveryReceipt ? 'true' : 'false';
  }
		
  public function __destruct()
  {
			
  }
}
		

/**
 * _4Info_Gateway_Address
 * 
 * A simple mobile address.  A mobile address is defined with a type, either a phone number or
 * short code, a phone number which identifies the address, and a carrier the phone number is
 * operated by, if applicable.
 */
class _4Info_Gateway_Address
{
  const PHONE_NUMBER_TYPE	= 5;
  const SHORT_CODE_TYPE	= 6;
		
  public $phoneNumber;
  public $addressType;
  public $carrier;

  function __construct($phoneNumber = false, $addressType = false, $carrier = false)
  {
    $this->phoneNumber = $phoneNumber;
    $this->addressType = $addressType;
    $this->carrier = $carrier;
  }
		
  public function __destruct()
  {
			
  }
}

/**
 * _4Info_Gateway_Receipt
 * 
 * A simple handset delivery receipt. A receipt is defined with a request id, status id and
 * status message.
 */
class _4Info_Gateway_Receipt
{		
  public $requestId;
  public $status;

  function __construct($requestId = false, $status = array('id' => null, 'message' => null))
  {
    $this->requestId = $requestId;
    $this->status = $status;
  }
		
  public function __destruct()
  {
			
  }
}

/**
 * _4Info_Gateway_Carrier
 * 
 * A mobile carrier. Mobile carriers are defined with a unique id and name. 
 */
class _4Info_Gateway_Carrier
{
  public $id;
  public $name;
		
  function __construct($id = false, $name = false)
  {
    $this->id = $id;
    $this->name = $name;
  }
		
  public function __destruct()
  {
			
  }
}


/**
 * _4Info_Gateway_Response
 *
 * Common response.
 */
class _4Info_Gateway_Response
{
  const RESPONSE_UNKNOWN					= 0;
  const RESPONSE_SUCCESS					= 1;
  const RESPONSE_FAILURE					= 2;
  const RESPONSE_CONNECTION_FAILURE		= 3;
  const RESPONSE_VALIDATION_ERROR			= 4;
  const RESPONSE_AUTHENTICATION_FAILURE	= 5;
  const RESPONSE_ADDRESSING_ERROR			= 6;
  const RESPONSE_GATEWAY_ACK				= 7;
  const RESPONSE_BROKER_ACK				= 8;
  const RESPONSE_SMSC_ACK					= 9;
  const RESPONSE_HANDSET_ACK				= 10;
		
  public $requestId;
  public $confCode;
  public $statusId;
  public $statusMessage;
		
		
  public function __construct($requestId = false, $confCode = false, $statusId = false, $statusMessage = false)
  {
    $this->requestId = $requestId;
    $this->confCode = $confCode;
    $this->statusId = $statusId;
    $this->statusMessage = $statusMessage;
  }
		
  public function __destruct()
  {
			
  }
		
}
	
?>