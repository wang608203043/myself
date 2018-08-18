<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/8/15
 * Time: 10:44
 */

namespace app\common\service;


use think\Model;

class Service
{
    protected $model;

    /**
     * @return Model
     */
    public function model(){
        return $this->model;
    }
}