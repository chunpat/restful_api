<?php
/**
 * Created by PhpStorm.
 * User: ZZHPENG
 * Date: 2017/12/13
 * Time: 21:16
 */

namespace app\api\service;


use think\Exception;

class WxMessage
{
    private $send_url = "https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token=%s";
    private $touser;
    private $color = 'black';
    protected $tplId;
    protected $page;
    protected $formId;
    protected $data;
    protected $emphasisKeyword;

    public function __construct()
    {
        $accessToken = new AccessToken();
        $token = $accessToken->get();
        $this->send_url = sprintf($this->send_url,$token);
    }

    protected function sendMessage($openId){
        $this->touser = $openId;
        $data = [
            'touser' => $this->touser,
            'template_id' => $this->tplId,
            'page' => $this->page,
            'form_id' => $this->formId,
            'data' => $this->data,
            'color' => $this->color,
            'emphasis_keyword' => $this->emphasisKeyword,

        ];
        $WxResult = curl_post($this->send_url,$data);
        $result = json_decode($WxResult,true);
        if(!$result){
            throw new Exception('发送收货微信短信出错');
        }
        if($result['errcode'] == 0){
            return true;
        }else{
            throw new Exception('模板消息发送失败-'.$result['errcode'].$result['errmsg']);
        }
    }


}