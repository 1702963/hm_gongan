
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
        'biz.ding.post']
});

dd.ready(function() {

//alert("j5")
	
    dd.runtime.permission.requestAuthCode({	
        corpId: _config.corpId, //企业id		
        onSuccess: function (info) {
			//logger.i(info.code) //获取临时授权码authCode
            $.ajax({
                url: 'dapi/getuser.php',
                type:"POST",
                data: {"event":"get_userinfo","code":info.code,"corpId":_config.corpId,"access_token":_config.access_token},
                dataType:'json',
                timeout: 900,
                success: function (data, status, xhr) {
                    var info = data;

                    if(typeof data == 'string'){
                         info = JSON.parse(data);
                    }

                    if (info.errcode === 0) {

						 $("#uid").html('user id:'+info.userid);
						 $("#uname").html('user name:'+info.name);
						 
                        dd.userid = info.userid;
                    }
                    else {
                        alert('auth error: ' + data);
                    }
                },
                error: function (xhr, errorType, error) {
                    alert(errorType + ', ' + error);
                }
            });
        },
        onFail: function (err) {
            alert('requestAuthCode fail: ' + JSON.stringify(err));
        }
    });
	
});

dd.error(function(err) {
    logger.e('dd error: ' + JSON.stringify(err));
});
