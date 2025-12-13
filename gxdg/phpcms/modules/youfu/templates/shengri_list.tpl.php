<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new', 'admin');


		$this->db->table_name = 'mj_youfu_tags';
		$rss = $this->db->select("",'id,name,pid','','id asc');
		foreach($rss as $aaa){
			if($aaa['pid']==0){
			   $tags[$aaa['id']]=$aaa['name'];
			}
			
			$tagsp[$aaa['pid']][]=$aaa;
			
			}	
			
		$this->db->table_name = 'mj_bumen';
		$rss = $this->db->select("",'id,name','','id asc');
		foreach($rss as $aaa){
			$bms[$aaa['id']]=$aaa['name'];
			$bmsm[$aaa['name']]=$aaa['id'];
		}

		$this->db->table_name = 'mj_fujing';
//////////////////////////////////////
if($_POST['donew']!=""){
$_indt=time();
$_ns=date("Y",$_indt);
$_ms=date("m",$_indt);
$_ds=date("d",$_indt);
$_tjdt=strtotime($_POST['niandt']);

$_POST['in']['indt']=$_indt;
$_POST['in']['ns']=date("Y",strtotime($_POST['niandt']));
$_POST['in']['ms']=date("m",strtotime($_POST['niandt']));
$_POST['in']['ds']=date("d",strtotime($_POST['niandt']));
$_POST['in']['tjdt']=$_tjdt;	



$newid=$this->db->insert($_POST['in'],true);
	
	}
//////////////////////////////////////


		$page = isset($_GET['page']) && intval($_GET['page']) ? intval($_GET['page']) : 1;

$_benyue=date("m");

		$where=" status=1 and sr_yue=$_benyue ";
		$orders=" id desc ";
		$bzlist = $this->db->listinfo($where,$order = $orders,$page, $pages = '12');
		$pages = $this->db->pages;
?>



<style type="text/css">
	html{_overflow-y:scroll}
</style><style>

