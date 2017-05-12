<?php 

/*
 * 日志类
 * @author zhanghegong
 * 
 */
namespace App\Http\Common;

class Log {

	protected static $log;//本类对象
	private static $model;//定义文件夹，如home,manage,payment 
	private static $maxSize;
	private static $path;

	private function __construct($model){
		self::$maxSize = 10485760; // 单位b  换算为 10MB
		self::$model = $model;
		self::$path = public_path('logs').'/'.$model.'/'.date('Y/m-d').'/';
	}

	// 创建连接的方法-单例模式
	static function getInstance($model){
		if(self::$log){
			return self::$log;
		}else{
			self::$log = new self($model);
			return self::$log;
		}
	}

	// 写日志
	static function write($data, $model = 'home'){
		if(empty($data)){
			return false;
		}

		self::getInstance($model);
		$path = self::getPath(self::$path);
		$data = 'Time：'.date('Y-m-d H:i:s')."\r\n". "Data:  \r\n#*#*#*#\r\n" .var_export($data, true)."\r\n#*#*#*#\r\n\r\n";
		return file_put_contents($path, $data, FILE_APPEND);
	}


	// 获取路径
	private static function getPath($path, $index = false){

		// 创建文件
		if(!is_dir($path) ){
			mkdir($path, 644, true);
		}

		// 拼接路径
		$file_path = $index===false ? ($path.date('Ymd')) : ($path.date('Ymd').'_'.$index);
		$file_path =  $file_path.'.txt';

		if(file_exists($file_path)){
			
			$size = filesize($file_path);

			// 校验最大值
			if($size > self::$maxSize){
				$file_path =  self::getPath($path, $index+1);
			}
		}else{
			// 写文件
			$handle = fopen($file_path, "w");
			fclose($handle);
		}

		// 返回文件路径
		return $file_path;
	}

}

?>