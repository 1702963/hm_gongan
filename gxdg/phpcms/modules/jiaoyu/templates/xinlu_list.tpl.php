<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header', 'admin');
?>
<div class="pad-lr-10">
<div class="explain-col" style=" margin-top:-10px;margin-bottom:3px"> 
 

<table width="100%" border="0">
  <tr>
    <td height="40" valign="middle">
  <a href="index.php?m=fujing&c=xinlu&a=pici"><input type="button" value="招录批次管理" class="button" name="dotongji" style="width:100px"></a> &nbsp;
  <input type="button" value="招录人员检索" class="button" name="dotongji" style="width:100px" onclick="showsourens()"> &nbsp;
  <input type="button" value="批量编辑" class="button" name="dotongji" style="width:100px" onclick="showpiliangrens()">&nbsp;
  <input type="button" value="招录人员导入" class="button" name="dotongji" style="width:100px" onclick="showaddrens()">&nbsp;
   &nbsp;
  当前批次共录入(<?php echo $zt_1?>)人,<a href="index.php?m=fujing&c=xinlu&a=init&zt=1">考核中（<?php echo $zt_1?>）</a> &nbsp;&nbsp; <a href="index.php?m=fujing&c=xinlu&a=init&zt=3">待审批（<?php echo $zt_3?>）</a> &nbsp;&nbsp; <a href="index.php?m=fujing&c=xinlu&a=init&zt=4">待分配（<?php echo $zt_4?>）</a>&nbsp;&nbsp; <a href="index.php?m=fujing&c=xinlu&a=init&zt=2">淘汰（<?php echo $zt_2?>）</a>  
    </td>
    </tr> 
  <tr id="sourens" style="display:<?php if($_GET['souits']==''){?>none<?php }?>">
  <form  method="get" enctype="multipart/form-data" >
  <input type="hidden" value="fujing" name="m">
  <input type="hidden" value="xinlu" name="c">
  <input type="hidden" value="init" name="a">   
    <td height="30"> 
    姓名： <input type="text" class="input-text" name="xingming" value="<?php echo $s_xingming?>" size="6"/> &nbsp;
    整治面貌： <input type="text" class="input-text" name="zzmm" value="<?php echo $s_zzmm?>" size="6"/> &nbsp;
    笔试： <select name="bishi">
           <option value="">不限</option>
           <option value=">" <?php if($s_bishi==">"){?>selected="selected"<?php }?>>高于</option>
           <option value="<" <?php if($s_bishi=="<"){?>selected="selected"<?php }?>>低于</option>
         </select> <input type="text" class="input-text" name="bishichengji" value="<?php echo $s_bishichengji ?>" size="3"/> &nbsp;
    面试: <select name="mianshi">
           <option value="">不限</option>
           <option value=">" <?php if($s_mianshi==">"){?>selected="selected"<?php }?>>高于</option>
           <option value="<" <?php if($s_mianshi=="<"){?>selected="selected"<?php }?>>低于</option>
         </select> <input type="text" class="input-text" name="mianshichengji" value="<?php echo $s_mianshichengji ?>" size="3"/> &nbsp;
    体能：<select name="tineng">
           <option value="">不限</option>
           <option value=">" <?php if($s_tineng==">"){?>selected="selected"<?php }?>>高于</option>
           <option value="<" <?php if($s_tineng=="<"){?>selected="selected"<?php }?>>低于</option>
         </select> <input type="text" class="input-text" name="tinengchengji" value="<?php echo $s_tinengchengji ?>" size="3"/> &nbsp;
    政审：<select name="zhengshen">
           <option value="">不限</option>
           <option value="合格" <?php if($s_zhengshen=="合格"){?>selected="selected"<?php }?>>合格</option>
           <option value="不合格" <?php if($s_zhengshen=="不合格"){?>selected="selected"<?php }?>>不合格</option>
         </select> &nbsp;
    学历：<input type="text" class="input-text" name="xueli" value="<?php echo $s_xueli?>" size="6"/> &nbsp;
    专业：<input type="text" class="input-text" name="zhuanye" value="<?php echo $s_zhuanye ?>" size="6"/> &nbsp;
    状态：<select name="zt">
           <option value="">不限</option>
           <?php foreach($zts as $k=>$v){
			   if($k>0){
			   ?>
           <option value="<?php echo $k?>" <?php if($s_zts==$k){?>selected="selected"<?php }?>><?php echo $v?></option>
           <?php }}?>
         </select> &nbsp;    
    
    <input type="submit" value="检索" class="button" name="souits" style="width:80px">&nbsp;
    <a href="index.php?m=fujing&c=xinlu&a=dao2xls&xingming=<?php echo $s_xingming ?>&zzmm=<?php echo $s_zzmm?>&bishi=<?php echo $s_bishi?>&bishichengji=<?php echo $s_bishichengji?>&mianshi=<?php echo $s_mianshi?>&mianshichengji=<?php echo $s_mianshichengji?>&tineng=<?php echo $s_tineng?>&tinengchengji=<?php echo $s_tinengchengji?>&zhengshen=<?php echo $s_zhengshen?>&xueli=<?php echo $s_xueli?>&zhuanye=<?php echo $s_zhuanye?>" target="_blank">
    <input type="button" value="导出" class="button" name="daoits" style="width:80px"> 
    </a>
    </td>
  </form>     
  </tr>    
  <tr id="addrens" style="display:none">
  <form  method="post" enctype="multipart/form-data" action="index.php?m=fujing&c=xinlu&a=inforxls">
  <input type="hidden" value="fujing" name="m">
  <input type="hidden" value="xinlu" name="c">
  <input type="hidden" value="inforxls" name="a">  
    <td height="30"> 
    <?php if($nofins['zj']==0){ ?>
     当前没有招录中的批次，无法进行导入操作
    <?php }else{?>   
     导入批次:<select name="inpici">
             <?php foreach($picis as $v){ ?>
               <option value="<?php echo $v['id']?>"><?php echo $v['zlnd']."年".$v['zlpc'];?></option> 
             <?php }?>  
             </select>&nbsp;&nbsp;
     要导入的XLS文件：<input type="file" name="infiles" size="30" accept=".xls,.xlsx"/>
    <input type="submit" value="导入人员" class="button" name="addits" style="width:80px">  <a href="dbtmp/zhaopinhuozong.xls" target="_new">下载导入模板</a> &nbsp; <b style="color:red">*请务必严格按照标准导入模板要求制作导入文件</b>
    <?php }?>
    </td>
  </form>    
  </tr> 
  <tr id="piliangrens" style="display:none">
  <form  method="post" enctype="multipart/form-data" action="index.php?m=fujing&c=xinlu&a=editxls">
  <input type="hidden" value="fujing" name="m">
  <input type="hidden" value="xinlu" name="c">
  <input type="hidden" value="editxls" name="a">  
    <td height="30"> 

     要导入的XLS文件：<input type="file" name="infiles" size="30" accept=".xls,.xlsx"/>
    <input type="submit" value="导入数据" class="button" name="addits" style="width:80px">  <a href="index.php?m=fujing&c=xinlu&a=downeditxls" target="_blank">点击下载要批量编辑的数据包</a>

    </td>
  </form>    
  </tr>              
