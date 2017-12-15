<?php
/**
 * Created by PhpStorm.
 * User: ZZHPENG
 * Date: 2017/12/13
 * Time: 22:12
 */

namespace app\api\service;


use app\api\model\ThirdApp;
use app\lib\exception\TokenException;
use app\lib\exception\UserException;
use think\Cache;
use think\Exception;

class AppToken extends Token
{
    public function get($ac,$se){
        $app = ThirdApp::check($ac,$se);
        if(!$app){
            throw new TokenException(
                [
                    'errorCode'=>10004,
                    'msg'=>'授权失败'
                ]
            );
        }
        $scope = $app->scope;
        $uid = $app->id;
        $value = [
            'scope' => $scope,
            'uid' => $uid
        ];
        return $token = $this->saveToCache($value);

    }

    private function saveToCache($value){
        $token = Token::generateToken();
        $expire_in = Config('setting.token_expire_in');
        $result = Cache::set($token,json_encode($value),$expire_in);
        if(!$result){
            throw new TokenException(
                [
                'errorCode'=>10005,
                'msg'=>'服务器缓存异常'
            ]);
        }
        return $token;
    }
}