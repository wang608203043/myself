<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/6/19
 * Time: 18:44
 */

namespace app\admin\controller;


use app\common\service\UserService;
use think\Cache;
use think\Hook;
use think\Request;

class User extends Base
{
    protected $service;
    public function __construct(Request $request = null,UserService $service)
    {
        parent::__construct($request);
        $this->service = $service;
    }

    public function index(){
        $status = input('status',0);
        $where = ['status'=>$status];
        $list = $this->service->model()->where($where)->paginate(20);
        $all = $this->service->model()->where(['status'=>1])->field('id,pid,uname')->select();
        $this->assign('list',$list);
        $this->assign('status',$status);
        $this->assign('all',json_encode($all));
        return $this->fetch();
    }

    public function add(){
        $all = $this->service->model()->where(['status'=>1])->field('id,pid,uname')->select();
        $this->assign('all',$all);
        return $this->fetch();
    }

    public function add_confirm(){
        $input = input('post.');
        $user = $this->service->model()->where(['phone'=>$input['phone']])->find();
        if ($user){
            return json(['code'=>0,'msg'=>'手机号已注册','data'=>null]);
        }
        $input['password'] = md5('123456');
        $input['secondaryPassword'] = md5('123456');
        $input['extensionCode'] = createQRCode($input['phone']);
        $res = $this->service->model()->allowField(true)->save($input);
        if ($res){
            $uid = $this->service->model()->getLastInsID();
            $user = $this->service->model()->find($uid);
            Hook::listen('extension',$user);
            return json(['code'=>1,'msg'=>'success','data'=>$res]);
        }
        return json(['code'=>0,'msg'=>'网络异常','data'=>null]);
    }

    public function edit(){
        $id = input('id');
        $detail = $this->service->model()->find($id);
        $all = $this->service->model()->where(['status'=>1])->field('id,pid,uname')->select();
        $this->assign('all',$all);
        $this->assign('detail',$detail);
        return $this->fetch();
    }

    public function edit_confirm(){
        $input = input('post.');
        $res = $this->service->model()->allowField(true)->save($input,['id'=>$input['id']]);
        if ($res){
            return json(['code'=>1,'msg'=>'success','data'=>$res]);
        }
        return json(['code'=>0,'msg'=>'网络异常','data'=>null]);
    }

    public function changeStatus(){ //激活账户
        $input = input('post.');
        $user = $this->service->model()->find($input['id']);
        $user->activation()->setField('status',1);
        $user->status = 1;
        if ($user->save()){
            return json(['code'=>1,'msg'=>'success','data'=>null]);
        }
        return json(['code'=>0,'msg'=>'网络异常','data'=>null]);
    }
}