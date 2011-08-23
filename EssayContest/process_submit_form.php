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
                <title>Essay Contest</title>
                <link rel="stylesheet" href="style.css" type="text/css" media="screen" />
        </head>
        <body>
                <div id="wrapper">
                            <a href="http://www.news-leader.com/civilwarshortstory"><img src="MoLitLogo.jpg" id="logo"></a>
                            <div id="content">
                                <form id="form">
                                 <div id="stuff">
                                            <h1>CIVIL WAR CHALLENGE SHORT STORY CONTEST</h1>
                                            <p>In celebration of the Sesquicentennial events surrounding the U.S. Civil War, the Missouri Literary Festival and the Springfield News-Leader have teamed up to host the 2011 Civil War Challenge Short Story Contest.</p>
                                            <p>From March to July 2011, the Missouri Literary Festival encouraged authors to take up the challenge and contribute their own creative short fiction for this contest. The writing contest was open to any fiction genre but stories were required to contain some element (such as setting, character, theme) related to the U.S. Civil War time period. As part of the competition, prizes will be awarded for National, Regional and People’s Choice winners.</p>
                                            <p>As a leading corporate sponsor of the Missouri Literary Festival, the Springfield News-Leader will host the People’s Choice Award Voting from August 22 through September 11. During this three-week time period, News-Leader online readers will be able to read and vote on their favorite short stories.</p>
                                            <p>Winners will be announced during the Missouri Literary Festival which will be held Sept. 23, 24 and 25, 2011. The festival headliners include Novelist Jeff Shaara, author of “Gods and Generals” and “The Last Full Measure,” and Historian William C. Davis, author of numerous books on the Civil War including the Pulitzer Prize-nominated “Breckinridge: Statesman, Soldier, Symbol.” Visitors will enjoy author readings, book signings, historic re-enactors and historic displays, a concert of Civil War era hymns and spirituals, children’s art activities, poetry readings, and more. Proceeds of the event will benefit Springfield Regional Arts Council and local writing and literacy programs, including Ozarks Literacy Council, Family Literacy Centers of the Ozarks and scholarships through the Writers Hall of Fame. For additional Missouri Literary Festival information go to <a href="http://www.missouriliteraryfestival.org" target="_new">www.missouriliteraryfestival.org</a>.</p>
                                    </div>
                                <div id="form">
                                <?php
                                $query = "SELECT * from entries where email like '". $_POST["email"]."'";
                                //print "<b>query</b> = $query <br />"; 



                                $res = mysql_query( $query, $conn );

                                if( mysql_num_rows( $res ) > 0 )
                                {
                                        print "<span class=\"error\"><h1>Email address already voted ! You can only vote once.</h1></span>";
                                }
                                else
                                {
                                        //saving code here;
                                        $insert_query = "INSERT INTO entries( name,address,city,state,zipcode,phone,email,snl_contact_allowed,essay)VALUES (";
                                        $insert_query .= "'". $_POST[ "name" ] ."', ";
                                        $insert_query .= "'". $_POST[ "address" ] ."', ";
                                        $insert_query .= "'". $_POST[ "city" ] ."', ";
                                        $insert_query .= "'". $_POST[ "state" ] ."', ";
                                        $insert_query .= "'". $_POST[ "zipcode" ] ."', ";
                                        $insert_query .= "'". $_POST[ "phone_number" ] ."', ";
                                        $insert_query .= "'". $_POST[ "email" ] ."', ";
                                        //current date
                                        if($_POST[ "snl_contact_allowed" ] == "on" )
                                        {
                                                $snl_contact_allowed = 1;
                                        }
                                        else
                                        {
                                                $snl_contact_allowed = 0;
                                        }
                                        $insert_query .= "'". $snl_contact_allowed ."',";
                                        $insert_query .= "'". $_REQUEST["essay"] ."' )";
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
                                                $to = "tlane@news-leader.com";
                                                $subject = "ERRROR!!!!!!!!!!!!!!!!! -  Essay Contest";
                                                $headers = 'From: Essay Contest <do-not-reply@news-leader.com>' . "\r\n" .
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
                                                $body .= "essay = ". $_POST[ "essay" ] ."\r\n ";
                                                mail( $to, $subject, $body, $headers );
                                        }
                                        else
                                        {
                                                print "<h1>Your entry has been received. Remember you can only enter once!</h1>";
                                                print "<!-- insert_query = $insert_query -->\r\n<br />";
                                                print "<!--". mysql_error( $insert_res ) ." -- ". mysql_errno() ." --><br />\r\n";
                                                //email crap
                                                $to = $_POST["email"];
                                                $subject = "Your entry in Essay Contest";
                                                $headers = "From: Essay Contest <do-not-reply@news-leader.com> \r\n" .
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
                                                $body .= "Essay = ". $_POST[ "essay" ] ."\r\n ";
                                                mail( $to, $subject, $body, $headers );
                                        }
                                }

                                ?>
                                </div>
                                </form>
                        <div id="footer">
                                <p><a href="rules.html">Click Here</a> for official Rules</p>
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
                                s.pageName="contest - essay contest"
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

