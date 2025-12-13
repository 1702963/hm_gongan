<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header','admin');
?>
<link href="statics/css/select2.min.css" rel="stylesheet" />
<script src="statics/js/select2.min.js"></script>
<script type="text/javascript">
    //页面加载完成后初始化select2控件
    $(function () {
        $("#area").select2();
    });
    
    // select2()函数可添加相应配置：
    $('#area').select2({
      placeholder: '请选择姓名'
    });

    //选中控件id="area"、value="1"的元素
    function findByName(){
        //初始化select2
        var areaObj = $("#area").select2();
        var optionVal = 1;
        areaObj .val(optionVal).trigger("change");
        areaObj .change();
    }
    
</script>
<div class="pad-lr-10">
<form action="?m=zhuangbei&c=zhuangbei&a=huanhui" method="POST" name="myform" id="myform">
<input type="hidden" name="id" value="<?php echo $_GET['id']?>" />
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">
	<tr>
		<th width="20%" height="31" align="right">装备使用人：</th>
		<td width="30%"><?php echo $zhuangbei['fjname']?></td>
		<th width="20%" align="right">使用人部门：</th>
		<td width="30%"><?php echo $bms[$zhuangbei['bmid']]?></td>
	  </tr>
	<tr>
	  <th height="29" align="right">装备名称：</th>
	  <td><?php echo $zb[$zhuangbei['zbid']]?></td>
	  <th align="right">发放数量：</th>
	  <td><?php echo $zhuangbei['ffshu']?></td>
	  </tr>
	
<tr>
		<th  height="28" align="right">发放人姓名：</th>
		<td ><?php echo $zhuangbei['ffname']?></td>
		<th align="right" >发放时间：</th>
		<td ><?php echo date("Y-m-d",$zhuangbei['fftime'])?></td>
	  </tr>
	<tr>
		<td colspan="4" align="center" style="height:25px; color: #FFF; background-color: #30C"><b>还回情况</b></td>
	  </tr>
	<tr>
		<th  height="29" align="right">还回时间：</th>
		<td colspan="3" ><?php echo form::date('hhtime',date("Y-m-d"),0,0,'false');?></td>
	  </tr>
	
	<tr>
		<th  height="29" align="right">备注：</th>
		<td colspan="3" ><textarea name="beizhu" rows="1" style="width:90%"></textarea></td>
	  </tr>
	<tr>
		<th></th>
		<td colspan="3"><input type="submit" id="dook" name="dosubmit" class="button" value=" <?php echo L('submit')?> " style="width:80px; display:none"/></td>
	  </tr>

</table>
<input type="hidden" name="forward" value="?m=zhuangbei&c=zhuangbei">
</form>
</div>
<script language="javascript">
function listadd(){
       var list2 = document.getElementById("fjids")
	   var list1 = document.getElementById("fjid")
       var addop = new Option(list1[list1.selectedIndex].text,list1[list1.selectedIndex].value);
       list2.options[list2.options.length] = addop;
	   list2.options[list2.options.length-1].selected=true		
	   //移出源
	   list1.options.remove(list1.selectedIndex); 
	}
	
function listdel(){
       var list1 = document.getElementById("fjids")
	   var list2 = document.getElementById("fjid")
       var addop = new Option(list1[list1.selectedIndex].text,list1[list1.selectedIndex].value);
       list2.options[list2.options.length] = addop;
	   //移出源
	   list1.options.remove(list1.selectedIndex); 
	}

function chkok(){
//防止移入后又获取焦点造成多选失败
          var list2=document.getElementById('fjids');
		  for(i=0;i<list2.options.length;i++){
			  list2.options[i].selected=true
			  }


	if($("#fjids").val()==null){alert("未选择人员");return false}
	if($("#zbid").val()=="0"){alert("未选择装备");return false}
	if($("#ffshu").val()==""){alert("发放数量为空");return false}
	if($("#ffname").val()==""){alert("发放人为空");return false}
	if($("#fftime").val()==""){alert("发放时间为空");return false}
   }

	
function ajaxrenyuan(bmid){

$.get("getrenyuan.php",{'bmid':bmid}, function(data){
  //alert(data)
  mydat=JSON.parse(data)
   if(mydat.err!='0'){
	 alert(mydat.errstr)  
	   }else{
		  //刷新人员列表
          var list1=document.getElementById('fjid');
          list1.options.length=0;		   
		  
		  for(j=0,len=mydat.datas.length; j < len; j++) {
            var addop = new Option(mydat.datas[j]['xingming']+'-'+mydat.datas[j]['sfz'],mydat.datas[j]['id']);
            list1.options[list1.options.length] = addop;	  
			  }	   
	}
   });	
}			
</script>
</body>
</html>



