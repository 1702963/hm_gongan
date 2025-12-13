<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Document</title>
  <style type="text/css">
    #main{
      margin: 50px auto;
      width: 640px;
      font-size: 0;
    }
    #logo img{
      height: 129px;
      width: 270px;
      padding: 0 185px;
    }
    #input{
      width: 640px;
      height: 40px;
    }
    #input #search{
      width: 522px;
      height: 36px;
      padding:0 5px;
      margin: 0;
      line-height: 40px;
      font-size: 16px;
      outline: none;
      float: left;
    } 
    #input #submit{
            float: left;
      width: 102px;
      height: 40px;
      padding: 0;
      margin: 0;
      background: #38f;
      font-size: 16px;
      color: white;
      border: 0;
    }
    #inputlist{
      margin: 0;
      padding: 0;
      border: 1px solid #ccc;
            width: 534px;
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
    }
  </style>
</head>
<body>
  <div id="main">
    <div id="logo"><img src="https://ss0.bdstatic.com/5aV1bjqh_Q23odCf/static/superman/img/logo/bd_logo1_31bdc765.png"></div>
    <div id="input">
      <form>
      <input id="search" type="text">
      <input id="submit" type="submit" value="百度一下">
      </form>
    </div>
    <div id="inputlist">
        <ul>
        </ul>
    </div>
     </div>
     <script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.js"></script>
     <script type="text/javascript">
      $(function(){
        $("#search").bind("keyup click",function(){
          var t=$(this),_html="";
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
                };
                $.ajax({
                  async:false,
                  url:'../../api/getuser.php?sel='+t.val(),
                  dataType:'jsonp',
                  jsonp:"mycallback",
                  jsonpCallback:"window.baidu.sug"
                });
        });
 
        $(document).delegate("#inputlist ul li","click",function(){
          var key = $(this).text();
          location.href = "https://www.baidu.com/s?wd="+key;
        })
 
        $(document).delegate("#submit","click",function(){
          var key = $("#search").val();
          location.href = "https://www.baidu.com/s?wd="+key;
        })
 
        $(document).click(function(){
          $("#inputlist").hide();
        })
      });
     </script>
</body>
</html>