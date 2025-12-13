
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>图片查看</title>
        <script type="text/javascript" src="<?php echo JS_PATH;?>jquery.min.js" ></script>
        <script type="text/javascript" src="<?php echo JS_PATH;?>jqueryui.js" ></script>
        <script type="text/javascript" src="<?php echo JS_PATH;?>jquery.mousewheel.min.js" ></script>
        <script type="text/javascript" src="<?php echo JS_PATH;?>jquery.iviewer.js" ></script>
        <script type="text/javascript">
            var $ = jQuery;
            $(document).ready(function(){
                 
                  var iv2 = $("#viewer2").iviewer(
                  {
                      src: "<?php echo $url;?>"
                  });

                  
            });
        </script>
        <link rel="stylesheet" href="<?php echo CSS_PATH;?>jquery.iviewer.css" />
        <style>
            .viewer
            {
                width: 99%;
                height: 780px;
               
                position: relative;
				margin:0 auto;
            }

            .wrapper
            {
                overflow: hidden;
            }
        </style>
    </head>
    <body>
       
        <!-- wrapper div is needed for opera because it shows scroll bars for reason -->
        <div class="wrapper" align="center">
            
            <div id="viewer2" class="viewer" style="width: 100%;"></div>
            
        </div>
    </body>
</html>
