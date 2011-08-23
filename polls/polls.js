	$(function() {
	var options = { path: '/', expires: 10, domain: '.news-leader.com' };
	var width = $("#poll_container" ).width();
	var current_poll_id = $( "#current_poll_id" ).val();
	var cookie_name = "online_poll_" + current_poll_id;	
	//$.ajaxSetup( { async: false } );
	
	//$.getJSON( "http://php.news-leader.com/polls/process_get_current_poll.php?callback=?", { "poll_type": "front_page" }, set_poll_id );
	//console.log( "get_current_poll" );
	
	//function to set a cookie
	function set_cookie ( name, value, path, domain )
	{
		var cookie_string = name + "=" + escape ( value );
		
		date = new Date();
		date.setTime( date.getTime() + ( 1 * 24 * 60 * 60 * 1000 ) );
		cookie_string += "; expires=" + date.toGMTString();
		if ( path )
			cookie_string += "; path=" + escape ( path );
			
		if ( domain )
			cookie_string += "; domain=" + escape ( domain );
			
	  	document.cookie = cookie_string;
	}
	//pretty self explanatory, get a cookie
	function get_cookie ( cookie_name )
	{
		var results = document.cookie.match ( '(^|;) ?' + cookie_name + '=([^;]*)(;|$)' );
		
		if ( results )
			return ( unescape ( results[2] ) );
		else
			return null;
	}
	
	//function to delete a cookie
	function delete_cookie ( cookie_name )
	{
		var cookie_date = new Date ( );  // current date & time
		cookie_date.setTime ( cookie_date.getTime() - 1 );
		document.cookie = cookie_name += "=; expires=" + cookie_date.toGMTString();
	}

	//going to see if the cookie is set for the poll
	function check_cookie()
	{
		if(  get_cookie( cookie_name ) )
		{
			//if the cookie exists, is it the same as our current poll?
			if( get_cookie( cookie_name ))
			{
				//console.log( "current_poll_id (inside check_cookie) = " + current_poll_id );
				//console.log( "jQuery.cookie( cookie_name ) =" + jQuery.cookie( cookie_name ) );
				//console.log( "current_poll_id =" + current_poll_id );
				if( parseInt( get_cookie( cookie_name ) ) == parseInt( current_poll_id ) )
				{
					$.getJSON( "http://php.news-leader.com/polls/process_get_result.php?callback=?", { "poll_type": "front_page", "width": width,"current_poll_id": current_poll_id }, set_results );
				}
				else
				{
					$.getJSON( "http://php.news-leader.com/polls/process_get_poll.php?callback=?", { "poll_type": "front_page" }, set_poll );
				}
			}
			else
			{
				//if its NOT the same poll id, then we pull the current poll.
				$.getJSON( "http://php.news-leader.com/polls/process_get_poll.php?callback=?", { "poll_type": "front_page" }, set_poll );
			}
		}
		//if no cookie set, then we pull the current poll
		else
		{
			$.getJSON( "http://php.news-leader.com/polls/process_get_poll.php?callback=?", { "poll_type": "front_page" }, set_poll );
		}
	}


	//function to set our poll_id var
	/*function set_poll_id( data )
	{
		//console.log( "data.poll_id = " + data.poll_id );
		current_poll_id = data.poll_id;
		
		//checking to see if the cookie poll id is the same or different than the CURRENT poll_id
		if( jQuery.cookie( cookie_name ) != current_poll_id )
		{
			//delete the cookie first before we display 
			jQuery.cookie( cookie_name, null, options );
		}
		//hopefully this will force the darned thing to work
		check_cookie();
	}
	*/
	
	//function to set the poll text
	function set_poll( data )
	{
		//console.log( "poll = " + data.poll );
		$( "#poll" ).html( data.poll );
		$( "#results" ).html( "" );
		$( "#poll" ).fadeIn( "fast" );
		$( "#results" ).fadeOut( "fast");
	}
	
	//function to set the results text
	function set_results( data )
	{
		//console.log( "result = " + data.result );
		$( "#results" ).html( data.result );
		$( "#poll" ).html ("");
		$( "#results" ).fadeIn( "fast" );
		$( "#poll" ).fadeOut( "fast" );
		
	}
	
	//callback function that does NOTHING but need it for the jsonrequest
	function record_vote( data )
	{
		//console.log( "vote = " + data.vote );
	}
	
	$( "#cookie_delete" ).click( function()
	{
		//deleting the cookie.
		delete_cookie( cookie_name );
		//console.log( "DELETING COOKIE" );
		check_cookie();
		return false;
	});
	
	$( "#check_cookie" ).click( function(){
		check_cookie();
	});
	
	//disabling the form.
	$( "#online_poll" ).live("submit", function(){ return false;} );
	
	//this should bind the input image
	$("#vote_button").live( "click", function()
	{
		//okay vote button was pressed. lets build our query string
		var poll_id = $( "#poll_id" ).val();
		var option_id = $( "input:radio:checked:last" ).val();
		if( option_id != undefined || option_id != "" )
		{
			//console.log( "Poll_id = " + poll_id );
			//console.log( "Option_id = " + option_id );
			//console.log( "submitting the option to record_vote.php" );
			
			$.getJSON( "http://php.news-leader.com/polls/process_record_vote.php?callback=?", {"poll_id": poll_id , "option_id": option_id }, record_vote );
			//setting the cookie cause we voted!
			if( get_cookie( cookie_name ) )
			{
				//deleting the cookie.
				delete_cookie( cookie_name, null, options );
				//console.log( "DELETING COOKIE" );
			}
			//setting the date for 1 day from now.
			date = new Date();
			date.setTime( date.getTime() + ( 1 * 24 * 60 * 60 * 1000 ) );
			//jQuery.cookie( cookie_name, poll_id, { expires: date, path: '/', domain:'.news-leader.com' });
			set_cookie( cookie_name, poll_id, "/", ".news-leader.com" );
			//then we run our check cookie function which will display the poll or the results
			check_cookie();
		
			//returning false so it doesn't try to submit the form manually.
		}
		
		//Omniture Code
		GEL.thepage.viewTracker.trackLink("Online Poll - Recording Vote");
		
		return false;
	} );
	
	$("#todays_results" ).live( "click", function()
	{
		//console.log( "loading today's results" );
		$.getJSON( "http://php.news-leader.com/polls/process_get_result.php?callback=?", { "poll_type": "front_page","width": width, "current_poll_id": current_poll_id }, set_results );

		//Omniture Code
		GEL.thepage.viewTracker.trackLink("Online Poll - Displaying Today\'s Results");
		
		
	});
	$("#yesterdays_results" ).live( "click", function()
	{
		//console.log( "loading yesterday's results" );
		$.getJSON( "http://php.news-leader.com/polls/process_get_result.php?callback=?", { "poll_type": "front_page","range":"yesterday", "width": width,"current_poll_id": current_poll_id  }, set_results );
		
		//Omniture Code
		GEL.thepage.viewTracker.trackLink("Online Poll - Displaying Yesterday\'s Results");
		
		
	});
	
	$("#display_poll" ).live( "click", function()
	{
		$.getJSON( "http://php.news-leader.com/polls/process_get_poll.php?callback=?", { "poll_type": "front_page" }, set_poll );
		//console.log( "Loaded the latest poll" );

		//Omniture Code
		GEL.thepage.viewTracker.trackLink("Online Poll - Displaying Poll");
		
	});
	
	
	//running check_cookie at the beginning
	check_cookie();
	

});

