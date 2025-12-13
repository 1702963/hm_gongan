
dd.config({
    agentId: _config.agentId,
    corpId: _config.corpId,
    timeStamp: _config.timeStamp,
    nonceStr: _config.nonceStr,
    signature: _config.signature,
    jsApiList: [
        'runtime.info',
        'device.notification.prompt',
        'biz.chat.pickConversation',
        'device.notification.confirm',
        'device.notification.alert',
        'device.notification.prompt',
        'biz.chat.open',
        'biz.util.open',
        'biz.user.get',
        'biz.contact.choose',
        'biz.telephone.call',
        'biz.util.uploadImage',
        'biz.ding.post',
		'biz.map.view',
		'biz.telephone.call',
		'device.audio.startRecord',
		'device.audio.stopRecord',
		'device.audio.translateVoice',
		'device.audio.download',
		'device.audio.play',
		'device.geolocation.get',
		'device.geolocation.start',
		'device.geolocation.stop']
});

dd.ready(function() {

    dd.runtime.permission.requestAuthCode({	
        corpId: _config.corpId, //企业id		
        onSuccess: function (info) {
			//alert(info.code) //获取临时授权码authCode
            $.ajax({
                url: 'dapi/getuser.php',
                type:"POST",
                data: {"event":"get_userinfo","code":info.code,"corpId":_config.corpId,"access_token":_config.access_token},
                dataType:'json', 
                timeout: 2900,
                success: function (data, status, xhr) {
					
                    var info = data;

                    if(typeof data == 'string'){
                         info = JSON.parse(data);
                    }
					                  
				   //$("#callb").html(data) 
				   
                    if (info.errcode === 0) {
				        myqx=info.quanxian.split(",")
	
                        if(myqx[0]==1){ //鉴权过程
						  $("#htlist").show();
						}else{
						 // if(info.isAdmin){	
						 //   $("#htlist").show();
						 // }else{
							//$("#nouser").html(info.name +"权限不足") 
							$("#chk").show();	
						 //	  }
							}
						 $("#uname").html('user name:'+info.name);
                        dd.userid = info.userid;
						//alert(dd.userid);
						//clist(0)
                    }
                    else {
                        alert('auth error: ' + data);
                    }
                },
                error: function (xhr, errorType, error) {
                    alert(errorType + ', ' + "数据接口调用失败");
                }
            });
        },
        onFail: function (err) {
            alert('requestAuthCode fail: ' + JSON.stringify(err));
        }
    });
	
});

dd.error(function(err) {
 //   logger.e('dd error: ' + JSON.stringify(err));
});

dd.device.base.getPhoneInfo({
    onSuccess : function(data) {
		$("#box2").css("display","none") //关闭层
		$("#a2").attr("onpc","0")
        /*
        {
            screenWidth: 1080, // 手机屏幕宽度
            screenHeight: 1920, // 手机屏幕高度
            brand:'Mi'， // 手机品牌
            model:'Note4', // 手机型号
            version:'7.0'. // 版本
            netInfo:'wifi' , // 网络类型 wifi／4g／3g 
            operatorType :'xx' // 运营商信息
        }
        */
    },
    onFail : function(err) {
		$("#a2").attr("onpc","0") //不管能不能获取手机信息
		}
});

function callme(oid){
  //如果是管理按钮
/*  if(oid==2){
	if($("#a2").attr("onpc")==0){
		dd.device.notification.alert({
           message: "管理功能只能运行在PC端",
           title: "提示",//可传空
           buttonName: "我明白了",
           onSuccess : function() {  
          //onSuccess将在点击button之后回调
          },
           onFail : function(err) {}
          });
		 return false  
		}else{ */
		getzuzhi(1)	
		sysuser()
			//}  
	 // } 		
  if($("#box"+oid).css("display")!='none'){
	  $("#box"+oid).css("display","none")
	    if($("#lists").css("display")=='none'){
			$("#lists").css("display","")
			$("#pages").css("display","")
			}				
	  }else{
      for(i=1;i<=4;i++){ //先关闭全部层
	  $("#box"+i).css("display","none")
	  }		  
	  $("#box"+oid).css("display","")
	   if(oid!=1){
		   $("#lists").css("display","none")
		   $("#pages").css("display","none")
		   }else{
		   $("#lists").css("display","")
		   $("#pages").css("display","")			   
			   }
		  }	
	}
	
