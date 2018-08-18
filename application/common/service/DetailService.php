<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/8/15
 * Time: 10:50
 */

namespace app\common\service;


use app\common\model\Detail;

class DetailService extends Service
{
    public function __construct()
    {
        $this->model = new Detail();
    }
}