<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new');?>
<script type="text/javascript">
//2020-09-11新增 切换栏目关闭树状菜单
window.top.$('#display_center_id').css('display','none');
</script>
<link href="statics/css/modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />
<style type="text/css">
.input-text {height:32px;}
.table_form {font-size:14px;width:98%;margin-left:2%;margin-top:10px}
.table_form td {height:80px}
.table_form th b {color:#eee;margin-left:20px}
.table_form th h3 {color:#D5FFFF;margin-left:20px}
.table_form th , .table_form td , .table_form tbody th , .table_form tbody td {padding:25px 0;text-align:left}
.table_form td span {margin-left:10px}
.button { background:#09c; font-size:14px; border-radius:3px; margin:10px 0; transition: all .2s ease-in-out }
.button:hover { background:#f60 }
input.button, input.btn {width:120px;height:32px;font-size:12px}
div.btn {background:none}
select {width:300px;height:32px;font-size:14px}
.kotable tbody td { text-align:left;height:28px }
.explain-col {padding:2px 10px}
.tableContent {padding-bottom:100px}
</style>
<?php if(ROUTE_A=='init') {?>


<div class="tableContent">
	<form name="myform" action="?m=admin&c=bumen&a=listorder" method="post">
	<div class="pad-lr-10">
		<div class="explain-col" style="margin-bottom:5px">
			<input type="button" value="添加一级单位" class="button" name="dotongji" >
		</div>
		<div class="table-list">
			<table width="100%" cellspacing="0" class="kotable" style="margin-top:0">
				<thead>
					<tr>
						<th width="100"><?php echo L('listorder');?></th>
						<th width="100">id</th>
						<th>部门名称</th>
						<th width="300"><?php echo L('operations_manage');?></th>
					</tr>
				</thead>
				<tbody>
					<?php echo $categorys;?>
				</tbody>
			</table>
  			<input type="submit" class="button" name="dosubmit" value="<?php echo L('listorder')?>" />
		</div>
	</div>
	</form>
</div>
</body>
</html>


<?php } elseif(ROUTE_A=='add') {?>
<script type="text/javascript">
<!--
	$(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
		
		$("#name").formValidator({onshow:"请输入部门名称",onfocus:"请输入部门名称",oncorrect:"正确"}).inputValidator({min:1,onerror:"请输入部门名称"});
		
	})
//-->
</script>

<div class="tableContent">
    <div class="common-form">
        <form name="myform" id="myform" action="?m=admin&c=bumen&a=add" method="post">
        <table width="100%" class="kotable table_form">
              <tr>
                <th colspan="2"><h3>添加子部门</h3></th>
              </tr>
              <tr>
                <th width="200" align="right"><b>上级部门：</b></th>
                <td><span><select name="info[parentid]" >
                <option value="0"><?php echo L('no_parent_menu')?></option>
        <?php echo $select_categorys;?>
        </select></span></td>
              </tr>
              
              <tr>
                <th align="right"><b>部门名称：</b></th>
                <td><span><input type="text" name="info[name]" id="name" class="input-text" ></span></td>
              </tr>
        </table>
        <!--table_form_off-->
        
         <div class="bk15"></div>
         <table width="100%">
         	<tr><td align="center">
			<input type="submit" id="dosubmit" class="button" name="dosubmit" value="<?php echo L('submit')?>"/>
            </td></tr>
         </table>
         <div class="bk15"></div>
        
        </form>
    </div>
</div>

<?php } elseif(ROUTE_A=='edit') {?>
<script type="text/javascript">
<!--
	$(function(){
		$.formValidator.initConfig({formid:"myform",autotip:true,onerror:function(msg,obj){window.top.art.dialog({content:msg,lock:true,width:'200',height:'50'}, function(){this.close();$(obj).focus();})}});
		$("#name").formValidator({onshow:"请输入部门名称",onfocus:"请输入部门名称",oncorrect:"正确"}).inputValidator({min:1,onerror:"请输入部门名称"});
	})
//-->
</script>
<div class="tableContent">
<div class="common-form">
<form name="myform" id="myform" action="?m=admin&c=bumen&a=edit" method="post">
<table width="100%" class="kotable table_form">
	  <tr>
      	<th colspan="2"><h3>修改</h3></th>
      </tr>
      <tr>
        <th width="200" align="right"><b><?php echo L('menu_parentid')?>：</b></th>
        <td><select name="info[parentid]" style="width:200px;">
 <option value="0"><?php echo L('no_parent_menu')?></option>
<?php echo $select_categorys;?>
</select></td>
      </tr>
     
      <tr>
        <th align="right"><b>部门名称：</b></th>
        <td><input type="text" name="info[name]" id="name" class="input-text" value="<?php echo $name?>"></td>
      </tr>
	

</table>
<!--table_form_off-->


         <div class="bk15"></div>
         <input name="id" type="hidden" value="<?php echo $id?>">
         <table width="100%">
         	<tr><td align="center">
			<input type="submit" id="dosubmit" class="button" name="dosubmit" value="<?php echo L('submit')?>"/>
            </td></tr>
         </table>
         <div class="bk15"></div>

</form>
</div>
</div>
<?php }?>
<script type="text/javascript" >  
  $(document).ready(function() {  
    $(".kotable tbody tr:odd").addClass("odd");//even 奇数行 gt(0)排除第一个
	$(".kotable tbody tr:even").addClass("even");//even 奇数行 gt(0)排除第一个
    $(".kotable tbody tr").mouseover(function() {  
      $(this).addClass("iover");  
    }).mouseout(function() {  
      $(this).removeClass("iover");  
    });  
  }  
)  
</script> 
</body>
</html>