<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/8/18
 * Time: 16:27
 */

namespace app\api\controller;


use app\common\service\UserService;
use think\Hook;
use think\Request;

class Register extends Base
{
    public function __construct(Request $request = null,UserService $service)
    {
        parent::__construct($request);
        $this->service = $service;
    }

    public function create(){
        $input = input('post.');
        $result = $this->validate($input,'Register');
        if($result!==true){
            $this->err_msg = $result;
            $this->err_code = 1002;
            return $this->jsonReturn(400);
        }
        $registered = $this->service->model()->where(['phone'=>$input['phone']])->find();
        if ($registered){
            $this->err_msg = '账号已被注册';
            $this->err_code = 1002;
            return $this->jsonReturn(400);
        }
        $parent = $this->service->model()->where(['phone'=>$input['parent']])->find();
        if (!$parent){
            $this->err_msg = '推广码错误，非法请求';
            $this->err_code = 1002;
            return $this->jsonReturn(400);
        }
        $input['pid'] = $parent->id;
        $input['extensionCode'] = createQRCode($input['phone']);
        $res = $this->service->model()->allowField(true)->save($input);
        $user = $this->service->model()->where(['phone'=>$input['phone']])->find();
        if (!$res){
            $this->err_code = 1003;
            $this->err_msg = '网络异常';
            return $this->jsonReturn();
        }
        Hook::listen('extension',$user);
        return $this->jsonReturn();
    }
}