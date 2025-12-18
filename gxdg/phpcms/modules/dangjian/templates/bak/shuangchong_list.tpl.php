<?php
defined('IN_ADMIN') or exit('No permission resources.');
include $this->admin_tpl('header_new', 'admin');
?>

<SCRIPT LANGUAGE="JavaScript">
<!--
parent.document.getElementById('display_center_id').style.display='none';
//-->
</SCRIPT>

<style type="text/css">
html{_overflow-y:scroll}
.explain-col {
    border: 1px solid #3132a4;
    zoom: 1;
    background: #252682;
    padding: 8px 10px;
    line-height: 20px;
    color:#bbd8f1
}
</style>
<link href="<?php echo CSS_PATH?>modelPatch.css?ver=<?php echo time() ?>" rel="stylesheet" type="text/css" />

<div class="tableContent">
<div class="pad-lr-10">

<div class="explain-col">
  快速工具:
<a href="index.php?m=dangjian&c=chengyuan&a=sczz_add"><input type="button" value="添加记录" style="margin-left:10px; width:80px" class="doLock" name="dook"></a>
&nbsp;&nbsp;&nbsp;
会议类型:
<select id="huiyi_type_filter" onchange="filterByConditions()" style="margin-left:5px;padding:5px;background:transparent;color:#fff;border:1px solid #ddd;">
  <option value="">全部</option>
  <option value="分局党委会" <?php echo $this->huiyi_type == '分局党委会' ? 'selected' : ''?>>分局党委会</option>
  <option value="理论中心组学习会" <?php echo $this->huiyi_type == '理论中心组学习会' ? 'selected' : ''?>>理论中心组学习会</option>
  <option value="民主生活会" <?php echo $this->huiyi_type == '民主生活会' ? 'selected' : ''?>>民主生活会</option>
  <option value="党支部生活会" <?php echo $this->huiyi_type == '党支部生活会' ? 'selected' : ''?>>党支部生活会</option>
  <option value="党支部党员大会" <?php echo $this->huiyi_type == '党支部党员大会' ? 'selected' : ''?>>党支部党员大会</option>
  <option value="党支部党小组会" <?php echo $this->huiyi_type == '党支部党小组会' ? 'selected' : ''?>>党支部党小组会</option>
  <option value="党支部党课" <?php echo $this->huiyi_type == '党支部党课' ? 'selected' : ''?>>党支部党课</option>
  <option value="其他活动" <?php echo $this->huiyi_type == '其他活动' ? 'selected' : ''?>>其他活动</option>
</select>
&nbsp;&nbsp;&nbsp;
参会人员:
<span style="position:relative;display:inline-block;">
  <input type="text" id="canhui_search" value="<?php echo htmlspecialchars($this->canhui_renyuan)?>"
         style="width:200px;padding:5px;background:transparent;color:#fff;border:1px solid #ddd;margin-left:5px;"
         placeholder="输入姓名搜索" autocomplete="off"/>
  <input type="hidden" id="canhui_renyuan_filter" value="<?php echo htmlspecialchars($this->canhui_renyuan)?>"/>
  <div id="canhui_inputlist" style="position:absolute;z-index:999;background-color:#28348e;border:1px solid #ccc;display:none;min-width:300px;left:5px;top:30px;">
    <ul style="list-style:none;padding:0;margin:0;"></ul>
  </div>
</span>
<input type="button" value="筛选" onclick="filterByConditions()" style="margin-left:10px;padding:5px 15px;cursor:pointer;"/>
<input type="button" value="清空" onclick="clearFilter()" style="margin-left:5px;padding:5px 15px;cursor:pointer;"/>
</div>

<div class="table-list">
<form name="myform" id="myform">
<script type="text/javascript" >
  $(document).ready(function() {
    $(".kotable tbody tr:odd").addClass("odd");
    $(".kotable tbody tr:even").addClass("even");
    $(".kotable tbody tr").mouseover(function() {
      $(this).addClass("iover");
    }).mouseout(function() {
      $(this).removeClass("iover");
    });
  })
</script>

<table width="100%" cellspacing="4" cellpadding="4" class="kotable">
    <thead>
    <tr>
      <th width='50'>序号</th>
      <th width="100">会议类型</th>
      <th width='200'>标题</th>
      <th width="150">会议时间</th>
      <th width="200">参会人员</th>
      <th width="80">附件</th>
      <th width="150">操作</th>
    </tr>
    </thead>
    <tbody>
  <?php

if(is_array($this->list)){
    $i=1;

    foreach($this->list as $info){
    ?>
    <tr>
      <td><?php echo $i?></td>
      <td><?php echo $info['huiyi_type']?></td>
      <td><?php echo $info['title']?></td>
      <td><?php echo $info['meeting_time_show']?></td>
      <td><?php echo mb_substr($info['canhui_renyuan'], 0, 30, 'utf-8') . (mb_strlen($info['canhui_renyuan'], 'utf-8') > 30 ? '...' : '')?></td>
      <td>
        <?php
        if($info['fujian']){
            $fujian_array = json_decode($info['fujian'], true);
            if (is_array($fujian_array) && count($fujian_array) > 0) {
                echo '<a href="javascript:void(0)" onclick="showFujianImages(' . $info['id'] . ')">查看(' . count($fujian_array) . '张)</a>';
                echo '<div id="fujian_imgs_' . $info['id'] . '" style="display:none;">' . htmlspecialchars($info['fujian']) . '</div>';
            } else {
                echo '<a href="' . $info['fujian'] . '" target="_blank">查看</a>';
            }
        }else{
            echo '无';
        }
        ?>
      </td>
      <td>
        &nbsp;<a href="index.php?m=dangjian&c=chengyuan&a=sczz_edit&id=<?php echo $info['id']?>">编辑</a>
        &nbsp;<a href="index.php?m=dangjian&c=chengyuan&a=sczz_del&id=<?php echo $info['id']?>" onclick="javascript:var r = confirm('确认删除该记录吗？');if(!r){return false;}">删除</a>
      </td>
    </tr>
   <?php
    $i++;}
}
?>
</tbody>
</table>

