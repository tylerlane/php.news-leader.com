<?php
//http://feeds.4info.net/feeds-poller/ping  


$site_name = "Greene County Weather Alerts";

/**
 * The URL of your site
 */
$site_url = "http://". $_SERVER["SERVER_NAME"] ."/weather/alerts-rss.php";

$request = xmlrpc_encode_request("weblogUpdates.ping", array($site_name, $site_url));

$context = stream_context_create(array('http' => array(
    'method' => "POST",
    'header' => "Content-Type: text/xml\r\nUser-Agent: PHPRPC/1.0\r\nHost: feeds.4info.net\r\n",
    'content' => $request
)));

$server = "http://feeds.4info.net/feeds-poller/ping";
$file = file_get_contents($server, false, $context);

$response = xmlrpc_decode($file);

if (is_array($response) and xmlrpc_is_fault($response)){
    echo "Failed to ping 4info";
} else {
    echo "Successfully pinged 4info";
}

?>
