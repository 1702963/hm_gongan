/**
 * 时钟插件 for jQuery 1.8+
 * 用法: 
 * 1. 引入jQuery 1.8+
 * 2. 引入本插件
 * 3. 在JS中调用: $('#clock-element').clock();
 */
(function($) {
    // 定义插件
    $.fn.clock = function(options) {
        // 默认配置
        var defaults = {
            format: 'HH:MM:SS' // 时间格式
        };
        
        // 合并配置
        var settings = $.extend({}, defaults, options);
        
        // 遍历所有匹配元素
        return this.each(function() {
            var $element = $(this);
            var timer; // 定时器
            
            // 更新时间函数
            function updateTime() {
                var now = new Date();
                var hours = now.getHours();
                var minutes = now.getMinutes();
                var seconds = now.getSeconds();
                
                // 补零处理
                hours = hours < 10 ? '0' + hours : hours;
                minutes = minutes < 10 ? '0' + minutes : minutes;
                seconds = seconds < 10 ? '0' + seconds : seconds;
                
                // 格式化时间字符串
                var timeStr = settings.format
                    .replace('HH', hours)
                    .replace('MM', minutes)
                    .replace('SS', seconds);
                
                // 更新元素内容
                $element.text(timeStr);
            }
            
            // 立即更新一次
            updateTime();
            
            // 启动定时器，每秒更新
            timer = setInterval(updateTime, 1000);
            
            // 存储定时器引用，便于后续销毁
            $element.data('clockTimer', timer);
        });
    };
    
    // 提供销毁方法
    $.fn.destroyClock = function() {
        return this.each(function() {
            var $element = $(this);
            var timer = $element.data('clockTimer');
            
            // 清除定时器
            if (timer) {
                clearInterval(timer);
                $element.removeData('clockTimer');
            }
        });
    };
})(jQuery);