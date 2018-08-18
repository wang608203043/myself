<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/8/15
 * Time: 10:51
 */

namespace app\common\service;


use app\common\model\Order;

class OrderService extends Service
{
    public function __construct()
    {
        $this->model = new Order();
    }
}