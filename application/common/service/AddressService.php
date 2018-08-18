<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/8/15
 * Time: 10:47
 */

namespace app\common\service;


use app\common\model\Address;

class AddressService extends Service
{
    public function __construct()
    {
        $this->model = new Address();
    }
}