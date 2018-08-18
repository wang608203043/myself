<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/8/15
 * Time: 10:38
 */

namespace app\common\model;


use think\Model;

class Address extends Model
{
    protected $name = 'address';
    protected $autoWriteTimestamp = true;
    protected $createTime = 'createTime';
    protected $updateTime = 'updateTime';
}