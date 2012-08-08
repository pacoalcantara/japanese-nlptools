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

function show_keyphrase($appid, $sentence){
  $output = "xml";
  $request  = "http://jlp.yahooapis.jp/KeyphraseService/V1/extract?";
  $request .= "appid=".$appid."&sentence=".urlencode($sentence)."&output=".$output;
  $sxml = new simplexml;
  $responsexml = $sxml->xml_load_file($request);
  
  $result_num = count($responsexml->Result);

  if($result_num > 0){
    echo "<table>";
    echo "<tr><td><b>キーフレーズ</b></td><td><b>スコア</b></td></tr>";

    for($i = 0; $i < $result_num; $i++){
      $result = $responsexml->Result[$i];
      echo "<tr><td>".escapestring($result->Keyphrase)."</td><td>".escapestring($result->Score)."</td></tr>";
    }
    echo "</table>";
  }
}

?>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<title>テキスト解析 - キーフレーズ抽出 | Japanese text analysis - Keyphrase extraction</title>
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

<h1>テキスト解析 - キーフレーズ抽出 | Japanese text analysis - Keyphrase extraction</h1>

<div>
<h2>入力文</h2>
  <form method="POST" name="qform">
  <textarea id="sentence" name="sentence" rows="4" cols="70"><?php echo escapestring($sentence) ?></textarea>
  <br>
  <input type="submit" name="command_query" value="解析">
  </form>
</div>

<div id="result">
<h2>解析結果 - Analytical Results</h2>
<?php
  if($sentence){
    show_keyphrase($appid, $sentence);
  }
?>
</div>

</body>
</html>
