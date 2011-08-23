<?php
//require the PEAR config module
require_once('Config.php');
require( "statesfips.php" );
//loading the csv file up top so i have access to it on saving etc.
$states_counties = Array();
if( ( $handle = fopen( "county_fips.csv", "r" ) ) !== FALSE )
{
	while( ( $data = fgetcsv( $handle,$delimiter="," ) ) !== FALSE )
  {
    $split = explode( ",", $data[1] );
    $state = trim( $split[1] );
    $fip = sprintf( "%06d", $data[0] );
    //building an array of our states
    //error check for DC
    if( trim( $split[1] ) == "" )
    {
      $split[1] = "DC";
    }
		if( !is_array( $states_counties[ $state ] ) )
		{
			$states_counties[ $state ] = Array( );
			$states_counties[ $state ][ $fip ] = Array( "name" => $split[0], "fips6" => $fip, "state" => $state );
		}
		else
		{
			$states_counties[ $state ][ $fip ] = Array( "name"=> $split[0], "fips6" => $fip, "state" => $state );
		}
  }
  fclose( $handle );
}

?>
<html>
	<head>
		<title>Weather Alerts</title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js" type="text/javascript"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.11/jquery-ui.min.js" type="text/javascript"></script>
    <link rel="stylesheet" href="query-ui-1.8.11.custom.css"></link>
    <script>
      $(document).ready( function(){
        $( "#accordion" ).accordion();
      });
    </script>
    <style>
			li{
				list-style-type: none;
      }
      .state-item{
        font-weight: bold;
        float: left:
        clear; both;
        /*border-top: 1px dotted black;*/
      }
      .county{
        max-width: 500px;
      }
      .county-item{
        float: left;
        position: relative;
        display: inline;
      }
      #accordion{
        width:400px;
      }
      .submit{
        float: left;
        clear: both;
        margin-top: 10px;
        margin-bottom: 50px;
      }
      .warningtype{
        clear: left;
      }
      #warnings ul li{
        border-bottom: 1px dotted black;
        margin-bottom: 5px;
        }
      #warnings ul li ul li{
        float: left;
        border-bottom: none;
        display: inline
      }
		</style>
			
	</head>
	<body>
			<div>
				<h1>Settings</h1>
<?php
$conf = new Config;
if( $_POST["submitted"] == "TRUE" )
{
  foreach( $_POST["fips"] as $fip )
  {
    $fip = sprintf( "%06d", $fip );
    $state = $states_fips[ substr( $fip, 0, 3 ) ][1];
    $county = $states_counties[ $state ][ $fip ][ "name" ];
  }
  $settings = Array();
  $settings["root"] = Array();
  $settings["root"]["conf"] = Array();
  $settings["root"]["conf"]["fips"] = $_POST["fips"];
  $settings["root"]["conf"]["alert_width"] = $_POST["alert_width"];
  $settings["root"]["conf"]["alert_color"] = $_POST["alert_color"];
  $settings["root"]["conf"]["include_links"] = $_POST["include_links"];
  $settings["root"]["conf"]["display_state"] = $_POST["display_state"];
  $settings["root"]["conf"]["vtecs"] = $_POST[ "vtecs" ];
  $conf->parseconfig($settings["root"]["conf"], "PHPArray");
  $options = array('name' => 'conf');
  $conf->writeConfig( getcwd(). "/config.xml", "xml", $options );
  print "Saved config file!<br />";

}
else
{
  $root =& $conf->parseConfig(getcwd() .'/config.xml', 'XML' );
  if (PEAR::isError($root))
  {
    die('Error while reading configuration: ' . $root->getMessage());
  }
  $settings = $root->toArray();
}

$count = 0;

