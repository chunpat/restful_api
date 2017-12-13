<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/11
 * Time: 20:53
 */

namespace app\api\controller\v1;


use app\api\validate\ThirdAppValidate;
use app\api\validate\TokenGet;
use app\api\service\UserToken;
use app\lib\exception\ParameterException;
use app\api\service\Token as TokenService;

class Token
{
    public function getToken($code = ''){
        (new TokenGet())->goCheck();
        $tk = new UserToken($code);
        $token =$tk->get();
//        $token =UserToken::get();
        return json([
           'token' => $token,
        ]);

    }

    public function getAppToken($ac = '',$se = ''){
        (new ThirdAppValidate())->goCheck();
    }

    public function verifyToken($token = ''){
        if(!$token){
            throw new ParameterException(
                [
                    'msg' => 'token参数不能为空'
                ]
            );
        }

        $valid = TokenService::verifyToken($token);
        return json([
            'isValid' =>$valid
        ]);
    }
}