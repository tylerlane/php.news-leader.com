<?php
//db file
require( "../config.php" );

$conn =  mysql_connect( $db_hostname, $db_username,$db_password );
$db_selected = mysql_select_db( $db_name, $conn );
if( !$db_selected )
{
	print "There was an error connecting to the database server.";
}

$query = "UPDATE polls SET ";
$query .= "type_id = '". $_REQUEST[ "poll_type" ] ."', ";
$query .= "question = '". $_REQUEST[ "question" ] ."', ";
$query .= "max_options = '". $_REQUEST[ "max_options" ] ."', ";
$query .= "start_time = '". $_REQUEST[ "start_date" ] ." 17:00:00', ";
$end_date = date("Y-m-d", strtotime( $_REQUEST[ "start_date"] ) + 86400 );
$query .= "end_time = '$end_date 16:59:59' ";
$query .= "WHERE id = '". $_REQUEST[ "id" ] ."'";
$update_res = mysql_query( $query, $conn );


print "<b>query</b> = $query \r\n";

for( $i=1; $i <= $_REQUEST[ "max_options" ]; $i++ )
{
	//update the options ONLY if its not empty.
	if( !empty( $_REQUEST[ "option" . $i ] ) )
	{
		$check_query = "SELECT * FROM options where option_id = ". $_REQUEST[ "option_". $i ."_id" ];
		$check_res = mysql_query( $check_query, $conn );
		if( mysql_num_rows( $check_res ) == 1 )
		{
			$options_query = "UPDATE options SET option_text = '". $_REQUEST[ "option". $i ] ."' WHERE option_id = ". $_REQUEST[ "option_" . $i . "_id" ];
			$options_res = mysql_query( $options_query, $conn );
		}
		else
		{
			$options_query = "INSERT INTO options( option_text, poll_id )VALUES( '". $_REQUEST[ "option". $i ] ."','". $_REQUEST[ "id" ] ."')";
			$options_res = mysql_query( $options_query, $conn );
			
		}
		print "<b>options_query</b> = $options_query \r\n";
	}
}


?>