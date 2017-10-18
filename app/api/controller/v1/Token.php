<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/11
 * Time: 20:53
 */

namespace app\api\controller\v1;


use app\api\validate\TokenGet;
use app\api\service\UserToken;

class Token
{
    public function getToken($code = ''){
        (new TokenGet())->goCheck();

        $tk = new UserToken($code);
        $token = $tk ->get();
        return [
           'token' => $token,
        ];

    }
}