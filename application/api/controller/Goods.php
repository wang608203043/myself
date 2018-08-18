<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/8/18
 * Time: 11:22
 */

namespace app\api\controller;


use app\common\service\GoodsService;
use think\Request;

class Goods extends Base
{
    public function __construct(Request $request = null,GoodsService $service)
    {
        parent::__construct($request);
        $this->service = $service;
    }

    public function getList(){
        return 'aaa';
    }
}