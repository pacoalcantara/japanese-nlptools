Syntactic analysis tools for Japanese language text
================================================

Example implementations of Yahoo Japan's APIs for the analysis of Japanese text:

* 係り受け解析 | Japanese Text Analysis - Dependency Parsing
* 形態素解析 | Morphological analysis
* キーフレーズ抽出 | Keyphrase extraction
* 校正支援 | Proofreading Assistance
* ルビ振り | Display Furigana of Japanese words
* かな漢字変換 | Kana to Kanji conversion

Useful tools for those working on areas of Natural Language Processing.

Registration in [Yahoo! Developer Network](http://e.developer.yahoo.co.jp/webservices/register_application/) is needed in order to obtain an application ID (in Japanese) for these implementations.

- The simplexml.class makes it possible to load XML documents under PHP4 just as
if PHP5's SimpleXML extension was being used. 
- Working from behind a proxy is also possible.

jdsa
------

テキスト解析 - 日本語係り受け解析 | Japanese Text Analysis - Dependency Parsing

Identifies the dependencies between words and phrases in a paragraph.
For example
: これはペンです will return =>　これは -> ペンです


ma_kaiseki
------------

テキスト解析 - 日本語形態素解析 | Japanese Text Analysis - Morphological analysis

Counts the number of words in text and returns information on each word such as string notation (), string reading (), part-of-speech, basic form and other syntactic information.


keyphrase
-----------

テキスト解析 - キーフレーズ抽出 | Japanese text analysis - Keyphrase extraction

Detects and extracts the most important phrases or words within a text and assigns a score of imporance to each.


kousei
--------

テキスト解析 - 校正支援 | Japanese text analysis - Proofreading Assistant

Corrects spelling on text with the help of a tooltip.


furigana
----------

テキスト解析 - ルビ振り | Japanese text analysis - Display Furigana

Displays the furigana (small hiragana to aid in reading) of Japanese words according to each level of schooling.


kanakanji
-----------

かな漢字変換 | Japanese text analysis - Kana to Kanji conversion

Provides a list of possible conversions to kanji for any word or string in hiragana.