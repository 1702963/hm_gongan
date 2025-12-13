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
			<th width='813' align="center">考核内容</th>
			<th width='348' align="center">考核时间</th>
			<th width='329' align="center">审核</th>
			<th width="374" align="center">操作</th>
		</tr>
	</thead>
<tbody>

<?php
if(is_array($peixun)){
	foreach($peixun as $info){
		?>
	<tr>
		
		
		
		
		<td align="center" width="813"><?=$info['content']?></td>
		<td align="center" width="348"><?=date("Y-m-d",$info['bztime'])?></td>
		
		<td width="329" align="center"><?php echo $_shen[$info['status']]?></td>
		<td align="center" width="374"><a href="javascript:;" onclick="att_delete(this,'<?php echo $info['id']?>')"><?php echo L('delete')?></a></td>
	</tr>
	<?php
	}
}
?>
</tbody>
</table>

<div id="pages"><?php echo $pages?></div>
</div>
<form action="?m=renshi&c=renshi&a=addkaohe_mj" method="POST" name="myform" id="myform">
<table width="966" cellpadding="2" cellspacing="1" class="table_form">

	<tr>
		<td width="11%" height="37"><strong>考核内容：</strong></td>
		<td width="51%"><input type="input" name="info[content]"  style="width:400px;" /></td>
		<td width="12%"><strong>考核时间：</strong></td>
		<td width="26%" height="37"><input type="input" name="info[bztime]"  style="width:200px;" /></td>
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
	$.get('?m=renshi&c=renshi&a=deletekaohe_mj&id='+aid+'&pc_hash=<?php echo $_SESSION['pc_hash']?>',function(data){
				if(data == 1) $(obj).parent().parent().fadeOut("slow");
			})
		 	
		 }, 
	function(){});
};
</script>