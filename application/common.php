<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

function base64_image_content($base64_image_content, $path, $uri='/upload/'){
    //匹配出图片的格式
    if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)){
        $type = $result[2];
        $new_file = $path.date('Ymd',time())."/";
        if(!file_exists($new_file)){
            //检查是否有该文件夹，如果没有就创建，并给予最高权限
            mkdir($new_file, 0700);
        }
        $name = md5(time().rand(10000,999999));
        $new_file = $new_file.$name.".{$type}";
        $uri = $uri.date('Ymd',time())."/".$name.".{$type}";
        if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $base64_image_content)))){
            return $uri;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function createQRCode($text){ //todo   二维码链接
    $res = file_get_contents('http://qr.liantu.com/api.php?text='.$text);
    !file_exists(ROOT_PATH.'public/static/qr/'.date('Ymd'))&&
    mkdir(ROOT_PATH.'public/static/qr/'.date('Ymd'));
    $save_name = '/static/qr/'.date('Ymd').'/'.md5(time()).'.png';
    file_put_contents(ROOT_PATH.'public'.$save_name,$res);
    return $save_name;
}
