<?php
require( "../config.php" );
require( "jsonwrapper.php" );


$conn = mysql_connect( $db_hostname, $db_username, $db_password );
$db_selected = mysql_select_db( $db_name, $conn );
if( !$db_selected )
{
	print "There was an error connecting to the database: ". mysql_error();
}

//array to hold our database vars
$array = Array();
$query = "SELECT *,unix_timestamp(start_time) as start_time_unix, polls.id as poll_id, type_config.type_id as type_config_id FROM polls INNER JOIN type_config ON polls.type_id = type_config.type_id ORDER BY polls.start_time DESC";
$res = mysql_query( $query, $conn );
while( $row = mysql_fetch_array( $res ) )
{
	$options_query = "SELECT count( option_id ) as count from options where poll_id = " . $row[ "poll_id" ];
	$options_res = mysql_query( $options_query );
	$options_row = mysql_fetch_array( $options_res );
	$row[ "options_count" ] = $options_row[ "count" ];
	$row[ "start_date" ] = date( 'm-d-Y H:i:s', $row[ "start_time_unix" ] );
	$array[] = $row;
	
}
print '{"polls_array":'. json_encode( $array ) .'}';