<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/8/15
 * Time: 10:49
 */

namespace app\common\service;


use app\common\model\Consumption;

class ConsumptionService extends Service
{
    public function __construct()
    {
        $this->model = new Consumption();
    }
}