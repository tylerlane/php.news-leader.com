<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<title>Reverse Publication: Polls</title>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/jquery-ui.min.js"></script>
		<script type="text/javascript" src="reverse_pub.js"></script>
		<link rel="stylesheet" href="style.css">
		<link rel="stylesheet" href="ui-lightness/jquery-ui.css" type="text/css">
		<link rel="stylesheet" href="ui-lightness/ui.all.css" type="text/css">
	</head>
	<body>
		<div id="links">
			<ul>
				<li><a href="index.php"><h1>View Polls</h1></a></li>
				<li><a href="reverse_pub.php"><h1>Reverse Pub</h1></a></li>
			</ul>
		</div>
		<div id="polls-contain" class="ui-widget">
		<span id="controls">
			<form>
				<fieldset>
					<ul>
						<li>
							<label for="question_date">Question Date</label>
							<input type="text" name="question_date" id="question_date" value="" class="text ui-widget-content ui-corner-all"  />
						</li>
						<li>
							<label for="result_date">Results Date</label>
							<input type="text" name="result_date" id="result_date" value="" class="text ui-widget-content ui-corner-all"  />
						</li>
					</ul>
				</fieldset>
			</form>
		</span>
		<table id="table" style=" border:0;padding 0px;">
			<tr>
				<td>
					<span id="question_div">
						<label for="question">Question</label><br />
						<textarea id="question"></textarea>
					</span>
				</td>
				<td>
					<span id="results_div">
						<label for="results">Results</label><br />
						<textarea id="results"></textarea>
					</span>
				</td>
			</tr>
		</table>
	</body>
</html>
	