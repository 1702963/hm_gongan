<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');
?>
<div class="pad-lr-10">
<div class="table-list" style="scroll-x:auto">

<table width="100%" cellspacing="0" border="1" style="margin-right:10px">
    <form action="" method="POST">
    <input type="hidden" name="m" value="gongzi"/>
    <input type="hidden" name="c" value="gzgl"/>
    <input type="hidden" name="a" value="addzdy"/>
		<tr>
            <td width="13%" align="center" style="font-size:12px">搜索人员</td>
            <td width="87%" align="left" style="font-size:12px"><input type="text" name="fjxm" value="" style="width:130px"/>&nbsp; <input type="submit" name="sousuo" value="检索" style="width:50px"/>
            &nbsp; * 设置特殊保险状态必须同时使用自定义工资基数
            </td>
		</tr>
</form>
		<tr>
		  <td colspan="2" align="center" style="font-size:12px; background-color:#39F">

<table width="99%" border="0" style="color:#FFF">
  <tr>
    <td width="5%">姓名</td>
    <td width="13%">所属部门</td>
    <td width="9%">岗位</td>
    <td >层级</td>
    <td width="9%">基础工资</td>
    <td width="9%">绩效工资</td>
    <td width="9%">值班费</td>
    <td width="9%">年功</td>
    <td width="9%">社保</td>
    <td width="9%">层级工资</td>
    <td width="5%">操作</td>
  </tr>
</table>
        
          </td>
	    </tr>
        
<?php if(is_array($sousuo)){
	   foreach($sousuo as $v){
	?>        
		<tr>
		  <td colspan="2" align="center" style="font-size:12px; background-color:#39F">
<form action="" method="post">
    <input type="hidden" name="m" value="gongzi"/>
    <input type="hidden" name="c" value="gzgl"/>
    <input type="hidden" name="a" value="addzdy"/>
    <input type="hidden" name="uid" value="<?php echo $v['id']?>"/>
<table width="99%" border="0" style="color:#FFF">
  <tr>
    <td width="5%"><?php echo $v['xingming']?></td>
    <td width="13%"><?php echo $bumen[$v['dwid']]?></td>
    <td width="9%"><?php echo $gangwei[$v['gangwei']]?></td>
    <td ><?php echo $cengji[$v['cengji']]?></td>
    <td width="9%"><input type="text" name="gzjs" value="<?php echo $v['gzjs']?>" style="width:70px"/></td>
    <td width="9%"><input type="text" name="kz_jixiao" value="<?php echo $v['kz_jixiao']?>" style="width:70px"/></td>
    <td width="9%"><input type="text" name="kz_zhiban" value="<?php echo $v['kz_zhiban']?>" style="width:70px"/></td>
    <td width="9%"><input type="text" name="kz_niangong" value="<?php echo $v['kz_niangong']?>" style="width:70px"/></td>
    <td width="9%"><label><input type="checkbox" name="canbao" checked="checked" value="1"/>缴纳社保</label></td>
    <td width="9%"><label><input type="checkbox" name="cancengji" checked="checked" value="1"/>层级工资</label></td>
    <td width="5%"><input type="submit" name="newzjs" value="新增" style="width:60px"/></td>
  </tr>
</table>
</form>          
          </td>
	    </tr>
<?php }}?>        
 <?php 
 if(is_array($zdy_fies)){
	foreach($zdy_fies as $v){ 
 ?>        
		<tr>
		  <td colspan="2" align="center" style="font-size:12px">
<form action="" method="post">
    <input type="hidden" name="m" value="gongzi"/>
    <input type="hidden" name="c" value="gzgl"/>
    <input type="hidden" name="a" value="addzdy"/>
    <input type="hidden" name="uid" value="<?php echo $v['id']?>"/>
<table width="98%" border="0">
  <tr>
    <td width="5%"><?php echo $v['xingming']?></td>
    <td width="13%"><?php echo $bumen[$v['dwid']]?></td>
    <td width="9%"><?php echo $gangwei[$v['gangwei']]?></td>
    <td ><?php echo $cengji[$v['cengji']]?></td>
    <td width="9%"><input type="text" name="gzjs" value="<?php echo $v['gzjs']?>" style="width:70px"/></td>
    <td width="9%"><input type="text" name="kz_jixiao" value="<?php echo $v['kz_jixiao']?>" style="width:70px"/></td>
    <td width="9%"><input type="text" name="kz_zhiban" value="<?php echo $v['kz_zhiban']?>" style="width:70px"/></td>
    <td width="9%"><input type="text" name="kz_niangong" value="<?php echo $v['kz_niangong']?>" style="width:70px"/></td>
    <td width="9%"><label><input type="checkbox" name="canbao" <?php if($v['jnbx']==1){?>checked="checked"<?php }?> value="1"/>缴纳社保</label></td>
    <td width="9%"><label><input type="checkbox" name="cancengji" <?php if($v['cancengji']==1){?>checked="checked"<?php }?> value="1"/>层级工资</label></td>
    <td width="5%" ><input type="submit" name="editgzjs" value="编辑" style="width:60px"/></td>
  </tr>
</table>
</form>
          </td>
	    </tr>
<?php }}?>                         
	</table>
 <div id="pages"><?php echo $pages?></div>

</div>
</div>
</body>
</html>
