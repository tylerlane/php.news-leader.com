<?php
require( "config.php" );

$conn = mysql_connect( $db_hostname, $db_username, $db_password );
$db_selected = mysql_select_db( $db_name, $conn );

//okay so the thought is we get the start date 
$now = time();
$fivepm = strtotime( "17:00" );
//its after pm so we pick the poll that starts today
if( $now > $fivepm )
{
	$start_date = date( "Y-m-d",time() );
	$end_date = date( "Y-m-d", time() + 86400 );
}
//else we pick the poll that started yesterday
else
{
	$start_date = date( "Y-m-d",time() - 86400 );
	$end_date = date( "Y-m-d", time()  );
	
}

$query = "SELECT polls.id as poll_id FROM polls INNER JOIN type_config ON polls.type_id = type_config.type_id WHERE poll_type='front_page' AND start_time between '$start_date 17:00:00' and '$end_date 16:59:59' LIMIT 1";
$res = mysql_query( $query, $conn );
$row = mysql_fetch_array( $res, MYSQL_ASSOC );


?>
<html>
	<head>
		<title>Get Poll</title>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		<script type="text/javascript" src="http://php.news-leader.com/polls/polls.js"></script>
		<link rel="stylesheet" href="http://www.news-leader.com/includes/css/go4/poll.css"/>
		<link rel="stylesheet" href="http://www.news-leader.com/gci/gc/p6/GO4Styles-min.css" type="text/css" />
		<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
		<META HTTP-EQUIV="EXPIRES" CONTENT="0">
		<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
		<style>
		    .graph { 
		        position: relative; /* IE is dumb */
		        width: <?php print $_GET[ "width" ]; ?>px; 
		        border: 0px solid #517da4; 
		        padding: 2px; 
		    }
		    .graph .bar { 
		        display: block;
		        position: relative;
		        background: #517da4; 
		        text-align: center; 
		        color: #333; 
		        height: 2em; 
		        line-height: 2em;            
		    }
			ul{
				list-style: none;
			}
		    .graph .bar span { position: absolute; left: 1em; }
		</style>
	</head>
	<body>
	<div id="poll_container" style="width: <?php print $_GET[ "width" ]; ?>; height: <?php print $_GET[ "height" ]; ?>">
			<input type="hidden" name="current_poll_id" value="<?php print $row[ "poll_id" ]; ?>" id="current_poll_id">
			<div id="results">
			</div>
			<div id="poll">
			</div>
		</div>
	</body>
</html>

