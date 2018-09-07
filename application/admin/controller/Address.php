<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/8/20
 * Time: 11:18
 */

namespace app\admin\controller;


use app\common\service\AddressService;
use think\Request;

class Address extends Base
{
    public function __construct(Request $request = null,AddressService $service)
    {
        parent::__construct($request);
        $this->service = $service;
    }

    public function index(){
        $keywors = input('keywords');
        $where = [];
        if ($keywors){
            $where['uname|phone'] = $keywors;
        }
        $list = $this->service->model()->hasWhere('User',$where)->order('uid')->paginate(20);
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function del(){
        $id = input('id');
        if (!$id){
            return json(['code'=>0,'msg'=>'参数错误','data'=>null]);
        }
        $goods = $this->service->model()->find($id);
        if ($goods){
            $res = $goods->delete();
            if ($res){
                return json(['code'=>1,'msg'=>'success','data'=>null]);
            }
            return json(['code'=>0,'msg'=>'网络异常','data'=>null]);
        }else{
            return json(['code'=>0,'msg'=>'数据有误','data'=>null]);
        }
    }

}