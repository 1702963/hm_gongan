<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new','admin');
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
 

function xuan(){
	var uuu = document.getElementById("area").value;
	$.ajax({
             url : "?m=shenpi&c=renyuanshenpi&a=chafj", //后台查询验证的方法
             data :"fjid="+uuu, //携带的参数
             type : "get",
			 datatype : "json",
		async:'false',
             success : function(msg) {
                 //根据后台返回前台的msg给提示信息加HTML
				var obj = JSON.parse(msg); 
				//alert(obj.gwname);
                // $("#oldgangwei").append("<option value="+.obj.gwid.+">"+.obj.gwname.+"</option>");
				$("#oldgangwei").empty();
				$("#oldgangweifz").empty();
				 $("#oldgangwei").append("<option value='"+obj.gwid+"'>"+obj.gwname+"</option>");
				 $("#oldgangweifz").append("<option value='"+obj.fzid+"'>"+obj.fzname+"</option>");
             }
         });
	}


  
</script>


<style type="text/css">
.clear {clear:both}
.baseinfo {width:100%;border-left:2px solid #ccc;border-top:2px solid #ccc;border-right:2px solid #ccc;border-bottom:2px solid #ccc;margin:0 0 20px 20px;_display:inline}
.baseinfo td {border-bottom:1px solid #ccc;padding:10px 0;height:25px}
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
.tabcon {width:97%;padding-top:30px;position:relative;}
.tabcon .title {width:90px;height:30px;line-height:30px;text-align:center;background:#fff;position:absolute;top:15px;left:35px;font-size:16px;font-weight:900;color:#06c}
.basetext {width:1150px;height:90px;background:#fff;border:1px solid #ddd;float:left;margin-left:5px;overflow:hidden}
.lztext {width:1150px;height:60px;background:#fff;border:1px solid #ddd;float:left;margin-left:5px;overflow:hidden}
.dowhat {width:160px;height:40px;line-height:40px;border-radius:6px;background:#06c;color:#fff;text-align:center;position:absolute;left:50%;margin-left:-80px;top:0px}
.null {width:100%;height:10px}
.rb {border-right:1px solid #ddd}
.upa {float:left;margin-left:15px}
.upa img {width:18px;margin-right:10px;}
.upa a {font-size:14px}
</style>

 <form enctype="multipart/form-data" method="post" action="ajaxup.php" >
<input type="file" name="file" accept="image/*"   id="myfiles"  multiple style="display:none" onchange="xhrSubmit()">
 <input type="hidden" id="myid" />
</form> 
<form action="?m=shenpi&c=cizhishenpi&a=gwbd" method="POST" name="myform" id="myform" onsubmit="return check();">
<div class="tabcon" style="margin-top:-20px">
<div class="title">选择人员</div>
<table cellpadding="0" cellspacing="0" class="baseinfo" align="center" >
  <tr>
    <td width="181" align="right" class="infotitle" style="padding-left:20px">所在单位：</td>
    <td width="306"><select id="bmid" name="info[olddw]" style="height:30px" class="infotitle" >
                    
                      <option value="<?php echo $_SESSION['bmid'];?>"><?php echo $bumens[$_SESSION['bmid']];?></option>
                    
                    </select>
                    </td>
    <td width="62" align="right" class="infotitle">姓名：</td>
    <td width="254"><?php echo form::select($fujing,'','name=info[fjid] id=area class=select2 onchange=xuan() ')?>
       
    </td>
    <td width="700" align="left" id="selmsg" style="padding-left:5px; color:red">&nbsp;</td>
    </tr>
  
</table>
</div>

<div class="clear"></div>

<div class="clear"></div>

<div class="tabcon">
<div class="title">申请详情</div>
<table cellpadding="0" cellspacing="0" class="baseinfo">

  <tr>
    <td width="13%" align="right" class="infotitle" style="padding-left:20px;border-bottom:0px">原岗位：</td>
    <td width="87%" align="left"  style="border-bottom:0px"> <select name="info[oldgangwei]" id="oldgangwei" class="infoinput" style="height:30px"></select>
					 &nbsp; 辅助岗位 <select name="info[oldgangweifz]" class="infoinput" id="oldgangweifz" style="height:30px"></select></td>
  </tr>
  
  <tr>
    <td align="right" class="infotitle" style="padding-left:20px;border-bottom:0px">离职原因：</td>
    <td align="left" class="infotitle" style="border-bottom:0px"><textarea name="info[content]" style="width:90%; height:100px" class="infoinput"></textarea></td>
  </tr>
  <tr>
    <td align="right" class="infotitle" style="padding-left:20px;border-bottom:0px">文件图片：</td>
    <td align="left" class="infotitle" style="border-bottom:0px">
	  <input type="hidden" id="con1" name="info[fj]"  />

    <div >
       
		<div style="float:left; height:100px;" id="show1"></div>
        <div style="float:left; width:100px; height:100px;" onclick="mycilck(1)">选择图片</div>
    </div>	</td>
  </tr>
   <tr>
    <td align="right" class="infotitle" style="padding-left:20px;border-bottom:0px">审批领导：</td>
    <td align="left" class="infotitle" style="border-bottom:0px"><?php echo form::select($ld,'','name=info[bmshid]  id=ld ')?></td>
  </tr>
</table>
</div>

<div class="tabcon">
	<input type="submit" class="dowhat" name="dosubmit" value="发起申请" />
</div>
</form>
<div class="clear"></div>
<div class="null"></div>
</div>

</body></html>
<script>
function check(){
var fjid=$('#area option:selected').val();
if(fjid==0){
alert('请选择辅警');
return false;
}
}

function xhrSubmit() {  //原生

   for(pnx=0;pnx<document.getElementById('myfiles').files.length;pnx++){  	   
            var file_obj = document.getElementById('myfiles').files[pnx];
			var callbackid=document.getElementById('myid').value;
	//压缩过程
var rpic = new FileReader();
 var mpic = new Image();
 rpic.readAsDataURL(file_obj);
 //rpic.readAsBinaryString(obj.files[0]); 二进制不能加载到IMG？
 rpic.onload=function(){
   mpic.src=this.result
    mpic.onload=function(){
		  var canvas = document.createElement('canvas');
          var ctx = canvas.getContext('2d');
          var w = 0;
          var h = 0;
          if (this.width > this.height) {
            h = 1000;
            var scale = this.width / this.height;
            h = h > this.height ? this.height : h;
            w = h * scale;
          }
          else {
            w = 1000;
            var scale = this.width / this.height;
            w = w > this.width ? this.width : w
            h = w / scale;
          }
          var anw = document.createAttribute("width");
          var anh = document.createAttribute("height");
          if (this.width > this.height) {
            anw.value = h;
            anh.value = w;
          }
          else {
            anw.value = w;
            anh.value = h;
          }
          canvas.setAttributeNode(anw);
          canvas.setAttributeNode(anh);
          if (this.width > this.height) {
            ctx.translate(h, 0);
            ctx.rotate(90 * Math.PI / 180)
            ctx.drawImage(this, 0, 0, w, h);
            ctx.restore();
          }
          else {
            ctx.drawImage(this, 0, 0, w, h);
          }
          dataURL = canvas.toDataURL('image/jpeg'); //b64  DataURL
		  canvas.toBlob(function (bval){ // Blob二进制
		  // ajax
			   var infile = new FormData();
			   infile.append('file',bval,"image.jpg")
               into = new XMLHttpRequest(); //这个声明HTTPXML对象的方法有浏览器兼容问题，这里只考虑微信核心，不必顾及其他浏览器
               into.open('POST', 'ajaxup.php', false)
               into.send(infile);
			   if(into.readyState == 4){
				var intoobj = JSON.parse(into.responseText);
				  if(intoobj.error==0){
				 sjid= Math.floor(Math.random() * (100 - 1 + 1) + 1); //产生一个1到100的随机数作为IMG的ID，供删除用
				if(document.getElementById('con'+callbackid).value==''){
				  document.getElementById('con'+callbackid).value=intoobj.pic;
				 }else{
				  document.getElementById('con'+callbackid).value+="|"+intoobj.pic;
				 }
				document.getElementById('show'+callbackid).innerHTML+="<div class='proof_pic'  id="+callbackid+"_"+intoobj.pic+"><img src="+intoobj.pic+"  onclick=\"delme('"+callbackid+"_"+intoobj.pic+"')\"></div>";
					  }else{
				  alert(obj.error) //此处可以用弹出层
						  }
					  }		  
		  	  // ajax end
			  },"image/jpeg", 0.95)
		 //console.log(dataURL)
		}
      
 }			
	//压缩过程结束		
     /*       var fd = new FormData();
            fd.append('file',file_obj); //第一个参数是后端接收$_FILES数组的名字 $_FILES['file']['name'] ，前后端变量名需要一致
            xhr = new XMLHttpRequest(); //这个声明HTTPXML对象的方法有浏览器兼容问题，这里只考虑微信核心，不必顾及其他浏览器
            xhr.open('POST', 'ajax.php', false)
            xhr.send(fd);			
           // xhr.onreadystatechange = function () { //多文件上传时不能异步
            if(xhr.readyState == 4){
             var obj = JSON.parse(xhr.responseText);
			 if(obj.error=="0"){ //拦截远端回调对象判断上传是否成功	 
				 sjid= Math.floor(Math.random() * (100 - 1 + 1) + 1); //产生一个1到100的随机数作为IMG的ID，供删除用
				 document.getElementById('con'+callbackid).value=obj.pic;
				 document.getElementById('show'+callbackid).innerHTML="<img src="+obj.pic+"  id="+callbackid+"_"+obj.pic+"   onclick=\"delme('"+callbackid+"_"+obj.pic+"')\">";
               }//返回串判断结束
			 }else{
			  alert(obj.error);	 //想用层显示提示就在这里开启层 输出信息
				 }//readyState结束
		   //onreadystatechange结束	};  */

          }// for 结束
        } // function 结束
		

function mycilck(objid){
	document.getElementById('myid').value=objid;
	document.getElementById('myfiles').click();
	}
	
function delme(obj){ 
if(confirm("确认删除当前附件吗？")){ 

	document.getElementById('show'+obj.split('_')[0]).removeChild(document.getElementById(obj));

	var oldpic=document.getElementById('con'+obj.split('_')[0]).value;
	var arr = oldpic.split("|");
	
	var pic=obj.split('_')[1];
	 Array.prototype.indexOf = function(val) { 
for (var i = 0; i < this.length; i++) { 
if (this[i] == val) return i; 
} 
return -1; 
};
Array.prototype.remove = function(val) { 
var index = this.indexOf(val); 
if (index > -1) { 
this.splice(index, 1); 
} 
};
	 arr.remove(pic);
	
	document.getElementById('con'+obj.split('_')[0]).value=arr.join('|'); //回写	
	
	}
}
</script>