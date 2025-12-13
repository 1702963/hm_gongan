<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new','admin');

		$this->db->table_name = 'v9_admin';
		$rss = $this->db->select("isbmuser=1",'userid,username','','userid asc');
		foreach($rss as $v){
			$lingdao[$v['userid']]=$v['username'];
			}

       if($_POST['dosubmit']!=""){
		  // print_r($_POST);
          $_indt=time();
          $_ns=date("Y",$_indt);
          $_ms=date("m",$_indt);
          $_ds=date("d",$_indt);
          $_tjdt=strtotime(date("Y-m-d",$_indt));

          $this->db->table_name = 'v9_renshi_xiujia';
          $_POST['xiu']['indt']=$_indt;
          $_POST['xiu']['ns']=$_ns;
          $_POST['xiu']['ms']=$_ms;
          $_POST['xiu']['ds']=$_ds;
          $_POST['xiu']['tjdt']=$_tjdt;
          $newid=$this->db->insert($_POST['xiu'],true);

            showmessage('操作完成','index.php?m=renshi&c=xiujia&a=init');
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
<form action="?m=renshi&c=xiujia&a=addxiu" method="POST" name="myform" id="myform">


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

<div class="tableContent">

<div class="tabcon">
<div class="title">休假申请</div>

<table width="1802" align="center" cellpadding="0" cellspacing="0" class="baseinfo" style="width:1675px">
  <tr>
    <td width="358" align="center" class="infotitle">申请人</td>
    <td width="358" align="center" class="infotitle">所属单位</td>
    <td width="113" align="center" class="infotitle">申请类型</td>
    <td width="108" align="center" class="infotitle">申请时间</td>
    <td width="301" align="center" class="infotitle">申请事由</td>
    <td width="194" align="center" class="infotitle">审批领导</td>
    <td width="241" align="center" class="infotitle">其他备注</td>    
    </tr>

  <tr>
    <td width="358" align="center" class="infotitle"><input type="text" name="xiu[xingming]" id="xingming" class="input-text" value="" style="width:200px"/>
        <div id="inputlist">
        <ul>
        </ul>
        </div>
        <input type="hidden" name="xiu[uid]" id="uid" /> <input type="hidden" name="xiu[dwid]" id="dwid" />
    </td>
    <td width="358" align="center" class="infotitle"><input type="text" name="xiu[danwei]" id="danwei" class="input-text" value="" style="width:200px"/></td>
    <td width="113" align="center" class="infotitle"><select name="xiu[leixing]">
                                                       <option value="事假">事假</option>
                                                       <option value="病假">病假</option>
                                                       <option value="婚假">婚假</option>
                                                       <option value="产假">产假</option>
                                                       <option value="丧假">丧假</option>
                                                       <option value="其他">其他</option>
                                                     </select></td>
    <td width="108" align="center" class="infotitle"> <?php echo form::date('xiu[qtime1]',date("Y-m-d H:i:s",time()),1,0,'true');?>
                    至
                    <?php echo form::date('xiu[qtime2]',date("Y-m-d H:i:s",time()),1,0,'true');?></td>
    <td width="301" align="center" class="infotitle"><input type="text" name="xiu[shiyou]" class="input-text" value="<?php echo $sarr[$v['id']]['beizhu']?>"/></td>
    <td width="194" align="center" class="infotitle"><select name="xiu[shuid]">
                                                      <?php foreach($lingdao as $k=>$v){ ?>
                                                       <option value="<?php echo $k?>"><?php echo $v?></option>
                                                       <?php }?>
                                                     </select>
    </td>
    <td width="241" align="center" class="infotitle"><input type="text" name="xiu[beizhu]" class="input-text" value="<?php echo $sarr[$v['id']]['beizhu']?>"/></td>    
    </tr>  

  </table>
</div>

<!--<div class="clear"></div>

<div class="tabcon">
<div class="title">参保类型</div>
<table cellpadding="0" cellspacing="0" class="baseinfo">
  <tr>
    <td width="90" align="right" class="infotitle">参保类型：</td>
    <td width="870">
        <input type="checkbox" class="rad" checked />失业保险
        <input type="checkbox" class="rad" checked />医疗保险
        <input type="checkbox" class="rad" checked />工伤保险
        <input type="checkbox" class="rad" checked />养老保险
        <input type="checkbox" class="rad" checked />生育保险
    </td>
  </tr>

</table>
</div>-->


<div class="clear"></div>

<div class="tabcon"></div>

<div class="clear"></div>

<div class="tabcon">
<input type="hidden" name="id" value="<?php echo $fujing['id'];?>" />
	<input type="submit" class="dowhat" name="dosubmit" value="提交申请" />
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
	
 $(function(){
        $("#xingming").bind("keyup click",function(){
          var t=$(this),_html="";
         /*
		  window.baidu= {};
          window.baidu.sug = function(data){
            var x = JSON.stringify(data);
            x=JSON.parse(x); 
            var abc = x.s;
            for(var i=0; i<abc.length; i++){
              _html+="<li>"+abc[i]+"</li>";
            }
            $("#inputlist ul").html(_html);
            if(t.val() == ""){
              $("#inputlist").hide();
            }else{
              $("#inputlist").show();
              }
            if($("#inputlist").html() == ""){
              $("#inputlist").hide();
            }
                }; */
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
              _html+="<li id="+x.data[i].id+" xm="+x.data[i].xingming+" sfz="+x.data[i].sfz+" sex="+x.data[i].sex+" zzmm="+x.data[i].zzmmname+" hj="+x.data[i].hjdizhi+" mz="+x.data[i].minzu+" dw="+x.data[i].danwei+" dwid="+x.data[i].dwid+" zw="+x.data[i].zhiwuname+" zj="+x.data[i].cengjiname+">"+x.data[i][0]+"["+x.data[i].sex+","+x.data[i].shenfen+"，"+x.data[i].danwei+"]</li>";
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
		  if($(this).attr('sex')=="男"){
			  $("#nan").attr("checked","checked");
			  }else{
				$("#nv").attr("checked","checked");  
				  }      
         $("#sfz").val($(this).attr('sfz'))
		 $("#zzmm").val($(this).attr('zzmm'))
         $("#hjdizhi").val($(this).attr('hj'))
		 $("#minzu").val($(this).attr('mz'))
		 $("#danwei").val($(this).attr('dw'))
		 $("#dwid").val($(this).attr('dwid'))
		 $("#zhiwu").val($(this).attr('zw'))
		 $("#zhiji").val($(this).attr('zj'))		  		  
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

<div id="return_up" onclick="javascript:history.go(-1);"></div>
</body></html>



