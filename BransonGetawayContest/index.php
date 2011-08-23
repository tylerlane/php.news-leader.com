<html>
	<head>
		<title>Ultimate Branson Family Getaway Sweepstakes</title>
		<link rel="stylesheet" href="style.css" type="text/css" media="screen" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
		<script src="jquery.maskedinput-1.2.2.min.js" type="text/javascript"></script>
		<script>
			$(document).ready(function() { 
				//masking the phone number so it looks pretty.
				$("#phone").mask("(999) 999-9999? x99999");
				//hooking into the submit button
				$("#reset").click(function(){
					$(".error").hide();
				});
				$('#form').submit(function()
				{  
					$(".error").hide();
					var hasError = false;
					var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
				
					var emailaddressVal = $("#email").val();
					var nameVal = $("#name").val();
					var addressVal = $("#address").val();
					var cityVal = $("#city").val();
					var stateVal = $("#state").val();
					var zipVal = $("#zipcode").val();
					var phoneVal = $("#phone").val();
					
					//name
					if( nameVal == '' )
					{
						$("#name").after('<br /><span class="error">Please enter your name.</span><br />');
						hasError = true;
					}
					//address
					if( addressVal == '' )
					{
						$("#address").after('<br /><span class="error">Please enter your address.</span><br />');
						hasError = true;
					}
					//city
					if( cityVal == '' )
					{
						$("#city").after('<br /><span class="error">Please enter your city.</span><br />');
						hasError = true;
					}
					//state
					if( stateVal == '' )
					{
						$("#state").after('<br /><span class="error">Please enter your State.</span><br />');
						hasError = true;
					}
					//zipcode 
					if( zipVal == '' )
					{
						$("#zipcode").after('<br /><span class="error">Please enter your Zip Code.</span><br />');
						hasError = true;
					}
					//zipcode 
					if( phoneVal == '')
					{
						$("#phone").after('<br /><span class="error">Please enter your Phone Number.</span><br />');
						hasError = true;
					}
					
					//email address
					if( emailaddressVal == '' )
					{
						$("#email").after('<br /><span class="error">Please enter your email address.</span><br />');
						hasError = true;
					}
					else if(!emailReg.test(emailaddressVal))
					{
						$("#email").after('<br /><span class="error">Enter a valid email address.</span><br />');
						hasError = true;
					}
					
					if( hasError == true )
					{ 
						return false; 
					}
				});
			});
		</script>
	</head>
	<body>
		<div id="wrapper">
			<a href="http://www.news-leader.com/getaway"><img src="bransongetawaylogo.jpg" id="logo"></a>
			<div id="content">
        <img src="logos.png" id="otherlogos" />
        <?php
        $end = mktime( "23", "59", "59","5","27","2011" );
        $now = time();
        if(  $now < $end )
        {
          ?>
				<form action="process_submit_form.php" method="POST" id="form">
					<div id="stuff">
						<h1>Sweepstakes</h1>
						<p>Silver Dollar City and the News-Leader present the Ultimate Branson Family Getaway Sweepstakes!</p>
						<p>Register and be eligible to win a getaway for the whole family to see Branson VIP style – exclusive access to Branson family fun like you’ve never had before!</p>
						<p>You may enter once per day per valid email address from March 20 thru May 27.  Must be 18 or older and a resident of Missouri or Arkansas.  Click here for complete rules.</p>
					</div>
					<table border="0">
						<tr>
							<td class="field_label">Name:</td>
							<td><input type="text" name="name" id="name" /></td>
						</tr>
						<tr>
							<td class="field_label">Address:</td>
							<td><input type="text" name="address" id="address" /></td>
						</tr>
						<tr>
							<td class="field_label">City:</td>
							<td><input type="text" name="city" id="city" /></td>
						</tr>
						<tr>
							<td class="field_label">State:</td>
							<td><input type="text" name="state" id="state" /></td>
						</tr>
						<tr>
							<td class="field_label">Zip Code:</td>
							<td><input type="text" name="zipcode" id="zipcode" /></td>
						</tr>
						<tr>
							<td class="field_label">Phone Number:</td>
							<td><input type="text" name="phone_number" id="phone" /></td>
						</tr>
						<tr>
							<td class="field_label">Email Address:</td>
							<td><input type="text" name="email" id="email"/></td>
						</tr>
					</table>
					<div id="contact_boxes">
						<input type='checkbox' name="sdc_contact_allowed" id="sdc_contact_allowed" checked /><label for="sdc_contact_allowed">Yes, I would like to receive e-communications from Silver Dollar City Attractions</label><br />
						<input type='checkbox' name="snl_contact_allowed" id="snl_contact_allowed" checked /> <label for="snl_contact_allowed">Yes, I would like to receive e-communications from News-Leader for local deals, 	including events and things to do.</label><br />
					</div>
					<div id="buttons">
					<input type="Submit" id="btn-submit" value="Submit" /><input type="reset" id="reset" value="Clear"/>
          </div>
          <?php
        }
        else
        {
          print "<h2>Sorry!</h2><br />The contest has ended. We will be contacting the winner soon to notify them of their prize.<br />";
        }
        ?>
        </form>
        <div id="misc">
					<h4>Grand prize:</h4>
					<ul>
						<li>Four-night stay in a luxury 2-bedroom condo at The Village at Indian Point (for a maximum of 6 guests)</li>
						<li>Three days for six guests at Silver Dollar City, including front-of-the-line passes for selected rides and backstage meet-and-greet at the show of your choice.</li>
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
					<p>For tips, deals, and the inside scoop about Branson all summer long, visit us at <a href="http://Facebook.com/BestofBranson">Facebook.com/BestofBranson</a>!</p>
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
