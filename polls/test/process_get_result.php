<?php
//require our db config file
require( "config.php" );
require( "admin/jsonwrapper.php" );

$conn = mysql_connect( $db_hostname, $db_username, $db_password );
$db_selected = mysql_select_db( $db_name );
if( !$db_selected )
{
	$result .= "There was an error connecting to the polls database." . mysql_error();
}
else
{
	$now = time();
	//timestamp for 5 pm
	$fivepm = strtotime( "17:00" );
	
	//okay so the thought is we get the start date 
	if( $_REQUEST[ "range" ] == "yesterday" )
	{
		//checking to see if its after 5pm for date calculations
		if( $now > $fivepm )
		{
			$start_date = date( "Y-m-d",time() - 86400 );
			$end_date = date( "Y-m-d", time() );
		}
		else
		{
			//if its not 5 pm them we go back 2 days technically
			$start_date = date( "Y-m-d",time() - 172800 );
			$end_date = date( "Y-m-d", time() - 86400);
		}
		
	}
	else
	{
		//checking to see if its before or after 5pm for date calc stuff
		if( $now > $fivepm )
		{
			//okay so its after 5pm so we want the poll that started today
			$start_date = date( "Y-m-d",time() );
			$end_date = date( "Y-m-d", time() + 86400 );
		}
		else
		{
			//its not 5pm so we want the poll that started yesterday
			$start_date = date( "Y-m-d",time() - 86400 );
			$end_date = date( "Y-m-d", time() );
			
		}
		
	}

	//if there is no poll_type set, we're going to set it to front_page
	if( empty( $_REQUEST[ "poll_type" ] ) )
	{
		$_REQUEST[ "poll_type" ] == "front_page";
	}
	
	$query = "SELECT *,polls.id as poll_id FROM polls INNER JOIN type_config ON polls.type_id = type_config.type_id WHERE  poll_type='". $_GET[ "poll_type" ] ."' AND start_time between '$start_date 17:00:00' and '$end_date 16:59:59' LIMIT 1";
	
	$res = mysql_query( $query, $conn );
	//if no rows returned, display error message
	if( mysql_num_rows( $res ) )
	{
		$row = mysql_fetch_array( $res, MYSQL_ASSOC );
	
		//getting the votes/options
		$votes_query = "SELECT options.option_id,options.option_text,COUNT( votes.vote_id ) AS count FROM options LEFT OUTER JOIN votes ON options.option_id = votes.option_id WHERE options.poll_id = ". $row[ "id" ]." GROUP BY options.option_id,options.poll_id";
		//$result .= $votes_query;
		$votes_res = mysql_query( $votes_query, $conn  );

		$total_votes_query = "SELECT count(*) as count from votes where poll_id = ". $row[ "id" ];
		$total_votes_res = mysql_query( $total_votes_query );
		$total_votes_row = mysql_fetch_array( $total_votes_res );
		$total_votes = $total_votes_row[ "count" ];
		$result = "<h3><a name='poll_title' id='poll_title'>". $row[ "poll_title" ] ."</a></h3>";
		if( $_REQUEST[ "range" ] == "yesterday" )
		{
			$result_title = "Yesterday's Poll Results";
		}
		else
		{
			$result_title = "Today's Poll Results";
		}
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
		$result .= "<div class=\"tiny\" style=\"margin-top: 5px;\">";
		$result .= "<b><a href=\"javascript:void(0);\" id=\"todays_results\">POLL RESULTS:<br>TODAY</a> | <a href=\"javascript:void(0);\" id=\"yesterdays_results\">YESTERDAY</a>";
		$result .= "<br> </b></div>";
		//closing the graph div
		$result .= "</div>";
		if( empty( $_COOKIE[ "online_poll_" . $_REQUEST[ "current_poll_id" ] ] ) )
		{
			$result .= "<br /><a href=\"javascript:void(0);\" id=\"display_poll\">Back to Today's Poll</a>";
		}
	}
	else
	{
		$result = "There was no poll available for this day. We are working on addressing this issue.";
	}
	print $_REQUEST[ "callback" ] ."(". json_encode( array( "result" => $result ) ) .")";
}


?>