<?php
//require our db config file
require( "config.php" );
require( "admin/jsonwrapper.php" );

$conn = mysql_connect( $db_hostname, $db_username, $db_password );
$db_selected = mysql_select_db( $db_name );
if( !$db_selected )
{
	$vote = "There was an error connecting to the polls database." . mysql_error();
}
else
{
	//make sure we got poll and option id to process votes
	if( !empty( $_REQUEST[ "poll_id" ] ) AND !empty( $_REQUEST[ "option_id" ] ) )
	{
		//query to check and see if the current pull being submitted is expired
		$check_query = "SELECT *,UNIX_TIMESTAMP(end_time) AS end_time_unix FROM polls WHERE id = ". $_REQUEST[ "poll_id" ];
		$check_res = mysql_query( $check_query, $conn );
		$check_row = mysql_fetch_array( $check_res );
		
		//stupid i have to do this but its MYSQL and its FUCKING RETARDED.
		// i'm pulling down the options and making sure the option submitted is a valid option.
		$options_query = "SELECT * FROM options where poll_id = ". $_REQUEST[ "poll_id" ];
		$options_res = mysql_query( $options_query, $conn );
		$options_array = Array();
		while( $options_row = mysql_fetch_array( $options_res ) )
		{
			$options_array[] = $options_row[ "option_id" ];
		}
		//get our current time and then the time from the db
		$current_time = time();
		$end_time = $check_row[ "end_time_unix" ];
		//if the end time is greater current time it means the end time hasn't occured yet so we can insert the record.
		if( $end_time > $current_time )
		{
			if( in_array( $_REQUEST[ "option_id" ], $options_array ) )
			{
				//build our query
				$query = "INSERT INTO votes( poll_id, option_id,ip_address ) VALUES( '". $_REQUEST[ "poll_id" ] ."', '". $_REQUEST[ "option_id" ] ."','". $_SERVER[ "REMOTE_ADDR" ] ."')";
		
				//print $query;
				$res = mysql_query( $query, $conn );
				$vote = "Vote Recorded";
			}
			else
			{
				//blank vote. DO nothing and delete the cookie.
				setcookie ("online_poll_" . $_REQUEST[ "poll_id" ], "", time() - 3600, "/", ".news-leader.com" );
			}
		}
		else
		{
			$vote = "EXPIRED POLL. VOTE BEING IGNORED.";
		}
		

	}
	else
	{
		$vote =  "missing a variable in the query string. FIXIT!";
	}
}

print $_REQUEST[ "callback" ] ."(". json_encode( array( "vote" => $vote ) ) .")";

?>