</table>
</div>
    
<div class="table-list">

<table width="100%" cellspacing="0">
	<thead>
		<tr>
		  <th width="4%" align="center">序号</th>
          <th width='4%' align="center">年度</th>
          <th width='4%' align="center">批次</th>	
			<th width='6%' align="center">姓名</th>			
			<th width='6%' align="center">身份证</th>
            <th width='6%' align="center">笔试成绩</th>
            <th width='6%' align="center">体能测试</th>
            <th width='6%' align="center">面试成绩</th>
            <th width='6%' align="center">政审结果</th>
			<th width='6%' align="center">学历</th>
            <th width='6%' align="center">专业</th>
            <th width='6%' align="center">特长</th>
			<th width='6%' align="center">电话</th>
			<th width='6%' align="center">兵役</th>
            <th width='6%' align="center">状态</th>
			<th align="center" >操作</th>
		</tr>
	</thead>
<tbody>
<?php if($nofins['zj']==0){
	 
	 echo '<tr><td colspan="16" align="center">当前没有进行中的招录批次</td></tr>'; 
	 
   }else{?>
<?php
$hang=1;
if(is_array($zhaolus)){
	foreach($zhaolus as $info){
		?>
	<tr>
		
		
		<td align="center" ><?php echo $hang?></td>
		<td align="center" ><?php echo $piciss[$info['pici']]['zlnd']?></td>
		<td align="center" ><?php echo $piciss[$info['pici']]['zlpc']?></td>        
		<td align="center" ><?php echo $info['xingming']?></td>
		<td align="center" ><?php echo $info['sfz']?></td>
		<td align="center" ><?php echo $info['bishicj']?></td>
		<td align="center" ><?php echo $info['tinengcj']?></td>
		<td align="center" ><?php echo $info['mianshicj']?></td>
		<td align="center" ><?php echo $info['zhengshenjg']?></td>         
		<td align="center" ><?php echo $info['xueli']?></td>
		<td align="center" ><?php echo $info['zhuanye']?></td>
		<td align="center" ><?php echo $info['techang']?></td>        
		<td align="center" ><?php echo $info['tels']?></td>
		<td align="center" ><?php echo $info['tuiyi']?></td>
        <td align="center" ><?php echo $zts[$info['zt']]?></td>
		<td align="center" ><a href="javascript:;" onclick="showme('<?php echo $info['id']?>')">查看</a>
        
                                       <?php if($_SESSION['roleid']<5){?>
                                       <a href="index.php?m=fujing&c=xinlu&a=init&xlid=<?php echo $info['id']?>&doty=0" onclick="javascript:var r = confirm('作废操作将清除当前记录且无法恢复，确认作废吗?');if(!r){return false;}">作废</a></td>
                                       <?php }?>
	</tr>
	<?php
	$hang++;
	}
}}
?>
</tbody>
</table>

