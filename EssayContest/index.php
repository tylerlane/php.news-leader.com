<html>
        <head>
                <title>Missouri Literary Festival: Civil War Short Story</title>
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
                                        //removing the old errors
                                        $(".error").remove();
                                        var hasError = false;
                                        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
                                        var emailaddressVal = $("#email").val();
                                        var nameVal = $("#name").val();
                                        var addressVal = $("#address").val();
                                        var cityVal = $("#city").val();
                                        var stateVal = $("#state").val();
                                        var zipVal = $("#zipcode").val();
                                        var phoneVal = $("#phone").val();
                                        //get all inputs with essay in it.
                                        var essayVal = $("input[id*=essay]:checked").val();
                                        //name
                                        if( nameVal == '' )
                                        {
                                                $("#name").after('<span class="error"><br />Please enter your name.<br /></span>');
                                                hasError = true;
                                        }
                                        //address
                                        if( addressVal == '' )
                                        {
                                                $("#address").after('<span class="error"><br />Please enter your address.<br /></span>');
                                                hasError = true;
                                        }
                                        //city
                                        if( cityVal == '' )
                                        {
                                                $("#city").after('<span class="error"><br />Please enter your city.<br /></span>');
                                                hasError = true;
                                        }
                                        //state
                                        if( stateVal == '' )
                                        {
                                                $("#state").after('<span class="error"><br />Please enter your State.<br /></span>');
                                                hasError = true;
                                        }
                                        //zipcode 
                                        if( zipVal == '' )
                                        {
                                                $("#zipcode").after('<span class="error"><br />Please enter your Zip Code.<br /></span>');
                                                hasError = true;
                                        }
                                        //zipcode 
                                        if( phoneVal == '')
                                        {
                                                $("#phone").after('<span class="error"><br />Please enter your Phone Number.<br /></span>');
                                                hasError = true;
                                        }
                                        //email address
                                        if( emailaddressVal == '' )
                                        {
                                                $("#email").after('<span class="error"><br />Please enter your email address.<br /></span>');
                                                hasError = true;
                                        }
                                        else if(!emailReg.test(emailaddressVal))
                                        {
                                                $("#email").after('<span class="error"><br />Enter a valid email address.<br /></span>');
                                                hasError = true;
                                        }
                                       if( essayVal == undefined )
                                       {
                                                $("#essay_error").after('<span class="error">Please select an essay.</span>');
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
                        <a href="http://www.news-leader.com/civilwarshortstory"><img src="MoLitLogo.jpg" id="logo"></a>
                        <div id="content">
        <?php
    $end = mktime( "17", "00", "0","9","11","2011" );
    $now = time();
    if(  $now < $end )
    {
        ?>
                            <form action="process_submit_form.php" method="POST" id="form">
                                    <div id="stuff">
                                            <h1>CIVIL WAR CHALLENGE SHORT STORY CONTEST</h1>
                                            <p>In celebration of the Sesquicentennial events surrounding the U.S. Civil War, the Missouri Literary Festival and the Springfield News-Leader have teamed up to host the 2011 Civil War Challenge Short Story Contest.</p>
                                            <p>From March to July 2011, the Missouri Literary Festival encouraged authors to take up the challenge and contribute their own creative short fiction for this contest. The writing contest was open to any fiction genre but stories were required to contain some element (such as setting, character, theme) related to the U.S. Civil War time period. As part of the competition, prizes will be awarded for National, Regional and People’s Choice winners.</p>
                                            <p>As a leading corporate sponsor of the Missouri Literary Festival, the Springfield News-Leader will host the People’s Choice Award Voting from August 22 through September 11. During this three-week time period, News-Leader online readers will be able to read and vote on their favorite short stories.</p>
                                            <p>Winners will be announced during the Missouri Literary Festival which will be held Sept. 23, 24 and 25, 2011. The festival headliners include Novelist Jeff Shaara, author of “Gods and Generals” and “The Last Full Measure,” and Historian William C. Davis, author of numerous books on the Civil War including the Pulitzer Prize-nominated “Breckinridge: Statesman, Soldier, Symbol.” Visitors will enjoy author readings, book signings, historic re-enactors and historic displays, a concert of Civil War era hymns and spirituals, children’s art activities, poetry readings, and more. Proceeds of the event will benefit Springfield Regional Arts Council and local writing and literacy programs, including Ozarks Literacy Council, Family Literacy Centers of the Ozarks and scholarships through the Writers Hall of Fame. For additional Missouri Literary Festival information go to <a href="http://www.missouriliteraryfestival.org" target="_new">www.missouriliteraryfestival.org</a>.</p>
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
                                                    <td><input type="text" name="state" id="state" max_length="2" /></td>
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
                                        <input type='checkbox' name="snl_contact_allowed" id="snl_contact_allowed" checked /> <label for="snl_contact_allowed">Yes, I would like to receive e-communications from News-Leader for local deals,  including events and things to do.</label><br />
                                    </div>
                                    <div id="instructions">
                                        <b>Instructions:</b> Complete the required information on the entry form.  Click each story title to read the selected short story entry.  Once all
                                        stories have been read, select the radial button at the left of your favorite short story.  Click submit to register your "readers' choice" vote.  You may only vote for one story.
                                    </div>
                                    <div id="essays">
                                        <input type='radio' name="essay" id="essay_1" value="The Doctor's Nightmare" /> <label for="essay_1"><a href="pdfs/The Doctor's Nightmare.pdf" target="_new">The Doctor's Nightmare</a> by Jennifer Pits Adair</label><br />
                                        <input type='radio' name="essay" id="essay_2" value="One, Two, Three" /> <label for="essay_2"><a href="pdfs/One, Two, Three.pdf" target="_new">One, Two, Three</a> by Wanda Fittro</label><br />
                                        <input type='radio' name="essay" id="essay_3" value="Coming to the Killing Fields" /> <label for="essay_3"><a href="pdfs/Coming to the Killing Fields.pdf" target="_new">Coming to the Killing Fields</a> by Adam Conrad Azzalino</label><br />
                                        <input type='radio' name="essay" id="essay_4" value="The Paneled Map" /> <label for="essay_4"><a href="pdfs/The Paneled Map.pdf" target="_new">The Paneled Map</a>: A Story of the Quilt Code and the Underground Railroad by Holly Elkins</label><br />
                                        <input type='radio' name="essay" id="essay_5" value="Going Home" /> <label for="essay_5"><a href="pdfs/Going Home.pdf" target="_new">Going Home</a> by Jim Brannon</label><br />
                                        <input type='radio' name="essay" id="essay_6" value="Broken Battle" /> <label for="essay_6"><a href="pdfs/Broken Battle.pdf" target="_new">Broken Battle</a>: Bed Time Stories from the Major by Ela Thompson</label><br />
                                        <input type='radio' name="essay" id="essay_7" value="Best Laid Plans" /> <label for="essay_7"><a href="pdfs/Best Laid Plans.pdf" target="_new">Best Laid Plans</a> by Alice R. Cummings</label><br />
                                        <input type='radio' name="essay" id="essay_8" value="Worth" /> <label for="essay_8"><a href="pdfs/Worth.pdf" target="_new">Worth</a> by Monique Hayes</label><br />
                                        <input type='radio' name="essay" id="essay_9" value="Enumeration Day" /> <label for="essay_9"><a href="pdfs/Enumeration Day.pdf" target="_new">Enumeration Day</a> by Frank Krone</label><br />
                                        <input type='radio' name="essay" id="essay_10" value="Brothers" /> <label for="essay_10"><a href="pdfs/Brothers.pdf" target="_new">Brothers</a>: A Short Story of War Ariving in Platte County, Missouri by Matthew R. Sibler</label><br />
                                        <input type='radio' name="essay" id="essay_11" value="Refugee" /> <label for="essay_11"><a href="pdfs/Refugee.pdf" target="_new">Refugee</a> by Eric Ellis</label><br />
                                        <div id="essay_error"></div>
                                    </div>
                                    <div id="buttons">
                                    <input type="Submit" id="btn-submit" value="Submit" /><input type="reset" id="reset" value="Clear"/>
        </div>
        <?php
    }
    else
    {
        print "<h2>Sorry!</h2><br />The contest has ended.<br />";
    }
    ?>
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
