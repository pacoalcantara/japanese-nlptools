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

function furi($appid, $sentence, $grade){

  $request  = "http://jlp.yahooapis.jp/FuriganaService/V1/furigana?";
  $request .= "grade=".$grade."&";
  $request .= "appid=".$appid."&sentence=".urlencode($sentence);
  $sxml = new simplexml;
  $responsexml = $sxml->xml_load_file($request);
  
  if($responsexml){
	echo '<table border="1" cellpadding="5"><tr valign="top">';
		echo '<tr align="center"><th>表記</th><th>ふりがな</th><th>ローマ字</th></tr>';
		foreach ($responsexml->Result->WordList->Word as $wlist){

			if($wlist->Surface != ' '){
				echo "<tr>\n";
				echo "<td><span style='color:gray'></span>".escapestring($wlist->Surface)."</td>";
				echo "<td><span style='color:gray'></span>".escapestring($wlist->Furigana)."</td>";
				echo "<td><span style='color:gray'></span>".escapestring($wlist->Roman)."</td>";
				echo "</tr>\n";
			}
		}
    echo "</table>";
    return true;
    }else {
		echo "Failed to get XML data";
		return FALSE;
	}
}

?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>テキスト解析 - ルビ振り | Japanese Text Analysis - Show Furigana</title>
</head>
<body>
    <style>
    </style>
<h1>テキスト解析 - ルビ振り | Japanese Text Analysis - Show Furigana</h1>

<h2>入力文 | Input String</h2>
  <form method="POST" name="qform" >
  <textarea id="sentence" name="sentence" rows="4" cols="70"><?php echo escapestring($sentence) ?></textarea>
  <br>
<?php
$grade = isset($_POST['grade']) ? $_POST['grade'] : 1;
?>
  <p>学年を指定してください (1:小学1年生向け ～ 6:小学6年生向け | 7:中学生以上向け | 8:一般向け):</p>
  <p>Select a school year level (1: Elementary 1st yr ～ 6: Elementary 6th yr | 7: Junior high | 8: General):</p>
  <input type="radio" name="grade" value="1" <?php echo $grade == 1?'checked':''; ?>/> 1
  <input type="radio" name="grade" value="2" <?php echo $grade == 2?'checked':''; ?>/> 2
  <input type="radio" name="grade" value="3" <?php echo $grade == 3?'checked':''; ?>/> 3
  <input type="radio" name="grade" value="4" <?php echo $grade == 4?'checked':''; ?>/> 4
  <input type="radio" name="grade" value="5" <?php echo $grade == 5?'checked':''; ?>/> 5
  <input type="radio" name="grade" value="6" <?php echo $grade == 6?'checked':''; ?>/> 6
  <input type="radio" name="grade" value="7" <?php echo $grade == 7?'checked':''; ?>/> 7
  <input type="radio" name="grade" value="8" <?php echo $grade == 8?'checked':''; ?>/> 8  
  <br/>
  <br/> 
  
  <input type="submit" name="command_query" value="解析">
  </form>

<div id="result">
<h2>解析結果 - Analytical Results</h2>
<?php
  if($sentence!=""){
    furi($appid, $sentence, $grade);
  }
?>
</div>

</body>
</html>
