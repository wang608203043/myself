<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/8/15
 * Time: 10:45
 */

namespace app\common\service;


use app\common\model\User;

class UserService extends Service
{
    public function __construct()
    {
        $this->model = new User();
    }
}