.Bar ,.Bars { position: relative; width: 100px; border: 1px solid #B1D632; padding: 1px; } 
.Bar div,.Bars div { display: block; position: relative;background:#00F; color: #333; height: 20px;line-height: 20px;} 
.Bars div{ background:#090} 
.Bar div span,.Bars div span { position: absolute; width: 100px; text-align: center; font-weight: bold; } 
.cent{ margin:0 auto; width:150px; overflow:hidden} 
input.button {padding:0 15px;background:#498cd0}
</style>
<link href="statics/css/modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />
<div class="tableContent">
<div class="pad-lr-10">
<?php if($_SESSION['roleid']<2){?>
<form name="searchform" action="" method="post" >
<input type="hidden" value="youfu" name="m">
<input type="hidden" value="youfu" name="c">
<input type="hidden" value="srlist" name="a">
<input type="hidden" value="<?php echo $status;?>" name="status">
<div class="explain-col"> 
  快速工具:   本月生日 &nbsp;  
</div>  
</form>

<form name="searchform" method="get" id="daoxls" >
<input type="hidden" value="youfu" name="m">
<input type="hidden" value="youfu" name="c">
<input type="hidden" value="srlist" name="a">
<input type="hidden" value="<?php echo $status;?>" name="status">
<div class="explain-col"> 
<table width="100%" border="0">
  <tr>
    <td height="30">
  单位：<select name="dwid">
                       <option value="">不限</option> 
                       <?php foreach($bms as $k=>$v){?>
                       <option value="<?php echo $k?>" <?php if($k==$dwid){?>selected="selected"<?php }?> ><?php echo $v?></option>
                       <?php }?>
                      </select>&nbsp;&nbsp;
&nbsp;
  <input type="submit" value="查询" class="button" name="dotongji">  
  <a href="index.php?m=biaozhang&c=biaozhang&a=mjdao2xls&status=<?php echo $status?>&xingming=<?php echo $xingming?>&dwid=<?php echo $dwid?>&sex=<?php echo $sex?>&agetj=<?php echo $_GET['agetj']?>&age1=<?php echo $age1?>&age2=<?php echo $age2?>&xueli=<?php echo $xuelis?>&rjtj=<?php echo $_GET['rjtj']?>&rjtime=<?php echo date("Y-m-d",$rjtimes)?>&rjtime2=<?php echo date("Y-m-d",$rjtimes2)?>&gangwei=<?php echo $gangweis?>&gangweifz=<?php echo $gangweifzs?>&zhiwu=<?php echo $zhiwus?>&cengji=<?php echo $cengjis?>&zzmm=<?php echo $zzmms?>&tuiwu=<?php echo $tuiwus?>&gzz=<?php echo $_GET['gzz']?>&pc_hash=<?php echo $_SESSION['pc_hash']?>" target="_blank"><input type="button" value="导出" class="button" id="daochu" style="display:none"> </a>  
  <input type="button" value="展《" class="button" id="mianban" onclick="showkuozhan()" style="width:40px; display:none">  
    </td>
    </tr>
  <tr id="kuozhan1" style="display:none">
    <div style="width:100%;height:15px"></div>
    <td height="30">
  政治面貌: <select name="zzmm">
         <option value="">不限</option>
         <?php foreach($zzmm as $k=>$v){?>
         <option value="<?php echo $k?>" <?php if($k==$zzmms){?>selected="selected"<?php }?>><?php echo $v?></option>
         <?php }?>
       </select>&nbsp;&nbsp;
       
  退役军人: <select name="tuiwu">
         <option value="">不限</option>
         <?php foreach($tuiyi as $k=>$v){?>
         <option value="<?php echo $k?>" <?php if($k==$tuiwus){?>selected="selected"<?php }?>><?php echo $v?></option>
         <?php }?>
       </select>&nbsp;&nbsp;       
           
  岗位类别: <select name="gangwei">
         <option value="">不限</option>
         <?php foreach($gangwei as $k=>$v){?>
         <option value="<?php echo $k?>" <?php if($k==$gangweis){?>selected="selected"<?php }?>><?php echo $v?></option>
         <?php }?>
       </select>&nbsp;&nbsp;
  辅助岗位: <select name="gangweifz">
         <option value="">不限</option>
         <?php foreach($gangweifz as $k=>$v){?>
         <option value="<?php echo $k?>" <?php if($k==$gangweifzs){?>selected="selected"<?php }?>><?php echo $v?></option>
         <?php }?>
       </select> &nbsp;&nbsp;
  职务: <select name="zhiwu">
         <option value="">不限</option>
         <?php foreach($zhiwu as $k=>$v){?>
         <option value="<?php echo $k?>" <?php if($k==$zhiwus){?>selected="selected"<?php }?>><?php echo $v?></option>
         <?php }?>
       </select>&nbsp;&nbsp; 
  层级: <select name="cengji">
         <option value="">不限</option>
         <?php foreach($cengji as $k=>$v){?>
         <option value="<?php echo $k?>" <?php if($k==$cengjis){?>selected="selected"<?php }?>><?php echo $v?></option>
         <?php }?>
       </select>&nbsp;&nbsp;
   电话: <input type="text" value="<?php echo $tel?>" class="input-text" size="6" name="tel">&nbsp;&nbsp;
   身高：<select name="shengaotj">
            <option value="">不限</option> 
            <option value="=" <?php if($_GET['shengaotj']=="="){?>selected="selected"<?php }?>>等于</option>
            <option value="<" <?php if($_GET['shengaotj']=="<"){?>selected="selected"<?php }?>>小于</option>
            <option value=">" <?php if($_GET['shengaotj']==">"){?>selected="selected"<?php }?>>大于</option>
           </select><input type="text" value="<?php echo $shengao?>" class="input-text" size="6" name="shengao">&nbsp;&nbsp;
   体重：<select name="tizhongtj">
            <option value="">不限</option> 
            <option value="=" <?php if($_GET['tizhongtj']=="="){?>selected="selected"<?php }?>>等于</option>
            <option value="<" <?php if($_GET['tizhongtj']=="<"){?>selected="selected"<?php }?>>小于</option>
            <option value=">" <?php if($_GET['tizhongtj']==">"){?>selected="selected"<?php }?>>大于</option>
           </select><input type="text" value="<?php echo $tizhong?>" class="input-text" size="6" name="tizhong">&nbsp;&nbsp; <br>    
   辅警号：<input type="text" name="gzz" class="input-text" value="<?php echo $_GET['gzz']?>" size="10"/>     
    </td>
    </tr>    
</table>
	</div>
</form>
<?php }?>
<?php if($_SESSION['roleid']==9){?>
<form name="searchform" method="get" id="daoxls" >
<input type="hidden" value="fujing" name="m">
<input type="hidden" value="fujing" name="c">
<input type="hidden" value="init" name="a">
<input type="hidden" value="<?php echo $status;?>" name="status">
<div class="explain-col"> 
<table width="100%" border="0">
  <tr>
    <td height="30">
	
  姓名: <input type="text" value="<?php echo $xingming?>" class="input-text" size="6" name="xingming">&nbsp;&nbsp;
  单位：<select name="dwid">
                       
                       
                       <option value="<?php echo $_SESSION['bmid'];?>"  ><?php echo $bms[$_SESSION['bmid']]?></option>
                       
                      </select>&nbsp;&nbsp;
  性别: <select name="sex">
          <option value="">不限</option>
          <option value="男" <?php if($sex=="男"){?>selected="selected"<?php }?>>男</option>
          <option value="女" <?php if($sex=="女"){?>selected="selected"<?php }?>>女</option>
       </select> &nbsp;&nbsp;
  年龄: <select name="agetj">
            <option value="">不限</option> 
            <option value="=" <?php if($_GET['agetj']=="="){?>selected="selected"<?php }?>>等于</option>
            <option value="<" <?php if($_GET['agetj']=="<"){?>selected="selected"<?php }?>>小于</option>
            <option value=">" <?php if($_GET['agetj']==">"){?>selected="selected"<?php }?>>大于</option>
           </select><input type="text" value="<?php echo $age ?>" class="input-text" size="3" name="age">&nbsp;&nbsp; 
  学历: <select name="xueli">
         <option value="">不限</option>
         <?php foreach($xueli as $k=>$v){?>
         <option value="<?php echo $k?>" <?php if($k==$xueli){?>selected="selected"<?php }?> ><?php echo $v?></option>
         <?php }?>
       </select>
       &nbsp;&nbsp; 
  入警时间: <select name="rjtj">
            <option value="">不限</option>
            <option value="=" <?php if($_GET['rjtj']=="="){?>selected="selected"<?php }?>>区间</option>
           </select><?php if(!isset($rjtimes)){$rjtimes=time();} echo form::date('rjtime',date("Y-m-d",$rjtimes),0,0,'false');?>&nbsp;至&nbsp;
           <?php if(!isset($rjtimes2)){$rjtimes2=time();} echo form::date('rjtime2',date("Y-m-d",$rjtimes2),0,0,'false');?>
           &nbsp;&nbsp;
  <input type="submit" value="查询" class="button" name="dotongji">  
  <a href="index.php?m=fujing&c=fujing&a=dao2xls&status=<?php echo $status?>&xingming=<?php echo $xingming?>&dwid=<?php echo $dwid?>&sex=<?php echo $sex?>&agetj=<?php echo $_GET['agetj']?>&age=<?php echo $age?>&xueli=<?php echo $xuelis?>&rjtj=<?php echo $_GET['rjtj']?>&rjtime=<?php echo date("Y-m-d",$rjtimes)?>&rjtime2=<?php echo date("Y-m-d",$rjtimes2)?>&gangwei=<?php echo $gangweis?>&gangweifz=<?php echo $gangweifzs?>&zhiwu=<?php echo $zhiwus?>&cengji=<?php echo $cengjis?>&zzmm=<?php echo $zzmms?>&tuiwu=<?php echo $tuiwus?>&pc_hash=<?php echo $_SESSION['pc_hash']?>" target="_blank"><input type="button" value="导出" class="button" id="daochu" > </a>  
  <input type="button" value="展《" class="button" id="mianban" onclick="showkuozhan()" style="width:40px">  
    </td>
    </tr>
  <tr id="kuozhan1" style="display:none">
    <td height="30">
    <div style="width:100%;height:15px"></div>
  政治面貌: <select name="zzmm">
         <option value="">不限</option>
         <?php foreach($zzmm as $k=>$v){?>
         <option value="<?php echo $k?>" <?php if($k==$zzmms){?>selected="selected"<?php }?>><?php echo $v?></option>
         <?php }?>
       </select>&nbsp;&nbsp;
       
  退役军人: <select name="tuiwu">
         <option value="">不限</option>
         <?php foreach($tuiyi as $k=>$v){?>
         <option value="<?php echo $k?>" <?php if($k==$tuiwus){?>selected="selected"<?php }?>><?php echo $v?></option>
         <?php }?>
       </select>&nbsp;&nbsp;       
           
  岗位类别: <select name="gangwei">
         <option value="">不限</option>
         <?php foreach($gangwei as $k=>$v){?>
         <option value="<?php echo $k?>" <?php if($k==$gangweis){?>selected="selected"<?php }?>><?php echo $v?></option>
         <?php }?>
       </select>&nbsp;&nbsp;
  辅助岗位: <select name="gangweifz">
         <option value="">不限</option>
         <?php foreach($gangweifz as $k=>$v){?>
         <option value="<?php echo $k?>" <?php if($k==$gangweifzs){?>selected="selected"<?php }?>><?php echo $v?></option>
         <?php }?>
       </select> &nbsp;&nbsp;
  职务: <select name="zhiwu">
         <option value="">不限</option>
         <?php foreach($zhiwu as $k=>$v){?>
         <option value="<?php echo $k?>" <?php if($k==$zhiwus){?>selected="selected"<?php }?>><?php echo $v?></option>
         <?php }?>
       </select>&nbsp;&nbsp; 
  层级: <select name="cengji">
         <option value="">不限</option>
         <?php foreach($cengji as $k=>$v){?>
         <option value="<?php echo $k?>" <?php if($k==$cengjis){?>selected="selected"<?php }?>><?php echo $v?></option>
         <?php }?>
       </select>
       &nbsp;&nbsp; 
   电话: <input type="text" value="<?php echo $tel?>" class="input-text" size="6" name="tel">&nbsp;&nbsp;
   身高：<select name="shengaotj">
            <option value="">不限</option> 
            <option value="=" <?php if($_GET['shengaotj']=="="){?>selected="selected"<?php }?>>等于</option>
            <option value="<" <?php if($_GET['shengaotj']=="<"){?>selected="selected"<?php }?>>小于</option>
            <option value=">" <?php if($_GET['shengaotj']==">"){?>selected="selected"<?php }?>>大于</option>
           </select><input type="text" value="<?php echo $shengao?>" class="input-text" size="6" name="shengao">&nbsp;&nbsp;<br><br>
   体重：<select name="tizhongtj">
            <option value="">不限</option> 
            <option value="=" <?php if($_GET['tizhongtj']=="="){?>selected="selected"<?php }?>>等于</option>
            <option value="<" <?php if($_GET['tizhongtj']=="<"){?>selected="selected"<?php }?>>小于</option>
            <option value=">" <?php if($_GET['tizhongtj']==">"){?>selected="selected"<?php }?>>大于</option>
           </select><input type="text" value="<?php echo $tizhong?>" class="input-text" size="6" name="tizhong">&nbsp;&nbsp;         
    </td>
    </tr>    
</table>
	</div>
</form>
<?php }?>
<div class="table-list">

<script type="text/javascript" >  
  $(document).ready(function() {  
    $(".kotable tbody tr:odd").addClass("odd");
	$(".kotable tbody tr:even").addClass("even");
    $(".kotable tbody tr").mouseover(function() {  
      $(this).addClass("iover");  
    }).mouseout(function() {  
      $(this).removeClass("iover");  
    });  
  }  
)  
</script> 
<style type="text/css">
/*
.table-list td, .table-list th {padding:0;margin:0}
.table-list tbody td {padding:0}
.kotable {border-top:1px solid #ddd;border-left:1px solid #ddd;margin-top:10px;float:left}
.kotable th {border-right:1px solid #ddd;border-bottom:1px solid #ddd;background:#cee8ff;text-align:center;line-height:36px}
.kotable td {border-right:1px solid #ddd;border-bottom:1px solid #ddd;text-align:center;line-height:32px}
.table-list td {font-size:12px}
.odd {	background:#f7f7f7;	}
.iover {background:#FFFDE8 }

#pages {width:100%;float:left;margin-top:5px}
*/
    #inputlist{
	  position: absolute;
	  z-index:999;
	  background-color:#28348e;	
      margin: 0;
      padding: 0;
      border: 1px solid #ccc;
            width: 300px;
            display: none;
    }
    #inputlist ul,li{
      list-style: none;
    }
    #inputlist ul{
      padding: 0;
    }
    #inputlist ul li{
            line-height: 30px;
            font-size: 14px;
            text-indent: 5px;
    }
    #inputlist ul li:hover{
      background: #E0E0E8;
	  color:#28348e;
    }

    #inputlist2{
	  position: absolute;
	  z-index:999;
	  background-color:#28348e;	
      margin: 0;
      padding: 0;
      border: 1px solid #ccc;
            width: 300px;
            display: none;
    }
    #inputlist2 ul,li{
      list-style: none;
    }
    #inputlist2 ul{
      padding: 0;
    }
    #inputlist2 ul li{
            line-height: 30px;
            font-size: 14px;
            text-indent: 5px;
    }
    #inputlist2 ul li:hover{
      background: #E0E0E8;
	  color:#28348e;
    }
	
    #inputlist3{
	  position: absolute;
	  z-index:999;
	  background-color:#28348e;	
      margin: 0;
      padding: 0;
      border: 1px solid #ccc;
            width: 300px;
            display: none;
    }
    #inputlist3 ul,li{
      list-style: none;
    }
    #inputlist3 ul{
      padding: 0;
    }
    #inputlist3 ul li{
            line-height: 30px;
            font-size: 14px;
            text-indent: 5px;
    }
    #inputlist3 ul li:hover{
      background: #E0E0E8;
	  color:#28348e;
    }	
