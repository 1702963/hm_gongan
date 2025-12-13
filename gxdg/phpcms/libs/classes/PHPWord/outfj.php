<?php
header('Content-Type:text/html;charset=utf-8');
require_once 'PHPWord.php';

$PHPWord = new PHPWord();

$document = $PHPWord->loadTemplate('fujingtemp.docx');

$document->setValue('xingming', "姓名");
$document->setValue('sex', '性别');

$picParam = array('src' => '../../uploadfile/2020/1112/20201112105513897.png', 'size' =>array('90','120')); 
$document->setImg('pic', $picParam);

$document->setValue('sex', '性别');
$document->setValue('shengri', '生日');
$document->setValue('minzu', '民族');
$document->setValue('jiguan', '籍贯');
$document->setValue('zzmm', '政治面貌');
$document->setValue('sfz', '身份证');
$document->setValue('xl', '学历');

$document->setValue('yuanxiao', '院校');
$document->setValue('zzjy', '在职教育');
$document->setValue('yuanxiao2', '院校2');
$document->setValue('zhuzhi', '住址');
$document->setValue('techang', '特长');

$document->setValue('jianli', '简历');
$document->setValue('danwei', '单位');
$document->setValue('zhiwu', '职务');
$document->setValue('ruzhi', '入职时间');
$document->setValue('cengji', '层级');
$document->setValue('gwdj', '岗位等级');



$document->save('out01.docx');

//////////////////////////////////////
/*
ob_clean();
ob_start();
$fp = fopen('out01.docx',"r");
$file_size = filesize('out01.docx');
Header("Content-type:application/octet-stream");
Header("Accept-Ranges:bytes");
Header("Accept-Length:".$file_size);
Header("Content-Disposition:attchment; filename=".'测试文件.docx');
$buffer = 1024;
$file_count = 0;
while (!feof($fp) && $file_count < $file_size){
    $file_con = fread($fp,$buffer);
    $file_count += $buffer;
    echo $file_con;
}
fclose($fp);
ob_end_flush();
*/
?>