function openme(oid){
  if($("#xiang"+oid).css("display")!='none'){
	  $("#"+oid).html("展开详情 ︾")
	  $("#xiang"+oid).css("display","none")
	  }else{
	  $("#"+oid).html("收起详情 ︽")	  
	  $("#xiang"+oid).css("display","")  
		  }	
	}	
	
function clist(offz){
	page=$("#page").text()
	title=$("#title").val()
	leixing=$("#leixing").val()
	bianh=$("#bianh").val()
	    
	        $.ajax({
                url: 'dapi/getlist.php',
                type:"POST",
                //data: {"page":page,"offz":offz},
				data: {"page":page,"offz":offz,"title":title,"leixing":leixing,"bianh":bianh},
                dataType:'html',
                timeout: 2900,
                success: function (data, status, xhr) {
                // alert(data)
                    var info = data;
                    if(typeof data == 'string'){
                         info = JSON.parse(data);
                    }     
                    if (info.error === 0) {
					if((title!="" ||leixing!="0" || bianh!="")&& info.nowpage==1 ){	
						$("#lists").html(info.lists);
					}else{
						$("#lists").html($("#lists").html()+info.lists);
						}
						$("#allnum").html(info.num +"条")
						$("#page").html(info.nowpage)
						$("#more").attr("zpage",info.zpage)
						if($("#more").attr("zpage")==$("#page").html()){
							$("#more").hide()
							}else{
							$("#more").show()	
								}
                    }
                    else {
                        alert('auth error: ' + data);
                    }
                },
                error: function (xhr, errorType, error) {
                    alert(errorType + ', ' + "getlist请求超时");
                }
            });	
	}	
	
function slist(offz){
	page=$("#page").text()
	title=$("#title").text()
	leixing=$("#leixing").text()
	bianh=$("#bianh").text()
	
            $.ajax({
                url: 'dapi/getlist.php',
                type:"POST",
                data: {"page":page,"offz":offz,"title":title,"leixing":leixing,"bianh":bianh},
                dataType:'html',
                timeout: 2900,
                success: function (data, status, xhr) {
                 //alert(data)
                    var info = data;
                    if(typeof data == 'string'){
                         info = JSON.parse(data);
                    }

                    if (info.error === 0) {
						
						$("#lists").html($("#lists").html()+info.lists);
						$("#allnum").html(info.num +"条")
						$("#page").html(info.nowpage)
                    }
                    else {
                        alert('auth error: ' + data);
                    }
                },
                error: function (xhr, errorType, error) {
                    alert(errorType + ', ' + error);
                }
            });	
	}	
	
function getzuzhi(subid){

            $.ajax({
                url: 'dapi/getzuzhi.php',
                type:"POST",
                data: {"subid":subid},
                dataType:'html',
                timeout: 2900,
                success: function (data, status, xhr) {
              //   $("#box2").html(data)
                    var info = data;
                    if(typeof data == 'string'){
                         info = JSON.parse(data);
                    }

                    if (info.errcode === 0) {
						$("#zuzhi").html(info.lists);
                    }
                    else {
                        alert('auth error: ' + data);
                    }
                },
                error: function (xhr, errorType, error) {
                    alert(errorType + ', ' + "getzuzhi访问接口失败");
                }
            });	
	}	
	
function subuser(zid){
            $.ajax({
                url: 'dapi/getuser.php',
                type:"POST",
                data: {"event":"get_userlist","department_id":zid,"corpId":_config.corpId,"access_token":_config.access_token},
                dataType:'json',
                timeout: 2900,
                success: function (data, status, xhr) {
                
				//$("#zuzhi2").html(data)
                    var info = data;
                    if(typeof data == 'string'){
                         info = JSON.parse(data);
                    }

                    if (info.errcode === 0) {
						lists=""
						for(i=0;i<info.userlist.length;i++){
						  lists+="<li id=\""+info.userlist[i]['userid']+"\" style=\"list-style:none;margin-left:10px;font-size:16px\" onclick=\"addme('"+info.userlist[i]['userid']+"')\" >"+info.userlist[i]['name']+"</li>"
						}
						if(lists==''){lists='无成员'}
										 
						$("#zuzhi2").html(lists);
                    }
                    else {
                        alert('auth error: ' + data);
                    }
                },
                error: function (xhr, errorType, error) {
                    alert(errorType + ', ' + "getuser访问接口失败");
                }
            });	
	}	
	