</style>
<table width="100%" cellspacing="0" class="kotable" style="margin-top:10px">
	<thead>
	<tr>
      <th width='71'>序号</th>
      <th width="227">姓名</th>
	  <th width='263'>所属单位</th>
	  <th width='141'>年龄</th>
	  <th width='143'>性别</th>
	  <th width="1015">生日</th>
	  </tr>
    </thead>
    <tbody>

  <?php
  
if(is_array($bzlist)){
	
	if(intval($_GET['page'])>1){
	 $i=12*(intval($_GET['page'])-1)+1;
	}else{
	 $i=1;
	}

$todayObj = new DateTime(date("Y-m-d"));
	
	foreach($bzlist as $info){

$birthDateObj = new DateTime(date("Y-m-d",$info['shengri']));

 
// 计算两个日期之间的差异
$interval = date_diff($todayObj, $birthDateObj);
 
// 获取年龄
$age = $interval->y; // y 表示年份的差异，即年龄	
		?>
     
	<tr>
      
      <td><?php echo $i?><input type="hidden" name="id" value="<?php echo $info['id']?>" /></td>
      <td><?php echo $info['xingming']?></td>
      <td align="left"><?php echo $bms[$info['dwid']]?></td>
      <td align="left"><?php echo $age?></td>
      <td align="left"><?php echo $info['sex']?></td>
      <td align="left"><?php echo date("Y-m-d",$info['shengri'])?></td>
      </tr>

   <?php
	$i++;}
}
?>
</tbody>
</table>

