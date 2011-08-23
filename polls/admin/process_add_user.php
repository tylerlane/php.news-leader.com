<?php
//config file
require( "../config.php" );

$conn = mysql_connect( $db_hostname, $db_username, $db_password );
$db_selected = mysql_select_db( $db_name, $conn );
if( !$db_selected )
{
    print "MySQL is stupid and here is why: ". mysql_error();
}

$query = "INSERT INTO users(";
$query .= "username, ";
$query .= "password,";
$query .= "password_hint, ";
$query .= "email ) ";
$query .= "VALUES(  ";
$query .= "'". $_REQUEST[ "username" ] ."', ";
$query .= "'". $_REQUEST[ "password" ] ."', ";
$query .= "'". $_REQUEST[ "password_hint" ] ."', ";
$query .= "'". $_REQUEST[ "email" ] ."' ) ";

$res = mysql_query( $query, $conn );

$id = mysql_insert_id( $conn );
if( $id )
{
    //insert was successful so we'll redirect back to the view users page for now
    header( "Location: view_users.php" );
}
else
{
    print "There was an error inserting user!. Mysql reported: ". mysql_error();
    print "<b>query</b> = $query <br />\r\n";
}

?>