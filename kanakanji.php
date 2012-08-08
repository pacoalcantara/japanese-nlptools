<?php
# To load XML documents under PHP 4 like PHP 5 SimpleXML extension and proxy support
require_once ('simplexml.class.php');
/**
 * An application ID is required to use the Yahoo! JAPAN Web APIs.
 * Register to obtain one in the following link and set it on $appid ↓
 * http://e.developer.yahoo.co.jp/webservices/register_application
 */
$appid = 'your_app_ID'; // <-- Your Application ID goes here

function escapestring($str) {
    return htmlspecialchars($str, ENT_QUOTES);
}
	
if(isset($_REQUEST['sentence'])){
  $sentence = mb_convert_encoding($_REQUEST['sentence'], 'utf-8', 'auto');
 }else{
  $sentence = "";
}

function kanatokanji($appid, $sentence){

  $request  = "http://jlp.yahooapis.jp/JIMService/V1/conversion?";
  $request .= "appid=".$appid."&sentence=".urlencode($sentence);
  $sxml = new simplexml;
  $responsexml = $sxml->xml_load_file($request);
  
  if($responsexml){
	echo '<table border="1" cellpadding="5"><tr valign="top">';
		foreach ($responsexml->Result->SegmentList->Segment as $clist){
			/*
			//not working / want each SegmentText element to appear on top of candidates
			foreach($clist->SegmentText as $s){
				echo "<td>".escapestring($s)."</td>"; 
			}
			
			*/
			echo "<td>";
			foreach($clist->CandidateList->Candidate as $c){
				echo escapestring($c)."<br>"; 
			}
			echo "</td>";
		}
    echo "</tr></table>";
    }else {
		echo "Failed to get XML data";
		return FALSE;
	}
}

?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>かな漢字変換 | Japanese Text Analysis - Kana to Kanji conversion</title>
</head>
<body>
    <style type="text/css">
    <!--
    h1 {
    text-align: center;
    float: left;
    }
    h2 {
    text-align: justify;
    margin: 0 0 0 0;
    padding: 0;
    }
    div {
    clear:both;
    }
    .apiEx {
    padding-top: 10px;
    *padding-top: 0px;
    }
    p {
    text-align: justify;
    padding: 0;
    margin: 0 0 0 0;
    float:left;
    }
    form { text-align: justify }
    -->
    </style>
<div>
<h1 class="title">かな漢字変換 | Japanese Text Analysis - Kana to Kanji conversion</h1>
</div>
<div>
<h2>入力文 - Input String</h2>
  <form method="POST" name="qform" >
  <textarea id="sentence" name="sentence" rows="4" cols="70"><?php echo escapestring($sentence) ?></textarea>
  <br>
  <input type="submit" name="command_query" value="解析">
  </form>
</div>

<div id="result">
<h2>解析結果 - Analytical Results</h2>
<?php
  if($sentence!=""){
    kanatokanji($appid, $sentence);
  }
?>
</div>

</body>
</html>
