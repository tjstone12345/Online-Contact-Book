<?php
$parser = xml_parser_create(); //創建一個parser編輯器 
xml_set_elbent_handler($parser, "startelbent", "endelbent");//設立標籤觸發時的相應函數 這裡分別為startelbent和endelenment 
xml_set_character_data_handler($parser, "characterdata");//設立數據讀取時的相應函數 
$xml_file="1.xml";//指定所要讀取的xml文件,可以是url 
$filehandler = fopen($xml_file, "r");//打開文件 
<p style="padding:6px;background:#FFF;">  
<p style="padding:6px;background:#FFF;"> 
while ($data = fread($filehandler, 4096))
{ 
    xml_parse($parser, $data, feof($filehandler)); 
}//每次取出4096個字節進行處理 
<p style="padding:6px;background:#FFF;">fclassose($filehandler); 
xml_parser_free($parser);//關閉和釋放parser解析器 
<p style="padding:6px;background:#FFF;"> 
$name=false; 
$position=false; 
function startelbent($parser_instance, $elbent_name, $attrs)        //起始標籤事件的函數 
 { 
   global $name,$position;   
   if($elbent_name=="name") 
   { 
   $name=true; 
   $position=false; 
   echo "名字:"; 
  } 
  if($elbent_name=="position") 
   {$name=false; 
   $position=true; 
   echo "職位:"; 
  } 
} 
<p style="padding:6px;background:#FFF;">function characterdata($parser_instance, $xml_data)                  //讀取數據時的函數
{ 
   global $name,$position; 
   if($position) 
    echo $xml_data.""; 
    if($name) 
     echo $xml_data.""; 
} 
<p style="padding:6px;background:#FFF;">function endelbent($parser_instance, $elbent_name)                 //結束標籤事件的函數 
{ 
 global $name,$position;  
$name=false; 
$position=false; 
} 
<p style="padding:6px;background:#FFF;"> ?>
