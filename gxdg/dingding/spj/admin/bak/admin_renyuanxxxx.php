<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

      <script src="https://g.alicdn.com/code/npm/@ali/dingtalk-h5-remote-debug-sdk/0.1.1/app.bundle.js"></script>
      <script>
        h5RemoteDebugSdk.init({
          uuid: "719c5e52-24f6-40ef-99ae-67ba4eb9ef69",
          observerElement: document.documentElement,
        });
      </script>
    
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>无标题文档</title>
</head>

<body>
<script type="text/javascript" src="../sdk/jquery-1.10.2.js"></script>
<script src="https://g.alicdn.com/dingding/dingtalk-jsapi/2.10.3/dingtalk.open.js"></script>

   <script language="javascript">

	dd.ready(function() {	
    dd.runtime.permission.requestAuthCode({
        corpId: "ding479ff0f07c5cca1cf2c783f7214b6d69",
        onSuccess: function(result) {
        var code = result.code;	   
		    alert(result)  
				   
        },
        onFail : function(err) {
		alert("error: " + JSON.stringify(err));
		}
  
    });

dd.error(function(error){
       /**
        {
           errorMessage:"错误信息",// errorMessage 信息会展示出钉钉服务端生成签名使用的参数，请和您生成签名的参数作对比，找出错误的参数
           errorCode: "错误码"
        }
       **/
       alert('dd error: ' + JSON.stringify(error));
});

//////////////////////////
});   
   </script>  
</body>
</html>