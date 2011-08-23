$(function() {
	
	//variable to hold the max max_options
	var max_max_options = 10;
	var question = $("#question"),
		max_options = $("#max_options"),
		start_date = $("#start_date"),
		allFields = $([]).add(question).add(max_options).add(start_date),
		tips = $("#validateTips");
	//variable to hold the old max options variable.
	var	max_options_old_val = 0;

	

	//hopefully making a calendar picker for start and end dates
	start_date.datepicker({ dateFormat: 'yy-mm-dd' });

	// for some reason my values in the html arne't being set.

	max_options.change( function()
	{
		if( max_options.val() <= max_max_options && max_options.val() != max_options_old_val )
		{
			if( max_options_old_val == NaN || max_options_old_val == "" )
			{
				//if no old max_options then we'll just make the options
				for (i=1; i <= max_options.val(); i++)
				{
					$("#options").append( '<label for="option' + i +'">Option #' + i +'</label>');
					$("#options").append( '<input type="text" name="option' + i + '" id="option' + i +'" class="text ui-widget-content ui-corner-all" />');

				}
			}
			else
			{
				//okay first thing we see if the new val is less than the old val. ie something they removed an option. new val 3 old val 4
				if( max_options.val() < max_options_old_val )
				{
					var i = 1;
					for( i = 1; i <= ( max_options_old_val - max_options.val() ); i++ )
					{
						//remove the last input and label one by one.
						$("#options").children( "label:last" ).remove();
						$("#options").children( "input:last" ).remove();
					}
				}
				else
				{
						var i = 1;
						for( i = 1; i <= ( max_options.val() - max_options_old_val ); i++ )
						{
							$("#options").append( '<label for="option' + ( parseInt( max_options_old_val ) + parseInt( i ) ) +'">Option #' + ( parseInt( max_options_old_val ) + parseInt( i ) ) +'</label>');
							$("#options").append( '<input type="text" name="option' + i + '" id="option' + (parseInt( max_options_old_val ) + parseInt( i ) ) +'" class="text ui-widget-content ui-corner-all" />');
						}
				}
				max_options.removeClass('ui-state-error');
				updateTips("");
			}
			//set the old max_options_val to the NEW max_options
			max_options_old_val = max_options.val();
		}
		else
		{
			updateTips( "Max options can be between 1 and 10");
			max_options.addClass('ui-state-error');
		}
	});
	//adding a max options spinner
	//max_options.spinner( {max:10,min:1} );
	
	//calling my table populator fnction. this would be awesome if it just worked.
	populate_polls_table();
	
	function updateTips(t) {
		tips.text(t).effect("highlight",{},1500);
	}

	function checkLength(o,n,min,max) {
		if ( o.val().length > max || o.val().length < min ) {
			o.addClass('ui-state-error');
			updateTips("Length of " + n + " must be between "+min+" and "+max+".");
			return false;
		} else {
			return true;
		}
	}

	function checkRegexp(o,regexp,n) {
		if ( !( regexp.test( o.val() ) ) ) {
			o.addClass('ui-state-error');
			updateTips(n);
			return false;
		} else {
			return true;
		}
	}
	
	//takes a list and populates our polls table with the data
	function populate_polls_table()
	{
		$.getJSON("process_view_polls.php", function(data)
		{
			var polls_array = data.polls_array;
			//delete all the rows of the table first off
			$('tbody').remove();
				
			var table = '<tbody>'
			$.each(polls_array , function(i,poll)
			{
				table += '<tr><td>'
				+ poll.friendly_name + '</td><td>' 
				+ poll.question +'</td><td>' 
				+ poll.options_count + '</td><td>'
				+ poll.max_options+ '</td><td>'
				+ poll.start_date + '</td><td>'
				+ '<button id="'+ poll.poll_id +'" name="edit_poll" class="ui-button ui-state-default ui-corner-all">Edit</button>'
				+ '</td></tr>';
			});
			table +='</tbody>';
			$('#polls').append( table );
		});
	}
	
	$("#dialog").dialog({
		bgiframe: true,
		autoOpen: false,
		height: 500,
		width: 600,
		modal: true,
		resizable: false,
		buttons: {
			'Save Poll': function() {
				var bValid = true;
				allFields.removeClass('ui-state-error');
				bValid = bValid && checkLength(question,"question",2,255);
				bValid = bValid && checkRegexp(max_options,/^([0-9])+$/,"Max Options must be a number: 0-9");
				bValid = bValid && checkRegexp(start_date,/^(19|20)\d\d([- /.])(0[1-9]|1[012])\2(0[1-9]|[12][0-9]|3[01])+$/,"eg. 2010-02-16");
				
				if (bValid)
				{
					//YES! found it. that was reallly stupid but this works in passing the info over to the add_poll.php page.
					var poll_form = $("form").serialize();
					//start the ajax
					$.ajax({
						//php file to handle our request
						url: "process_add_poll.php",
						//use the GET method
						type: "GET",
						//pass the data we made
						data: poll_form,
						//do not cache the page
						cache: false,
						//success
						success: function (html)
						{
							//the processing page should return 1/true if it added the record
							populate_polls_table();
						}
		        });

				$(this).dialog('close');
				}
			},
			Cancel: function() {
				$(this).dialog('close');
			}
		},
		close: function() {
			allFields.val('').removeClass('ui-state-error');
		}
	});
	
	
	$('button[name=edit_poll]').live('click', function()
	{
		//open the dialog?
		$('#dialog').dialog('open');

		//get the id from the table row's id.button->td->tr
		var id = this.id;
		//setting the div's title attrib to Edit poll
		$("#dialog" ).dialog("option", "title","Edit Poll");
		//disabling the max options field for editing
		$("#max_options").attr("disabled", "disabled");
		
		//get the JSON data via ajax.
		$.getJSON("process_view_poll.php?id="+id, function(data)
		{
			//pull out our array.
			var poll = data.poll;
			var options = data.options;
			
			$( "#question" ).val( poll.question );
			$( "#max_options" ).val( poll.max_options );
			//setting the max_options_old_val so i know what changed
			max_options_old_val = poll.max_options;
			//select the poll type
			$( "#poll_type" ).val( poll.type_config_id );
			
			//splitting start time to fill our two fields. Not sure i like this entirely. i'd like to have one field but not sure if that will work with our calendar widget.
			var start_date = poll.start_time.split( " " );
			$( "#start_date" ).val( start_date[ 0 ] );
			
			//settign the story link
			var link = "http://php.news-leader.com/polls/get_poll_story.php?width=260&poll_id=" + id;
			$("#story_link").val( link );
			//enabling the story link.
			$( "#story_link" ).removeAttr( "disabled");
			
			//clearing out the options already there.
			$('#options').children( 'label' ).remove();
			$('#options').children( 'input' ).remove();
			
			//looping through our options and putting them into the options div
			var i = 0;
			for( i=0 ; i < poll.max_options; i++ ) 
			{
				//having to add one to i because i want it to read option 1 through 3 etc instead of 0 through 2
				$("#options").append( '<label for="option' + i +'">Option #' + ( i + 1 ) +'</label>');
				if( ( options.length - 1 ) >= i )
				{
					$("#options").append( '<input type="text" name="option' + ( i + 1 ) + '" id="option' + i +'" class="text ui-widget-content ui-corner-all" value="' + options[i].option_text + '"/>');
					//appending the option id so i can use it to update the option t ext.
					$("#options").append( '<input type="hidden" name="option_' + ( i + 1 )+ '_id" value="' + options[i].option_id +'"/>')
				}
				else
				{
					$("#options").append( '<input type="text" name="option' + ( i + 1 ) + '" id="option' + i +'" class="text ui-widget-content ui-corner-all" value="" />');
					//appending the option id so i can use it to update the option t ext.
				}
			}
		});
		
		//okay now i'm having to override the buttons already set and define them for our editing
		$( "#dialog" ).dialog( "option", "buttons", { "Save Poll": function(){
			var bValid = true;
			allFields.removeClass('ui-state-error');
			bValid = bValid && checkLength(question,"question",2,1000);
			bValid = bValid && checkRegexp(max_options,/^([0-9])+$/,"Max Options must be a number: 0-9");
			bValid = bValid && checkRegexp(start_date,/^(19|20)\d\d([- /.])(0[1-9]|1[012])\2(0[1-9]|[12][0-9]|3[01])+$/,"Start Date must be in YYYY-MM-DD format eg. 2010-02-16");

			
			if (bValid)
			{
				//YES! found it. that was reallly stupid but this works in passing the info over to the add_poll.php page.
				var poll_form = $("form").serialize();
				//start the ajax
				$.ajax(
				{
					//php file to handle our request
					url: "process_edit_poll.php?id=" + id +"&max_options=" + max_options.val(),
					//use the GET method
					type: "GET",
					//pass the data we made
					data: poll_form,
					//do not cache the page
					cache: false,
					//success
					success: function (html)
					{
						//the processing page should return 1/true if it added the record
						populate_polls_table();
					}
				});
				$(this).dialog('close');
				//clearing my ui-state errors
				allFields.val('').removeClass('ui-state-error');
				updateTips( "" ); 
			}},
			Cancel: function()
			{
				$(this).dialog('close');
				//clearing my ui-state errors
				allFields.val('').removeClass('ui-state-error');
				updateTips( "" );
			}
		});
	});
	$('button[name=edit_poll]')
		.live('mouseenter', function(){ $(this).addClass("ui-state-hover"); })
		.live('mouseleave', function(){ $(this).removeClass("ui-state-hover");})
		.live('mousedown', function(){ $(this).addClass("ui-state-active"); })
		.live('mouseup', function(){ $(this).removeClass("ui-state-active");});
	
	
	$('#create-poll').click( function()
	{
		//putting this in here in case they click on create a poll after edit poll
		$('#dialog').dialog('option', 'title','Create Poll' );

		//disabling the story link.
		$( "#story_link" ).attr( "disabled","disabled" );
		$( "#story_link" ).val( "" );
		
		//re-enabling the max_options
		$("#max_options").removeAttr("disabled");
		//setting the max_options_old_val so it won't mess things up
		max_options_old_val = 0;
		
		//clearing out the options already there.
		$('#options').children( 'label' ).remove();
		$('#options').children( 'input' ).remove();
		$( "#dialog" ).dialog( "option", "buttons", { "Save Poll": function()
		{
			var bValid = true;
			allFields.removeClass('ui-state-error');
			bValid = bValid && checkLength(question,"question",2,1000);
			bValid = bValid && checkRegexp(max_options,/^([0-9])+$/,"Max Options must be a number: 0-9");
			bValid = bValid && checkRegexp(start_date,/^(19|20)\d\d([- /.])(0[1-9]|1[012])\2(0[1-9]|[12][0-9]|3[01])+$/,"Start Date must be in YYYY-MM-DD format eg. 2010-02-16");
			
			if (bValid)
			{
				//YES! found it. that was reallly stupid but this works in passing the info over to the add_poll.php page.
				var poll_form = $("form").serialize();
				//start the ajax
				$.ajax(
				{
					//php file to handle our request
					url: "process_add_poll.php",
					//use the GET method
					type: "GET",
					//pass the data we made
					data: poll_form,
					//do not cache the page
					cache: false,
					//success
					success: function (html)
					{
						//the processing page should return 1/true if it added the record
						populate_polls_table();
					}
				});
				$(this).dialog('close');
				//clearing my ui-state errors
				allFields.val('').removeClass('ui-state-error');
				updateTips( "" );
			}
		},
		Cancel: function()
		{
			$(this).dialog('close');
			//clearing my ui-state errors
			allFields.val('').removeClass('ui-state-error');
			updateTips( "" );
		}});
		$('#dialog').dialog('open');
	})
	.hover(
		function(){ 
			$(this).addClass("ui-state-hover"); 
		},
		function(){ 
			$(this).removeClass("ui-state-hover"); 
		}
	).mousedown(function(){
		$(this).addClass("ui-state-active"); 
	})
	.mouseup(function(){
			$(this).removeClass("ui-state-active");
	});
	
	
});
