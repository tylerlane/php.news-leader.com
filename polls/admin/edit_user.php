<?php
require( "../config.php" );
$conn = mysql_connect( $db_hostname, $db_username, $db_password );
$db_selected = mysql_select_db( $db_name, $conn );
if( !$db_selected )
{
    print "MySQL is stupid and here is why: ". mysql_error();
}

$query = "SELECT * FROM users where username = '". $_REQUEST[ "username" ] ."'";
print "<b>query</b> = $query <br />";
$res = mysql_query( $query );
$row = mysql_fetch_array( $res );
?>
<html>
    <head>
        <title>Edit User</title>
    </head>
    <body>
        <h3>Edit User</h3>
        <form action="process_edit_user.php" method="POST">
            <table>
                <tr>
                    <td>
                        <b>Username</b>
                    </td>
                    <td>
                        <input type="text" name="username" value="<?php print $row[ "username" ]; ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Password</b>
                    </td>
                    <td>
                        <input type="text" name="password" value="<?php print $row[ "password" ]; ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Password Hint</b>
                    </td>
                    <td>
                        <input type="text" name="password_hint" value="<?php print $row[ "password_hint" ]; ?>">
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Email</b>
                    </td>
                    <td>
                        <input type="text" name="email" value="<?php print $row[ "email" ]; ?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" value="Save">
                        <input type="reset" value=" Reset">
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
