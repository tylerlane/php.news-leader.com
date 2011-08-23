<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
<head>
<title>News-Leader.com | Joplin, MO Before and After Interactive</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.13/jquery-ui.min.js"></script>
<script type="text/javascript" src="jquery.beforeafter.min.js"></script>
<script type="text/javascript">
$(function(){
  $('#container').beforeAfter({showFullLinks:false,animateIntro:true});
  $('#container2').beforeAfter({showFullLinks:false,animateIntro:true});
});
</script>
<style type="text/css">
body,td,th {
    font-family: Arial, Helvetica, sans-serif;
    color:#fff;
}


#container,#container2,#container3 { width:900px; margin-left: auto; margin-right: auto; }
p { margin:0; padding:0 }
h1 { margin:0; padding:0; font:bold 18px Arial, Helvetica, sans-serif }
#desc-text{
margin-left: auto;
margin-right: auto;
font-family: Arial,Helvetica,sans-serif;
color: black;
}
</style>

</head>
<!-- REQUIRED:Begin Header -->
    <div class="ody-skin" style="background: white;">
        <style>
            .ody-skin .cobrand input{height:auto; overflow:visible;}
        </style>
        <div class="ody-custom cobrand">
            <div class="main-container">
                <link rel="stylesheet" type="text/css" href="http://www.News-Leader.com/includes/css/ody/ody-local.css">
        <link rel="stylesheet" type="text/css" href="http://www.News-Leader.com/odygci/p5/ody-styles-min.css"/>
        <link rel="stylesheet" type="text/css" href="css/custom-theme/jquery-ui-1.8.13.custom.css"/>    
<div class="header-container">
    <div class="header-classified"> 
        <div class="header-wrap">
            <ul>
                <li><strong>CLASSIFIEDS:</strong></li>
<li><a href="http://www.news-leader.com/jobs">JOBS</a></li>
<li><a href="http://www.news-leader.com/cars">CARS</a></li>
<li><a href="http://www.news-leader.com/classifieds">CLASSIFIEDS</a></li>
<li><a href="http://www.news-leader.com/realestate">REAL ESTATE</a></li>

<li><a href="http://www.news-leader.com/apartments">APARTMENTS</a></li>
<li><a href="http://www.news-leader.com/deals">DEALS</a></li>
<li><a href="http://www.news-leader.com/dating">DATING</a></li>
            </ul>
        </div>
    </div>
    <div class="header-main">
        <div class="header-wrap">
            <div class="header-logo">

                <a name="top" href="http://www.News-Leader.com/" title="www.News-Leader.com Home"></a>
            </div>
            <div id="Nav">
                <ul class="nav-tabs">
                    <li id="tab0" class="mega tab 0"><a href="http://www.News-Leader.com/section/news" class="first">News</a></li><li id="tab1" class="mega tab 1"><a  href="http://www.News-Leader.com/section/sports">Sports</a></li><li id="tab2" class="mega tab 2"><a  href="http://www.News-Leader.com/section/life">Life</a></li><li id="tab3" class="mega tab 3"><a  href="http://www.News-Leader.com/section/opinions">Opinions</a></li><li id="tab4" class="mega tab 4"><a  href="http://www.News-Leader.com/section/entertainment">Entertainment</a></li><li id="tab5" class="mega tab 5"><a  href="http://www.news-leader.com/obits">Obituaries</a></li><li id="tab6" class="mega tab 6"><a  href="http://www.News-Leader.com/section/blogs">Blogs</a></li><li id="tab7" class="mega tab 7"><a class="special" href="http://www.News-Leader.com/section/help">Help</a></li>

                </ul>
                <div style="clear:both"></div>
            </div>
        </div>  
</div>
<div class="header-featured">
    <div class="header-wrap">
        <ul id="login-container" class="login-container"></ul>
        <ul>
            <li><strong>FEATURED:</strong></li><li><a href="http://data.news-leader.com/schools/ayp">Missouri AYP scores</a></li><li><a href="http://www.news-leader.com/section/joplin">Joplin tornado</a></li><li><a href="http://register.dealchicken.com/1042NL/mainnav">DealChicken</a></li><li><a href="http://www.news-leader.com/section/Census">2010 Census</a></li><li><a href="http://www.news-leader.com/section/civilwar">Civil War 150th anniversary</a></li>
        </ul>
        <div class="pd-search">
                <div class="searchbox-shift">
