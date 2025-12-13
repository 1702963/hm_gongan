/**
 * Created by liqiao on 8/10/15.
 */

//logger.i('JAPI LOADING');

//logger.i(location.href);

/**
 * _config comes from server-side template. see views/index.jade
 */
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
dd.userid=0;
dd.ready(function() {

alert("oks")

/*  这是什么接口？为啥JAPI目录里没有？

    dd.runtime.info({
        onSuccess: function(info) {
            logger.i('runtime info: ' + JSON.stringify(info));
        },
        onFail: function(err) {
            logger.i('fail: ' + JSON.stringify(err));
        }
    });
*/

		//	alert("此处触发前端授权事件");	
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
                  //alert(data)
				  //logger.i(data);
                    if(typeof data == 'string'){
                         info = JSON.parse(data);
                    }

                    if (info.errcode === 0) {
                       // logger.i('user id: ' + info.userid);
					   //logger.i('user name: ' + info.name);
						//document.getElementById("uid").innerText='user id:'+info.userid
						//document.getElementById("uname").innerText='user name:'+info.name
						 $("#uid").html('user id:'+info.userid);
						 $("#uname").html('user name:'+info.name);
						 
                        dd.userid = info.userid;
                    }
                    else {
                        logger.e('auth error: ' + data);
                    }
                },
                error: function (xhr, errorType, error) {
                    logger.e(errorType + ', ' + error);
                }
            });
        },
        onFail: function (err) {
            logger.e('requestAuthCode fail: ' + JSON.stringify(err));
        }
    });

    $('.chooseonebtn').on('click', function() {

        dd.biz.chat.pickConversation({
            corpId: _config.corpId, //企业id
            isConfirm:'false', //是否弹出确认窗口，默认为true
            onSuccess: function (data) {
                var chatinfo = data;
                if(chatinfo){
                console.log(chatinfo.cid);
                    dd.device.notification.prompt({
                        message: "发送消息",
                        title: chatinfo.title,
                        buttonLabels: ['发送', '取消'],
                        onSuccess : function(result) {
                            var text = result.value;
                            if(text==''){
                                return false;
                            }

                            $.ajax({
                                url: '/sdk/sendMsg.php',
                                type:"POST",
                                data: {"event":"send_to_conversation","cid":chatinfo.cid,"sender":dd.userid,"content":text,"corpId":_config.corpId},
                                dataType:'json',
                                timeout: 900,
                                success: function (data, status, xhr) {
                                    var info = data;
                                    if(typeof data == 'string'){
                                        info = JSON.parse(data);
                                    }
                                    logger.i('sendMsg: ' + JSON.stringify(data));
                                    if(info.errcode==0){
                                        logger.i('sendMsg: 发送成功');
                                        /**
                                         * 跳转到对话界面
                                         */
                                        dd.biz.chat.open({
                                            cid:chatinfo.cid,
                                            onSuccess : function(result) {
                                            },
                                            onFail : function(err) {}
                                        });
                                    }else{
                                        logger.e('sendMsg: 发送失败'+info.errmsg);
                                    }
                                },
                                error: function (xhr, errorType, error) {
                                    logger.e(errorType + ', ' + error);
                                }
                            });
                        },
                        onFail : function(err) {}
                    });
                }
            },
            onFail: function (err) {
            }
        });
    });

    $('.phonecall').on('click', function() {
        dd.biz.contact.choose({
            startWithDepartmentId: 0, //-1表示打开的通讯录从自己所在部门开始展示, 0表示从企业最上层开始，(其他数字表示从该部门开始:暂时不支持)
            multiple: false, //是否多选： true多选 false单选； 默认true
            users: [], //默认选中的用户列表，userid；成功回调中应包含该信息
            corpId: _config.corpId, //企业id
            max: 10, //人数限制，当multiple为true才生效，可选范围1-1500
            onSuccess: function(data) {
                if(data&&data.length>0){
                    var selectUserId = data[0].emplId;
                    if(selectUserId>0){
                        dd.biz.telephone.call({
                            users: [selectUserId], //用户列表，工号
                            corpId: _config.corpId, //企业id
                            onSuccess : function(info) {
                                logger.i('biz.telephone.call: info' + JSON.stringify(info));

                            },
                            onFail : function(err) {
                                logger.e('biz.telephone.call: error' + JSON.stringify(err));
                            }
                        })
                    }else{
                        return false;
                    }
                }else{
                    return false;
                }
        },
        onFail : function(err) {}
    });
    });
});

dd.error(function(err) {
    logger.e('dd error: ' + JSON.stringify(err));
});
