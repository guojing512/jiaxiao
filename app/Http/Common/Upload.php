<?php
/*
	文件上传基础类

*/
namespace App\Http\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Upload
{

	public $config;
	public $error;
    public $savePathList = false;// 文件存储列表

	public function __construct($user_config = false){
        $this->config = array(
            'maxSize'      => 1048576, //上传的文件大小限制 (0不做限制)
            'exts'         => array('jpg', 'gif', 'png', 'jpeg'), //允许上传的文件后缀
            'pathKey'         => 'default', //文件存储目录列表的下表
        );
        if(!empty($user_config)){
            $this->config = array_merge($this->config, $user_config);
        }

        $this->save_path_list['default'] = '/manage/images/'.date('ymd').'/'.date('His').uniqid();//默认存储目录
        $this->save_path_list['file'] = '/manage/file/'.date('ymd').'/'.date('His').uniqid();
	}

	/*
		上传单个文件
		@param $file $file = Input::file('myfile');

		$file->getMaxFilesize() 获取系统允许文件上传最大值

	*/
    public function uploadOne($file){

    	if(empty($file) || !is_object($file)){
    		return returnRes('error','参数错误');	
    	}

		if($file->isValid()){

			if($file->getClientSize() > $this->config['maxSize']){
				return returnRes('error','上传文件超过限制');	
			}

			//原文件名
			$originalName = $file->getClientOriginalName();
			//扩展名
			$extName = $file->getClientOriginalExtension();
			//MIME type
			$type = $file->getClientMimeType();
			//临时绝对路径
			$realPath = $file->getRealPath();

			$filePath = $this->save_path_list[$this->config['pathKey']].'.'.$extName;
			$res = Storage::disk('uploads')->put($filePath,file_get_contents($realPath));//存储文件
			if($res){
				return returnRes('success','上传成功',array('file_path'=>'/uploads'.$filePath));	
			}else{
				return returnRes('success','上传失败'.$file->getgetError());	
			}
		}else{
			return returnRes('error','请选择上传文件');	
		}

    }

}
