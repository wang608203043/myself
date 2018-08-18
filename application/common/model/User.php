<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/8/15
 * Time: 10:38
 */

namespace app\common\model;


use think\Model;

class User extends Model
{
    protected $name = 'user';
    protected $autoWriteTimestamp = true;
    protected $createTime = 'createTime';
    protected $updateTime = 'updateTime';

    public function parent(){
        return $this->belongsTo('User','pid','id')->field('id,pid,uname,phone,extensionCode,level');
    }

    public function achievement(){
        return $this->hasMany('Achievement','refereeId','id');
    }

    public function activation(){
        return $this->hasMany('Achievement','uid','id');
    }
}