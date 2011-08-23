<?php
require( "../config.php" );
require( "jsonwrapper.php" );

$conn = mysql_connect( $db_hostname, $db_username, $db_password );
$db_selected = mysql_select_db( $db_name );
if( $_REQUEST[ "type" ] == "natural" )
{
	$table = "natural_wonders";
}
else
{
	$table = "manmade_wonders";
}
$vote = "";
$errors = "";
foreach( $_REQUEST[ "wonders" ] as $wonder )
{
	$query = "UPDATE $table SET votes = (votes + 1 ) WHERE name like '%$wonder%'";
	mysql_query( $query, $conn );
	$error_text = mysql_error();
	$errors .= $errors .";";
	$vote .= $query .";";
	
}
print $_REQUEST[ "callback" ] ."(". json_encode( array( "vote" => $vote,"errors" =>$errors ) ) .")";

?>