<div id="pages"><?php echo $pages?></div>

</div>
</div>
</body>
</html>
<script language="javascript">
function showaddrens(){
 $("#addrens").css('display','none')
 $("#sourens").css('display','none')
 $("#piliangrens").css('display','none')	
  if($("#addrens").css('display')!='table-row'){
	   $("#addrens").css('display','table-row') 
	  }else{
	   $("#addrens").css('display','none')		  
	}	 
}
function showsourens(){
 $("#addrens").css('display','none')
 $("#sourens").css('display','none')
 $("#piliangrens").css('display','none')	
  if($("#sourens").css('display')!='table-row'){
	   $("#sourens").css('display','table-row') 
	  }else{
	   $("#sourens").css('display','none')		  
	}	 
}
function showpiliangrens(){
 $("#addrens").css('display','none')
 $("#sourens").css('display','none')
 $("#piliangrens").css('display','none')	
  if($("#piliangrens").css('display')!='table-row'){
	   $("#piliangrens").css('display','table-row') 
	  }else{
	   $("#piliangrens").css('display','none')		  
	}	 
}
</script>
<script type="text/javascript">
	
function showme(id){ 
		window.top.art.dialog({title:'查看详情', id:'shows', iframe:'?m=fujing&c=xinlu&a=edit&id='+id,width:'1200px',height:'600px'}, 	function(){var d = window.top.art.dialog({id:'shows'}).data.iframe;
		var form = d.document.getElementById('dook');form.click();return false;}, function(){location.reload();window.top.art.dialog({id:'shows'}).close()});
	}	
</script>