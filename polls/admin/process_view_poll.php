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
$query = "SELECT *,unix_timestamp(start_time) as start_time_unix,unix_timestamp( end_time ) as end_time_unix FROM polls WHERE id = ". $_REQUEST[ "id" ] ." ORDER BY id ASC";
$res = mysql_query( $query, $conn );
$options_array = Array();
$row = mysql_fetch_array( $res );

$options_query = "SELECT * from options where poll_id = " . $row[ "id" ];
$options_res = mysql_query( $options_query );
while( $options_row = mysql_fetch_array( $options_res ) )
{
	$options_array[] = $options_row;
}

print '{"poll":'. json_encode( $row ) .',"options":'. json_encode( $options_array ).'}';