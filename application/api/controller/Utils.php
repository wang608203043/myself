<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/8/20
 * Time: 11:05
 */

namespace app\api\controller;


class Utils extends Base
{
    /**
     * 参数  filename  文件名  fileType 文件类型（base64,file）  file
     */
    public function upload(){
        $fileType = input('fileType');
        $filename = input('filename');
        $file_path = '';
        if ($fileType == 'base64'){
            $file_path = base64_image_content(input($filename),UPLOAD_PATH);
        }elseif ($fileType == 'file'){
            $file = $this->request->file($filename);
            $info = $file->move(UPLOAD_PATH);
            $file_path = '/upload/'.$info->getSaveName();
        }
        $this->result = ['url'=>$file_path];
        return $this->jsonReturn();
    }
}