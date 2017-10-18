<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 23:17
 */

namespace app\api\service;


class Token
{
    public static function generateToken(){
        //32随机字符组成
        $randChars = getRandChar(32);
        $timesstap = $_SERVER['REQUEST_TIME_FLOAT'];
        $salt = config('secure.token_salt');
        return md5($randChars.$timesstap.$salt);
    }
}