<script>
var search_default = "Find what you are looking for ...";
var timer = null;
function showOptions() {
    var search_options = document.getElementById("search-options");
    search_options.style.display = "";
}
function HideAllSearchOptions() {
    var search_options = document.getElementById("search-options");
    search_options.style.display = "none";
}
function submitFormAction() {
    sanitizeKeywords();
    var keywords = document.getElementById("searchbox").value;
        if (keywords == search_default){
            keywords = "";
        }
    var search_form = document.getElementById("pd-header-search");
    var checked_option = "";
    for(var i = 0; i < search_form.searchoption.length; i++) {
        if(search_form.searchoption[i].checked) {
            checked_option = search_form.searchoption[i].value;
        }
    }
    var new_url = "";
    if(checked_option === "OPTION1") new_url = "http://search.news-leader.com/sp?aff=1100&skin=&keywords=";
    else if(checked_option === "OPTION2") new_url = "http://pqasb.pqarchiver.com/news_leader/results.html?st=basic&QryTxt=";
    else if(checked_option === "OPTION3") new_url = "http://search.news-leader.com/sp?aff=1180&keywords=";
    else if(checked_option === "OPTION4") new_url = "http://search.news-leader.com/sp?skin=&aff=1109&keywords=";
    new_url = new_url + "" + keywords;
    window.location.href = new_url;
    return false; 
}   
function safeParam( key, def) { //get cleaned up keywords so they look pretty in the search box
        var defval = def|| ""; 
        var re = new RegExp( "[?&]" + key + "=([^&$]*)", "i" ); 
        var offset = location.search.search(re); 
        if ( offset == -1 || RegExp.$1 == '') return defval;
        var keywords = RegExp.$1;
        keywords = keywords.replace(/\+/g," ");
        return keywords; 
    }
    function sanitizeKeywords() {
        //clean up keywords for submit to avoid encoding
        var temp = document.getElementById("searchbox").value;
        temp = temp.replace(/<.*>/g,"");
        temp = temp.replace(/%20/g," "); //get rid of whitespace encoding
        temp = temp.replace(/%\w{2}/g, ""); //get rid of other encoding
        document.getElementById("searchbox").value = temp
    }   
</script>
<form method="get" id="pd-header-search" class="multi-search" onsubmit="return submitFormAction()" action=" ">
    <div id="search-wrapper" class="clear">
        <div id="search_border">
            <input id="searchbox" type="text" size="34" maxlength="34" onfocus="if(this.value==='Find what you are looking for ...') this.value=''; showOptions();" onblur="if(this.value=='') this.value=safeParam('keywords','Find what you are looking for ...');timer=setTimeout('HideAllSearchOptions()',1500);" onkeydown="showOptions();"/>
            <button class="search_btn" type="submit"> Search</button>

        </div>
        <div id="search-options" style="display:none;" onmouseover="clearTimeout(timer);" onmouseout="timer=setTimeout('HideAllSearchOptions()',1500);">
            <p>Search in</p>
            <div class="left">
                <input class="submit" name="searchoption" type="radio" value="OPTION1" checked/>&nbsp;&nbsp;News<br/>
                <input class="submit" name="searchoption" type="radio" value="OPTION2" />&nbsp;&nbsp;Archives
            </div>
            <div class="left">

                <input class="submit" name="searchoption" type="radio" value="OPTION3" />&nbsp;&nbsp;Local Deals<br/>
                <input class="submit" name="searchoption" type="radio" value="OPTION4" />&nbsp;&nbsp;Yellow Pages
            </div>       
        </div>
    </div>
</form>
<script type="text/javascript">document.getElementById("searchbox").value = safeParam('keywords',search_default);</script>
</div>
        </div>              
    </div>
</div>

</div>

            </div>
        </div>
    </div>
  <!-- REQUIRED:End Header -->
<div style="width:900px; margin-top:30px; margin-bottom:10px" id="desc-text">
<h2>Joplin, Missouri aerial photo before and after</h2>
<h5>Look back at our full coverage of the <a href="http://www.news-leader.com/section/joplin/">Joplin Tornado</a> here.</h5>

<p>Move the slider to compare images before and after Sunday's deadly tornado in Joplin, Missouri. The before and after photos are from AP.</p>
</div>

<div id="container2" style="margin-bottom:50px">

 <div><img alt="before" src="ap-before.jpg" width="900" height="582" /></div>
 <div><img alt="after" src="ap-after.jpg" width="900" height="582" /></div>
</div>



<div style="width:900px; margin-top:30px; margin-bottom:10px" id="desc-text">
<h1>Joplin, Missouri apartment complex before and after</h1>
<p>Move the slider to compare images before and after Sunday's deadly tornado in Joplin, Missouri. The before photo was rendered from Bing maps. The after is an AP photo taken Sunday by Charlie Riedel. Graphic by Andre L. Smith/The News Journal (Wilmington, Del.)</p>
</div>

<div id="container" style="margin-bottom:50px">

 <div><img alt="before" src="jopbefore.jpg" width="900" height="582" /></div>
 <div><img alt="after" src="jopafter.jpg" width="900" height="582" /></div>
</div>


