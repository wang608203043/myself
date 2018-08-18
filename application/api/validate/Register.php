<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/8/18
 * Time: 16:40
 */

namespace app\api\validate;


use think\Validate;

class Register extends Validate
{
    protected $rule = [
        'cardId|身份证号'=>'require',
        'uname|姓名'=>'require',
        'phone|手机号'=>'require|integer|length:11',
        'level|会员等级'=>'require',
        'aliAccount|支付宝账号'=>'require',
        'parent|上级'=>'require'
    ];
}