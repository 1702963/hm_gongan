<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');
?>
<div class="pad-lr-10">
<div class="table-list" style="scroll-x:auto">


<table width="50%" border="1" align="center" style="margin-top:200px">
<thead>
  <tr>
    <th>没有未结转的默认工资表，请选择要查看的历史工资表</td>
  </tr>
</thead>
<form action="" method="get"> 
<input type="hidden" name="m" value="gongzi"/>
<input type="hidden" name="c" value="gzgl"/>
<input type="hidden" name="a" value="dytables"/>   
  <tr>
    <td align="center"><select name="yue">
         <?php foreach($tableslist as $v){?>
           <option value="<?php echo $v['id']?>"><?php echo $v['yue']?></option>
         <?php }?>
        </select>  <input type="submit" name="xuanze" value="查看" style="border-radius:.4em;cursor:pointer; width:80px; height:25px; background-color:#06C; color:#FFF"/> </td>
  </tr>
</form> 
 <tr>
  <td>&nbsp; * 历史工资表只能查阅，无法进行操作</td>
 </tr>  
</table>

</div>
</div>
<script type="text/javascript">

function showtgongzis(id,dbs) {
		window.top.art.dialog({title:'工资录入/编辑', id:'shows', iframe:'?m=gongzi&c=gzgl&a=showgongziedit&id='+id+'&dbs='+dbs ,width:'1100px',height:'550px'},function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}
		
</script>
</body>
</html>
