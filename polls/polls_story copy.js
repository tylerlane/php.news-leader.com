$(function() {
	var poll_id = $( "#poll_id" ).val();
	var cookie_name = "online_poll_" + poll_id;
	var options = { path: '/', expires: 10, domain: '.news-leader.com' };
	var width = $("#poll_container" ).width();

	$.ajaxSetup( { async: true } );

	//going to see if the cookie is set for the poll
	function check_cookie()
	{
		console.log( "checking cookie" );
		if( $.cookie( cookie_name ) )
		{
			$.getJSON( "http://php.news-leader.com/polls/process_get_result_story.php?callback=?", { "poll_id": poll_id, "width": width }, set_results );
			//console.log( "found cookie, loading results" );
		}
		//if no cookie set, then we pull the current poll
		else
		{
			$.getJSON( "http://php.news-leader.com/polls/process_get_poll_story.php?callback=?", { "poll_id": poll_id }, set_poll );
			//console.log( "no cookie, loading poll" );
		}
	}

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
		$.cookie( cookie_name, null, options );
		//console.log( "DELETING COOKIE" );
		check_cookie();
		return false;
	});
	
	//disabling the form.
	$( "#online_poll" ).live("submit", function(){ return false;} );
	
	//this should bind the input image
	$("input:image").live( "click", function()
	{
		//okay vote button was pressed. lets build our query string
		var option_id = $( "input:radio:checked:last" ).val();
		if( option_id != undefined || option_id != "" )
		{
			//console.log( "Poll_id = " + poll_id );
			//console.log( "Option_id = " + option_id );
			//console.log( "submitting the option to record_vote.php" );
			
			$.getJSON( "http://php.news-leader.com/polls/process_record_vote.php?callback=?", {"poll_id": poll_id , "option_id": option_id }, record_vote );
			//setting the cookie cause we voted!
			if( $.cookie( cookie_name ) )
			{
				//deleting the cookie.
				$.cookie( cookie_name, null, options );
				console.log( "DELETING COOKIE" );
			}
			//setting the date for 1 day from now.
			date = new Date();
			date.setTime( date.getTime() + ( 1 * 24 * 60 * 60 * 1000 ) );
			$.cookie( cookie_name, poll_id, { expires: date, path: '/', domain:'.news-leader.com' });
		
			//then we run our check cookie function which will display the poll or the results
			check_cookie();
		
			//returning false so it doesn't try to submit the form manually.
		}
		return false;
	} );
	
	$("#display_results" ).live( "click", function()
	{
		//console.log( "loading today's results" );
		$.getJSON( "http://php.news-leader.com/polls/process_get_result_story.php?callback=?", { "poll_id": poll_id,"width": width }, set_results );
		//console.log( "loading the results");
	});

	$("#display_poll" ).live( "click", function()
	{
		$.getJSON( "http://php.news-leader.com/polls/process_get_poll_story.php?callback=?", { "poll_id": poll_id }, set_poll );
		//console.log( "Loaded the poll" );
	});
	
	//running check_cookie at the beginning
	check_cookie();
});

