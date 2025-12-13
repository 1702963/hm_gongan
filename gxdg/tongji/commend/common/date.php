<?php
/**
 * 农历转换和节假日判断类 (兼容PHP 5.2)
 */
class ChineseCalendar {
    // 农历数据
    private $lunarInfo = array(
        0x04bd8,0x04ae0,0x0a570,0x054d5,0x0d260,0x0d950,0x16554,0x056a0,0x09ad0,0x055d2,
        0x04ae0,0x0a5b6,0x0a4d0,0x0d250,0x1d255,0x0b540,0x0d6a0,0x0ada2,0x095b0,0x14977,
        0x04970,0x0a4b0,0x0b4b5,0x06a50,0x06d40,0x1ab54,0x02b60,0x09570,0x052f2,0x04970,
        0x06566,0x0d4a0,0x0ea50,0x06e95,0x05ad0,0x02b60,0x186e3,0x092e0,0x1c8d7,0x0c950,
        0x0d4a0,0x1d8a6,0x0b550,0x056a0,0x1a5b4,0x025d0,0x092d0,0x0d2b2,0x0a950,0x0b557,
        0x06ca0,0x0b550,0x15355,0x04da0,0x0a5b0,0x14573,0x052b0,0x0a9a8,0x0e950,0x06aa0,
        0x0aea6,0x0ab50,0x04b60,0x0aae4,0x0a570,0x05260,0x0f263,0x0d950,0x05b57,0x056a0,
        0x096d0,0x04dd5,0x04ad0,0x0a4d0,0x0d4d4,0x0d250,0x0d558,0x0b540,0x0b5a0,0x195a6,
        0x095b0,0x049b0,0x0a974,0x0a4b0,0x0b27a,0x06a50,0x06d40,0x0af46,0x0ab60,0x09570,
        0x04af5,0x04970,0x064b0,0x074a3,0x0ea50,0x06b58,0x055c0,0x0ab60,0x096d5,0x092e0,
        0x0c960,0x0d954,0x0d4a0,0x0da50,0x07552,0x056a0,0x0abb7,0x025d0,0x092d0,0x0cab5,
        0x0a950,0x0b4a0,0x0baa4,0x0ad50,0x055d9,0x04ba0,0x0a5b0,0x15176,0x052b0,0x0a930,
        0x07954,0x06aa0,0x0ad50,0x05b52,0x04b60,0x0a6e6,0x0a4e0,0x0d260,0x0ea65,0x0d530,
        0x05aa0,0x076a3,0x096d0,0x04bd7,0x04ad0,0x0a4d0,0x1d0b6,0x0d250,0x0d520,0x0dd45,
        0x0b5a0,0x056d0,0x055b2,0x049b0,0x0a577,0x0a4b0,0x0aa50,0x1b255,0x06d20,0x0ada0
    );
    
    // 农历月份
    private $lunarMonths = array('一', '二', '三', '四', '五', '六', '七', '八', '九', '十', '十一', '十二');
    // 农历日期
    private $lunarDays = array('初一', '初二', '初三', '初四', '初五', '初六', '初七', '初八', '初九', '初十',
                          '十一', '十二', '十三', '十四', '十五', '十六', '十七', '十八', '十九', '二十',
                          '廿一', '廿二', '廿三', '廿四', '廿五', '廿六', '廿七', '廿八', '廿九', '三十');
    // 星期
    private $weekDays = array('日', '一', '二', '三', '四', '五', '六');
    
    /**
     * 转换公历到农历
     * @param int $year 公历年
     * @param int $month 公历月
     * @param int $day 公历日
     * @return array 农历信息
     */
    public function solarToLunar($year, $month, $day) {
        if ($year < 1900 || $year > 2100) {
            return array('error' => '年份超出范围(1900-2100)');
        }
        
        $totalDays = $this->countDaysFrom1900($year, $month, $day);
        $i = 1900;
        $j = 1;
        $sum = 0;
        
        // 计算农历年份
        while ($i < 2101 && $sum + $this->lunarYearDays($i) < $totalDays) {
            $sum += $this->lunarYearDays($i);
            $i++;
        }
        $lunarYear = $i;
        $daysInYear = $totalDays - $sum;
        
        // 计算农历月份和日期
        $leapMonth = $this->lunarLeapMonth($lunarYear);
        $isLeap = false;
        $j = 1;
        $sum = 0;
        
        while ($j < 13 && $sum + $this->lunarMonthDays($lunarYear, $j, $j == $leapMonth) < $daysInYear) {
            $sum += $this->lunarMonthDays($lunarYear, $j, $j == $leapMonth);
            $j++;
        }
        
        if ($j == $leapMonth + 1) {
            $isLeap = true;
            $j--;
            $sum -= $this->lunarMonthDays($lunarYear, $j, true);
        }
        
        $lunarMonth = $j;
        $lunarDay = $daysInYear - $sum;
        
        return array(
            'year' => $lunarYear,
            'month' => $lunarMonth,
            'day' => $lunarDay,
            'isLeap' => $isLeap,
            'monthStr' => ($isLeap ? '闰' : '') . $this->lunarMonths[$lunarMonth - 1],
            'dayStr' => $this->lunarDays[$lunarDay - 1]
        );
    }
    
