<?php
require( "config.php" );
require( "admin/jsonwrapper.php" );
$conn = mysql_connect( $db_hostname, $db_username, $db_password );
$db_selected = mysql_select_db( $db_name, $conn );
if( !$db_selected )
{
	$poll .= "There was an error connecting to the database: ". mysql_error();
}
else
{
	//okay so the thought is we get the start date 
	$now = time();
	$fivepm = strtotime( "17:00" );
	//its after pm so we pick the poll that starts today
	if( $now > $fivepm )
	{
		$start_date = date( "Y-m-d",time() );
		$end_date = date( "Y-m-d", time() + 86400 );
	}
	//else we pick the poll that started yesterday
	else
	{
		$start_date = date( "Y-m-d",time() - 86400 );
		$end_date = date( "Y-m-d", time()  );
		
	}
	//if there is no poll_type set, we're going to set it to front_page
	if( empty( $_REQUEST[ "poll_type" ] ) )
	{
		$_REQUEST[ "poll_type" ] == "front_page";
	}
	
	$query = "SELECT *,polls.id as poll_id FROM polls INNER JOIN type_config ON polls.type_id = type_config.type_id WHERE  poll_type='". $_REQUEST[ "poll_type" ] ."' AND start_time between '$start_date 17:00:00' and '$end_date 16:59:59' LIMIT 1";
	
	$res = @mysql_query( $query, $conn );
	$error = mysql_error();
	
	//temp html section
	//end temp html

	if(  !$error  )
	{
		$row = @mysql_fetch_array( $res, MYSQL_ASSOC );
		$cookie_name = "online_poll_" . $row[ "poll_id" ];
		if( empty( $_COOKIE[ $cookie_name ] ) )
		{
		
			$poll = "<div id='poll'>";
			$poll .= "<h3><a name='poll_title' id='poll_title'>". $row[ "poll_title" ] ."</a></h3>";
			$poll .= "<form id=\"online_poll\" name=\"online_poll\">";
			//hidden field for the poll_id
			$poll .= "<input type='hidden' id='poll_id' name='poll_id' value='". $row[ "id" ] ."' />";
			//question section
			$poll .= "<div class='small'>". $row[ "question" ] . "</div>";
			//end question question
			//options section
			$poll .= "<div style='margin-top: 10px;'></div>";
			$poll .= "<div class='newslist'>";
			$poll .= "<ul>";
			$options_query = "SELECT * FROM options WHERE poll_id = ". $row[ "id" ] ." ORDER BY option_id ASC";
			//$poll .= "<!--options_query = $options_query-->";
			$options_res = mysql_query( $options_query, $conn );
			while( $options_row = mysql_fetch_array( $options_res, MYSQL_ASSOC ) )
			{	
				$poll .= "<li>";
				$poll .= "<input name='option_id' value='". $options_row[ "option_id" ] ."' type='radio'>". $options_row[ "option_text" ];
				$poll .= "</li>";
			}
			$poll .= "</ul>";
			$poll .= "</div>";
			$poll .= "<div style='margin-top: 10px;'></div>";
			//end of options section
			//voting button
			$poll .= "<!--Voting Button-->";
			$poll .= "<div align='center'>";
			$poll .= "<input src='http://www.news-leader.com/graphics/poll_btn2.gif' style='font-weight: bold;' type='IMAGE' id='vote_button'>";
			$poll .= "</div>";
			$poll .= "<!--End Voting Button-->";
			//end of voting button
			$poll .= "<div style='margin-top: 12px;'></div>";
			// results section
			$poll .= "<div class='tiny' style='margin-top: 5px;'>";
			$poll .= "<b><a href='javascript:void(0);' id='todays_results'>POLL RESULTS:<br>TODAY</a> | <a href='javascript:void(0);' id='yesterdays_results'>YESTERDAY</a>";
			$poll .= "<br> </b></div>";
			//end results section
			$poll .= "</form>";
			$poll .= "<pbsdisabled:macro name='go4_smartpoll' pollcategory='OPINIONS' width='160'>";
			$poll .= "</pbsdisabled:macro></div>";
		}
		else
		{
			//this should never display but just in case i'm adding in some code to prevent this.
			$poll = "<div class='tiny'>You have already voted in this poll. <a href='javascript:void(0);' id='todays_results'>Click Here</a> To See the Results of this Poll";
		}
		
	}
	else
	{
		$poll = "<div class='tiny'>Due to a technical error, poll voting is not currently possible. We apologize for the inconvenience.</div>";
	}
}
print $_REQUEST[ "callback" ] . "(" . json_encode( array( "poll"=> $poll ) ) .")";
?>