<?php
//turning on error reporting for now. i will disable this when we push it live or change it from showing all errors etc
//error_reporting(E_ALL);
//ini_set('display_errors','On');
//pear config module
require( "Config.php");
require( "statesfips.php" );

//config stuff
$conf = new Config;
$root =& $conf->parseConfig(getcwd() .'/config.xml', 'XML' );
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
    $fh = fopen( $file, 'w' );
    fwrite( $fh, $output );
    fclose( $fh );	
  }

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

     //pull our list of counties we care about from the config array
     $counties = $settings["root"]["conf"]["fips"];
     //we compare our list of counties that we care about vs the counties/fips code in the xml feed.
     $compare = array_intersect( array_values( $counties ),array_values( $fips ) );
     //if there is anything in the compare array and its a warning
     //if so, append the warning to our string to output

     if( sizeof( $compare ) > 0 AND ( $vtec[4] == "W" or $vtec[3] == "TO" ) )
     {
        $string .= "<b><a href=\"". $entry->link->attributes() ."\" target=\"_blank\">". $title_array[0]."</a></b> - ". $ns_dc->areaDesc ." till ". strftime( "%r %D", $expires_ts ) ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\t\t\t\t\t";
     }
  }
}

//by default we'll output html tags headers
if( !empty( $_REQUEST[ "noheaders" ] ) )
{
	?>
	<html>
		<head>
			<title>Weather Alerts</title>
		</head>
		<body>
		<?php
}
    //if string isn't empty, then we'll spit out our info
 	if( !empty( $string ) ) 
	{
		?>
	<table border="0" cellspacing="2" cellpadding="2" width="960" bgcolor="#CC0000">
		<tr>
			<td align="right" class="alertstrip">
				<a href="http://www.crh.noaa.gov/sgf/" target="_blank" style="color:#FFFFFF; font-weight:bold; font-size:12px;">LATEST WEATHER ALERTS:</a>
			</td>
			<td class="small" bgcolor="#ffffff" width="740">
				<marquee width="760" scrollamount="3" scrolldelay="1" style="color: black; font-size: 11px;" onmouseover="this.stop()" onmouseout="this.start()"><?php print $string; ?></marquee>
			</td>
		</tr>
	</table>
	<?php
    }
    //otherwise we output something so that saxotech will at least refresh the cached copy
	else
	{
		print "<!-- These are not the droids, err alerts, you are looking for. -->";
    }
//once again we output closing html tags by default
if( !empty( $_REQUEST[ "noheaders" ] ) )
{
	?>
	</body>
</html>
<?php
}
?>
