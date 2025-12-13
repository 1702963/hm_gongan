    var mypath,marker, lineArr ,offtime; 

//先拉出空白中心点

    var map = new AMap.Map('container', {
      resizeEnable: true, //是否监控地图容器尺寸变化
      zoom: 13, //初始地图级别
      center: [118.171488,39.624846], //初始地图中心点
      showIndoorMap: false //关闭室内地图
    });

//进行转换
function getgui(uid){

suid=$("#suid").val();
sdata=$("#sdata").val();
sdt=$("#sdt").val();
edt=$("#edt").val();

//此处拉出轨迹坐标
            $.ajax({
                url: 'dapi/getgps.php',
				async: false, //这里需要用同步模式，防止坐标集还没有完成返回就开始进行轨迹渲染
                type:"POST",
                data: {"uid":suid,"sdata":sdata,"sdt":sdt,"edt":edt},
                dataType:'html',
                timeout: 1900,
                success: function (data, status, xhr) {
				//alert(data) 
                    var info = data;
                    if(typeof data == 'string'){
                         info = JSON.parse(data);
                    }

                    if (info.errorcode === 0) {
					//$("#gpss").html(info.gpss);	
					  lineArr=JSON.parse(info.gpss); //这里要把JSON字符串转换为JSON数组对象
					  offtime=info.offtime;
					  centered=lineArr[0];   
                    }
                    else {
                        alert('异常: ' + info.errorcode);
						return false;
                    }
                },
                error: function (xhr, errorType, error) {
                    alert(errorType + ', ' + "alllist访问接口失败");
					return false;
                }
            });
// 坐标结束

    var map = new AMap.Map("container", {
        resizeEnable: true,
        center: centered,
        zoom: 17
    });

    marker = new AMap.Marker({
        map: map,
        position: centered,
        icon: "http://www.tshmkj.com/htgl/dapi/man.png",
        offset: new AMap.Pixel(-26, -13),
        autoRotation: true,
        angle:-90,
    });

    // 绘制轨迹
    var polyline = new AMap.Polyline({
        map: map,
        path: lineArr,
        showDir:true,
        strokeColor: "#28F",  //线颜色
        // strokeOpacity: 1,     //线透明度
        strokeWeight: 6,      //线宽
        // strokeStyle: "solid"  //线样式
    });

    var passedPolyline = new AMap.Polyline({
        map: map,
        // path: lineArr,
        strokeColor: "#AF5",  //线颜色
        // strokeOpacity: 1,     //线透明度
        strokeWeight: 6,      //线宽
        // strokeStyle: "solid"  //线样式
    });


    marker.on('moving', function (e) {
        passedPolyline.setPath(e.passedPath);
    });

    map.setFitView();

    //计算里程
	
	licheng_m=Math.round(AMap.GeometryUtil.distanceOfLine(lineArr))/1000;
	
	//计算速度
	
	offtime_h=(offtime/3600).toFixed(2);
    sudu=(licheng_m.toFixed(3)/offtime_h).toFixed(3);
	
	$("#licheng").html("合计里程约"+licheng_m.toFixed(3)+"千米，用时"+offtime_h+"小时，平均时速"+sudu+"公里/小时");

    startAnimation ()
	
}

    function startAnimation () {
        marker.moveAlong(lineArr, 200);
    }

    function pauseAnimation () {
        marker.pauseMove();
    }

    function resumeAnimation () {
        marker.resumeMove();
    }

    function stopAnimation () {
        marker.stopMove();
    }