<div id="pages"><?php echo $this->pages?></div>
</form>
</div>
</div>
</div>

<script type="text/javascript">
// 综合筛选
function filterByConditions() {
    var huiyi_type = document.getElementById('huiyi_type_filter').value;
    var canhui_renyuan = document.getElementById('canhui_renyuan_filter').value;
    var url = 'index.php?m=dangjian&c=chengyuan&a=shuangchongzuzhi';
    var params = [];
    if (huiyi_type != '') {
        params.push('huiyi_type=' + encodeURIComponent(huiyi_type));
    }
    if (canhui_renyuan != '') {
        params.push('canhui_renyuan=' + encodeURIComponent(canhui_renyuan));
    }
    if (params.length > 0) {
        url += '&' + params.join('&');
    }
    window.location.href = url;
}

// 清空筛选条件
function clearFilter() {
    window.location.href = 'index.php?m=dangjian&c=chengyuan&a=shuangchongzuzhi';
}

// 参会人员搜索功能
$(function(){
    // 搜索辅警自动完成
    $("#canhui_search").bind("keyup click", function(){
        var t = $(this), _html = "";
        var searchVal = t.val().trim();

        if(searchVal == "") {
            $("#canhui_inputlist").hide();
            return;
        }

        // 通过AJAX搜索辅警
        $.ajax({
            url: 'index.php?m=dangjian&c=chengyuan&a=searchfujing',
            type: 'POST',
            data: {keyword: searchVal},
            dataType: 'json',
            success: function(res) {
                if(res.status == 1 && res.data && res.data.length > 0) {
                    for(var i = 0; i < res.data.length; i++) {
                        var item = res.data[i];
                        _html += "<li data-name='" + item.xingming + "' style='line-height:30px;font-size:14px;padding:5px 10px;cursor:pointer;white-space:nowrap;'>"
                               + item.xingming + " [" + item.sex + ", " + item.sfz + ", " + (item.danwei || '') + "]</li>";
                    }
                    $("#canhui_inputlist ul").html(_html);
                    $("#canhui_inputlist").show();
                } else {
                    $("#canhui_inputlist ul").html("<li style='color:#999;padding:5px 10px;'>未找到匹配的辅警</li>");
                    $("#canhui_inputlist").show();
                }
            },
            error: function() {
                $("#canhui_inputlist").hide();
            }
        });
    });

    // 选择人员
    $(document).delegate("#canhui_inputlist ul li", "click", function(){
        var name = $(this).attr("data-name");
        if(name) {
            $("#canhui_search").val(name);
            $("#canhui_renyuan_filter").val(name);
            $("#canhui_inputlist").hide();
        }
    });

    // 点击其他地方隐藏下拉列表
    $(document).click(function(e){
        if(!$(e.target).closest('#canhui_search, #canhui_inputlist').length) {
            $("#canhui_inputlist").hide();
        }
    });

    // 鼠标悬停效果
    $(document).delegate("#canhui_inputlist ul li", "mouseover", function(){
        $(this).css('background', '#E0E0E8').css('color', '#28348e');
    }).delegate("#canhui_inputlist ul li", "mouseout", function(){
        $(this).css('background', 'transparent').css('color', '#fff');
    });

    // 输入框内容改变时同步更新隐藏字段
    $("#canhui_search").on('input', function(){
        $("#canhui_renyuan_filter").val($(this).val());
    });

    // 支持回车键筛选
    $("#canhui_search").on('keydown', function(e){
        if(e.keyCode == 13) {
            e.preventDefault();
            filterByConditions();
        }
    });
});

// 查看附件图片
function showFujianImages(id) {
    var fujianJson = $('#fujian_imgs_' + id).text();
    if (fujianJson) {
        try {
            var images = JSON.parse(fujianJson);
            if (Array.isArray(images) && images.length > 0) {
                var html = '<div style="max-width:800px;max-height:600px;overflow:auto;">';
                for (var i = 0; i < images.length; i++) {
                    html += '<div style="margin:10px;text-align:center;">'
                          + '<img src="' + images[i] + '" style="max-width:100%;border:1px solid #ddd;" />'
                          + '</div>';
                }
                html += '</div>';

                // 使用art.dialog显示（如果系统有的话）
                if (typeof art !== 'undefined' && art.dialog) {
                    art.dialog({
                        title: '附件图片',
                        content: html,
                        lock: true
                    });
                } else {
                    // 简单的弹窗显示
                    var win = window.open('', '_blank', 'width=820,height=620,scrollbars=yes');
                    win.document.write('<html><head><title>附件图片</title></head><body style="background:#f5f5f5;">' + html + '</body></html>');
                }
            }
        } catch (e) {
            alert('图片数据格式错误');
        }
    }
}
</script>

</body>
</html>
