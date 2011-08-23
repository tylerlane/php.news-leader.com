<?php
//config file
require( "../config.php" );

$conn = mysql_connect( $db_hostname, $db_username, $db_password );
$db_selected = mysql_select_db( $db_name, $conn );
if( !$db_selected )
{
    print "MySQL is stupid and here is why: ". mysql_error();
}

$query = "INSERT INTO polls(";
$query .= "type_id, ";
$query .= "question,";
$query .= "max_options, ";
$query .= "start_time, ";
$query .= "end_time ) ";
$query .= "VALUES(  ";
$query .= "'". $_REQUEST[ "poll_type" ] ."',";
$query .= "'". $_REQUEST[ "question" ] ."', ";
$query .= "'". $_REQUEST[ "max_options" ] ."', ";
$query .= "'". $_REQUEST[ "start_date" ] . " 17:00:00', ";
//calculating the end date automagatically now
$end_date = date("Y-m-d", strtotime( $_REQUEST[ "start_date"] ) + 86400 );
$query .= "'$end_date 16:59:59' ) ";

print $query;
$res = mysql_query( $query, $conn );

$id = mysql_insert_id( $conn );
if( $id )
{
   	for( $i=1; $i<= $_REQUEST[ "max_options" ]; $i++ )
	{
		$options_var_name = "option" . $i;
		if( !empty( $_REQUEST[ $options_var_name ] ) )
		{
			$options_query = "INSERT INTO options( poll_id, option_text ) VALUES($id,'". $_REQUEST[ $options_var_name ] ."')";
			$options_res = mysql_query( $options_query, $conn );
		}
		
	}
	print"1";
}
else
{
   print "0";
}

?>