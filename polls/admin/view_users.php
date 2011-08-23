<?php
//db config
require( "../config.php" );
$conn = mysql_connect( $db_hostname, $db_username, $db_password);
$db_selected = mysql_select_db( $db_name, $conn );
if( !$db_selected )
{
    print "mysql is stupid and here is why: ". mysql_error();
}

?>

<html>
    <head>
        <title>View Users</title>
    </head>
    <body>
        <h3>View Users</h3>
        <br />
        <table border="1">
            <tr>
                <th>Username</th>
                <th>Password</th>
                <th>PW Hint</th>
                <th>Email</th>
                <th>Locked?</th>
                <th>Admin?</th>
            </tr>
            <?php
            $query = "SELECT * FROM users ORDER BY id ASC";
            $res = mysql_query( $query, $conn );
            while( $row = mysql_fetch_array( $res ) )
            {
                print "<tr>";
                print "<td><a href=\"edit_user.php?username=". $row[ "username" ] ."\">".$row[ "username" ] ."</a></td>";
                print "<td>". $row[ "password" ] ."</td>";
                print "<td>". $row[ "password_hint" ] ."</td>";
                print "<td>". $row[ "email" ] ."</td>";
                print "<td>". $row[ "locked" ] ."</td>";
                print "<td>". $row[ "admin" ] ."</td>";
                print "</tr>";
            }
            print "<tr><td colspan=\"6\">". mysql_num_rows( $res ) ." total users</td></tr>";
            ?>
        </table>
        <br />
        <a href="add_user.php">Add a User</a>
    </body>
</html>

        