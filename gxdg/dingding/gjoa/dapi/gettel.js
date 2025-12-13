
function tels_start(num){

var ulist = new Array();
 
for(i=0;i<num;i++){	
  if($("#telu"+i).attr("checked")){
	ulist[i]= $("#telu"+i).val(); 
	  }	  
}

if(ulist.length<1){
 alert("未指定通话对象")	
 return false;
	}

	
  dd.biz.telephone.call({
    users: ulist, 
    corpId: _config.corpId, 
    onSuccess : function() {
      //alert("ok");
    },
    onFail : function() {
      alert("ERR")
    }
  })
}

var mediaIds,durations,djtimeid;

function startRecord(){
	
//处理倒计时
js=1
djtimeid = setInterval(function(){if(js<=60){$("#https").attr("disabled","disabled");$("#https").val("录制音频("+js+"s)");js++}else{clearInterval(djtimeid);$("#https").removeAttr("disabled","");stopRecord();}}, 900);
	
dd.device.audio.startRecord({
    onSuccess : function () {//支持最长为60秒（包括）的音频录制
	 //alert("OK");
    },
    onFail : function (err) {
	 alert("no OK1"); 	
    }
});
	}
	


	
function stopRecord(){
clearInterval(djtimeid);
$("#https").val("录制音频");
$("#https").removeAttr("disabled","");	
	
dd.device.audio.stopRecord({
    onSuccess : function(res){
      //  res.mediaId; // 返回音频的MediaID，可用于本地播放和音频下载
      //  res.duration; // 返回音频的时长，单位：秒
	mediaIds=res.mediaId; 
	durations=res.duration; 
	//	alert(res.mediaId+","+res.duration);
	   translateVoice();	
    },
    onFail : function (err) {
		alert("no OK2"); 
    }
});	
	}	
	

function translateVoice(){
dd.device.audio.translateVoice({
    mediaId : mediaIds,
    duration : durations,
    onSuccess : function (res) {
      //  res.mediaId; // 转换的语音的mediaId
      $("#texts").html(res.content); // 语音转换的文字内容
    }
});	
}

function soundplay(){

//先下载到本地
dd.device.audio.download({
    mediaId : mediaIds,
    onSuccess : function(res) {
		//alert(mediaIds);
//回放
dd.device.audio.play({
    localAudioId : res.localAudioId,
 
    onSuccess : function () {
      alert(res.localAudioId);
    },
 
    onFail : function (err) {
	  alert("回放失败");	
    }
});	
//------
    },
    onFail : function (err) {
	 alert("没有音频资源");	
    }
});

}