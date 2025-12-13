<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_gongzi', 'admin');
?>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>jquery.min.js"></script>
<div class="pad-lr-10">
<div class="table-list" style="scroll-x:auto">

    <form action="" method="POST">
    <input type="hidden" name="m" value="shenpi"/>
    <input type="hidden" name="c" value="jixiaoshenpi"/>
    <input type="hidden" name="a" value="jixiaoshenpi_do"/>
    <input type="hidden" name="msgid" value="<?php echo $_GET['msgid']?>"/>
    <input type="hidden" name="ty" value="<?php echo $_GET['ty']?>"/> 
    <input type="hidden" name="yue" value="<?php echo $_GET['yue']?>"/>
    <input type="hidden" name="bmid" value="<?php echo $_GET['bmid']?>"/>
<table width="100%" cellspacing="0" border="1" style="margin-right:10px">
		<tr>
            <td width="30%" align="center" style="font-size:12px">选择处理方式</td>
            <td align="left" style="font-size:12px">
			 <select name="sq" id="sq" onchange="showdos()">
              <option value="1">同意</option>
			  <option value="0">退回</option>
             </select> *"退回"将回到审核发起者,而非上一级审核人
            </td>
		</tr>
       <?php if($_GET['ty']!='zguser'){
		       if($_GET['ty']!='juuser'){
		   ?> 
		<tr id="shows">
            <td width="30%" align="center" style="font-size:12px">选择下步审批人</td>
            <td align="left" style="font-size:12px; display:">
			 <select name="nextuser" >
             <?php foreach($shenpis as $k=>$v){?>
              <option value="<?php echo $k?>"><?php echo $v?></option>
             <?php }?> 
             </select> 
            </td>
		</tr>
        <?php }}?>        
	<tr>		
</table>
<input type="submit" value="确认" id="dook" name="dook" style="display:none"  /> 
</form>
</div>
</div>
<script language="javascript">
 function showdos(){
	 if($("#sq").val()==0){
		 $("#shows").css("display","none")
		 }else{
			$("#shows").css("display","") 
			 }
	 }
</script>
</body>
</html>
