<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/5/26
 * Time: 17:05
 */

namespace app\admin\controller;


use think\Db;

class Login extends Base
{
    public function index(){
        return $this->fetch();
    }

    public function checkLogin(){
        $input = input('post.');
        $input['password'] = md5($input['password']);
        $admin = Db::name('admin')->field('id,account,name')->where($input)->find();
        if ($admin){
            session('admin',$admin);
            return json(['code'=>1,'msg'=>'success','data'=>$admin]);
        }else{
            return json(['code'=>0,'msg'=>'账号或密码错误','data'=>$admin]);
        }
    }

    public function logout(){
        session('admin',null);
        $this->redirect('index');
    }
}