function addme(uid){
	name=$("#"+uid).html()
	//alert(name)
            $.ajax({
                url: 'dapi/douser.php',
                type:"POST",
                data: {"event":"add","uid":uid,"name":name},
                dataType:'html',
                timeout: 2900,
                success: function (data, status, xhr) {
                
				// $("#zuzhi2").html(data)
			//alert(data)	 
                    var info = data;
                    if(typeof data == 'string'){
                         info = JSON.parse(data);
                    }

                    if (info.errorcode === 0) {
						lists=""
						for(i=0;i<info.userlist.length;i++){
						  lists+="<li id=\""+info.userlist[i]['uid']+"\" style=\"list-style:none;margin-left:10px;font-size:16px\" onclick=\"delme('"+info.userlist[i]['uid']+"')\" >"+info.userlist[i]['name']+" &nbsp; 删除</li>"
						}
						if(lists==''){lists='无成员'}
						$("#yonghu").html(lists);
                    }
                    else {
                        alert('auth error: ' + data);
                    }
                },
                error: function (xhr, errorType, error) {
                    alert(errorType + ', ' + "douseradd访问接口失败");
                }
            });	
	}		
	
	
function delme(uid){
	//alert($("#"+uid).text())
            $.ajax({
                url: 'dapi/douser.php',
                type:"POST",
                data: {"event":"del","uid":uid,"name":name},
                dataType:'html',
                timeout: 2900,
                success: function (data, status, xhr) {
   				 
                    var info = data;
                    if(typeof data == 'string'){
                         info = JSON.parse(data);
                    }

                    if (info.errorcode === 0) {
						lists=""
						for(i=0;i<info.userlist.length;i++){
						  lists+="<li id=\""+info.userlist[i]['uid']+"\" style=\"list-style:none;margin-left:10px;font-size:16px\" onclick=\"delme('"+info.userlist[i]['uid']+"')\" >"+info.userlist[i]['name']+" &nbsp; 删除</li>"
						}
						if(lists==''){lists='无成员'}
						$("#yonghu").html(lists);
                    }
                    else {
                        alert('auth error: ' + data);
                    }
                },
                error: function (xhr, errorType, error) {
                    alert(errorType + ', ' + "douserdel访问接口失败");
                }
            });	
	}	
	
function sysuser(){

            $.ajax({
                url: 'dapi/douser.php',
                type:"POST",
                data: {"event":"alllist"},
                dataType:'html',
                timeout: 2900,
                success: function (data, status, xhr) {
				//alert(data) 
                    var info = data;
                    if(typeof data == 'string'){
                         info = JSON.parse(data);
                    }

                    if (info.errorcode === 0) {
						lists=""
						for(i=0;i<info.userlist.length;i++){
						  lists+="<li id=\""+info.userlist[i]['userid']+"\" style=\"list-style:none;margin-left:10px;font-size:16px\" onclick=\"delme('"+info.userlist[i]['userid']+"')\" >"+info.userlist[i]['name']+" &nbsp; 删除</li>"
						}
						if(lists==''){lists='无成员'}
						$("#yonghu").html(lists);
                    }
                    else {
                        alert('auth error: ' + data);
                    }
                },
                error: function (xhr, errorType, error) {
                    alert(errorType + ', ' + "alllist访问接口失败");
                }
            });	
	}		
	
