<?php
require( "../config.php" );
$conn = mysql_connect( $db_hostname, $db_username, $db_password );
$db_selected = mysql_select_db( $db_name );
if( $_REQUEST[ "type" ] == "natural" )
{
	$table = "natural_wonders";
}
elseif( $_REQUEST[ "type" ] == "manmade" )
{
	$table = "manmade_wonders";
}
$query = "SELECT * FROM $table";
$res = mysql_query( $query, $conn );
?>
<html>
<head>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script>
$(document).ready( function(){
	$('input:checkbox').click( function()
	{
		var counter = $('input:checkbox').filter(':checked' ).length;
		if( counter > 7 )
		{
			$(this).removeAttr( "checked" );
		}
	});
	$('input:button').click( function()
	{
		var my_string = "";
		var count = 0;
		$( '#content input:checkbox:checked' ).each(function()
		{
			if( count == 0 )
			{ 
				my_string = my_string +"wonders[]=" + $(this).val();
			}
			else
			{
				my_string = my_string + "&wonders[]=" + $(this).val();
			}
			count = count + 1;
			
		});
		if( typeof console != "undefined" )
		{
			console.log( my_string );
		}
		$.getJSON( "http://php.news-leader.com/polls/custom/process_votes.php?" + my_string + "&callback=?", {"type": <?php print "'" . $_REQUEST[ "type" ] ."'"; ?>}, record_vote );
		return false;
	});
	
	function record_vote( data )
	{
		if( typeof console != "undefined" )
		{
			console.log( "data = " + data );	
		}

		if( data )
		{
			$('#content' ).html( "Your vote has been submitted. Thank you!" );
		}
	}
});
</script>
</head>
<body>
<?php
print "<div id=\"content\">";
print "<form>";
while( $row = mysql_fetch_array($res ) )
{
	print "<input type=\"checkbox\" name=\"wonders[]\" value=\"". $row[ "name" ] ."\">". $row[ "name" ] ."<br />";
}
print "<input type=\"button\" value=\"Submit Votes\">";
print "</form>";
print "</div>";
print "</body>";
print "</html>";
?>