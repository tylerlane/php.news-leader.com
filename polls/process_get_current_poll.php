<?php
require( "config.php" );
require( "admin/jsonwrapper.php" );

$conn = mysql_connect( $db_hostname, $db_username, $db_password );
$db_selected = mysql_select_db( $db_name );
if( !$db_selected )
{
	$error = "There was an error connecting to the polls database." . mysql_error();
}
else
{
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
	
	//if there is no poll_type set, we're going to set it to front_page
	if( empty( $_REQUEST[ "poll_type" ] ) )
	{
		$_REQUEST[ "poll_type" ] == "front_page";
	}
	$query = "SELECT polls.id as poll_id FROM polls INNER JOIN type_config ON polls.type_id = type_config.type_id WHERE  poll_type='". $_REQUEST[ "poll_type" ] ."' AND start_time between '$start_date 17:00:00' and '$end_date 16:59:59' LIMIT 1";
	$res = mysql_query( $query, $conn );
	if( mysql_num_rows( $res ) == 1 )
	{
		$row = mysql_fetch_array( $res );
		$poll_id = $row[ "poll_id" ];
	}
}
print $_REQUEST[ "callback" ] ."(". json_encode( Array( "poll_id" => $poll_id ) ) .")";
?>