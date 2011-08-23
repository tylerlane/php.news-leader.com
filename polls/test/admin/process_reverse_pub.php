<?php
require( "../config.php" );

$conn = mysql_connect( $db_hostname, $db_username, $db_password );

$db_selected = mysql_select_db( $db_name );

if( !$db_selected )
{
	print "There was an error connecting to the database." . mysql_error();
}
/*
	Function to get the poll by the date specified and format it for reverse pub
*/
function get_question( $question_date, $conn )
{
	$question_date_start = date( "Y-m-d", ( strtotime( $question_date ) ) );
	$question_date_end =  date( "Y-m-d",  ( strtotime( $question_date ) + 86400 ) );
	$next_day = date( "l",strtotime( $question_date ) + 86400 );
	$query = "SELECT * FROM polls WHERE start_time = '$question_date_start 17:00:00' AND end_time = '$question_date_end 16:59:59' ORDER BY id ASC LIMIT 1";
	//print $query ."\r\n";
	$res = mysql_query( $query, $conn );
	//if we get results then fetch the array and output it.
	if( mysql_num_rows( $res ) == 1)
	{
		$row = mysql_fetch_array( $res, MYSQL_ASSOC );
		print "Question: ". $row[ "question" ]."\r\n";
		
		//query the options for this poll.
		$options_query = "SELECT * FROM options WHERE poll_id = ". $row[ "id" ] ." ORDER BY option_id asc";
		$options_res = mysql_query( $options_query, $conn );

		while( $options_row = mysql_fetch_array( $options_res, MYSQL_ASSOC ) )
		{
			//having to make sure there's no spaces/tabs when i close out php. stupid.
			print "&#149; ". $options_row["option_text" ] ."\r\n"; 
		}
		print "\r\nTo vote, please go online to News-Leader.com. Vote by 5 p.m. and see results in $next_day's newspaper.\r\n";
	}
	//if no rows returned, lets print out an error
	else
	{
		print "ERROR! No Poll for selected day. Please fix this!";
	}
//closing out the mysql_num_rows statement
//closing out the function
}

/* 
	Function to get the results of a poll for the day specified
*/
function get_results( $result_date, $conn )
{
	$result_date_start = date( "Y-m-d", strtotime( $result_date ) - 86400 );
	$result_date_end =  date( "Y-m-d", ( strtotime( $result_date ) ) );
	$day = date( "l",strtotime( $result_date ) );
	$query = "SELECT * FROM polls WHERE start_time = '$result_date_start 17:00:00' AND end_time = '$result_date_end 16:59:59' LIMIT 1";
	//print $query ."\r\n";
	$res = mysql_query( $query, $conn );

	if( mysql_num_rows( $res ) == 1 )
	{
		$row = mysql_fetch_array( $res, MYSQL_ASSOC );
		//$votes_query = "select COUNT( vote_id ) AS count,votes.poll_id,question, votes.option_id,option_text FROM votes INNER JOIN options ON votes.option_id = options.option_id INNER JOIN polls ON votes.poll_id = polls.id WHERE votes.poll_id = ". $row[ "id" ] ." GROUP BY votes.option_id,votes.poll_id ORDER BY option_id ASC";
		$votes_query = "SELECT options.option_id,options.option_text,COUNT( votes.vote_id ) AS count FROM options LEFT OUTER JOIN votes ON options.option_id = votes.option_id WHERE options.poll_id = ". $row[ "id" ]." GROUP BY options.option_id,options.poll_id";
		//print $votes_query ."\r\n";
		$votes_res = mysql_query( $votes_query, $conn );
		
		//okay doing to do something wierd here. basically if no results are brought back, then i'll query just the options
		$total_votes_query =  "SELECT COUNT( vote_id ) AS total_votes FROM votes where poll_id = ". $row[ "id" ];
		//print $total_votes_query ."\r\n";
		$total_votes_res = mysql_query( $total_votes_query, $conn );
		if( mysql_num_rows( $total_votes_res ) )
		{
			$total_votes_row = mysql_fetch_array( $total_votes_res );
			$total_votes = $total_votes_row[ "total_votes" ];
		}
		else
		{
			$total_votes = 0;
		}
		//print "total_votes = $total_votes \r\n";
		print $day ."'s results: ". $row[ "question" ] ."\r\n\r\n";
		
		
		//fucking hate hate hate hate this. gonna have to loop through the the results and see if the percentages add up to 100%
		$percent_total = 0;
		$num_rows = mysql_num_rows( $votes_res );
		while( $votes_row = mysql_fetch_array( $votes_res ) )
		{
			@$percent = round( bcdiv( $votes_row[ "count" ],$total_votes, 10 ), 4 ) * 100;
			$percent_total += $percent;
		}
		//okay now we check to see what percent_Total is
		$count = 1;
		$votes_res = mysql_query( $votes_query, $conn );
		while( $votes_row = mysql_fetch_array( $votes_res ) )
		{
			@$percent = round( bcdiv( $votes_row[ "count" ],$total_votes, 10 ), 4 ) * 100;
			// this is so stupid but if the percent_total isn't 100 and the num_rows == the count ie the last row. add or subtract 0.01 to the total
			if( $percent_total < 100 AND $count == $num_rows )
			{
				$percent += 0.01;
			}
			elseif( $percent_total > 100 AND $count == $num_rows )
			{
				$percent += -0.01;
			}
			
			print "&#149;". $votes_row[ "option_text" ] .": $percent percent \r\n";
			$count +=1;
		}
		print "Total Votes: $total_votes";
	}
	else
	{
		print "ERROR! No Poll for selected. Please fix this!";
	}
//closing out the function
}
if( !empty( $_REQUEST[ "question_date" ] ) )
{
	//use our handy function
	get_question( $_REQUEST[ "question_date" ], $conn );
}

if( !empty( $_REQUEST[ "result_date" ] ) )
{
	//use our handy function
	get_results( $_REQUEST[ "result_date" ], $conn  );
}

?>