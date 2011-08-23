<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

function convert_smart_quotes($string) 
{ 
	$search = array("\xe2\x80\x9c", "\xe2\x80\x9d", "\xe2\x80\x98", "\xe2\x80\x99", "\xE2\x80\x94", "\xE2\x80\xA2" );
	$replace = array('"', '"', "'", "'", "&mdash;", "&bull;" );
	return str_replace( $search, $replace, $string ); 
}
?>
<div style="padding-bottom:30px;">&nbsp;</div>


<div class="secList tab_item_selected">
	<div class="feedList">
		<ol>
<?php
$target_url = "http://www.ktts.com/weather/schoolclosings/";
$userAgent = 'Googlebot/2.1 (http://www.googlebot.com/bot.html)';

// make the cURL request to $target_url
$ch = curl_init();
curl_setopt($ch, CURLOPT_USERAGENT, $userAgent);
curl_setopt($ch, CURLOPT_URL,$target_url);
curl_setopt($ch, CURLOPT_FAILONERROR, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_AUTOREFERER, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$html= curl_exec($ch);
if (!$html) {
	echo "<br />cURL error number:" .curl_errno($ch);
	echo "<br />cURL error:" . curl_error($ch);
	exit;
}


$html = str_replace("<BR>", "[br]", $html );

//parsing the page we just pulled down.
// parse the html into a DOMDocument
$dom = new DOMDocument();
@$dom->loadHTML($html);

//loading all of the table rows - since there's only one table on the page and we want to look at
//all of the rows IN the table, we can just use elementsbytagname on tr and loop through the results
$elements = $dom->getElementsByTagName("tr");


if( !is_null( $elements))
{
    //variable to track our row count
    $row_count = 0;
	#$elements = $table->childNodes;
    foreach( $elements as $element )
    {
		if( $row_count > 5 )
		{
			if( $element->hasChildNodes() )
			{
				print "<li class=\"clearfix\">";
				$nodes = $element->childNodes;
				$count = 0;
				foreach( $nodes as $node )
				{
					
					if( $count == 0 )
					{
						/*if( $node->hasChildNodes )
						{
							$tr_nodes = $node->childNodes;
							$tr_count = 0;
							foreach( $tr_nodes as $tr_node )
							{
								print $tr_count ." - " . $tr_node->nodeValue ."<br >";
								$tr_count += 1;
							}
						}
						*/
						$childnodes = $node->childNodes;
						$childcount = 0;
						print "<div class=\"content\">";
						foreach( $childnodes as $child )
						{
							if( $childcount == 1 )
							{
								print "<h3>". convert_smart_quotes( $child->nodeValue ) ."</h3>\r\n";
							}
							elseif( $childcount == 3)
							{
								print str_replace( "[br]","<br />", convert_smart_quotes( $child->nodeValue ) ) ."\r\n";
							}
							$childcount +=1;
						}
						print "</div>";
					}
					$count +=1;
				}
				print "</li>";
			}
		}
		$row_count += 1;
	}
}
?>
</ol>
</div>
</div>