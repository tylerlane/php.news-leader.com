<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" 
"http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.1/jquery.min.js"></script>
		<script type="text/javascript" src="login.js"></script>
		<title>Poll Admin Login</title>
	</head>
	<body>
		<form method="post" id="login_form" class="login_form">
		<div class="error"></div>
		<div class="element">
			<label>Username</label>
			<input type="text" name="username" class="text" />
		</div>
		<div class="element">
			<label>Password</label>
			<input type="password" name="password" class="text" />
		</div>
		<div class="element">
			<input type="submit" id="submit" value="Submit"/>
			<div class="loading"></div>
		</div>
	</form>
	</body>
</html>