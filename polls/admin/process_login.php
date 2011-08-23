<?php
//our db config file
require("../config.php" );

$conn = mysql_connect( $db_hostname, $db_username, $db_password );
$db_selected = mysql_select_db( $db_name, $conn );
if( !$db_selected )
{
	print "There was an error connecting to the polls database!". mysql_error();
}
 
$query = "SELECT * FROM users where username = '". $_REQUEST[ "username" ] ."'";
$res = mysql_query( $query, $conn );

#var to hold the string we'll be returning
$retval = "";
if( mysql_num_rows( $res ) > 0 )
{
	$row = mysql_fetch_array( $res );
	if( $row[ "username" ] == $_REQUEST[ "username" ] AND $row[ "password" ] == $_REQUEST[ "password" ] )
	{
		$retval = 1;
	}
	else
	{
		$retval = 0;
	}
}
else
{
	$retval = 0;
}
//put the login value
print $retval;
?>