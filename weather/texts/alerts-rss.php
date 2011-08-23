<?php
//turning on error reporting for now. i will disable this when we push it live or change it from showing all errors etc
error_reporting(E_ALL);
ini_set('display_errors','On');
//pear config module
require( "Config.php");
require( "../statesfips.php" );


function genRandomString() {
    $length = 10;
    $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
    $string = ''; 
    for ($p = 0; $p < $length; $p++)
    {
        $string .= $characters[mt_rand(0, strlen($characters))];
    }
    return $string;
}


//config stuff
$conf = new Config;
$root =& $conf->parseConfig(getcwd() .'/../config.xml', 'XML' );
if( PEAR::isError($root) )
{
  die('Error while reading configuration: ' . $root->getMessage());
}
$settings = $root->toArray();

//lets loop through the fips array and then see what stats we need to pull from.
$found_states = Array();
foreach( $settings["root"]["conf"]["fips"] as $fips )
{
  if( !in_array( substr( $fips, 0, 3 ), $found_states ) )
  {
    $found_states[] = substr( $fips, 0, 3 );
  }
}

//create a blank string to store our output
$string = "";
foreach( $found_states as $state )
{
  //pull the state abbreviation out of our fips translation table
  $state = strtolower( $states_fips[ $state ][1] );
  /* curl stuff here:
  * basically it goes through and pulls the atom/cap feed and puts it into a string for us
  */
  $url = "http://alerts.weather.gov/cap/". strtolower( $state ) .".php?x=0";
  // create curl resource 
  $ch = curl_init(); 
  // set url 
  curl_setopt( $ch, CURLOPT_URL, $url ); 
  //return the transfer as a string 
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 ); 
  curl_setopt( $ch, CURLOPT_FAILONERROR, 1 );

  // $output contains the output string 
  $output = curl_exec( $ch ); 
  // close curl resource to free up system resources 
  curl_close( $ch );

  //if we have content in output, we save the file just in case the next time we need it, the feed dies  
  if( empty( $output ) )
  {
	  $file = $state .".xml";
  	if( file_exists( $file ) )
	  {
		  $output = file( $file );
		}
  }
  //if there is no content in output, then we use our backup xml file from the last time it ran.
  else
  {
    //write a backup file
    $file = $state .".xml";
    $fh = fopen( "../". $file, 'w' );
    fwrite( $fh, $output );
    fclose( $fh );	
  }




  $now = date("D, d M Y H:i:s T");
  $rss_output = "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>
            <rss version=\"2.0\"> 
                <channel>
                    <title>News-Leader weather alerts</title>
                    <link>http://". $_SERVER["SERVER_NAME"] . $_SERVER["PHP_SELF"] ."</link>
                    <description>Weather alerts testing</description>
                    <language>en-us</language>
                    <pubDate>$now</pubDate>
                    <lastBuildDate>$now</lastBuildDate>
                    <docs>http://news-leader.com/section/data</docs>
                    <managingEditor>tlane2@news-leader.com (Tyler Lane)</managingEditor>
                    <webMaster>tlane2@news-leader.com (Tyler Lane)</webMaster>
          ";


  //load out xml string into SimpleXMLElement
  $xml = simplexml_load_string( $output );
  //loop through each entry in our xml dom.
  foreach( $xml->entry as $entry )
  {
    //get the title
    $title = $entry->title;
    //blow it up into an array and take everything bfore issued.
    //TODO: there is a better way to do this using VTEC codes that i will look at soon.
    $title_array = explode( "issued", $title );
    //get all of the children of the casep name space
    //this lets me access all of the cap:<blah> elements
    $ns_dc = $entry->children('urn:oasis:names:tc:emergency:cap:1.1');
    //time format for the timestamps in the xml file
    $time_format = "%Y-%m-%dT%T%z";
    //convert the timestamps into a php time object so i can format it
    $effective = strptime( $ns_dc->effective, $time_format );
    $effective_ts = mktime( 
	                    $effective['tm_hour'], 
	                    $effective['tm_min'], 
	                    $effective['tm_sec'], 
	                    1 , 
	                    $effective['tm_yday'] + 1, 
	                   $effective['tm_year'] + 1900 
	                 );

    $expires = strptime( $ns_dc->expires, $time_format );
    $expires_ts = mktime( 
	                    $expires['tm_hour'], 
	                    $expires['tm_min'], 
	                    $expires['tm_sec'], 
	                    1 , 
	                    $expires['tm_yday'] + 1, 
	                   $expires['tm_year'] + 1900 
                   );
    //get the children ( no namespace needed ) for the cap:geocode nodes
    $geocodechildren = $ns_dc->geocode->children();
    //making sure that the child is a FIPS6 value. it MIGHT not be so i'll put in error checking anyways
    if( strtoupper( $geocodechildren->valueName ) == "FIPS6" )
    {
         //if it is, expode it into an array incase there are multiple counties
         $fips = explode( " ", $geocodechildren->value );
     }
     //if its NOT a fips6 value, we'll make a blank array so our code doesn't error out.
     else
     {
        $fips = Array();
     }
     //old debug code. leaving it in for now
     //printf("<li><b>%s</b> - %s till %s</li>", $title_array[0],$ns_dc->areaDesc, strftime( "%r %D", $expires_ts) );

     //now we get the children of the cap:parameter field so i can get the VTEC code
     $parameter_children = $ns_dc->parameter->children();
     //check to make sure its a VTEC valueName
     if( strtoupper( $parameter_children->valueName ) == "VTEC" )
     {
         //explode the VTEC into an array based on "." so i can access key seconds of it easily.
         $vtec = explode( ".", $parameter_children->value );
     }
     //if its NOT a VTEC element, we'll make a blank array again
     else
     {
       $vtec = Array();
     }
     //temp var to hold the 2 vtec values: event and severity
     @$tempvtec = $vtec[3] . "-" . $vtec[4];

     //pull our list of counties we care about from the config array
     $counties = $settings["root"]["conf"]["fips"];
     //we compare our list of counties that we care about vs the counties/fips code in the xml feed.
     $compare = array_intersect( array_values( $counties ),array_values( $fips ) );
     //if there is anything in the compare array and its a warning
     //if so, append the warning to our string to output

     // $vtec[4] == "W" or $vtec[3] == "TO"
     //if( sizeof( $compare ) > 0 AND ( in_array( $tempvtec, array_values($settings["root"]["conf"]["vtecs"] ) ) ) )
     if(@$vtec[4] == "W" or @$vtec[3] == "TO")
     {
       //$string .= "<b><a href=\"". $entry->link->attributes() ."\" target=\"_blank\">". $title_array[0]."</a></b> - ". $ns_dc->areaDesc ." till ". strftime( "%r %D", $expires_ts ) ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\t\t\t\t\t";
       $rss_output .= "
                    <item><title>".htmlentities( $title_array[0])."</title>
                      <link>".htmlentities( $entry->link->attributes() )."</link>
                      <description>for " .htmlentities( $ns_dc->areaDesc ." till ". strftime( "%r %D", $expires_ts )  )."</description>
                      <guid>".htmlentities( $entry->link->attributes() )."</guid>
                      <pubDate>$now</pubDate>
                    </item>";

     }
  }
}
$rss_output .= "</channel></rss>";
header("Content-Type: application/rss+xml");
print $rss_output;
?>
