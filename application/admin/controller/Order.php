<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/8/20
 * Time: 11:46
 */

namespace app\admin\controller;


use app\common\service\OrderService;
use think\Request;

class Order extends Base
{
    public function __construct(Request $request = null,OrderService $service)
    {
        parent::__construct($request);
        $this->service = $service;
    }

    public function index(){
        $status = input('status',0);
        $where = ['status'=>$status];
        $list = $this->service->model()->where($where)->paginate(20);
        $this->assign('list',$list);
        $this->assign('status',$status);
        return $this->fetch();
    }


    public function changeOrder(){ //发货
        $id = input('post.id');
        $order = $this->service->model()->find($id);
        $order->consumption()->setField('status',1); //激活销售业绩
        $order->status = 2;
        if ($order->save()){
            return json(['code'=>1,'msg'=>'success','data'=>null]);
        }
        return json(['code'=>0,'msg'=>'网络异常','data'=>null]);
    }

    public function detail(){
        $id = input('id');
        $order = $this->service->model()->find($id);
        $this->assign('order',$order);
        return $this->fetch();
    }
}