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

function kousei($appid, $sentence, $filter_group, $no_filter){

  $request  = "http://jlp.yahooapis.jp/KouseiService/V1/kousei?";
  $request .= "appid=".$appid."&sentence=".urlencode($sentence);
  $request .= "&filter_group=".$filter_group;
  $request .= "&no_filter=".$no_filter;
  $sxml = new simplexml;
  $responsexml = $sxml->xml_load_file($request);
  
  if($responsexml){	
		foreach($responsexml->Result as $correction){
			if($correction->Surface != ' '){
				$sentence = str_replace($correction->Surface,"<span class='r' onmouseout=\"\" onmouseover=\"popupmsg('".escapestring($correction->ShitekiWord)."<br/>".escapestring($correction->ShitekiInfo)."')\">".escapestring($correction->Surface)."</span>",$sentence);
				
			}
		}  
		echo $sentence;		
		return true;
    }else {
		echo "Failed to get file";
		return FALSE;
	}
}

?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>テキスト解析 - 校正支援 | Japanese Text Analysis - Proofreading Assistant</title>
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
    .r {background-color:yellow;margin:1px}
    form { text-align: justify }
    -->
    </style>
	
<script>
function popupmsg(message){
    if (document.all) {
	msgbox = document.all("popupmemo");
	rx = event.clientX + document.body.scrollLeft;
	ry = event.clientY + document.body.scrollTop + 10;
    } else {
	msgbox = document.getElementById("popupmemo");
	rx = NNX;
	ry = NNY + 10;
    }
    if (message) {
	msgbox.style.display = "block";
	msgbox.style.left = rx +"px";
	msgbox.style.top = ry +"px";
	msgbox.innerHTML = message; 
    }else{
	msgbox.style.display = "none"; 
	msgbox.innerHTML = ""; 
    }
}
function MouseXY(ev){
    NNX = ev.pageX;
    NNY = ev.pageY;
}
window.onmousemove = MouseXY;
</script>
</head>
<body>
<div id="popupmemo" style="position:absolute;z-index:2;border:1px solid;padding:5px;font-size:small;background-color:#eee;color:darkred;display:none"></div>

<h1>テキスト解析 - 校正支援 | Japanese Text Analysis - Proofreading Assistant</h1>
    <div>
        <h2>入力文</h2>
  <form method="POST" name="qform" >
  <textarea id="sentence" name="sentence" rows="4" cols="70"><?php echo escapestring($sentence) ?></textarea>
  <br>
  <br>
  <?php
	$filter_group = !empty($_POST['filter_group']) ? $_POST['filter_group'] : '';
	$no_filter = !empty($_POST['no_filter']) ? $_POST['no_filter'] : '';
	
	function checkboxes($name,$total,$selected=""){
		$opt = '<option value="">None</option>';
		for($x=1;$x<=$total;$x++){
			$opt .= '<option value="'.$x.'" '.($x==$selected?'selected':'').'>'.$x.'</option>';
		}
		return '<select name="'.$name.'">'.$opt.'</select>';
	  }
	?>
  <!--
  Filter Group: <?php echo checkboxes('filter_group',3,$filter_group); ?>
  &nbsp;&nbsp;&nbsp;
  No filter: <?php echo checkboxes('no_filter',17,$filter_group); ?>
  -->
  <br/>
  <br/>
  <input type="submit" name="command_query" value="解析">
  </form>
  	  </div>
  
  <br/>
<div id="result">
<h2>解析結果 - Analytical Results</h2>
  <?php		
	  if($sentence!=""){		
		kousei($appid, $sentence, $filter_group, $no_filter) or die ("Could not process");
		
	  }
  ?>
</div>
</body>
</html>