<div id="pages"><?php echo $pages?></div>

</div>
</div>
</div>
</div>

<script language="javascript">
function showkuozhan(){
  if($("#mianban").val()=='展《'){
	   $("#mianban").val('收》')
	   $("#kuozhan1").css('display','') 
	  }else{
	   $("#mianban").val('展《')
	   $("#kuozhan1").css('display','none')		  
		  }	 
}

function showadd(){
	if($("#addin").css('display')=='none'){
		$("#addin").css('display','')
		}else{
		$("#addin").css('display','none')	
			}
	}

////////////////////////
	    $(function(){
        $("#addxm").bind("keyup click",function(){
          var t=$(this),_html="";
                $.ajax({
                  async:false,
                  url:'api/getuser.php?mj=1&sel='+t.val(),
                  dataType:'json',
                  //jsonp:"mycallback",
                  //jsonpCallback:"window.baidu.sug"
                  success: function(data) {
                  var x = JSON.stringify(data);
                  x=JSON.parse(x); 
			      if(x.errnum==0){
			//var abc = x.data;
			//console.log(x.data)	
            for(var i=0; i<x.data.length; i++){
              _html+="<li id="+x.data[i].id+" xm="+x.data[i].xingming+" sfz="+x.data[i].sfz+" sex="+x.data[i].sex+" zzmm="+x.data[i].zzmmname+" hj="+x.data[i].hjdizhi+" mz="+x.data[i].minzu+" dw="+x.data[i].danwei+" dwid="+x.data[i].dwid+" zw='"+x.data[i].zhiwuname+"'  zj='"+x.data[i].cengjiname+"'>"+x.data[i][0]+"["+x.data[i].sex+","+x.data[i].shenfen+"，"+x.data[i].danwei+"]</li>";
            }}
            $("#inputlist ul").html(_html);
            if(t.val() == ""){
              $("#inputlist").hide();
            }else{
              $("#inputlist").show();
              }
            if($("#inputlist").html() == ""){
              $("#inputlist").hide();
            }	

					 },				  
                });
        });
 
        $(document).delegate("#inputlist ul li","click",function(){
		  $("#uid").val($(this).attr("id"))	
		  $("#addxm").val($(this).attr("xm"))
		  $("#sex").val($(this).attr("sex"))
		  $("#danwei").val($(this).attr("dw"))
		  $("#dwid").val($(this).attr("dwid"))		  		  
        })
 
 
        $(document).click(function(){
          $("#inputlist").hide();
  
        })
      });	
</script>
</body>
</html>