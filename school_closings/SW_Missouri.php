<?php
function ExtractString($str, $start, $end) { 
   $str_low = strtolower($str); 
   $pos_start = strpos($str_low, $start); 
   $pos_end = strpos($str_low, $end, ($pos_start + strlen($start))); 
   if ( ($pos_start !== false) && ($pos_end !== false) ) 
   { 
       $pos1 = $pos_start + strlen($start); 
       $pos2 = $pos_end - $pos1; 
       return substr($str, $pos1, $pos2); 
   } 
}

$data = "";
$handle = @fopen("http://www.ktts.com/weather/schoolclosings/", "r");

if ($handle) {
   while (!feof($handle)) {
       $data .= fgets($handle, 4096);
   }
   fclose($handle); 
   $data = trim($data);
   $data = str_replace("\r", "", $data);
   $data = str_replace("\n", "", $data);
   $data = str_replace("\t", "", $data);
   $data = str_replace("  ", " ", $data);
   $data = str_replace("&nbsp;", "", $data);
   
  preg_match_all('#<tr>[\s]*?<td' . '([^<]*?)' . '>' . '([^<]*?)' . '<\/td>[\s]*?<td' . '([^<]*?)' . '>' . '([^<]*?)' . '<\/td>[\s]*?<\/tr>#si', $data, $match, PREG_PATTERN_ORDER);  
  
?>


<html>
<head>
<title>News-Leader.com | School Closings</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8">
<meta name="description" content="The Springfield News-Leader Online Edition - Your Complete News Source in the Ozarks.">
<meta name="keywords" content="The Springfield News-Leader Online Edition, Springfield, Missouri, Ozarks, editorial, opinion, business, sports, outdoors, health, life, entertainment, columnists, business, southwest, web, genealogy, subscribe, stock market, weather">
<meta name="Author" content="Online Department Springfield News-Leader">

<LINK REL="STYLESHEET" HREF="http://www.news-leader.com/styles/news-leader.css">

<STYLE TYPE="text/css">
<!--
.ktts_links {font-face:arial; font-size:12px; color: #FFFFFF; font-weight:bold; line-height: 14pt; margin-left:5px; margin-right:5px;}
.ktts_links A:link {font-size:12px; color:#FFFFFF; font-weight:bold; text-decoration:none; line-height: 14pt;}
.ktts_links A:visited {font-size:12px; color:#FFFFFF; font-weight:bold; text-decoration:none; line-height: 14pt;}
.ktts_links A:active {font-size:12px; color:#FFFFFF; font-weight:bold; text-decoration:underline; line-height: 14pt;}
.ktts_links A:hover {font-size:12px; color:#CCCCCC; font-weight:bold; text-decoration:underline; line-height: 14pt;}

.nl_links {font-face:arial; font-size:12px; color: #FFFFFF; font-weight:bold; line-height: 14pt; margin-left:5px; margin-right:5px;}
.nl_links A:link {font-size:12px; color:#FFFFFF; font-weight:bold; text-decoration:none; line-height: 14pt;}
.nl_links A:visited {font-size:12px; color:#FFFFFF; font-weight:bold; text-decoration:none; line-height: 14pt;}
.nl_links A:active {font-size:12px; color:#FFFFFF; font-weight:bold; text-decoration:underline; line-height: 14pt;}
.nl_links A:hover {font-size:12px; color:#CCCCCC; font-weight:bold; text-decoration:underline; line-height: 14pt;}

-->
</STYLE>

</head>

<BODY LEFTMARGIN="10" TOPMARGIN="4" MARGINWIDTH="10" MARGINHEIGHT="4" BGCOLOR="#DCDFE1">

<TABLE bgcolor="#FFFFFF" width="728" align="center" border="0" cellpadding="0" cellspacing="0">
<TR>
	<TD><img src="images/logo.jpg" width="780" height="101" border="0" usemap="#Map"></TD>
</TR>
<TR>
	<TD bgcolor="#EE2714"><div class="ktts_links">
		<a href="http://ktts.com" class="ktts_links">Visit KTTS:</a>
		 <a href="http://ktts.com/AndyJulie/tabid/819/Default.aspx" class="ktts_links">Andy & Julie</a>
		  - <a href="http://ktts.com/ConcertsandArtists/tabid/764/Default.aspx" class="ktts_links">Concerts and Artists</a>
		  - <a href="http://ktts.com/ContactUs/tabid/1709/Default.aspx" class="ktts_links">Contact Us</a>
		  - <a href="http://ktts.com/Contests/tabid/2069/Default.aspx" class="ktts_links">Contests</a>
		  - <a href="http://ktts.com/Events/tabid/1825/Default.aspx" class="ktts_links">Events</a>
		  - <a href="http://ktts.com/OnAirStaff/tabid/1826/Default.aspx" class="ktts_links">On-Air Staff</a></div>
	</TD>
</TR>
<TR><TD height="1"></TD></TR>
<TR>
	<TD bgcolor="#243C91"><div class="nl_links">
	<a href="http://news-leader.com" class="nl_links">Visit News-Leader:</a>
	 <a href="http://www.news-leader.com/apps/pbcs.dll/section?Category=NEWS01" class="nl_links">Local News</a>
	 - <a href="http://www.news-leader.com/apps/pbcs.dll/section?Category=ENTERTAINMENT" class="nl_links">Entertainment</a>
	 - <a href="http://www.news-leader.com/apps/pbcs.dll/section?Category=LIFE" class="nl_links">Life</a>
	 - <a href="http://www.news-leader.com/apps/pbcs.dll/section?Category=SPORTS" class="nl_links">Sports</a>
	 - <a href="http://www.news-leader.com/apps/pbcs.dll/section?Category=BUSINESS" class="nl_links">Business</a>
	 - <a href="http://www.news-leader.com/apps/pbcs.dll/section?Category=OPINIONS" class="nl_links">Opinions</a>
	 - <a href="http://www.news-leader.com/apps/pbcs.dll/section?Category=NEWS07" class="nl_links">Nation/World</a>
	 - <a href="http://asp.usatoday.com/travel/gcitravel/destination.aspx?cid=ozarksnow" class="nl_links">Travel</a>
	 - <a href="http://www.news-leader.com/obits" class="nl_links">Obituaries</a></div>
	</TD>
</TR>
<TR>
	<TD><BR></TD>
</TR>

<TR><TD align="center">
<a href="SW_Missouri.php">SW Missouri Public Schools</a> - <a href="Arkansas.php">Arkansas Schools</a> - <a href="Private.php">Private Schools</a> - <a href="HeadStarts.php">Headstart Schools</a></TD></TR>

<TR><TD align="center">
	<table width="95%" border="0" cellpadding="2" cellspacing="2">
	<TR><TD class="smaller" COLSPAN="2" BGCOLOR="#333399">
	  <FONT CLASS="big" color="#FFFFFF"><b>&nbsp;&nbsp;SW Missouri Public Schools current reports on closings &#151; 
	  <?php echo date("l, F j, Y"); ?></b></FONT>
	</TD></TR>
	  
	  
<?php
$color1 = "#FFFFFF"; 
$color2 = "#FFFFCC"; 
$row_count = 0; 

	for ($i=0;$i < count($match[1]);$i++) {
		$row_color = ($row_count % 2) ? $color1 : $color2;	
?>
	<TR bgcolor="<?php echo $row_color ?>">
	  <TD class="smaller" width="20%"><B><?php echo $match[4][$i]; ?></B></TD>
 	  <TD class="smaller" width="50%">&nbsp;<font color="red"><?php echo strtoupper($match[2][$i]); ?></font></TD>
	</TR>
<?php
	$row_count++; 
	}
?>
	<TR><TD BGCOLOR="#333399" colspan="2">
	  <FONT CLASS="smaller" color="#FFFFFF"><I>News-Leader.com does not assume responsibility for the accuracy or completeness of the information listed.</I></FONT>
	</TD></TR>
	</table>
	</td></tr>
<TR><TD align="center">
<a href="SW_Missouri.php">SW Missouri Public Schools</a> - <a href="Arkansas.php">Arkansas Schools</a> - <a href="Private.php">Private Schools</a> - <a href="HeadStarts.php">Headstart Schools</a></TD></TR>
</table>
</TD></TR>
</TABLE>

<!--SiteCatalyst Coding Begins-->

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
<script language="JavaScript" src="http://content.gannettonline.com/global/s_code/s_code.js"></script>
<script language="JavaScript"><!--
/* You may give each page an identifying name, server, and channel on
the next lines. */
s.pageName="<?php echo $_SERVER['PHP_SELF']; ?>"
s.server=""     // Do Not Alter
s.channel=""
s.pageType=""
s.pageValue=""
s.prop1=""
s.prop2="school_closings"
s.prop3=""
s.prop4=""
s.prop5=""
s.prop6="news"
s.prop7="local_news"
s.prop16=""
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
<script language="JavaScript"><!--
/************* DO NOT ALTER ANYTHING BELOW THIS LINE ! **************/
var s_code=s.t();if(s_code)document.write(s_code)//--></script>
<script language="JavaScript"><!--
if(navigator.appVersion.indexOf('MSIE')>=0)document.write(unescape('%3C')+'\!-'+'-')
//--></script><noscript><img src="http://gntbcstglobal.112.2O7.net/b/ss/gntbcstglobal,gpaper171/1/H.3--NS/0" height="1" width="1" border="0" alt="" /></noscript><!--/DO NOT REMOVE/-->
<!-- End SiteCatalyst code version: H.3. -->


<map name="Map">
  <area shape="rect" coords="629,1,780,102" href="http://www.ktts.com">
  <area shape="rect" coords="-33,-4,244,57" href="http://www.news-leader.com">
</map>
</body>
</HTML>

<?php
 }
?>





