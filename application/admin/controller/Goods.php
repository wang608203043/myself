<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/6/9
 * Time: 17:00
 */

namespace app\admin\controller;

use app\common\service\GoodsService;
use think\Request;

class Goods extends Base
{
    protected $service;
    public function __construct(Request $request = null,GoodsService $service)
    {
        parent::__construct($request);
        $this->service = $service;
    }

    public function index(){
        $list = $this->service->model()->select();
        $this->assign('list',$list);
        return $this->fetch();
    }

    public function add(){
        return $this->fetch();
    }

    public function add_confirm(){
        $input = input('post.');
        $file = $this->request->file('file');
        $imgUrls = '';
        if ($file){
            $info = $file->move(UPLOAD_PATH);
            $input['headUrl'] = '/upload/'.$info->getSaveName();
        }
        if ($input['file1']){
            $input['file1'] = base64_image_content($input['file1'],UPLOAD_PATH);
            $imgUrls .= ','.$input['file1'];
        }
        if ($input['file2']){
            $input['file2'] = base64_image_content($input['file2'],UPLOAD_PATH);
            $imgUrls .= ','.$input['file2'];
        }
        if ($input['file3']){
            $input['file3'] = base64_image_content($input['file3'],UPLOAD_PATH);
            $imgUrls .= ','.$input['file3'];
        }
        $input['imgUrls'] = trim($imgUrls,',');
        if ($this->service->model()->allowField(true)->save($input)){
            return json(['code'=>1,'msg'=>'success','data'=>null]);
        }else{
            return json(['code'=>0,'msg'=>'网络异常','data'=>null]);
        }
    }

    public function edit(){
        $id = input('id');
        $detail = $this->service->model()->find($id);
        $imgUrls = $detail->imgUrls;
        $imgs = explode(',',$imgUrls);
        $this->assign('imgs',$imgs);
        $this->assign('detail',$detail);
        return $this->fetch();
    }

    public function edit_confirm(){
        $input = input('post.');
        $file = $this->request->file('file');
        $imgUrls = '';
        if ($file){
            $info = $file->move(UPLOAD_PATH);
            $input['headUrl'] = '/upload/'.$info->getSaveName();
        }
        if ($input['file1']){
            $input['file1'] = base64_image_content($input['file1'],UPLOAD_PATH);
            $imgUrls .= ','.$input['file1'];
        }
        if ($input['file2']){
            $input['file2'] = base64_image_content($input['file2'],UPLOAD_PATH);
            $imgUrls .= ','.$input['file2'];
        }
        if ($input['file3']){
            $input['file3'] = base64_image_content($input['file3'],UPLOAD_PATH);
            $imgUrls .= ','.$input['file3'];
        }
        if ($url = trim($imgUrls,',')){
            $input['imgUrls'] = $url;
        }
        if ($this->service->model()->allowField(true)->save($input,['id'=>$input['id']])){
            return json(['code'=>1,'msg'=>'success','data'=>null]);
        }else{
            return json(['code'=>0,'msg'=>'网络异常','data'=>null]);
        }
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

    public function changeStatus(){
        $input = input('post.');
        $res = $this->service->model()->update($input);
        if ($res){
            return json(['code'=>1,'msg'=>'success','data'=>$res]);
        }
        return json(['code'=>0,'msg'=>'网络异常','data'=>null]);
    }
}