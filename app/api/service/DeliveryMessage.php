<?php
/**
 * Created by PhpStorm.
 * User: ZZHPENG
 * Date: 2017/12/13
 * Time: 21:10
 */

namespace app\api\service;


use app\api\model\User as UserModel;
use app\lib\exception\OrderException;

class DeliveryMessage extends WxMessage
{
    const DELIVERY_MSG_ID = "your template message id";

    public function sendDeliveryMessage($order,$tplJumpPage = ''){
        if(!$order){
            throw new OrderException();
        }
        $this->tplId = self::DELIVERY_MSG_ID;
        $this->page = $tplJumpPage;
        $this->formId = $order->prepay_id;
        $this->data = $this->prepareMessageData($order);
        $this->emphasisKeyword = "keyword1.DATA";
        return parent::sendMessage(UserModel::getOpenIdByUserId($order->user_id));
    }
    private function prepareMessageData($order){
        $dt = new \DateTime();
        return [
            'keyword1'=>[
                "value"=>"XX快递",
            ],
            'keyword2'=>[
                "value"=>$order->snap_name,
                "color"=> "#173177"
            ],
            'keyword3'=>[
                "value"=>$order->order_sn,
            ],
            'keyword4'=>[
                "value"=>$dt->format('Y-m-d H:i'),
             ]
        ];
    }

}