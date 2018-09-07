<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/8/18
 * Time: 17:52
 */

namespace app\api\controller;


use app\common\service\UserService;
use think\Request;

class User extends Base
{
    public function __construct(Request $request = null,UserService $service)
    {
        parent::__construct($request);
        $this->service = $service;
    }

    public function getUserInfo(){
        $id = input('post.id');
        $user = $this->service->model()->field('id,uname,phone,imgUrl,balance,extensionCode,amount,level,aliAccount')->find($id);
        if (!$user){
            $this->err_code = 1004;
            $this->err_msg = '没有找到用户';
            return $this->jsonReturn();
        }
        $this->result = ['userInfo',$user];
        return $this->jsonReturn();
    }
}