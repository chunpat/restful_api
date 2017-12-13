<?php
/**
 * Created by PhpStorm.
 * User: ZZHPENG
 * Date: 2017/12/13
 * Time: 22:11
 */

namespace app\api\service;


use think\Cache;
use think\Exception;

class AccessToken
{
    private $send_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s";
    const TOKEN_CACHED_KEY = 'access';
    const TOKEN_EXPIRED_IN = 7000;

    public function __construct()
    {
        $this->send_url = sprintf($this->send_url,config("wx.app_id"),config("wx.app_secret"));
    }

    public function get(){
        $token = $this->getFromCache();
        if(!$token){
            return $this->getFromServer();
        }
        return $token;
    }

    private function getFromServer(){
        $WxResult = curl_get($this->send_url);
        $result = json_decode($WxResult,true);
        if(!empty($result['errcode'])){
            throw new Exception("获取access_token异常");
        }
        $this->saveToCache($result['access_token']);
        return $result['access_token'];
    }

    private function getFromCache(){
        $token = Cache::get(self::TOKEN_CACHED_KEY);
        if(!$token){
            return false;
        }else{
            return $token;
        }
    }

    private function saveToCache($token = ''){
        Cache::set(self::TOKEN_CACHED_KEY,$token,self::TOKEN_EXPIRED_IN);
    }

}