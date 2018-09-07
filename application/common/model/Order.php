<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/8/15
 * Time: 10:39
 */

namespace app\common\model;


use think\Model;

class Order extends Model
{
    protected $name = 'order';
    protected $autoWriteTimestamp = true;
    protected $createTime = 'createTime';
    protected $updateTime = 'updateTime';

    public function user(){
        return $this->belongsTo('User','uid','id')->field('id,uname,phone,aliAccount');
    }

    public function address(){
        return $this->belongsTo('Address','addressId','id');
    }

    public function consumption(){
        return $this->hasMany('Consumption','oid','id');
    }

    public function detail(){
        return $this->hasMany('Detail','oid','id');
    }
}