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
        font-weight: bold;
      }
      #warnings ul li{
        border-bottom: 1px dotted black;
        margin-bottom: 5px;
        }
      #warnings ul li ul li{
        float: left;
        border-bottom: none;
        font-weight: normal;
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

        <hr />
        <?php 
          $warnings = Array( 
            "AF" => "Ashfall",
            "AS" => "Air Stagnation",
            "BS" => "Blowing Snow",
            "BW" => "Brisk Wind",
            "BZ" => "Blizzard",
            "CF" => "Coastal Flood",
            "DS" => "Dust Storm",
            "DU" => "Blowing Dust",
            "EC" => "Extreme Cold",
            "EH" => "Excessive Heat",
            "EW" => "Extreme Wind",
            "FA" => "Aereal Flood",
            "FF" => "Flash Flood",
            "FG" => "Dense Fog",
            "FL" => "Flood",
            "FR" => "Frost",
            "FW" => "Fire Weather", 
            "FZ" => "Freeze",
            "GL" => "Gale",
            "HF" => "Hurricane Force Wind",
            "HI" => "Inland Hurricane", 
            "HS" => "Heavy Snow",
            "HT" => "Heat", 
            "HU" => "Hurricane",
            "HW" => "High Wind", 
            "HY" => "Hydrologic", 
            "HZ" => "Hard Freeze",
            "IP" => "Sleet",
            "IS" => "Ice Storm",
            "LB" => "Lake Effect Snow and Blowing Snow",
            "LE" => "Lake Effect Snow",
            "LO" => "Low Water",
            "LS" => "Lakeshore Flood",
            "LW" => "Lake Wind", 
            "MA" => "Marine",
            "RB" => "Small Craft for Rough Bar",
            "SB" => "Snow and Blowing Snow",
            "SC" => "Small Craft",
            "SE" => "Hazardous Seas",
            "SI" => "Small Craft For Winds",
            "SM" => "Dense Smoke",
            "SN" => "Snow",
            "SR" => "Storm",
            "SU" => "High Surf",
            "SV" => "Seveve Thunderstorm",
            "SW" => "Small Craft for Hazardous Seas",
            "TI" => "Inland Tropical Storm",
            "TO" => "Tornado",
            "TR" => "Tropical Storm",
            "TS" => "Tsunami",
            "TY" => "Typhoon",
            "UP" => "Ice Accretion",
            "WC" => "Wind Chill",
            "WI" => "Wind",
            "WS" => "Winter Storm",
            "WW" => "Winter Weather",
            "ZF" => "Freezing Fog",
            "ZR" => "Freezing Rain"
          );
        
        print "<h3>Warnings</h3>";
        print "<div id=\"warnings\">";
        print "<ul>";
        foreach( $warnings as $key => $value )
        {
          print "<li class=\"warningtype\">$value\r\n";
          print "<ul>\r\n";
          print "<li><input type=\"checkbox\" name=\"vtecs[]\" value=\"$key-Y\"";
          $var = $key ."-Y";
          if( in_array( $var, $settings["root"]["conf"]["vtecs"] ) )
          {
            print " CHECKED ";
          }
          print "/>Advisory</li>\r\n";
          print "<li><input type=\"checkbox\" name=\"vtecs[]\" value=\"$key-A\"";
          $var = $key ."-A";
          if( in_array( $var, $settings["root"]["conf"]["vtecs"] ) )
          {
            print " CHECKED ";
          }
          print "/>Watch</li>\r\n";
          print "<li><input type=\"checkbox\" name=\"vtecs[]\" value=\"$key-W\"";
          $var = $key ."-W";
          if( in_array( $var, $settings["root"]["conf"]["vtecs"] ) )
          {
            print " CHECKED ";
          }
          print "/>Warning</li>\r\n";
          print "</ul>\r\n";
          print "</li>\r\n";
        }
        print "</ul>\r\n";
   
?>
        <br />
        <br />
        <br />
        <hr />
        <br />
        <br />
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
