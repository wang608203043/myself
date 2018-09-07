<?php
/**
 * Created by PhpStorm.
 * User: mayn
 * Date: 2018/7/21
 * Time: 17:08
 */

namespace app\api\controller;


use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use think\Cache;
use think\Controller;
use think\Hook;
use think\Request;
define('UPLOAD_PATH',ROOT_PATH.'public/upload/');
class Base extends Controller
{
    const KEY = 'access_token_key';
    protected $service;
    protected $err_msg = 'success';
    protected $err_code = 0;
    protected $result = null;
    /**
     * Base constructor.
     * @param Request|null $request
     */
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        Hook::add('extension','app\common\behavior\Extension');
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With,Authorization,Content-Type');
        header('Access-Control-Allow-Methods: OPTIONS,GET,POST');
        header('Access-Control-Expose-Headers: Authorization');
        header('Cache-Control: no-store');
        $controller  = request()->controller();
        if (strtolower($controller)!=='login'&&strtolower($controller)!=='register'){
            $token = request()->header('authorization');
            try {
                JWT::decode($token,self::KEY,array('HS256'));
            } catch (ExpiredException $exception) {
                $cache = Cache::get('token_'.$token);
                if ($cache){
                    $this->createToken($token);
                }else{
                    $this->err_msg = 'token已过期，请重新登陆';
                    $this->err_code = 1001;
                    $this->httpErrorResponse(401);
                }
            }catch (\Exception $exception) {
                $this->err_msg = $exception->getMessage();
                $this->err_code = 1001;
                $this->httpErrorResponse(401);
            }
        }
    }


    protected function createToken($token=''){
        $expiry = 3600*24*7;
        $time = Cache::get('token_'.$token)||(time()+$expiry);
        if ($token){
            Cache::rm('token_'.$token);
            $expiry = $time - time();
        }
        $payload = array(
            "iss" => "http://xuryin.com",
            "iat" => time(),
            "exp" => time()+7200,
            'rand'=>rand(0,1000000000)
        );
        $jwt = JWT::encode($payload,self::KEY);
        Cache::set('token_'.$jwt,$time,$expiry);//可刷新一周，之后必须登陆
        header('Authorization:'.$jwt);
    }

    /**
     * @param int $code
     */
    protected function httpErrorResponse($code){
        http_response_code($code);
        $data = ['err_code'=>$this->err_code,'err_msg'=>$this->err_msg];
        exit(json_encode($data));
    }

    protected function jsonReturn($code = 200){
        return json(['err_code'=>$this->err_code,'err_msg'=>$this->err_msg,'result'=>$this->result],$code);
    }
}