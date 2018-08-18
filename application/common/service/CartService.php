<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/8/15
 * Time: 10:48
 */

namespace app\common\service;


use app\common\model\Cart;

class CartService extends Service
{
    public function __construct()
    {
        $this->model = new Cart();
    }
}