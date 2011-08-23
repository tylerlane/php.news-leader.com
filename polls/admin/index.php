<?php
require( "../config.php" );
$conn = mysql_connect( $db_hostname, $db_username, $db_password );
$db_selected = mysql_select_db( $db_name );
if( !$db_selected )
{
	print "There was an error connecting to the mysql database." . mysql_error();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>View Polls</title>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
		<script type="text/javascript" src="view_polls.js"></script>
		<link rel="stylesheet" href="style.css" type="text/css">
		<link rel="stylesheet" href="ui-lightness/jquery-ui.css" type="text/css">
	</head>
	<body>
		<div id="dialog" title="">
			<p id="validateTips">All form fields are required.</p>
			<form id="poll_form">
			<fieldset>
				<label for="poll_type">Poll Type</label>
				<select name="poll_type">
					<?php
					$query = "SELECT * FROM type_config WHERE active = True ORDER BY type_id ASC";
					$res = mysql_query ( $query, $conn );
					while( $row = mysql_fetch_array( $res ) )
					{
						print "<option id=\"". $row[ "type_id" ] ."\" value=\"". $row[ "type_id" ] ."\">". $row[ "friendly_name" ] ."</option>";
					}
					?>
				</select>
				<label for="story_link">Story Link</label>
				<input type="text" name="story_link" id="story_link" value="" class="text ui-widget-content ui-corner-all" />
				<label for="question">Question</label>
				<textarea name="question" id="question" value="" class="text ui-widget-content ui-corner-all" cols="80" rows="3" wrap="virtual"></textarea>
				<label for="max_options">Max Options</label>
				<input type="text" name="max_options" id="max_options" value="" class="text ui-widget-content ui-corner-all" />
				<label for="start_date">Start Date</label>
				<input type="text" name="start_date" id="start_date" value="" class="text ui-widget-content ui-corner-all"  />
				<hr />
				<div id="options">
				</div>
			</fieldset>
			</form>
		</div>
		<div id="links">
			<ul>
				<li><a href="index.php"><h1>View Polls</h1></a></li>
				<li><a href="reverse_pub.php"><h1>Reverse Pub</h1></a></li>
			</ul>
		</div>
		
		<div id="polls-contain" class="ui-widget">
			<button id="create-poll" class="ui-button ui-state-default ui-corner-all">Create new poll</button>
			<table id="polls" class="ui-widget ui-widget-content">
				<thead>
					<tr class="ui-widget-header">
						<th>Type</th>
						<th>Question</th>
						<th>Options</th>
						<th>Max</th>
						<th>Start Date</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
			<br />
			<button id="create-poll" class="ui-button ui-state-default ui-corner-all">Create new poll</button>
		</div>
	</body>
</html>

        