//array of our states for prettification
$state_list = array(
                'AL'=>"Alabama",
                'AK'=>"Alaska",  
                'AZ'=>"Arizona",  
                'AR'=>"Arkansas",  
                'CA'=>"California",  
                'CO'=>"Colorado",  
                'CT'=>"Connecticut",  
                'DE'=>"Delaware",  
                'DC'=>"District Of Columbia",  
                'FL'=>"Florida",  
                'GA'=>"Georgia",  
                'HI'=>"Hawaii",  
                'ID'=>"Idaho",  
                'IL'=>"Illinois",  
                'IN'=>"Indiana",  
                'IA'=>"Iowa",  
                'KS'=>"Kansas",  
                'KY'=>"Kentucky",  
                'LA'=>"Louisiana",  
                'ME'=>"Maine",  
                'MD'=>"Maryland",  
                'MA'=>"Massachusetts",  
                'MI'=>"Michigan",  
                'MN'=>"Minnesota",  
                'MS'=>"Mississippi",  
                'MO'=>"Missouri",  
                'MT'=>"Montana",
                'NE'=>"Nebraska",
                'NV'=>"Nevada",
                'NH'=>"New Hampshire",
                'NJ'=>"New Jersey",
                'NM'=>"New Mexico",
                'NY'=>"New York",
                'NC'=>"North Carolina",
                'ND'=>"North Dakota",
                'OH'=>"Ohio",  
                'OK'=>"Oklahoma",  
                'OR'=>"Oregon",  
                'PA'=>"Pennsylvania",  
                'RI'=>"Rhode Island",  
                'SC'=>"South Carolina",  
                'SD'=>"South Dakota",
                'TN'=>"Tennessee",  
                'TX'=>"Texas",  
                'UT'=>"Utah",  
                'VT'=>"Vermont",  
                'VA'=>"Virginia",  
                'WA'=>"Washington",  
                'WV'=>"West Virginia",  
                'WI'=>"Wisconsin",  
                'WY'=>"Wyoming"
              );

