<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Author: wang
 * Date: 2018/9/19
 * Time: 15:01
 */

namespace app\common\model;


use think\Model;

class AccountBook extends Model
{
    protected $name = 'account_book';
    protected $createTime = 'createTime';
    protected $updateTime = 'updateTime';
    protected $autoWriteTimestamp = true;
}