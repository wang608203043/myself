<?php
namespace app\index\controller;

use think\Env;

class Index
{
    public function index()
    {
        $level = Env::get('level.one');
        print_r($level);
    }
}