<!-- REQUIRED:Begin Footer -->
    <div class="ody-skin"  style="background: white;">
        <div class="ody-custom">

            <div class="main-container">
                <link rel="stylesheet" type="text/css" href="http://www.News-Leader.com/includes/css/ody/ody-local.css">
<link rel="stylesheet" type="text/css" href="http://www.News-Leader.com/odygci/p5/ody-styles-min.css"/>
<div class="footer-container">
    <div class="footer-content">
        <div class="footer-top">
            <div class="footer-wrap">
                <div class="footer-logo">
                    <a href="http://www.News-Leader.com"></a>
                </div>

                <div class="right"><a href="http://www.News-Leader.com/section/sitemaphtml">Site Map</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="#top">Back to Top</a><span class="backtotop">&nbsp;</span></div>
                <div class="clear"></div>
            </div>
        </div>
        <div class="footer-main">
            <div class="footer-wrap">
                <div class="left">

                    <ul><li><h4><a href=http://www.News-Leader.com/section/news>NEWS</a></h4></li><li><a href=http://www.News-Leader.com/section/news>Ozarks News</a></li><li><a href=http://www.News-Leader.com/section/7daysarchives>Latest Headlines</a></li><li><a href=http://www.News-Leader.com/section/news12>Crime & Courts</a></li><li><a href=http://www.News-Leader.com/section/news06>Politics & Government</a></li><li><a href=http://www.News-Leader.com/section/news04>Education</a></li><li><a href=http://www.News-Leader.com/section/business>Business</a></li><li><a href=http://www.News-Leader.com/section/news11>Around Missouri</a></li><li><a href=http://www.News-Leader.com/section/news07>Nation/World</a></li><li><a href=http://data.news-leader.com>Data</a></li><li><a href=http://www.News-Leader.com/section/galleriessectionfront>Photos</a></li><li><h4><a href=http://www.News-Leader.com/section/blogs>BLOGS</a></h4></li><li><a href=http://blogs.news-leader.com/mopolitics/>Inside Missouri Politics</a></li><li><a href=http://blogs.news-leader.com/msu/>MSU Bears</a></li><li><a href=http://blogs.news-leader.com/hssports/>High School Sports</a></li><li><a href=http://blogs.news-leader.com/courtwatch/>Court Watch</a></li><li><a href=http://blogs.news-leader.com/cardinals/>Cardinals Corner</a></li><li><a href=http://blogs.news-leader.com/schools/>Schools</a></li><li><a href=http://blogs.news-leader.com/highered/>Higher Education</a></li><li><a href=http://blogs.news-leader.com/letterfromtheeditor/>Letter from the Editor</a></li></ul><ul><li><h4><a href=http://www.News-Leader.com/section/sports>SPORTS</a></h4></li><li><a href=http://www.News-Leader.com/section/sports0401>MSU Bears</a></li><li><a href=http://www.highschoolsports.net/local/Springfield>High School Sports</a></li><li><a href=http://www.News-Leader.com/section/sports02>Cardinals</a></li><li><a href=http://www.News-Leader.com/section/sports05>TV/Radio listings</a></li><li><h4><a href=http://www.News-Leader.com/section/entertainment>ENTERTAINMENT</a></h4></li><li><a href=http://ozarks.metromix.com>Metromix</a></li><li><a href=http://www.news-leader.com/calendar>Events Calendar</a></li><li><a href=http://www.News-Leader.com/section/entertainment07>Movies</a></li><li><a href=http://www.news-leader.com/section/entertainment01>Weekend</a></li><li><a href=http://www.News-Leader.com/section/entertainment09>People & Celebrities</a></li><li><a href=http://www.News-Leader.com/pets>Pet photos</a></li><li><a href=http://www.news-leader.com/section/Comics>Comics</a></li><li><a href=http://www.News-Leader.com/section/Games>Games</a></li><li><a href=http://affiliate.zap2it.com/tvlistings/ZCGrid.do?aid=metozarks>TV listings</a></li></ul><ul><li><h4><a href=http://www.News-Leader.com/section/life>LIFE</a></h4></li><li><a href=http://www.News-Leader.com/section/life05>Spaces</a></li><li><a href=http://www.News-Leader.com/section/life02>Food</a></li><li><a href=http://www.News-Leader.com/section/life06>Outdoors</a></li><li><a href=http://www.News-Leader.com/section/life04>Health</a></li><li><a href=http://www.News-Leader.com/section/life07>Religion</a></li><li><a href=http://www.news-leader.com/calendar>Events Calendar</a></li><li><a href=http://www.News-Leader.com/section/Announcements>Announcements</a></li><li><a href=http://www.News-Leader.com/section/Comics>Comics</a></li><li><a href=http://www.news-leader.com/genealogy>Genealogy</a></li><li><a href=http://ozarks.momslikeme.com>MomsLikeMe</a></li><li><h4><a href=http://www.news-leader.com/obits>OBITUARIES</a></h4></li><li><a href=https://ssl1.gmti.com/springfield/secure/ccsubscribers/obit_order.html>Submit an obituary</a></li><li><a href=http://www.news-leader.com/deathnotices>Latest Death Notices</a></li></ul><ul><li><h4><a href=http://www.News-Leader.com/section/opinions>OPINIONS</a></h4></li><li><a href=http://www.News-Leader.com/section/opinions01>Our Voice</a></li><li><a href=http://www.News-Leader.com/section/opinions02>Local voices</a></li><li><a href=http://www.News-Leader.com/section/opinions03>Readers' Letters</a></li><li><a href=http://www.News-Leader.com/section/columnists>Columnists</a></li></ul>

                </div>
                <div class="right">
                    <ul>
                        <li><h4><a href=http://www.News-Leader.com/section/help>HELP</a></h4></li><li><a href=http://www.news-leader.com/section/service>Contact Us</a></li><li><a href=https://ssl1.gmti.com/springfield/secure/icon/subscriber.html>Customer Service</a></li><li><a href=http://www.News-Leader.com/section/FAQ>FAQ</a></li><li><a href=http://www.news-leader.com/archives>Archives</a></li>
                    </ul>
                    <ul class="right_row">

    <li><h4>FOLLOW US</h4></li>
    <li class="icn_follow_twitter"><a href="http://www.News-Leader.com/twitter">Twitter</a></li>
    <li class="icn_follow_facebook"><a href="http://www.News-Leader.com/facebook">Facebook</a></li>
    <li class="icn_follow_mobile"><a href="http://www.News-Leader.com/mobile">Mobile</a></li>
    <li class="icn_follow_rss"><a href="http://www.News-Leader.com/rss">RSS</a></li>
    <li class="icn_follow_email"><a href="http://www.News-Leader.com/section/nlettersubscribe">E-mail Alerts</a></li>

    <li class="icn_follow_text"><a href="http://www.News-Leader.com/sms">Text Alerts</a></li>
