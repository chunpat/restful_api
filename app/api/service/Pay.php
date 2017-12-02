<?php
/**
 * Created by PhpStorm.
 * User: ZZHPENG
 * Date: 2017/11/18
 * Time: 17:30
 */

namespace app\api\service;

use app\api\model\Order as OrderModel;
use app\api\service\Order as OrderService;
use app\lib\enum\OrderStatusEnum;
use app\lib\exception\OrderException;
use app\lib\exception\TokenException;
use think\Exception;
use think\helper\hash\Md5;
use think\Loader;
use think\Log;

Loader::import('WxPay.WxPay',EXTEND_PATH,'.Api.php');

class Pay
{
    protected $orderID;
    protected $orderNO;
    function __construct($orderId = ''){
        if(!$orderId){
            throw new Exception('参数订单id不允许为null');
        }
        $this->orderID = $orderId;
    }
    public  function  goPay(){
        /**
         *  1、检测订单order_id是否真实存在
         *  2、检测订单order与用户是否匹配
         *  3、检测订单是否已经支付过
         *  4、检测判断库存
         **/

        $order = $this->checkOrderValid();
        $this->orderNO = $order->order_no;
        $orderService = new OrderService();
        $status = $orderService->checkOrderStock($this->orderID);
        if(!$status['pass']){
           return $status;
        }
        return $this->makeWxPreOrder($status['orderPrice']);
    }

    private function makeWxPreOrder($totalPrices){
        //①、获取用户openid
        $openId = Token::getCurrentTokenVar('openid');
        if(!$openId){
            throw new TokenException();
        }
        //②、统一下单
        $input =  new \WxPayUnifiedOrder();
        $input->SetBody("炒蛋饭");
        $input->SetAttach("水潭");
        $input->SetOut_trade_no($this->orderNO);
        //以分为单位
        $input->SetTotal_fee($totalPrices*100);
//        $input->SetTime_start(date("YmdHis"));
//        $input->SetTime_expire(date("YmdHis", time() + 600));
//        $input->SetGoods_tag("test");
        $input->SetNotify_url(config('secure.pay_back_url'));
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);
        return $this->getPaySignature($input);
    }

    private function getPaySignature($input){
        $wxOrder = \WxPayApi::unifiedOrder($input);
        if($wxOrder['return_code'] != 'SUCCESS' || $wxOrder['result_code'] !='SUCCESS'){
            Log::record($wxOrder,'error');
            Log::record('获取预先支付订单失败','error');
            throw new Exception($wxOrder['return_msg']);
        }
        //prepay_id
        $this->recordOrderPrepayId($wxOrder['prepay_id']);
        $sign = $this->sign($wxOrder['prepay_id']);
        return $sign;
    }

    private function sign($prepayID){
        $jsApiPayData = new \WxPayJsApiPay();
        $jsApiPayData->SetAppid(config('wx.app_id'));
        $jsApiPayData->SetTimeStamp((string)time());
        $rand = md5(time().mt_rand(0,1000));
        $jsApiPayData->SetNonceStr($rand);
        $jsApiPayData->SetPackage('prepay_id='.$prepayID);
        $jsApiPayData->SetSignType('MD5');
        $sign = $jsApiPayData->MakeSign();
        $result = $jsApiPayData->GetValues();
        $result['paySign'] = $sign;
        unset($result['appid']);
        return $result;
    }

    private function recordOrderPrepayId($prepayID){
        $result = OrderModel::where('id','=',$this->order_id)->update(['prepay_id' =>$prepayID]);
        if(!$result){
            throw new Exception('更新prepay_id失败');
        }
    }
    private function checkOrderValid(){
        $order = OrderModel::where('id','=',$this->orderID)->find();
        if(!$order){
            throw new Exception('该orderId订单不存在');
        }
        if(!Token::isValidOperate($order->user_id)){
            throw new TokenException([
                'msg'=>'订单与用户不匹配',
                'errorCode'=>10003,
            ]);
        }
        if($order->status != OrderStatusEnum::UNPAID){
            throw new OrderException(
                [
                    'msg'=>'该订单已经支付过啦',
                    'code' =>400,
                    'errorCode'=>80003
                ]
            );
        }

        return $order;

    }
}