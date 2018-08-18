<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/6/8
 * Time: 17:10
 */

namespace app\admin\controller;

use think\Controller;
use think\Hook;
use think\Request;
define('UPLOAD_PATH',ROOT_PATH.'public/upload/');
class Base extends Controller
{
    protected $service;
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        Hook::add('extension','app\common\behavior\Extension');
        $controller = $request->controller();
        if (strtolower($controller)!=='login'&&!session('admin')){
            $this->redirect('login/index');
        }
    }

}