function canin(){

            $.ajax({
                url: 'dapi/getuser.php',
                type:"POST",
                data: {"event":"get_userinfo"},
                dataType:'html',
                timeout: 2900,
                success: function (data, status, xhr) {
				//alert(data) 
                    var info = data;
                    if(typeof data == 'string'){
                         info = JSON.parse(data);
                    }

                    if (info.errorcode === 0) {
						lists=""
						for(i=0;i<info.userlist.length;i++){
						  lists+="<li id=\""+info.userlist[i]['userid']+"\" style=\"list-style:none;margin-left:10px;font-size:16px\" onclick=\"delme('"+info.userlist[i]['userid']+"')\" >"+info.userlist[i]['name']+" &nbsp; 删除</li>"
						}
						if(lists==''){lists='无成员'}
						$("#yonghu").html(lists);
                    }
                    else {
                        alert('auth error: ' + data);
                    }
                },
                error: function (xhr, errorType, error) {
                    alert(errorType + ', ' + "getuser访问接口失败");
                }
            });	
	}	


function showpics(aid){  //图片查看器

var pics = new Array()

for(i=0;i<=$("#pics"+aid).children().length-1;i++){
	//pics[i]='"'+$("#pics"+aid).children().eq(i).attr("src")+'"'
	pics[i]=$("#pics"+aid).children().eq(i).attr("src")
	}

   dd.biz.util.previewImage({
    urls:pics, //卧槽！ 你直接说传入数组行不
    current: pics[0],
    onSuccess : function(result) {
      // alert("y")
    },
    onFail : function(err) {
	 alert("无法解析附件结构")	
		}
  })
}	


function mymap(){
  dd.biz.map.view({
    latitude: 39.625132, // 纬度,
    longitude:  118.173376, // 经度
    title: "唐山市" // 地址/POI名称
  });	
	}
	
function dingwei(){ //单次定位
dd.device.geolocation.get({
    targetAccuracy : 200,
    coordinate : 1,
    withReGeocode : true,
    useCache:false, //默认是true，如果需要频繁获取地理位置，请设置false
    onSuccess : function(result) {
	   alert(dd.userid+"->"+result.longitude)	
        /* 高德坐标 result 结构
        {
            longitude : Number,
            latitude : Number,
            accuracy : Number,
            address : String,
            province : String,
            city : String,
            district : String,
            road : String,
            netType : String,
            operatorType : String,
            errorMessage : String,
            errorCode : Number,
            isWifiEnabled : Boolean,
            isGpsEnabled : Boolean,
            isFromMock : Boolean,
            provider : wifi|lbs|gps,
            isMobileEnabled : Boolean
        }
        */
    },
    onFail : function(err) {}
});	
	}	
	
function dingwei_lx_start(){ //连续定位开始

$("#dings").attr("disabled","disabled") //关闭按钮

dd.device.geolocation.start({
    targetAccuracy : 10, // 期望精确度
    iOSDistanceFilter: 10, // 变更感知精度(iOS端参数)
    useCache: false, // 是否使用缓存(Android端参数)
    withReGeocode : true, // 是否返回逆地理信息,默认否
    callBackInterval : 10000, //回传时间间隔，ms
    sceneId: '0', // 定位场景id,
    onSuccess : function(result) {

            $.ajax({
                url: 'dapi/savegps.php',
                type:"POST",
                data: {"longitude":result.longitude,"uid":dd.userid,"latitude":result.latitude,"accuracy":result.accuracy,"address":result.address,"netType":result.netType},
                dataType:'html',
                timeout: 2900,
                success: function (data, status, xhr) { 
                    var info = data;
                    if(typeof data == 'string'){
                         info = JSON.parse(data);
                    }

                    if (info.errorcode === 0) {
						if(result.longitude!=undefined){
						reli="<li style=\"list-style:none;margin-left:10px;font-size:16px\" >"+result.longitude+","+result.latitude+"["+result.address+"]</li>"
						$("#gpss").html(reli+$("#gpss").html());
						}
                    }else {
                     //   alert('auth error: ' + "错误的返回结构");
                    }
                },
                error: function (xhr, errorType, error) {
                   //  alert(errorType + ', ' + "访问接口失败");
                }
            });	
    },
    onFail : function(err) {
		es=JSON.stringify(err)
		alert(es)
		}
});	
	}	
	
function dingwei_lx_stop(){ //连续定位结束

$("#dings").removeAttr("disabled")
getgui()

  dd.device.geolocation.stop({
    sceneId: "0", // 需要停止定位场景id
    onSuccess : function(result) {
        //sceneId: String // 停止的定位场景id，或者null
    },
    onFail : function(err) {

		}
  });
   }	