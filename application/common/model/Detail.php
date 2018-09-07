<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/8/15
 * Time: 10:38
 */

namespace app\common\model;


use think\Model;

class Detail extends Model
{
    protected $name = 'detail';

    public function goods(){
        return $this->belongsTo('Goods','gid','id');
    }
}