?>
				<form method="POST" action="<?php print $_SERVER["PHP_SELF"]; ?>">
        <input type="hidden" name="submitted" value="TRUE" />
        <?php 
        //checked string check
        if( in_array ( $county["fips6"],array_values( $settings["root"]["conf"]["fips"] ) ) )
        {
          $checked_string = " CHECKED";
        }
        else
        {
          $checked_string = " ";
        }
        //checked string check
        if( in_array ( $county["fips6"],array_values( $settings["root"]["conf"]["fips"] ) ) )
        {
          $checked_string = " CHECKED";
        }
        else
        {
          $checked_string = " ";
        }

        ?>

        <span><label for="include_links">Include Links: <input type="checkbox" id="include_links" name="include_links" value="<?php print $settings["root"]["conf"]["include_links"];?>" ></label></span>
        <span><label for="display_state">Display State with County Name: <input type="checkbox" id="display_state" name="display_state"  value="<?php print $settings["root"]["conf"]["display_state"];?>" ></label></span>
        <div><label for="alert_color">Alert Color: <input type="input" id="alert_color" name="alert_color" value="<?php print $settings["root"]["conf"]["alert_color"]; ?>"></label></div>
        <div><label for="alert_width">Alert Width: <input type="input" id="alert_width" name="alert_width" value="<?php print $settings["root"]["conf"]["alert_width"]; ?>"></label></div>

				<br />
				<br />
				<br />
				<br />
        <hr />
        <h3>Warnings</h3>
        <div id="warnings">
          <ul>
            <li class="warningtype">Ashfall:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="AF-Y" /> Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="AF-A" />Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="AF-W" />Warning</li>
              </ul>
            </li>
            <li class="warningtype">Air Stagnation:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="AS-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="AS-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="AS-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li class="warningtype">Blowing Snow:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="BS-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="BS-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="BS-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li class="warningtype">Brisk Wind:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="BW-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="BW-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="BW-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Blizzard:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="BZ-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="BZ-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="BZ-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Coastal Flood:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="CF-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="CF-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="CF-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Dust Storm:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="DS-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="DS-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="DS-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Blowing Dust:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="DU-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="DU-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="DU-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Extreme Cold:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="EC-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="EC-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="EC-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Excessive Heat:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="EH-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="EH-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="EH-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Extreme Wind:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="EW-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="EW-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="EW-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Aereal Flood:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="FA-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="FA-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="FA-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Flash Flood:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="FF-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="FF-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="FF-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Dense Fog:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="FG-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="FG-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="FG-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Flood:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="FL-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="FL-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="FL-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Frost:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="FR-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="FR-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="FR-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Fire Weather:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="FW-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="FW-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="FW-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Freeze:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="FZ-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="FZ-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="FZ-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Gale:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="GL-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="GL-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="GL-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Hurricane Force Wind:
              <ul>
 Snow               <li><input type="checkbox" name="vtecs[]" value="HF-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="HF-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="HF-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Inland Hurricane:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="HI-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="HI-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="HI-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Heavy Snow:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="HS-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="HS-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="HS-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Heat:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="HT-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="HT-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="HT-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Hurricane:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="FZ-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="FZ-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="FZ-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>High Wind:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="FZ-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="FZ-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="FZ-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Hydrologic:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="HY-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="HY-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="HY-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Hard Freeze:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="HZ-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="HZ-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="HZ-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Sleet:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="IP-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="IP-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="IP-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Ice Storm:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="IS-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="IS-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="IS-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Lake Effect Snow and Blowing Snow:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="LB-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="LB-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="LB-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Lake Effect Snow:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="LE-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="LE-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="LE-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Low Water:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="LO-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="LO-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="LO-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Lakeshore Flood:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="LS-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="LS-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="LS-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Lake Wind:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="LW-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="LW-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="LW-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Marine:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="MA-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="MA-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="MA-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Small Craft for Rough Bar:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="RB-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="RB-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="RB-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Snow and Blowing Snow:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="SB-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="SB-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="SB-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Small Craft:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="SC-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="SC-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="SC-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Hazardous Seas:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="SE-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="SE-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="SE-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Small Craft For Winds:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="SI-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="SI-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="SI-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Dense Smoke:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="SM-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="SM-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="SM-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Snow:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="SN-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="SN-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="SN-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Storm:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="SR-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="SR-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="SR-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>High Surf:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="SU-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="SU-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="SU-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Seveve Thunderstorm:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="SV-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="SV-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="SV-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Small Craft for Hazardous Seas:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="SW-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="SW-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="SW-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Inland Tropical Storm:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="TI-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="TI-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="TI-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Tornado:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="TO-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="TO-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="TO-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Tropical Storm:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="TR-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="TR-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="TR-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Tsunami:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="TS-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="TS-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="TS-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Typhoon:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="TY-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="TY-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="TY-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Ice Accretion:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="UP-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="UP-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="UP-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Wind Chill:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="WC-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="WC-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="WC-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Wind:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="WI-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="WI-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="WI-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Winter Storm:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="WS-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="WS-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="WS-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Winter Weather:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="WW-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="WW-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="WW-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Freezing Fog:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="ZF-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="ZF-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="ZF-W" />&nbsp;Warning</li>
              </ul>
            </li>
            <li>Freezing Rain:
              <ul>
                <li><input type="checkbox" name="vtecs[]" value="ZR-Y" />&nbsp;Advisory</li>
                <li><input type="checkbox" name="vtecs[]" value="ZR-A" />&nbsp;Watch</li>
                <li><input type="checkbox" name="vtecs[]" value="ZR-W" />&nbsp;Warning</li>
              </ul>
            </li>
          </ul>
        </div>
				<h3>States</h3>
        <div id="accordion">
            <?php 
          foreach( array_keys( $states_counties ) as $state )
          {
            print "<h3 class=\"state-item\">". $state_list[ trim($state) ] ."</h3>";
            print "<div>";
            print "<ul class\"county\">";
            foreach( $states_counties[ $state ] as $county )
            {
              //checked string check
              if( in_array ( $county["fips6"], array_values( $settings["root"]["conf"]["fips"] ) ) )
              {
                $checked_string = " CHECKED";
              }
              else
              {
                $checked_string = " ";
              }
              printf( "<li class=\"county-item\"><input type=\"checkbox\" value=\"%06d\" name=\"fips[]\" %s /> %s </li>",$county["fips6" ], $checked_string, $county ["name" ]);
            }
            print "</ul>";
            print "</div>";
          }
        ?>
        </div>
        <input class="submit" type="submit" value="Save" />
        </form>
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
        <br />
			</div>
		</body>
</html>
