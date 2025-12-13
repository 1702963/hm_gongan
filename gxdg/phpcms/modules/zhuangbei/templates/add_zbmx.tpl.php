<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');

$myref=explode("?",$_SERVER["HTTP_REFERER"]);
//////
//判断是否是增加子节点
$nowpid=intval($_GET['pid']);

//////

$outtree="";

////此处递归输出树形结构
///pid 要获取的节点ID  0为一级；spid 当前选中的节点 ；dotime 批次；outstr 输出字串，&$引用
function gettrees($dbobj,$pid=0,$spid=0,$dotime=0,&$outstr ){
	$tmprs = $dbobj->select("pid=$pid",'*','',"px asc");
	if(isset($tmprs[0])){
		foreach($tmprs as $t){
		 //根据节点路由补加前置占位
		 $bwqzstr=str_repeat("┈",count(explode(",",$t['paths']))-1); //生成字符占位	
		 //判断是否选中
		 if($t['id']==$spid){
			 $issed="selected='selected'";
			 }else{
				$issed=""; 
				 }
		 
		 $outstr.="<option value='".$t['id']."' $issed >".$bwqzstr."&nbsp;".$t['name']."</option>";
		  gettrees($dbobj,$t['id'],$spid,0,$outstr);	
			}
		}else{
		  return ;	
			}
	}
	
gettrees($this->db,0,$nowpid,0,$outtree);

?>
<div class="pad-lr-10">
<form action="?m=zhuangbei&c=zbmx&a=add" method="POST" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
	<tr>
		<th width="125" height="37">类目名称：</th>
		<td width="315"><input type="input" name="lm[name]" /></td>
		<td width="1416" align="left">&nbsp;必填</td>
	</tr>
	<tr>
		<th width="125" height="37">所属父类目：</th>
		<td width="315"><select name="lm[pid]">
                          <option value="0" >作为一级类目</option>
                          <?php echo $outtree;	?>
                        </select>
        </td>
		<td width="1416">&nbsp;必选</td>
	</tr>
	<tr>
		<th width="125" height="37">规格：</th>
		<td width="315"><input type="input" name="lm[guige]"  /></td>
		<td width="1416">例：套 可留空</td>
	</tr>
	<tr>
		<th width="125" height="37">上衣号型：</th>
		<td width="315"><input type="input" name="lm[syhx]"  /></td>
		<td width="1416">例：180/108B 可留空</td>
	</tr>  
	<tr>
		<th width="125" height="37">下衣号型：</th>
		<td width="315"><input type="input" name="lm[xyhx]"  /></td>
		<td width="1416">例：180/100B 可留空</td>
	</tr>        
	<tr>
		<th width="125" height="37">单价：</th>
		<td width="315"><input type="input" name="lm[jiage]"  /></td>
		<td width="1416">例：21.99 可留空</td>
	</tr> 
	<tr>
		<th width="125" height="37">状态：</th>
		<td width="315"><select name="lm[isok]">
                          <option value="1">启用</option>
                          <option value="0">停用</option>
                        </select></td>
		<td width="1416">停用类目在批次设置内不可见</td>
	</tr>
	<tr>
		<th width="125" height="37">备注：</th>
		<td width="315"><textarea name="lm[beizhu]" rows="4" style="width:90%" ></textarea></td>
		<td width="1416">&nbsp;</td>
	</tr>            
	<tr>
		<th></th>
		<td><input type="submit" name="dosubmit" id="dosubmit" class="button" value=" <?php echo L('submit')?> " style="width:90px"/> &nbsp; <a href="<?php echo "index.php?".$myref[1];?>"><input type="button" class="button" value=" 返回 " style="width:90px"/></a></td>
		<td>&nbsp;</td>
	</tr>

</table>
<input type="hidden" name="dotime" value="<?php echo $_GET['dotime']?>">
<input type="hidden" name="forward" value="<?php echo "index.php?".$myref[1];?>">
</form>
</div>
</body>
</html>



