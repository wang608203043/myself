<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/8/16
 * Time: 17:11
 */

namespace app\common\behavior;


use app\common\model\User;
use think\Db;
use think\Env;
use think\Log;

class Extension
{
    /**
     * 推广行为  注册时触发
     * @param User $user
     * @param $isActive
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function run(&$user){
        //生成业绩记录
        $userModel = new User();
        $parent_one = $user->parent;
        $parent_two = $userModel->where(['id'=>$parent_one['pid']])->find();
        $parent_three = $userModel->where(['id'=>$parent_two['pid']])->find();
        $user_pay = 0;
        $award_one_limit = 0;
        $award_two_limit = 0;
        $award_three_limit = 0;
        $data = [];
        switch ($user->level){
            case 1:
                $user_pay = Env::get('level.one');
                break;
            case 2:
                $user_pay = Env::get('level.two');
                break;
            case 3:
                $user_pay = Env::get('level.three');
                break;
        }
        if ($parent_one){
            switch ($parent_one->level){
                case 1:
                    $award_one_limit = Env::get('level.one')*Env::get('limit');
                    break;
                case 2:
                    $award_one_limit = Env::get('level.two')*Env::get('limit');
                    break;
                case 3:
                    $award_one_limit = Env::get('level.three')*Env::get('limit');
                    break;
            }
            $award_one = $award_one_limit > $user_pay*Env::get('parent.one')?$user_pay*Env::get('parent.one'):$award_one_limit;
            array_push($data,['refereeId'=>$parent_one->id,'uid'=>$user->id,'payAmount'=>$user_pay,'refereeObtain'=>$award_one,'isDirect'=>1,'createTime'=>time(),'updateTime'=>time(),'status'=>$user->status]);
        }
        if ($parent_two){
            switch ($parent_two->level){
                case 1:
                    $award_two_limit = Env::get('level.one')*Env::get('limit');
                    break;
                case 2:
                    $award_two_limit = Env::get('level.two')*Env::get('limit');
                    break;
                case 3:
                    $award_two_limit = Env::get('level.three')*Env::get('limit');
                    break;
            }
            $award_two = $award_two_limit > $user_pay*Env::get('parent.two')?$user_pay*Env::get('parent.two'):$award_two_limit;
            array_push($data,['refereeId'=>$parent_two->id,'uid'=>$user->id,'payAmount'=>$user_pay,'refereeObtain'=>$award_two,'isDirect'=>0,'createTime'=>time(),'updateTime'=>time(),'status'=>$user->status]);
        }
        if ($parent_three){
            switch ($parent_three->level){
                case 1:
                    $award_three_limit = Env::get('level.one')*Env::get('limit');
                    break;
                case 2:
                    $award_three_limit = Env::get('level.two')*Env::get('limit');
                    break;
                case 3:
                    $award_three_limit = Env::get('level.three')*Env::get('limit');
                    break;
            }
            $award_three = $award_three_limit > $user_pay*Env::get('parent.three')?$user_pay*Env::get('parent.three'):$award_three_limit;
            array_push($data,['refereeId'=>$parent_three->id,'uid'=>$user->id,'payAmount'=>$user_pay,'refereeObtain'=>$award_three,'isDirect'=>0,'createTime'=>time(),'updateTime'=>time(),'status'=>$user->status]);
        }
        if ($data){
            Db::name('achievement')->insertAll($data); //未激活业绩入库
        }
    }
}