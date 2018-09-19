<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Author: wang
 * Date: 2018/9/19
 * Time: 15:03
 */

namespace app\admin\controller;


use app\common\service\AccountBookService;
use think\Request;

class AccountBook extends Base
{
    public function __construct(Request $request = null,AccountBookService $service)
    {
        parent::__construct($request);
        $this->service = $service;
    }

    public function index(){
        $type = input('type',0);
        $list = $this->service->model()->where(['type'=>$type])->order('createTime desc')->paginate(15);
        $this->assign('list',$list);
        $this->assign('type',$type);
        return $this->fetch();
    }

    public function add(){
        return $this->fetch();
    }

    public function add_confirm(){
        $input = input('post.');
        if ($this->service->model()->allowField(true)->save($input)){
            return json(['code'=>1,'msg'=>'success','data'=>null]);
        }else{
            return json(['code'=>0,'msg'=>'网络异常','data'=>null]);
        }
    }

    public function edit(){
        $id = input('id');
        $detail = $this->service->model()->find($id);
        $this->assign('detail',$detail);
        return $this->fetch();
    }

    public function edit_confirm(){
        $input = input('post.');
        if ($this->service->model()->allowField(true)->save($input,['id'=>$input['id']])){
            return json(['code'=>1,'msg'=>'success','data'=>null]);
        }else{
            return json(['code'=>0,'msg'=>'网络异常','data'=>null]);
        }
    }

    public function queryByKeywords(){
        $input = input('post.');
        $where = [];
        if ($input['start_time']){
            $where['createTime'] = ['>',strtotime($input['start_time'])];
        }
        if ($input['end_time']){
            $where['createTime'] = ['<',strtotime($input['end_time'])];
        }
        if ($input['keywords']){
            $where['book_keeping'] = ['like','%'.$input['keywords'].'%'];
        }
        $list = $this->service->model()->where($where)->select();
        $this->assign('list',$list);
        $this->assign('type',100);
        return $this->fetch('index');
    }
}