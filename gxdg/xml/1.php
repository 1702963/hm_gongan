<?php 

/* 

//执行不了，获取不到结构
$xml = simplexml_load_file('01.xml'); // 加载 XML 文件

print_r($xml);

//echo $xml->getName(); 
//var_dump($xml->children()); 
// 遍历所有子节点
foreach ($xml->children() as $child) {
    echo $child->getName() . ": " . $child . "\n";
}
*/
///////////////////////////////////////////////////////////////////////////

/*
//可以执行，一大堆字符 比下面的还强点
$xmlDoc = new DOMDocument();
$xmlDoc->load("01.xml");

//print $xmlDoc->saveXML(); 内容输出到STR

$x = $xmlDoc->documentElement;
foreach ($x->childNodes AS $item) {
  print $item->nodeName . " = " . $item->nodeValue . "<br>";
}
*/


/*
// 执行不了，根本就不是JSON结构
//$xmls=file_get_contents("01.xml");
//var_dump($xmls);exit;
$xmlDoc = new DOMDocument();
$xmlDoc->load("01.xml");
$xmls=$xmlDoc->saveXML();
echo $xmls;
$xml = simplexml_load_string($xmls);

//$json = json_encode($xml);
//$docArray = json_decode($json, TRUE);

print_r($docArray);exit; 
 
foreach ($docArray['w:body']['w:p'] as $paragraph) {
    $text = '';
    foreach ($paragraph['w:r'] as $run) {
        $text .= (string)$run['w:t']; // w:t 是文本节点，需要转换为字符串类型
    }
    echo $text . "\n"; // 输出段落文本
}
*/

/*
//这个也是解析的稀碎
$reader = new XMLReader();
$reader->open('01.xml'); // 打开 XML 文件
 
while ($reader->read()) {
    if ($reader->nodeType == XMLReader::ELEMENT) {
        echo $reader->name . ": " . $reader->readString() . "\n";
    }
}
$reader->close();
*/

/*
//干脆不能跑
//class MySaxHandler extends SAXParser {
    function startElement($parser, $name, $attribs) {
        echo "Start Element: $name\n";
    }
    function endElement($parser, $name) {
        echo "End Element: $name\n";
    }
    function characterData($parser, $data) {
        echo "Data: $data\n";
    }
//} 
 
$parser = xml_parser_create(); // 创建解析器实例
$handler = new MySaxHandler(); // 创建处理器实例
xml_set_object($parser, $handler); // 设置处理器对象
xml_set_element_handler($parser, "startElement", "endElement"); // 设置元素处理器方法
xml_set_character_data_handler($parser, "characterData"); // 设置字符数据处理器方法
xml_parse($parser, file_get_contents('01.xml')); // 解析 XML 文件内容
xml_parser_free($parser); // 释放解析器资源
*/

/*
///////XML函数
//
$xmlfile = '01.xml';

$xmlparser = xml_parser_create();

// 打开文件并读取数据
$fp = fopen($xmlfile, 'r');
//var_dump($fp);
while ($xmldata = fread($fp, 4096)) 
  {
  // parse the data chunk
  if (!xml_parse($xmlparser,$xmldata,feof($fp))) 
    {
    die( print "ERROR: "
    . xml_get_error_code($xmlparser)
    . "<br />"
    . "Line: "
    . xml_get_current_line_number($xmlparser)
    . "<br />"
    . "Column: "
    . xml_get_current_column_number($xmlparser)
    . "<br />");
    }else{
		echo "OK";
		}
  }

xml_parser_free($xmlparser);
*/

?>