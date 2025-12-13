<?php 

/// 常驻进程，纯PHP定时器
/// 定时器里不做业务逻辑，因为定时器时隙太短，串行业务逻辑会卡掉时隙
/// 定时器直接用CLI执行业务逻辑，定时器只做触发用


while(1){
	
	/////////////////////////////////////////////////////////
	/// 以下是定时器逻辑
	//执行
	// $command = 'php ' . escapeshellarg($scriptPath) . ' > /dev/null 2>&1 &';   命令模式
	
	//exec('start "" /b "C:\path\to\your\program.exe" &');
	
 	//exec('F:\phpStudy\PHPTutorial\php\php-5.3.29-nts\php.exe L:\phpweb\wrj\flyapi\tasktime.php', $output, $returnCode); //后台执行，不知道是不是异步
		
	@system('F:\phpStudy\PHPTutorial\php\php-5.3.29-nts\php.exe L:\phpweb\gxdg\cron\tasktime.php', $return_str);
	
	echo date("Y-m-d H:i:s")."--".$return_str."\r\n";
	
	
	////////////////////////////////////////////////////////
		
	sleep(60); //延迟，时隙由此控制
	}


?>