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

if (isset($_POST['sentence'])) {
    $sentence = mb_convert_encoding($_POST['sentence'], 'utf-8', 'auto');
}
else
{
    $sentence = "";
}
?>

<html>
<head>
    <meta http-equiv="Content-type" content="text/html; charset=UTF-8">
    <title>テキスト解析 - 日本語係り受け解析 | Japanese Text Analysis - Dependency Parsing</title>
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
    <h1>テキスト解析 - 日本語係り受け解析 | Japanese Text Analysis - Dependency Parsing</h1>
    </div>

    <div>
        <h2>入力文 | String Input</h2>
        <form name="myForm" method="post" action="./jdsa.php">
            <textarea name="sentence" cols=70 rows=8><?php echo escapestring($sentence); ?></textarea>
            <br/>
            <input type="submit" name="exec" value="解析"></input>
        </form>
    </div>

    <div id="result">
        <h2>解析結果 - Analysis Results</h2>
        <table width="622px" cellpadding="5" cellspacing="1"style="float:left" border=solid>
        <tbody>
        <?php
            if ($sentence != "")
            {
                echo "<tr>";
                echo "<td>文節</td>";
                echo "<td>係り先の文節</td>";
                echo "</tr>";
                $request = "http://jlp.yahooapis.jp/DAService/V1/parse?appid=" . $appid . "&sentence=" . urlencode($sentence);
                $sxml = new simplexml;
                $responsexml = $sxml->xml_load_file($request);
                $size = count($responsexml->Result->ChunkList->Chunk);
                for ($i= 0; $i < $size; $i++)
                {
                    $chunk = $responsexml->Result->ChunkList->Chunk[$i];
                    $depend_chunk_id = intval($chunk->Dependency);
                    if ($depend_chunk_id >= 0)
                    {
                        $depend_chunk = $responsexml->Result->ChunkList->Chunk[$depend_chunk_id];
                    }
                    echo "<tr>";
                    echo "<td>";
                    foreach ($chunk->MorphemList->Morphem as $morph)
                    {
                        echo escapestring($morph->Surface);
                    }
                    echo "</td>";
                    echo "<td>";
                    if ($depend_chunk_id < 0)
                    {
                        echo "-> 文末";
                    }
                    else
                    {
                        echo "-> ";
                        foreach ($depend_chunk->MorphemList->Morphem as $t_morph)
                        {
                            echo escapestring($t_morph->Surface);
                        }
                    }
                    echo "</td>";
                    echo "</tr>";
                }
            }
        ?>
        </tbody>
        </table>
    </div>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td align="center">

</td>
</tr>
</table>

</body>
</html>
