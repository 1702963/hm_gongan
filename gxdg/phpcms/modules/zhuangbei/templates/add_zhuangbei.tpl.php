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
<form action="?m=zhuangbei&c=zhuangbei&a=add" method="POST" name="myform" id="myform">
<table cellpadding="2" cellspacing="1" class="table_form" width="100%">

	
	
	
	
	<tr>
		<th width="115" height="8">选择部门：</th>
		<td width="253"><select name="bms" onchange="ajaxrenyuan(this.value)">
                          <?php foreach($bms as $k=>$v){?>
                            <option value="<?php echo $k?>"><?php echo $v?></option>
                          <?php }?>
        </select></td>
		<td width="98">&nbsp;</td>
		<td width="345" rowspan="6" valign="top" style="padding-left:19px">
          <select name="fjids[]" size="15" multiple="multiple" id="fjids" style="width:200px">

          </select>        
        
        </td>
		<td width="731">&nbsp;</td>
	</tr>
	<tr>
	  <th width="115" height="8">人员选择：</th>
	  <td><select name="fjid" size="7" id="fjid" style="width:200px">
          </select>
      </td>
	  <td width="98" align="center"><input type="button" value="加入>>" style="width:80px" class="dowhat" onclick="listadd()"/><br><input type="button"  class="dowhat" style="margin-top:9px; width:80px"  onclick="listdel()" value="移出<<" /></td>
	  <td width="731">&nbsp;</td>
	  </tr>
	
<tr>
		<th width="115" height="37">装备名称：</th>
		<td width="253"><?php echo form::select($zb,'','name=info[zbid] class=infoselect id=zbid')?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<th width="115" height="37">发放数量：</th>
		<td width="253"><input type="input" name="info[ffshu]"  id="ffshu" style="width:200px;" onkeyup="value=value.replace(/^(0+)|[^\d]+/g,'')"/></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<th width="115" height="37">发放人姓名：</th>
		<td width="253"><input type="input" name="info[ffname]"  id="ffname" style="width:200px;"/></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	
	<tr>
		<th width="115" height="37">发放时间：</th>
		<td width="253"><?php echo form::date('fftime','',0,0,'false');?></td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<th></th>
		<td><input type="submit" name="dosubmit" id="dosubmit" class="button" value=" <?php echo L('submit')?> " style="width:80px" onclick="return chkok()"/></td>
		<td colspan="3">&nbsp;</td>
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



