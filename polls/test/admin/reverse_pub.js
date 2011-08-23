$(function() {
	$("#question_date" ).datepicker({ dateFormat: 'yy-mm-dd' });
	$("#result_date").datepicker({ dateFormat: 'yy-mm-dd' });
	
	
	$("#question_date" ).change( function(){
		var question_date = $( "#question_date" ).val();
		if( $( "#result_date" ).val() == "" )
		{
			$( "#result_date" ).val( question_date );
			//jQuery.trigger( "change", "#result_date" );
			$( "#result_date" ).trigger( "change" );
		}
		
		$.get( "process_reverse_pub.php", { "question_date": question_date }, function(data){
			$( "#question" ).html( data );
		});
	});
	
	$("#result_date" ).change( function(){
		var result_date = $( "#result_date" ).val();
		
		$.get( "process_reverse_pub.php", { "result_date": result_date }, function(data){
			$( "#results" ).html( data );
		});
	});
});