<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/6/9
 * Time: 9:50
 */

namespace app\admin\controller;


use menu\MenuAuth;
use menu\Tree;
use think\Db;

class Index extends Base
{
    public function index(){
        return $this->fetch();
    }

    public function welcome(){
        return $this->fetch();
    }

    public function modify(){
        $old_password = input('post.old_password');
        $new_password = input('post.new_password');
        $password_confirm = input('post.password_confirm');
        if ($password_confirm!=$new_password){
            return json(['code'=>0,'msg'=>'新密码两次输入不一致','data'=>null]);
        }
        $admin = Db::name('admin')->where(['account'=>session('admin')['account'],'password'=>md5($old_password)])->find();
        if (!$admin){
            return json(['code'=>0,'msg'=>'原密码有误','data'=>null]);
        }else{
            $res = Db::name('admin')->where(['id'=>$admin['id']])->update(['password'=>md5($new_password)]);
            if ($res){
                return json(['code'=>1,'msg'=>'success','data'=>null]);
            }else{
                return json(['code'=>0,'msg'=>'网络异常','data'=>null]);
            }
        }

    }
}