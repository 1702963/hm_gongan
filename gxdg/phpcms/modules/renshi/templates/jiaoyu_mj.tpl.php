<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');

$zzmm[1]="中共党员";
$zzmm[2]="共青团员";
$zzmm[3]="民主党派";
$zzmm[4]="学生";
$zzmm[5]="群众";

$_guo[1]="通过";
$_guo[2]="未通过";
$_shen[1]="待审";
$_shen[9]="通过";

			//绑定组织tree
			$show_validator = '';
			$tree = pc_base::load_sys_class('tree');
			$this->db = pc_base::load_model('bumen_model');
			
			if($_SESSION['roleid']>5){
		      $where .= "  id in(1,".$_SESSION['bmid'].")";
		    }
			
			$result = $this->db->select($where);
			
			$array = array();
			foreach($result as $r) {
				$r['cname'] = $r['name'];
				if($_SESSION['roleid']>5){
				 $r['selected'] = $r['id'] == $_SESSION['bmid'] ? 'selected' : '';
				}else{
				  $r['selected'] = $r['id'] == 2 ? 'selected' : '';
				}
				$array[] = $r;
			}
			$str  = "<option value='\$id' \$selected>\$spacer \$cname</option>";
			$tree->init($array);
			$select_categorys = $tree->get_tree(0, $str);
?>
<div class="pad-lr-10">
<link href="statics/css/modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />
<style type="text/css">
.kotable {margin-top:0}
input[type=input] {height:24px}
.infoselect {width:200px;height:24px;border:0;margin-left:0}
.table_form {width:98%; margin-left:1%}
.kotable a {padding:2px 8px;background:#F66;color:#fff;border-radius:3px}
.kotable a:hover {background:#c00}
.kotable tbody tr {transition: all .2s ease-in-out}
.kotable tbody tr:nth-child(even) {background:#373891}
.kotable tbody tr:hover {background:#077fac}
.table_form input[type=submit] {background:#3C6}
.table_form input[type=submit]:hover {background:#3CC}
</style>

<div class="table-list" style="height:320px;">

<table width="100%" cellspacing="0" class="kotable">
	<thead>
		<tr>
			<th width='350' align="center">培训名称</th>
			<th width='276' align="center">开始时间</th>
			<th width='219' align="center">结束时间</th>
			<th width='462' align="center">成绩</th>
			<th width='176' align="center">是否通过</th>
			<th width='177' align="center">审核</th>
			<th width="200" align="center">操作</th>
		</tr>
	</thead>
<tbody>

<?php
if(is_array($peixun)){
	foreach($peixun as $info){
		?>
	<tr>
		
		
		
		
		<td align="center" width="350"><?=$info['title']?></td>
		<td align="center" width="276"><?=date("Y-m-d",$info['dtime'])?></td>
		
		<td align="center" width="219"><?=date("Y-m-d",$info['etime'])?></td>
		<td width="462" align="center"><?=$info['chengji']?></td>
		<td width="176" align="center"><?php echo $_guo[$info['guo']]?></td>
		<td width="177" align="center"><?php echo $_shen[$info['status']]?></td>
		<td align="center" width="200"><a href="javascript:;" onclick="att_delete(this,'<?php echo $info['id']?>')"><?php echo L('delete')?></a></td>
	</tr>
	<?php
	}
}
?>
</tbody>
</table>

<div id="pages"><?php echo $pages?></div>
</div>
<form action="?m=renshi&c=renshi&a=addpeixun_mj" method="POST" name="myform" id="myform">
<table width="966" cellpadding="2" cellspacing="1" class="table_form">

	<tr>
		<td width="11%" height="37"><strong>培训名称：</strong></td>
		<td width="23%"><input type="input" name="info[title]"  style="width:200px;" /></td>
		<td width="15%"><strong>开始时间：</strong></td>
		<td height="37"><input type="input" name="info[btime]"  style="width:200px;" /></td>
	  </tr>
    
    
    
	<tr>
		<td width="11%" height="18"><strong>结束时间：</strong></td>
		<td width="23%"><input type="input" name="info[etime]"  style="width:200px;"/></td>
		<td width="15%"><strong>成绩：</strong></td>
		<td><input type="input" name="info[chengji]"  style="width:200px;" /></td>
	</tr>
	<tr>
	  <td height="18"><strong>是否通过：</strong></td>
	  <td width="23%"><select name="info[guo]">
                        <option value="1">通过</option>
                        <option value="2">未通过</option>
                      </select></td>
	  <td width="15%"><strong>培训时单位：</strong></td>
	  <td>
<select class="infoselect" name="info[bmid]" >       
<?php echo $select_categorys;?>
</select>      
      </td>
	  </tr>
	<tr>
		<td colspan="4"><input type="submit" name="dosubmit" id="dosubmit" class="button" value=" <?php echo L('submit')?> " /></td>
	</tr>
</table>
<input type="hidden" name="id" value="<?php echo $id;?>">
</form>
</div>
</body>
</html>
<script type="text/javascript">

function att_delete(obj,aid){
	 window.top.art.dialog({content:'确认删除吗?', fixed:true, style:'confirm', id:'att_delete'}, 
	function(){
	$.get('?m=renshi&c=renshi&a=deletepeixun_mj&id='+aid+'&pc_hash=<?php echo $_SESSION['pc_hash']?>',function(data){
				if(data == 1) $(obj).parent().parent().fadeOut("slow");
			})
		 	
		 }, 
	function(){});
};
</script>