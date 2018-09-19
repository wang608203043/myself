<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/8/15
 * Time: 10:51
 */

namespace app\common\service;


use app\common\model\AccountBook;

class AccountBookService extends Service
{
    public function __construct()
    {
        $this->model = new AccountBook();
    }
}