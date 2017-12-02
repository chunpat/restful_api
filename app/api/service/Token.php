<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 23:17
 */

namespace app\api\service;


use app\lib\enum\ScopeEnum;
use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{
    public static function generateToken(){
        //32随机字符组成
        $randChars = getRandChar(32);
        $timesstap = $_SERVER['REQUEST_TIME_FLOAT'];
        $salt = config('secure.token_salt');
        return md5($randChars.$timesstap.$salt);
    }

    public static function getCurrentTokenVar($key){

        $token = Request::instance()->header('token');

        if(!$token){
            throw new TokenException(
                ['msg'=>'未携带token']);
        }

        $vars = Cache::get($token);


        if(!$vars){
            throw new TokenException();
        }
        if(!is_array($vars)){
            $vars = json_decode($vars,true);
        }
        if(array_key_exists($key,$vars)){
            return $vars[$key];
        }else{
            throw new Exception('尝试获取token变量值不存在');
        }


    }

    public static function getCurrentUId(){
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }

    //需要普通权限
    public static function needPrimaryScope(){
        $scope = self::getCurrentTokenVar('scope');
        if($scope){
            if($scope >= ScopeEnum::user){
                return true;
            }else{
                throw new ForbiddenException();
            }
        }else{
            throw new TokenException();
        }
    }

    //只有
    public static function needExclusiveScope(){
        $scope = self::getCurrentTokenVar('scope');
        if($scope){
            if($scope == ScopeEnum::user){
                return true;
            }else{
                throw new ForbiddenException();
            }
        }else{
            throw new TokenException();
        }
    }

    public static function isValidOperate($uid = ''){
        if($uid != self::getCurrentUId()){
            return false;
        };
        return true;
    }


}