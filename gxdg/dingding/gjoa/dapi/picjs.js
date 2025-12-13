
function upme(obj){

 //console.log(obj.files[0])
 var rpic = new FileReader();
 var mpic = new Image();
// var mpic=document.getElementById('pic')
 rpic.readAsDataURL(obj.files[0]);
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
		  
// 获取坐标
dd.device.geolocation.get({
    targetAccuracy : 50,
    coordinate : 1,
    withReGeocode : true,
    useCache:false, //默认是true，如果需要频繁获取地理位置，请设置false
    onSuccess : function(result) {
		zb=result.longitude +","+result.latitude 
        address=result.address  
			   var infile = new FormData();
			   infile.append('myfiles',bval,"image.png")
			   infile.append('zbs',zb)
			   infile.append('uid',dd.userid)
			   infile.append('address',address)
               into = new XMLHttpRequest(); //这个声明HTTPXML对象的方法有浏览器兼容问题，这里只考虑微信核心，不必顾及其他浏览器
			   into.upload.addEventListener("progress", uploadProgress, true);
               into.open('POST', 'dapi/ajax.php', true)
               into.send(infile);
			   into.onreadystatechange=function() {
			   if(into.readyState == 4){
				//alert(into.responseText)   
				var intoobj = JSON.parse(into.responseText);
				  if(intoobj.error==0){
					$("#picshow").attr("src",dataURL);
					$("#biaoji").html("时间戳："+intoobj.untime+"，坐标:"+intoobj.zb+"("+intoobj.address+")")  
					  }}
			   }
		  	  // ajax end
    },
    onFail : function(err) {
		alert("GPS设备无应答")
		}
});
//坐标结束		  
			  })
		 //console.log(dataURL)
		 //document.getElementById('pic2').src=dataURL
		 //$("#picshow").attr("src",dataURL);
		 //mpic.src=dataURL
		}
      
 }
 	//
}

      function uploadProgress(evt) {
		  //	console.log(evt.lengthComputable);
        if (evt.lengthComputable) {
          var percentComplete = Math.round(evt.loaded * 100 / evt.total);
          //document.getElementById('progressNumber').innerHTML = percentComplete.toString() + '%';
		  document.getElementById("prob1").value=percentComplete;
        }
        else {
          document.getElementById("prob1").value=0;
        }
      }