</ul>
                    <!-- pbs:macro name="ody_footermenupdsearch" -->
                </div>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <div class="footer-partners">

    <div class="footer-wrap">
        <ul>
            <li><a class="footer-usatoday" href="http://www.usatoday.com" target="_blank"></a></li>
<!--            <li><a class="footer-gannett" href="http://www.gannett.com" target="_blank"></a></li>-->
            <li><a class="footer-cars" href="http://www.cars.com/?aff=spfield" target="_blank"></a></li>
            <li><a class="footer-homefind" href="http://ozarksnow.gon.gannettonline.com/apps/pbcs.dll/section?Category=HOMES" target="_blank"></a></li>
            <li><a class="footer-career" href="http://ozarksnow.gannettonline.com/careerbuilder/index.html" target="_blank"></a></li>
            <li><a class="footer-apts" href="http://www.news-leader.com/apartments/" target="_blank"></a></li>
            <li><a class="footer-homegain" href="http://www.homegain.com" target="_blank"></a></li>

            <li><a class="footer-shop" href="http://www.shoplocal.com/ozarksnow/home.aspx" target="_blank"></a></li>
            <li><a class="footer-moms" href="http://ozarks.momslikeme.com" target="_blank"></a></li>
            <li><a class="footer-metromix" href="http://ozarks.metromix.com" target="_blank"></a></li>
            <li><a class="footer-eharmony" href="http://gannett.eharmony.com/dating&cid=1046&aid=3310&cmd=registration-profile-opt" target="_blank"></a></li>           
        </ul>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
        <div class="footer-gannett">

    <a href="http://www.gannett.com" target="_blank"><img src="/odygci/p5/ody_gannett_footer.gif" alt="Gannett" title="Gannett"></a>
</div>
<p class="footer-bottom">
    Copyright &copy; 2011 www.News-Leader.com. All rights reserved.<br />
    Users of this site agree to the <a href="http://www.News-Leader.com/section/terms">Terms of Service</a>, <a href="http://www.News-Leader.com/section/privacy">Privacy Notice/Your California Privacy Rights</a>, and <a href="http://www.News-Leader.com/section/privacy#adchoices">Ad Choices</a>

</p>
    </div>
</div>

            </div>
        </div>
    </div>
  <!-- REQUIRED:End Footer -->
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
    s.pageName="data - joplin before and after interactive"
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
  <!--pagetracker code -->
  <script>
  var js=document.createElement('script');
        // assign <script> attributes
        js.setAttribute('language','javascript');
        js.setAttribute('src','http://data.news-leader.com/pageview/story/2011052499999/Interactive%20Graphic:%20Joplin%20-%20Before%20And%20After');
        // append element to document tree & send GET request
        document.getElementsByTagName('head')[0].appendChild( js );
  </script>
</body>
</html>



