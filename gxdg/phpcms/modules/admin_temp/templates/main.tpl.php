<?php
defined('IN_ADMIN') or exit('No permission resources.');
include PC_PATH.'modules'.DIRECTORY_SEPARATOR.'admin'.DIRECTORY_SEPARATOR.'templates'.DIRECTORY_SEPARATOR.'header.tpl.php';
?>

<style type="text/css">
h3{width:96%;height:32px;line-height:32px;padding:0;display:block;background:#09c;font-size:14px;font-weight:900;color:#fff;margin:20px 0 10px 2%;text-indent:14px}
table {margin:0 auto;border-left:1px solid #ddd;border-top:1px solid #ddd}
th {background:#f1f2f3;font-size:14px;font-weight:900;color:#666;line-height:32px;border-right:1px solid #ddd;border-bottom:1px solid #ddd}
td {background:#fff;font-size:14px;color:#666;line-height:28px;border-right:1px solid #ddd;border-bottom:1px solid #ddd}
td a {color:#09c}
.m_box {width:47%;height:199px;border:1px solid #ddd;float:left;margin:2% 0 0 2%;overflow:hidden}
.m_box_t {width:100%;height:39px;line-height:36px;border-bottom:1px solid #ddd}
.m_box_t b {font-size:14px;float:left;text-indent:14px}
.m_box_t a {float:right;margin-right:10px;font-size:12px}
.m_list li {width:100%;height:31px;border-bottom:1px solid #ddd;line-height:31px}
.m_list li a {width:100%;height:31px;display:block;font-size:12px;text-decoration:none}
.m_list li a:hover {background:#eee}
.m_list li span {margin:0 5px}
.m_list li em {font-style:normal;margin-right:20px}
#gwcl .m_box_t {background:#e6fbff}
#qjcl .m_box_t {background:#fff7f1}
#cwcl .m_box_t {background:#fffdf1}
#tzgg .m_box_t {background:#f7f7f7}
#gywm .m_box_t {background:#f8fbfe}
#ric .m_box_t {background:#eefff8}
</style>
<?php
if($_SESSION['roleid']==3||$_SESSION['roleid']==4||$_SESSION['roleid']==5||$_SESSION['roleid']==8||$_SESSION['roleid']==9||$_SESSION['roleid']==10){
?>
<div class="m_box" id="gwcl">
	<div class="m_box_t"><b>公文处理</b><a href="<?php echo $gwurl?>">更多</a></div>
    <ul class="m_list">
    <?php
    foreach($gw as $info){
		
		?>
    	<li><a href="<?php echo $gwurl?>"><span><?PHP echo date("Y-m-d",$info['inputtime']);?></span><?php echo $info['xmname'];?></a></li>
       <?php
	    }?>
    </ul>
</div>
<?php }?>


<div class="m_box" id="tzgg">
	<div class="m_box_t"><b>通知公告</b><a href="?m=gonggao&c=gonggao&a=lists">更多</a></div>
    <ul class="m_list"> <?php
    foreach($gg as $infog){
		
		?>
    	<li><a href="?m=gonggao&c=gonggao&a=lists"><span>•</span>[<?php echo date("Y-m-d",$infog['inputtime'])?>] <?php echo $infog['title']?></a></li>
         <?php
	    }?>
    </ul>
</div>




<div class="bk10"></div>

</div>
</body></html>