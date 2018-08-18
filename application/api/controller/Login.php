<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/7/21
 * Time: 16:56
 */

namespace app\api\controller;

use think\Cache;
use think\Db;

class Login extends Base
{
    /**
     * @return \think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function getAccessToken(){
        $account = input('post.account');
        $password = input('post.password');
        $user = Db::name('user')
            ->field('id,uname,phone,imgUrl,balance,extensionCode,amount,level,aliAccount')
            ->where(['status'=>1,'phone'=>$account,'password'=>md5($password)])
            ->find();
        if ($user){
            $this->createToken();
            return json(['code'=>1,'msg'=>'success','data'=>['userInfo'=>$user]]);
        }else{
            return json(['code'=>0,'msg'=>'账号或密码错误','data'=>null]);
        }
    }

    public function logout(){
        $token = $this->request->header('authorization');
        Cache::rm('token_'.$token);
        return json(['code'=>1,'msg'=>'success','data'=>null]);
    }
}