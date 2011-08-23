<?php
require( "../config.php" );

?>
<html>
    <head>
        <title>Add User</title>
    </head>
    <body>
        <h3>Add User</h3>
        <form action="process_add_user.php" method="POST">
            <table>
                <tr>
                    <td>
                        <b>Username</b>
                    </td>
                    <td>
                        <input type="text" name="username">
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Password</b>
                    </td>
                    <td>
                        <input type="text" name="password">
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Password Hint</b>
                    </td>
                    <td>
                        <input type="text" name="password_hint">
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Email</b>
                    </td>
                    <td>
                        <input type="text" name="email">
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" value="Add User">
                        <input type="reset" value=" Reset">
                    </td>
                </tr>
            </table>
        </form>
    </body>
</html>
