<?php
//config file
require( "../config.php" );

$conn = mysql_connect( $db_hostname, $db_username, $db_password );
$db_selected = mysql_select_db( $db_name, $conn );
if( !$db_selected )
{
    print "MySQL is stupid and here is why: ". mysql_error();
}

$query = "UPDATE users SET ";
$query .= "username = '". $_REQUEST[ "username" ] ."', ";
$query .= "password = '". $_REQUEST[ "password" ] ."', ";
$query .= "password_hint = '". $_REQUEST[ "password_hint" ] ."', ";
$query .= "email = '". $_REQUEST[ "email" ] ."' ";
$query .= " WHERE username ='". $_REQUEST[ "username" ] ."'";
$res = mysql_query( $query, $conn );


if( mysql_affected_rows( $conn ) == 1 )
{
    //insert was successful so we'll redirect back to the view users page for now
    header( "Location: view_users.php" );
}
else
{
    print "There was an error updating user!. Mysql reported: ". mysql_error();
    print "<b>query</b> = $query <br />\r\n";
}

?>