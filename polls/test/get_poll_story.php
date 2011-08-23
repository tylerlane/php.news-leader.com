<html>
	<head>
		<title>Get Poll</title>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
		<script type="text/javascript" src="http://php.news-leader.com/polls/jquery.cookie.js"></script>
		<script type="text/javascript" src="http://php.news-leader.com/polls/polls_story.js"></script>
		<link rel="stylesheet" href="http://www.news-leader.com/includes/css/go4/poll.css"/>
		<link rel="stylesheet" href="http://www.news-leader.com/gci/gc/p6/GO4Styles-min.css" type="text/css" />
		<META HTTP-EQUIV="CACHE-CONTROL" CONTENT="NO-CACHE">
		<META HTTP-EQUIV="EXPIRES" CONTENT="0">
		<META HTTP-EQUIV="PRAGMA" CONTENT="NO-CACHE">
		<style>
		    .graph { 
		        position: relative; /* IE is dumb */
		        width: <?php print $_GET[ "width" ]; ?>px; 
		        border: 0px solid #517da4; 
		        padding: 2px; 
		    }
		    .graph .bar { 
		        display: block;
		        position: relative;
		        background: #517da4; 
		        text-align: center; 
		        color: #333; 
		        height: 2em; 
		        line-height: 2em;            
		    }
			ul{
				list-style: none;
			}
		    .graph .bar span { position: absolute; left: 1em; }
		</style>
	</head>
	<body>
	<div id="poll_container" style="width: <?php print $_GET[ "width" ]; ?>; <?php if( !empty( $_GET[ "height" ] ) ){ print "height: ". $_GET[ "height" ]; ?>">
			<input type="hidden" name="poll_id" value="<?php print $_REQUEST[ "poll_id" ]; ?>" id="poll_id">
			<div id="results">
			</div>
			<div id="poll">
			</div>
		</div>
	</body>
</html>