    /**
     * 计算农历年的天数
     */
    private function lunarYearDays($year) {
        $days = 0;
        $leapMonth = $this->lunarLeapMonth($year);
        
        for ($i = 1; $i <= 12; $i++) {
            $days += $this->lunarMonthDays($year, $i, $i == $leapMonth);
            if ($i == $leapMonth) {
                $days += $this->lunarMonthDays($year, $i, true);
            }
        }
        return $days;
    }
    
    /**
     * 计算农历月的天数
     */
    private function lunarMonthDays($year, $month, $isLeap) {
        $idx = $year - 1900;
        $info = $this->lunarInfo[$idx];
        
        if ($isLeap) {
            return ($info & 0x10000) ? 30 : 29;
        }
        
        switch ($month) {
            case 1: return ($info & 0x8000) ? 30 : 29;
            case 2: return ($info & 0x4000) ? 30 : 29;
            case 3: return ($info & 0x2000) ? 30 : 29;
            case 4: return ($info & 0x1000) ? 30 : 29;
            case 5: return ($info & 0x800) ? 30 : 29;
            case 6: return ($info & 0x400) ? 30 : 29;
            case 7: return ($info & 0x200) ? 30 : 29;
            case 8: return ($info & 0x100) ? 30 : 29;
            case 9: return ($info & 0x80) ? 30 : 29;
            case 10: return ($info & 0x40) ? 30 : 29;
            case 11: return ($info & 0x20) ? 30 : 29;
            case 12: return ($info & 0x10) ? 30 : 29;
            default: return 0;
        }
    }
    
    /**
     * 获取农历闰年的闰月
     */
    private function lunarLeapMonth($year) {
        $idx = $year - 1900;
        return ($this->lunarInfo[$idx] & 0xf);
    }
    
    /**
     * 计算从1900年1月31日到指定日期的天数
     */
    private function countDaysFrom1900($year, $month, $day) {
        $days = 0;
        
        // 计算整年的天数
        for ($i = 1900; $i < $year; $i++) {
            $days += $this->isSolarLeapYear($i) ? 366 : 365;
        }
        
        // 计算当月的天数
        for ($i = 1; $i < $month; $i++) {
            $days += $this->solarMonthDays($year, $i);
        }
        
        // 加上日
        $days += $day;
        
        // 减去1900年1月的前30天
        return $days - 30;
    }
    
    /**
     * 判断公历年是否为闰年
     */
    private function isSolarLeapYear($year) {
        return ($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0);
    }
    
    /**
     * 获取公历月的天数
     */
    private function solarMonthDays($year, $month) {
        switch ($month) {
            case 1: case 3: case 5: case 7: case 8: case 10: case 12:
                return 31;
            case 4: case 6: case 9: case 11:
                return 30;
            case 2:
                return $this->isSolarLeapYear($year) ? 29 : 28;
            default:
                return 0;
        }
    }
    
    /**
     * 获取星期几
     */
    public function getWeekDay($timestamp = null) {
        if ($timestamp === null) {
            $timestamp = time();
        }
        $weekNum = date('w', $timestamp);
        return '星期' . $this->weekDays[$weekNum];
    }
    
    /**
     * 获取节假日
     */
    public function getHoliday($year, $month, $day) {
        // 固定节假日
        $fixedHolidays = array(
            '01-01' => '元旦',
            '02-14' => '情人节',
            '03-08' => '妇女节',
            '03-12' => '植树节',
            '04-01' => '愚人节',
            '05-01' => '劳动节',
            '05-04' => '青年节',
            '06-01' => '儿童节',
            '07-01' => '建党节',
            '08-01' => '建军节',
            '09-10' => '教师节',
            '10-01' => '国庆节',
            '12-25' => '圣诞节'
        );
        
        $dateStr = sprintf('%02d-%02d', $month, $day);
        if (isset($fixedHolidays[$dateStr])) {
            return $fixedHolidays[$dateStr];
        }
        
        // 计算农历节日
        $lunar = $this->solarToLunar($year, $month, $day);
        if ($lunar['month'] == 1 && $lunar['day'] == 1) {
            return '春节';
        }
        if ($lunar['month'] == 1 && $lunar['day'] == 15) {
            return '元宵节';
        }
        if ($lunar['month'] == 5 && $lunar['day'] == 5) {
            return '端午节';
        }
        if ($lunar['month'] == 8 && $lunar['day'] == 15) {
            return '中秋节';
        }
        if ($lunar['month'] == 9 && $lunar['day'] == 9) {
            return '重阳节';
        }
        
        return null;
    }
}

// 使用示例
$calendar = new ChineseCalendar();
$now = time();
$year = date('Y', $now);
$month = date('m', $now);
$day = date('d', $now);

// 公历日期
$solarDate = date('Y年m月d日', $now);

// 星期几
$weekDay = $calendar->getWeekDay($now);

// 农历日期
$lunar = $calendar->solarToLunar($year, $month, $day);
//$lunarDate = $lunar['year'] . '年' . $lunar['monthStr'] . '月' . $lunar['dayStr'];
$lunarDate = $lunar['monthStr'] . '月' . $lunar['dayStr'];

// 节假日
$holiday = $calendar->getHoliday($year, $month, $day);


echo ' '.$solarDate.' '.$weekDay.' 农历 '.$lunarDate.' '.$holiday
?>