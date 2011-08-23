<?php
                        #num pages
                        $max_pages = 15;
                        #get the page name without .php
                        $base_page = basename($_SERVER["PHP_SELF"]);
                        #get the page number ( hopefully )
                        $page_num = substr($base_page, 7, 2 );
                        #previous page
                        if( $page_num != 1 )
                        {
                            print '<div style="float: left; margin-right: 10px;height:12px;padding-top:3px;">';
                            print '<a href="http://php.news-leader.com/joplin/cleanup'. ( $page_num - 1 ) .'.php"><img src="images/arrow.lt.jpg" style="height:12px;"/></a></div>';
                        }
                        #loop through page numbers
                        for($x=1;$x<= $max_pages;$x++)
                        {
                            #if x is our current page. print out the currentpage span
                            if( $x == $page_num )
                            {
                                print '<span id="currentPage">'. $x . '</span>';
                            }
                            #if the x isn't the current page. pritn out our link
                            else
                            {
                                print '<a href="http://php.news-leader.com/joplin/cleanup'. $x .'.php">'. $x .'</a>';
                            }
                            #print the | in between numbers
                            if( $x != $max_pages )
                            {
                                print " | ";
                            }
                        }
                        #close out the div for our page numbers
                        print "</div>";
                        #next page
                        if( $page_num != $max_pages )
                        {
                            print '<div style="float: left; margin-left: 10px;height:12px;padding-top:3px;"><a href="http://php.news-leader.com/joplin/cleanup'. ($page_num + 1 ) .'.php"><img src="images/arrow.rt.jpg" style="height:12px;"></a></div>';
                        }
?>
