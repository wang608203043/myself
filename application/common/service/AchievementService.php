<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/8/15
 * Time: 10:46
 */

namespace app\common\service;


use app\common\model\Achievement;

class AchievementService extends Service
{
    public function __construct()
    {
        $this->model = new Achievement();
    }
}