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
use think\Request;

class Base extends Controller
{
    const KEY = 'access_token_key';
    protected $service;

    /**
     * Base constructor.
     * @param Request|null $request
     */
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        header("Access-Control-Allow-Origin: *");
        header('Access-Control-Allow-Headers: X-Requested-With,Authorization,Content-Type');
        header('Access-Control-Allow-Methods: OPTIONS,GET,POST');
        header('Access-Control-Expose-Headers: Authorization');
        header('Cache-Control: no-store');
        $controller  = request()->controller();
        if (strtolower($controller)!=='login'){
            $token = request()->header('authorization');
            try {
                JWT::decode($token,self::KEY,array('HS256'));
            } catch (ExpiredException $exception) {
                $cache = Cache::get('token_'.$token);
                if ($cache){
                    $this->createToken($token);
                }else{
                    $this->httpErrorResponse(401,['error'=>'token已过期']);
                }
            }catch (\Exception $exception) {
                $this->httpErrorResponse(401,['error'=>$exception->getMessage()]);
            }
        }
    }


    protected function createToken($token=''){
        if ($token){
            Cache::rm('token_'.$token);
        }
        $payload = array(
            "iss" => "http://xuryin.com",
            "iat" => time(),
            "exp" => time()+20,
            'rand'=>rand(0,1000000000)
        );
        $jwt = JWT::encode($payload,self::KEY);
        Cache::set('token_'.$jwt,1,40);
        header('Authorization:'.$jwt);
    }

    /**
     * @param int $code
     * @param null $data
     */
    protected function httpErrorResponse($code,$data = null){
        http_response_code($code);
        exit(json_encode($data));
    }
}