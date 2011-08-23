<?php
require( "config.php" );
//connect to the db
$conn = mysql_connect( $db_hostname, $db_username, $db_password );
$db_selected = mysql_select_db( $db_name, $conn );
if( !$db_selected )
{
    print "There was an error connecting to the database. We are aware of the issue and are working on getting it resolved.";
	exit;
}
?>
<html>
	<head>
		<title>Ultimate Branson Family Getaway Sweepstakes</title>
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
	</head>
	<body>
		<div id="wrapper">
			<a href="http://www.news-leader.com/getaway"><img src="bransongetawaylogo.jpg" id="logo"></a>
			<div id="content">
				<form id="form">
				<div id="stuff">
				
					<h1>Sweepstakes</h1>
					<p>Silver Dollar City and the News-Leader present the Ultimate Branson Family Getaway Sweepstakes!</p>
					<p>Register and be eligible to win a getaway for the whole family to see Branson VIP style – exclusive access to Branson family fun like you’ve never had before!</p>
					<p>You may enter once per day per valid email address from March 20 thru May 27.  Must be 18 or older and a resident of Missouri or Arkansas.  Click here for complete rules.</p>
				</div>
				<div id="form">
				<?php
				$query = "SELECT * from entries where email like '". $_POST["email"]."' and date = '". date( "Y-m-d" )."'";
				//print "<b>query</b> = $query <br />";	



				$res = mysql_query( $query, $conn );

				if( mysql_num_rows( $res ) > 0 )
				{
					print "<span class=\"error\"><h1>Email address already signed up today! You can only sign up once a day.</h1></span>";
				}
				else
				{
					//saving code here;
					$insert_query = "INSERT INTO entries( name,address,city,state,zipcode,phone,email,date,snl_contact_allowed,sdc_contact_allowed )VALUES (";
					$insert_query .= "'". $_POST[ "name" ] ."', ";
					$insert_query .= "'". $_POST[ "address" ] ."', ";
					$insert_query .= "'". $_POST[ "city" ] ."', ";
					$insert_query .= "'". $_POST[ "state" ] ."', ";
					$insert_query .= "'". $_POST[ "zipcode" ] ."', ";
					$insert_query .= "'". $_POST[ "phone_number" ] ."', ";
					$insert_query .= "'". $_POST[ "email" ] ."', ";
					//current date
					$insert_query .= "'". date( "Y-m-d" ) ."', ";
					if($_POST[ "snl_contact_allowed" ] == "on" )
					{
						$snl_contact_allowed = 1;
					}
					else
					{
						$snl_contact_allowed = 0;
					}
					if($_POST[ "sdc_contact_allowed" ] == "on" )
					{
						$sdc_contact_allowed = 1;
					}
					else
					{
						$sdc_contact_allowed = 0;
					}
					$insert_query .= "'". $snl_contact_allowed ."',";
					$insert_query .= "'". $sdc_contact_allowed ."' )";
					//print "<b>insert_query</b> = $insert_query <br />";
					$insert_res = mysql_query($insert_query, $conn );
					
					//lets get the id for what we just inserted
					$insert_id = mysql_insert_id();
					
					//now we will query for it and make sure that it actually got into the db
					$fail_query = "SELECT * FROM entries where id = $insert_id";
					print "<!-- fail_query = $fail_query -->\r\n";
					$fail_res = mysql_query( $fail_query, $conn );
					
					//if num rows does NOT return 1 row then it didn't get inserted properly and we need to report it
					print "<!-- fail_query num_rows = ". mysql_num_rows( $fail_res ) ."-->\r\n";
					if( mysql_num_rows( $fail_res ) != "1" )
					{
						//spit out an error block
						print "<span class=\"error\"><h1>There was an error saving your entry to the database. We have been alerted to the issue and are working on resolving it. Please try again later.</h1></span>\r\n";
						
						//email crap
						$to = "tlane@news-leader.com, dklewis@gannett.com";
						$subject = "ERRROR!!!!!!!!!!!!!!!!! -  Ultimate Branson Family Getaway Contest";
						$headers = 'From: Ultimate Branson Family Getaway Contest <do-not-reply@news-leader.com>' . "\r\n" .
						   'X-Mailer: PHP/' . phpversion();
						//message
						$body = "There was an error saving the entry record. The error reported was: ". mysql_error( $insert_res ) ." -- ". mysql_errno() ."\r\n";
						//error text so we dont' lose data ( hopefully )
						$body .= "Please check why this is happening!. Debugging text to follow:\r\n";
						$body .= "name = ". $_POST[ "name" ] ."\r\n ";
						$body .= "address = ". $_POST[ "address" ] ."\r\n ";
						$body .= "city = ". $_POST[ "city" ] ."\r\n ";
						$body .= "state = ". $_POST[ "state" ] ."\r\n ";
						$body .= "zipcode = ". $_POST[ "zipcode" ] ."\r\n ";
						$body .= "phone_number = ". $_POST[ "phone_number" ] ."\r\n ";
						$body .= "email = ". $_POST[ "email" ] ."\r\n ";
						mail( $to, $subject, $body, $headers );
						
					}
					else
					{
						print "<h1>Your entry has been received. Remember you can only enter once a day!</h1>";
						print "<!-- insert_query = $insert_query -->\r\n<br />";
						print "<!--". mysql_error( $insert_res ) ." -- ". mysql_errno() ." --><br />\r\n";
						
						//email crap
						$to = $_POST["email"];
						$subject = "Your entry in Ultimate Branson Family Getaway Contest";
						$headers = "From: Ultimate Branson Family Getaway Contest <do-not-reply@news-leader.com> \r\n" .
									"X-Mailer: PHP/" . phpversion() ." \r\n" .
 									"BCC: dklewis@gannett.com,tlane@news-leader.com \r\n";
						//message
						$body .= "This is a confirmation email that we received your entry:\r\n";
						$body .= "Name = ". $_POST[ "name" ] ."\r\n ";
						$body .= "Address = ". $_POST[ "address" ] ."\r\n ";
						$body .= "City = ". $_POST[ "city" ] ."\r\n ";
						$body .= "State = ". $_POST[ "state" ] ."\r\n ";
						$body .= "Zip Code = ". $_POST[ "zipcode" ] ."\r\n ";
						$body .= "Phone Number = ". $_POST[ "phone_number" ] ."\r\n ";
						$body .= "Email = ". $_POST[ "email" ] ."\r\n ";
						mail( $to, $subject, $body, $headers );
						
						
					}
				}

				?>
				</div>
				</form>
				<div id="misc">
					<h4>Grand prize:</h4>
					<ul>
						<li>Four-night stay in a luxury 2-bedroom condo at The Village at Indian Point (for a maximum of 6 guests)</li>
						<li>Three-day pass for six guests to Silver Dollar City, including front-of-the-line passes for selected rides and backstage meet-and-greet at the show of your choice.</li>
						<li>Captains Row VIP seating for six on the Showboat Branson Belle</li>
						<li>One-day pass for six guests at White Water, including use of a private cabana w/ widescreen TV</li>
						<li>Branson “Ride the Ducks” land and water adventure family pass</li>
	 					<li>Six tickets to Dolly Parton’s Dixie Stampede Dinner Attraction, including four-course dinner and dessert
						<li>Six tickets to a show of your choice at a Branson music theatre</li>
						<li>Total Package ARV: $ 3,270</li>
					</ul>
				</div>
			<div id="footer">
				<script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like href="http://www.facebook.com/BestofBranson" show_faces="false" width="450" font="arial"></fb:like>
				<p>For tips, deals, and the inside scoop about Branson all summer long!</p>
				<p><a href="rules.html">Click Here</a> for official Rules</p>
				<p><a href="prize.html">Click Here</a> for Complete Prize Description</p>
			</div>
			<script language="javascript" type="text/javascript" src="http://content.gannettonline.com/global/scripts/revsci.js"></script> 
				<script type="text/javascript" src="http://js.revsci.net/gateway/gw.js?csid=J06575" charset="ISO-8859-1"></script> 
				<script type="text/javascript" language="JavaScript"> 
				<!--
				s_account="gpaper171,gntbcstglobal";
				//--> 
				</script> 
				<!-- SiteCatalyst code version: H.3.
				Copyright 1997-2005 Omniture, Inc. More info available at
				http://www.omniture.com --> 
				<script src="http://content.gannettonline.com/global/s_code/s_code.js"></script> 
				<script><!--
				/* You may give each page an identifying name, server, and channel on
				the next lines. */
				s.pageName="contest - branson getaway"
				s.server=""     // Do Not Alter
				s.channel=""
				s.pageType=""
				s.pageValue=""
				s.prop1=""
				s.prop2="data"
				s.prop3="data"
				s.prop4=""
				s.prop5=""
				s.prop6="news"
				s.prop7="local_news"
				s.prop16="article"
				s.prop25="Springfield:news-leader"
				s.prop50="Newspaper";

				var currentTime=new Date();
				var gciYear = currentTime.getFullYear();
				DM_addToLoc("zipcode", escape(s.prop30));
				DM_addToLoc("age", escape((gciYear-s.prop31)));
				DM_addToLoc("gender", escape(s.prop32));
				var gci_ssts=OAS_sitepage;

				gci_ssts=gci_ssts.replace(/\/article\.htm.*$/,'');
				gci_ssts=gci_ssts.replace(/\/front\.htm.*$/,'');
				gci_ssts=gci_ssts.replace(/\/index\.htm.*$/,'');
				gci_ssts=gci_ssts.replace(/\@.*$/,'');
				gci_ssts=gci_ssts.replace(/^.*\.com\//,'');

				var gci_tempossts=gci_ssts; 
				var gci_ossts=gci_tempossts.split("/")
				gci_ssts=gci_ssts.replace(/\//g,' > ');
				gci_ssts='newspaper > '+gci_ssts;

				if
				(  gci_ossts[0] == "life"
				|| gci_ossts[0] == "money"
				|| gci_ossts[0] == "news"
				|| gci_ossts[0] == "sports"
				|| gci_ossts[0] == "tech"
				|| gci_ossts[0] == "travel"
				|| gci_ossts[0] == "weather"
				|| gci_ossts[0] == "umbrella"
				)

				{
				  DM_cat(gci_ssts);
				}
				else
				{
				  DM_cat('newspaper > other');
				}

				var gci_osstslen=gci_ossts.length;
				for(var i=0; i<gci_osstslen; i++) {
				if(i==0)
				s.prop17=gci_ossts[i];   // section
				if(i==1)
				s.prop18=gci_ossts[i];   // subsection
				if(i==2)
				s.prop19=gci_ossts[i];   // topic
				if(i==3)
				s.prop20=gci_ossts[i];   // Subtopic
				}
				DM_tag();

				// sets the RevSci cookie in GCION domain
				if (rsinetsegs.length > 0)
				{
				  if (!RevSci.HasSegmentCookie())
				  {
				    RevSci.Rpc.Send(RevSci.RequestUrl(rsinetsegs));
				    RevSci.Cookie.Set(revsci_Cookie, true);
				  }
				}
				 if(typeof rsinetsegs!='undefined'){s.prop48=(rsinetsegs.join('|')).replace(/J06575_/g,'');}else{s.prop48='no segment';}

				//-->
				</script> 

				<script><!--
				/************* DO NOT ALTER ANYTHING BELOW THIS LINE ! **************/
				var s_code=s.t();if(s_code)document.write(s_code)//--></script> 
				<script><!--
				if(navigator.appVersion.indexOf('MSIE')>=0)document.write(unescape('%3C')+'\!-'+'-')
				//--></script><noscript><img src="http://gntbcstglobal.112.2O7.net/b/ss/gntbcstglobal,gpaper171/1/H.3--NS/0" height="1" width="1" border="0" alt="" /></noscript><!--/DO NOT REMOVE/--> 
				<!-- End SiteCatalyst code version: H.3. -->
			</div>
		</div>
	</body>
</html>

