<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new','admin');


		$this->db->table_name = 'mj_bumen';
		$rss = $this->db->select("",'id,name','','id asc');
		$bms[]="";
		foreach($rss as $aaa){
			$bms[$aaa['id']]=$aaa['name'];
			$bmfy[$aaa['name']]=$aaa['id'];
			}	
			
			
if($_POST['dosubmit']!=""){

//print_r($_POST);
//exit;

$_indt=time();
$_ns=date("Y",$_indt);
$_ms=date("m",$_indt);
$_ds=date("d",$_indt);
$_tjdt=strtotime(date("Y-m-d",$_indt));

	
$this->db->table_name = 'mj_jiandu_zhifa';
$_POST['in']['indt']=$_indt;
$_POST['in']['ns']=$_ns;
$_POST['in']['ms']=$_ms;
$_POST['in']['ds']=$_ds;
$_POST['in']['tjdt']=$_tjdt;
$_POST['in']['ladt']=strtotime($_POST['in']['ladt']);
$_POST['in']['jadt']=strtotime($_POST['in']['jadt']);
$_POST['in']['lrdt']=strtotime($_POST['in']['lrdt']);
$_POST['in']['danwei']=$bms[$_POST['in']['dwid']];
if($_POST['in']['cled']=="1"){
$_POST['in']['cldt']=strtotime($_POST['in']['cldt']);	
	}
if($_POST['in']['cfed']=="1"){
$_POST['in']['cfdt']=strtotime($_POST['in']['cfdt']);	
	}	
if($_POST['in']['djed']=="1"){
$_POST['in']['djcfdt']=strtotime($_POST['in']['djcfdt']);	
	}	
if($_POST['in']['zwed']=="1"){
$_POST['in']['zwcfdt']=strtotime($_POST['in']['zwcfdt']);	
	}	
	

$_POST['in']['inuser']=param::get_cookie('admin_username');
$_POST['in']['inuid']=$_SESSION['userid'];


///处理附件
$zmuparr=$qtuparr=array();
if(isset($_POST['zmups-url'])){
	$mx=count($_POST['zmups-url']);
	for($i=0;$i<$mx;$i++){
		$zmuparr[]=array("url"=>$_POST['zmups-url'][$i],"name"=>$_POST['zmups-name'][$i]);
		}
	}
if(isset($_POST['qtups-url'])){
	$mx=count($_POST['qtups-url']);
	for($i=0;$i<$mx;$i++){
		$qtuparr[]=array("url"=>$_POST['qtups-url'][$i],"name"=>$_POST['qtups-name'][$i]);
		}
	}

$_POST['in']['zmup']=json_encode($zmuparr,JSON_UNESCAPED_UNICODE);
$_POST['in']['qtup']=json_encode($qtuparr,JSON_UNESCAPED_UNICODE);

$newid=$this->db->insert($_POST['in'],true);
showmessage('操作完成','index.php?m=jiandu&c=zhifa&a=init');	
}

?>

<script type="text/javascript">
<!--
	var charset = '<?php echo CHARSET;?>';
	var uploadurl = '<?php echo pc_base::load_config('system','upload_url')?>';
//-->
</script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>content_addtop.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>colorpicker.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>hotkeys.js"></script>

<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>swfupload/swf2ckeditor.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidator.js" charset="UTF-8"></script> 
<script language="javascript" type="text/javascript" src="<?php echo JS_PATH?>formvalidatorregex.js" charset="UTF-8"></script> 
<link href="statics/css/modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />
<form action="?m=jiandu&c=zhifa&a=addzf" method="POST" name="myform" id="myform">


