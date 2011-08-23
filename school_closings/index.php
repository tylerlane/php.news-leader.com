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
$handle = @fopen("http://www.ozarksfirst.com/content/closings", "r");

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
   
   $LastUpdated = ExtractString($data, "<td class=\"timestamp\" align=right>", "</td>");
   if (!empty($LastUpdated)) {
   		$LastUpdate = "UPDATED". date("l, F j, Y");
	}
	
  preg_match_all('#<TR><TD BGCOLOR=\"\#......\"><FONT CLASS=\"orgname\">' . '([^<]*?)' . '<\/FONT>: <FONT CLASS=\"status\">' . '([^<]*?)' . '<\/FONT><\/TD><\/TR>#si', $data, $match, PREG_PATTERN_ORDER);  
  
//  if (count($match[1]) > 0) {
?>

<div style="font-size:9px; padding-bottom:5px;"><?php echo $LastUpdated; ?></div>

<div style="color:#9B4F16; font-family:verdana; font-size:11px; line-height:13px; font-weight:bold;">

	<ul style="list-style-image:none; list-style-position:outside; list-style-type:none; margin:0pt; padding:0pt;">
<?php
$color1 = "#FFFFFF"; 
$color2 = "#FFFFCC"; 
$row_count = 0; 

	for ($i=0;$i < count($match[1]);$i++) {
		$row_color = ($row_count % 2) ? $color1 : $color2;	
?>
		<li><?php echo $match[1][$i]; ?> - <?php echo strtoupper($match[2][$i]); ?></li>
<?php
	$row_count++; 
	}
?>
		
	</ul>
</div>

<div style="font-size:9px; padding-top:5px;">News-Leader.com does not assume responsibility for the accuracy or thoroughness of the information listed.</div>
<?php
//	 } else {
?>
<!-- 	<div style="font-size:9px; padding-bottom:15px;"><?php echo $LastUpdated; ?></div>
	<div style="color:#9B4F16; font-family:verdana; font-size:11px; line-height:13px; font-weight:bold;">No school closings are being reported at this time.</div>
	<div style="font-size:9px; padding-top:15px;">News-Leader.com does not assume responsibility for the accuracy or thoroughness of the information listed.</div> -->
<?php	 
//	 }
?>

<?php
 }
?>