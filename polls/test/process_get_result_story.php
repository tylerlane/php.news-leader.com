<?php
//require our db config file
require( "config.php" );
require( "admin/jsonwrapper.php" );
$cookie = "online_poll_" . $_REQUEST[ "poll_id" ];

$conn = mysql_connect( $db_hostname, $db_username, $db_password );
$db_selected = mysql_select_db( $db_name );
if( !$db_selected )
{
	$result .= "There was an error connecting to the polls database." . mysql_error();
}
else
{
	$query = "SELECT * FROM polls INNER JOIN type_config on polls.type_id = type_config.type_id WHERE id = ". $_REQUEST[ "poll_id" ];		
	$res = mysql_query( $query, $conn );
	//if no rows returned, display error message
	if( mysql_num_rows( $res ) )
	{
		$row = mysql_fetch_array( $res, MYSQL_ASSOC );
	
		$votes_query = "SELECT options.option_id,options.option_text,COUNT( votes.vote_id ) AS count FROM options LEFT OUTER JOIN votes ON options.option_id = votes.option_id WHERE options.poll_id = ". $row[ "id" ]." GROUP BY options.option_id,options.poll_id";
		//$result .= $votes_query;
		$votes_res = mysql_query( $votes_query, $conn  );

		$total_votes_query = "SELECT count(*) as count from votes where poll_id = ". $row[ "id" ];
		$total_votes_res = mysql_query( $total_votes_query );
		$total_votes_row = mysql_fetch_array( $total_votes_res );
		$total_votes = $total_votes_row[ "count" ];
		$result = "<h3><a name='poll_title' id='poll_title'>". $row[ "poll_title" ] ."</a></h3>";
		$now = time();
		$poll_end_time = strtotime( $row[ "end_time"] );
		$poll_end_date = date( "F jS, Y", $poll_end_time );
		if( $now > $poll_end_time )
		{
			//poll has already closed. print out the "this poll closed on blah 5th."
			$result .= "This poll closed on $poll_end_date.";
		}
		else
		{
			$result .= "This poll will close on $poll_end_date.";
		}
		$result_title = "Poll Results";
		$result .= "<h5>$result_title</h5>";
		$result .= "<div class=\"small\">". $row[ "question" ] . "</div>";
		$result .= "<div style=\"margin-top: 10px;\"></div>";
		$result .= "<div class=\"graph\">";

		while( $votes_row = mysql_fetch_array( $votes_res ) )
		{
			@$percent = round( bcdiv( $votes_row[ "count" ],$total_votes, 10 ), 4 ) * 100;
			$height = 20;
			$result .= "<div style='width:" . $_REQUEST[ "width" ] ."px; height:".$height ."px; background-color:#92b7d3;'>";
			$result .= "<div style='width:$percent%; height:".$height ."px; background-color:#517da4; border-right:1px white solid;'></div>";
			$result .= "<div style='margin-top:-20px; color:black; padding-left:4px;'>&nbsp;</div>";
			$result .= "<div style='text-align:right; margin-top:-12px; color:black; padding-right:4px;'><span class=\"small\"><b>$percent% (". $votes_row[ "count" ] .")</b></span></div>";
			$result .= "</div>";
			$result .= "<div class=\"small\"><b>". $votes_row[ "option_text" ] ."</b></div>";
			//$result .= "<strong style='width: $percent%' class=\"bar\">$percent%</strong>" . $votes_row[ "option_text" ] ." (". $votes_row[ "count" ] .")";
		}

		//closing the graph div
		$result .="<div class='tiny' style='margin-top:5px;'>";

		$result .= "</div>";
		if( empty( $_COOKIE[ $cookie ] ) AND $poll_end_time > $now )
		{
			$result .= "<br /><a href=\"javascript:void(0);\" id=\"display_poll\">Back to Poll</a>";
		}
	}
	else
	{
		$result = "There was no poll available for this day. We are working on addressing this issue.";
	}
	print $_REQUEST[ "callback" ] ."(". json_encode( array( "result" => $result ) ) .")";
}


?>