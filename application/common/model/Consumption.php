<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/8/15
 * Time: 10:38
 */

namespace app\common\model;


use think\Model;

class Consumption extends Model
{
    protected $name = 'consumption';
    protected $autoWriteTimestamp = true;
    protected $createTime = 'createTime';
    protected $updateTime = 'updateTime';
}