<style type="text/css">
/*
.clear {clear:both}
.baseinfo {width:1270px;border-left:2px solid #ccc;border-top:2px solid #ccc;border-right:2px solid #ccc;border-bottom:2px solid #ccc;margin:0 0 20px 20px;_display:inline}
.baseinfo td {border-bottom:1px solid #ccc;padding:15px 0;height:32px}
.baseinfo td b {margin-left:10px;color:#f00}
.infotitle {background:#fff;font-weight:900}
.infotitle span {color:#f00}
.infoinput {width:200px;height:20px;background:#fff;border:1px solid #ddd;margin-left:5px;text-indent:1px}
.baseinfo select {padding:5px 0}
.infonum {width:525px;height:24px;background:#fff;border:1px solid #aaa;margin-left:10px;text-indent:5px}
.rad {margin-left:10px;margin-right:5px}
.infoselect {width:206px;margin-left:5px}
#headpic {width:150px;height:230px;background:#fff;margin-left:15px;overflow:hidden}
#headpic img {width:150px}
.topnav {width:960px;padding-left:10px;margin-top:20px}
.thisnav {width:100%;height:90px}
.thisnav a {margin-left:15px;width:120px;height:80px;display:block;float:left;background:#f6f6f6;color:#3e6a90;font-weight:900;border-radius:4px;font-size:12px;text-decoration:none;text-align:center;overflow:hidden}
.thisnav a div {width:120px;height:80px;display:block;position:relative}
.thisnav a img {width:36px;position:absolute;left:50%;margin-left:-18px;top:40%;margin-top:-18px}
.thisnav a em {width:100%;height:36px;line-height:36px;display:block;font-style:normal;position:absolute;bottom:0;left:0}
.thisnav a:hover {background:url(statics/images/nb.gif) repeat-x;color:#039}
.tabcon {width:1270px;padding-top:30px;position:relative;}
.tabcon .title {width:90px;height:30px;line-height:30px;text-align:center;background:#fff;position:absolute;top:15px;left:35px;font-size:16px;font-weight:900;color:#06c}
.basetext {width:1150px;height:90px;background:#fff;border:1px solid #ddd;float:left;margin-left:5px;overflow:hidden}
.lztext {width:1150px;height:60px;background:#fff;border:1px solid #ddd;float:left;margin-left:5px;overflow:hidden}
.dowhat {width:160px;height:40px;line-height:40px;border-radius:6px;background:#06c;color:#fff;text-align:center;position:absolute;left:50%;margin-left:-80px;top:0px}
.null {width:100%;height:100px}
.rb {border-right:1px solid #ddd}
.upa {float:left;margin-left:15px}
.upa img {width:18px;margin-right:10px;}
.upa a {font-size:14px}
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

</style>



<div class="tabcon">
<div class="title" style="width:150px">案件基本情况</div>
<table cellpadding="0" cellspacing="0" class="baseinfo" align="center">
  <tr>
    <td align="right" class="infotitle">案件标题：</td>
    <td colspan="5"><input type="text" id="title" name="in[title]" value="<?php echo $jd['title'];?>" class="infoinput" style="width:80%"/></td>
    </tr>
  <tr>
    <td width="117" align="right" class="infotitle"><span>涉案人数：</span></td>
    <td width="246"><input type="text" name="in[renshu]" value="<?php echo $jd['renshu'];?>" class="infoinput"/></td>
    <td width="100" align="right" class="infotitle">立案时间：</td>
    <td width="211"><?php echo form::date('in[ladt]',"2020-1-1",0,0,'false')?> </td>    
    <td width="152" align="right" class="infotitle">结案时间：</td>
    <td width="172" class="rb"><?php echo form::date('in[jadt]',date("Y-m-d"),0,0,'false')?></td>
    </tr>

  <tr>
    <td align="right" class="infotitle">案件内容：</td>
    <td colspan="5">
<div id='content_tip'></div><textarea name="in[neirong]" id="content" boxid="content"><?php echo $jd['neirong']?></textarea><script type="text/javascript" src="statics/js/ckeditor/ckeditor.js"></script><script type="text/javascript">
CKEDITOR.replace( 'content',{height:300,pages:true,subtitle:true,textareaid:'content',module:'content',catid:'16',
flashupload:true,alowuploadexts:'',allowbrowser:'1',allowuploadnum:'10',authkey:'08bcee8a59bcfdc9f47fd3b67f84d8c2',
filebrowserUploadUrl : 'index.php?m=attachment&c=attachments&a=upload&module=content&catid=16&dosubmit=1',
toolbar :
[
['Source','-','Templates'],
		    ['Cut','Copy','Paste','PasteText','PasteFromWord','-','Print'],
		    ['Undo','Redo','-','Find','Replace','-','SelectAll','RemoveFormat'],['ShowBlocks'],['Image','Capture','Flash','flashplayer','MyVideo'],['Maximize'],
		    '/',
		    ['Bold','Italic','Underline','Strike','-'],
		    ['Subscript','Superscript','-'],
		    ['NumberedList','BulletedList','-','Outdent','Indent','Blockquote'],
		    ['JustifyLeft','JustifyCenter','JustifyRight','JustifyBlock'],
		    ['Link','Unlink','Anchor'],
		    ['Table','HorizontalRule','Smiley','SpecialChar','PageBreak'],
		    '/',
		    ['Styles','Format','Font','FontSize'],
		    ['TextColor','BGColor'],
		    ['attachment'],
]
});
</script>    
    </td>
    </tr>
  <tr>
    <td align="right" class="infotitle">涉案材料：</td>
    <td><input type="file" id="zmups" style="display:none" onchange="ufs('zmups')" name="zmup"/>&nbsp;<input type="button" value="上传" style="width:70px" onclick="onfiles('zmups')"/>&nbsp;
    <progress id="prob-zmups" value="0" max="100" style="display:none"></progress></td>
    <td>&nbsp;</td>
    <td id="msgs-zmups">&nbsp;</td>
    <td align="right" class="infotitle">录入时间：</td>
    <td><?php echo form::date('in[lrdt]',date("Y-m-d"),0,0,'false')?></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">已上传材料：</td>
    <td colspan="5" id="uplist-zmups">&nbsp;</td>
    </tr>
</table>
</div>

<div class="clear"></div>

<div class="tabcon">
<div class="title" style="width:150px">涉案人基本情况</div>
<table cellpadding="0" cellspacing="0" class="baseinfo" align="center">
  <tr>
    <td width="117" align="right" class="infotitle"><span>涉案人：</span></td>
    <td width="246"><input type="text" id="xingming" name="in[xingming]" value="<?php echo $jd['xingming'];?>" class="infoinput" />
        <div id="inputlist">
        <ul>
        </ul>
       </div><input type="hidden" name="in[uid]" id="uid" />     
    </td>
    <td width="100" align="right" class="infotitle">单位：</td>
    <td width="211"><select name="in[dwid]" class="infoselect">
                      <?php foreach($bms as $k=>$v){?>
                      <option value="<?php echo $k?>" <?php if($jd['dwid']==$k){?>selected<?php }?>><?php echo $v?></option>
                      <?php }?>
                    </select> </td>    
    <td width="152" align="right" class="infotitle">性别：</td>
    <td width="172" class="rb"><input type="text" id="sex" name="in[sex]" value="<?php echo $jd['sex'];?>" class="infoinput" /></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">身份证号：</td>
    <td width="246"><input type="text" id="sfz" name="in[sfz]" value="<?php echo $jd['sfz'];?>" class="infoinput" /></td>
    <td width="100" align="right" class="infotitle">警种:</td>
    <td><input type="text" id="jingzhong" name="in[jingzhong]" value="<?php echo $jd['jingzhong'];?>" class="infoinput" /></td>
    <td align="right" class="infotitle">警衔：</td>
    <td><input type="text" id="jingxian" name="in[jingxian]" value="<?php echo $jd['jingxian'];?>" class="infoinput" /></td>
    </tr>
  <tr>
    <td align="right" class="infotitle">出生日期：</td>
    <td width="246"><input type="text" id="shengri" name="in[shengri]" value="<?php echo $jd['shengri'];?>" class="infoinput" /></td>
    <td width="100" align="right" class="infotitle">职级：</td>
    <td><input type="text" id="zhiji" name="in[zhiji]" value="<?php echo $jd['zhiji'];?>" class="infoinput" /></td>
    <td align="right" class="infotitle">职务：</td>
    <td><input type="text" id="zhiwu" name="in[zhiwu]" value="<?php echo $jd['zhiwu'];?>" class="infoinput" /></td>
  </tr>
  <tr>
    <td align="right" class="infotitle">警号:</td>
    <td width="246"><input type="text" id="jinghao" name="in[jinghao]" value="<?php echo $jd['jinghao'];?>" class="infoinput" /></td>
    <td width="100" align="right" class="infotitle">政治面貌：</td>
    <td><input type="text" id="zzmm" name="in[zzmm]" value="<?php echo $jd['zzmm'];?>" class="infoinput" /></td>
    <td align="right" class="infotitle">人员类型：</td>
    <td><input type="text" id="rylx" name="in[rylx]" value="<?php echo $jd['rylx'];?>" class="infoinput" /></td>
  </tr>
  <tr>
    <td align="right" class="infotitle">职务描述：</td>
    <td width="246"><input type="text" id="zwms" name="in[zwms]" value="<?php echo $jd['zwms'];?>" class="infoinput" /></td>
    <td width="100" align="right" class="infotitle">班子成员：</td>
    <td><input type="text" id="bzcy" name="in[bzcy]" value="<?php echo $jd['bzcy'];?>" class="infoinput" /></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right" class="infotitle">其他情况：</td>
    <td colspan="5" ><textarea name="in[qtbz]" style="width:90%; height:40px"></textarea></td>
  </tr>
</table>
</div>


<div class="clear"></div>

<div class="tabcon">
<div class="title" style="width:150px">处置情况</div>

<table cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td align="right" class="infotitle">违纪行为：</td>
    <td><span class="rb">
      <input type="text" name="in[wjxw]" id="wjxw" class="infoinput"  value="<?php echo $jd['wjxw'];?>" />
    </span></td>
    <td align="right" class="infotitle">移送司法机关：</td>
    <td width="225"><input type="text" name="in[yssf]" id="yssf" class="infoinput"  value="<?php echo $jd['yssf'];?>" /></td>
    <td width="130" >&nbsp;</td>
    <td width="459">&nbsp;</td>
    </tr>
  <tr>
    <td align="right" class="infotitle">处理时间：</td>
    <td width="281"><?php echo form::date('in[cldt]',date("Y-m-d"),0,0,'false')?> &nbsp; <input type="checkbox" name="in[cled]" value="1" /> &nbsp;已处理</td>
    <td width="195" align="right" class="infotitle" >处理情况：</td>
    <td colspan="3"><input type="text" name="in[clqk]" id="clqk" class="infoinput"  value="<?php echo $jd['clqk'];?>" /></td>
  </tr>
  <tr>
    <td width="143" align="right" class="infotitle">处分时间：</td>
    <td><?php echo form::date('in[cfdt]',date("Y-m-d"),0,0,'false')?> &nbsp; <input type="checkbox" name="in[cfed]" value="1" /> &nbsp;已处分</td>
    <td align="right" class="infotitle">处分情况：</td>
    <td colspan="3"><input type="text" name="in[cfqk]" id="cfqk" class="infoinput"  value="<?php echo $jd['cfqk'];?>" /></td>
  </tr>
  <tr>
    <td align="right" class="infotitle">党纪处分时间：</td>
    <td><?php echo form::date('in[djcfdt]',date("Y-m-d"),0,0,'false')?> &nbsp; <input type="checkbox" name="in[djed]" value="1" /> &nbsp;已处分</td>
    <td align="right" class="infotitle">政务处分时间</td>
    <td colspan="3"><?php echo form::date('in[zwcfdt]',date("Y-m-d"),0,0,'false')?> &nbsp; <input type="checkbox" name="in[zwed]" value="1" /> &nbsp;已处分</td>
  </tr>
  <tr>
    <td align="right" class="infotitle">挽回经济损失：</td>
    <td><input type="text" name="in[whss]" id="whss" class="infoinput"  value="<?php echo $jd['whss'];?>" /></td>
    <td align="right" class="infotitle">是否问责：</td>
    <td colspan="3"><input type="text" name="in[wenze]" id="wenze" class="infoinput"  value="<?php echo $jd['wenze'];?>" /></td>
  </tr>
  <tr>
    <td align="right" class="infotitle">通报曝光：</td>
    <td><input type="text" name="in[baoguang]" id="baoguang" class="infoinput"  value="<?php echo $jd['baoguang'];?>" /></td>
    <td align="right" class="infotitle">交代类型：</td>
    <td colspan="3"><input type="text" name="in[jdlx]" id="jdlx" class="infoinput"  value="<?php echo $jd['jdlx'];?>" /></td>
  </tr>
  <tr>
    <td align="right" class="infotitle">相关附件：</td>
    <td colspan="2"><input type="file" name="qtup" id="qtups" style="display:none" onchange="ufs('qtups')"/>&nbsp;<input type="button" value="上传" style="width:70px" onclick="onfiles('qtups')"/>&nbsp;
    <progress id="prob-qtups" value="0" max="100" style="display:none"></progress></td>
    <td colspan="3" id="msgs-qtups">&nbsp;</td>
    </tr>
  <tr>
    <td align="right" class="infotitle">已上传附件：</td>
    <td colspan="5" id="uplist-qtups">&nbsp;</td>
  </tr>
</table>


</div>

<div class="clear"></div>

<div class="tabcon">

	<input type="submit" class="dowhat" name="dosubmit" value="提交信息" />
</div>
<div class="clear"></div>
<div class="null"></div>

</div>
</form>
<script language="javascript">
function getbmi(){
	if($("#shengao").val()!="" || !isNaN($("#shengao").val()) ){
		if($("#tizhong").val()!="" || !isNaN($("#tizhong").val()) ){
		tmp=$("#tizhong").val()/($("#shengao").val()*$("#shengao").val());	
		  $("#bmi").val(tmp.toFixed(2))
		}
	  }
	}
	
 function showzmup(){
	 $("#zmup").click()
	 }	
 function showqtup(){
	 $("#qtup").click()
	 }		 
	///////////////////////////////////////////////////////////////
     $(function(){
        $("#xingming").bind("keyup click",function(){
          var t=$(this),_html="";
                $.ajax({
                  async:false,
                  url:'api/getuser.php?sel='+t.val(),
                  dataType:'json',
                  //jsonp:"mycallback",
                  //jsonpCallback:"window.baidu.sug"
                  success: function(data) {
                  var x = JSON.stringify(data);
                  x=JSON.parse(x); 
			      if(x.errnum==0){
			//var abc = x.data;
			console.log(x.data)	
            for(var i=0; i<x.data.length; i++){
              _html+="<li id="+x.data[i].id+" xm="+x.data[i].xingming+" sfz="+x.data[i].sfz+" sex="+x.data[i].sex+" zzmm="+x.data[i].zzmmname+" hj="+x.data[i].hjdizhi+" mz="+x.data[i].minzu+" dw="+x.data[i].danwei+" dwid="+x.data[i].dwid+" zw='"+x.data[i].zhiwuname+"'  zj='"+x.data[i].cengjiname+"' sr='"+x.data[i].shengri+"' >"+x.data[i][0]+"["+x.data[i].sex+","+x.data[i].shenfen+"，"+x.data[i].danwei+"]</li>";
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
		  $("#xingming").val($(this).attr("xm"))	 
		 $("#sex").val($(this).attr('sex'))		      
         $("#sfz").val($(this).attr('sfz'))
		 $("#zzmm").val($(this).attr('zzmm'))
		 $("#danwei").val($(this).attr('dw'))
		 $("#dwid").val($(this).attr('dwid'))
		 $("#zhiwu").val($(this).attr('zw'))
		 $("#zhiji").val($(this).attr('zj'))
		 $("#shengri").val($(this).attr('sr'))		  		  
        })
 
       //$(document).delegate("#submit","click",function(){
       //   var key = $("#search").val();
       //   //点击
       // })
 
        $(document).click(function(){
          $("#inputlist").hide();
        })
      });	 	 
</script>
<script language="javascript">
ajax = new XMLHttpRequest();

   
//console.log(canh5)   

function clearall(){
	//清空标记
	var bmdiv=$("span.folder"); 
	bmdiv.each(function(){
		adiv=$(this).children();
		    if(adiv[0].attributes[1].nodeValue==1){
				tmpid=adiv[0].attributes[0].nodeValue;
				$("#"+tmpid).css("color","#000");
				$("#"+tmpid).attr("seds",0);
			 //console.log($("#"+tmpid).css("color"));
		     }
			
		})
	///////////////////////
	$('#ren').html('');
	}
	
function selall(){
		var chx = $("input[type=checkbox]");
		chx.each(function(){
			if($(this).prop("name")!='ispublic'){
			var flag = $(this).prop("checked");
			$(this).prop("checked",!flag);
			}
		})

	}	
	
function onfiles(objname){
	$("#"+objname).click()
	}	
	
function ufs(objname){
     document.getElementById('prob-'+objname).style.display=''
	 $("#msgs-"+objname).html("正在上传，请等待...");	
	 up_files(objname)
	}	

function dellist(objname,objid){
	$("#list"+objname+objid).remove();
	}	
	
function up_files(objname){ //H5上传
            var fd = new FormData();
            fd.append('file',document.getElementById(objname).files[0]); //第一个参数是后端接收$_FILES数组的名字 $_FILES['file']['name'] ，前后端变量名需要一致	
			fd.append('canshu','<?php echo $_SESSION['userid']?>');
			ajax.upload.addEventListener("progress", p_uploadProgress, true);		
            ajax.open('POST', 'api/ajax.php') 
            ajax.send(fd);
			fd=null //销毁对象
            ajax.onreadystatechange = function () { //多文件上传时不能异步,但是上传进度必须在异步下才能获取		  
			//console.log(ajax.responseText)	
             if(ajax.readyState == 4){ //if-1		
              var obj = JSON.parse(ajax.responseText);
			  if(obj.error==0){ //if-2
				 $("#msgs-"+objname).html("上传完成");
				 //document.getElementById('writeback').innerHtml="<a href=\""+obj.furl+"\">"+obj.fname+"</a>"
				 //防止因文件名包含特殊字符截断代码，需要从DOCM提取
                 liststr="<label style='width:90%; float:left;line-height:18px' id='list"+objname+obj.aid+"'><input type='hidden' name='"+objname+"-url[]' value='"+obj.furl+"' /><input type='hidden' name='"+objname+"-name[]' value='"+obj.name+"' /><b id='rtitle"+obj.aid+"' >"+obj.name+"</b> &nbsp; <span><a href='javascript:;' onclick='dellist("+obj.aid+")'>删除</a>&nbsp;&nbsp;</span></label>";
				 //alert(liststr)
				 $('#uplist-'+objname).html($('#uplist-'+objname).html()+liststr);
				// console.log(liststr)
				 //$('#uplist'+objname).append(liststr);
				 //document.getElementById('hx').text=obj.fname
				 document.getElementById('prob-'+objname).style.display='none'
			  }else{
				  document.getElementById('prob-'+objname).style.display='none'
				  $("#msgs-"+objname).html(obj.error);
				 }// if-2 end
			 }//if-1 end
			} //onreadystatechange end 
   } // up_files end   

function p_uploadProgress(evt) { //普通上传进度
	//console.log(evt.loaded);
  if (evt.lengthComputable) {
    var percentComplete = Math.round(evt.loaded * 100 / evt.total);
       // document.getElementById('bfb').innerHTML = percentComplete.toString() + '%';
		document.getElementById("prob").value=percentComplete;

  }else {
        document.getElementById("prob").value=0;
        }
} //p_uploadProgress end  

function tiqutitle(objvar){
	//alert(document.getElementById("rtitle"+objvar).innerText.split(".")[0]);
	
	document.getElementById("aname").value+=document.getElementById("rtitle"+objvar).innerText.split(".")[0];
	}
	
/////////////////////////////////////
//IE下的附件上传弹窗
<!--
	function ieups(uid) {
		window.top.art.dialog({title:'附件上传', id:'ieups', iframe:'ieup.php?canshu='+uid,width:'500px',height:'430px'}, 	function(){var d = window.top.art.dialog({id:'ieups'}).data.iframe;
		var form = d.document.getElementById('dosubmit');form.click();return false;}, function(){window.top.art.dialog({id:'ieups'}).close()});
	}

    function wopen(){
       var l=(screen.availWidth-500)/2;
       var t=(screen.availHeight-300)/2;  		
		window.open ("ieup.php?canshu=<?php echo $_SESSION['userid']?>", "newwindow", "top="+t+",left="+l+",height=150, width=500, toolbar =no, menubar=no, scrollbars=no, resizable=no, location=yes, status=no") //写成一行
		}
//-->		
</script>
<div id="return_up" onclick="javascript:history.go(-1);"></div>
</body></html>



