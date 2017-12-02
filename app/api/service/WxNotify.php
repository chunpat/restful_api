<?php
/**
 * Created by PhpStorm.
 * User: ZZHPENG
 * Date: 2017/11/24
 * Time: 23:27
 */

namespace app\api\service;

use app\api\model\Order as OrderModel;
use app\api\model\Product;
use app\lib\enum\OrderStatusEnum;
use think\Db;
use think\Exception;
use think\Loader;
use think\Log;

Loader::import('WxPay.WxPay',EXTEND_PATH,'.Api.php');
class WxNotify extends \WxPayNotify
{
    public function NotifyProcess($data, &$msg)
    {
        // <xml>
        //   <appid>wx2421b1c4370ec43b</appid>
        //   <attach>支付测试</attach>
        //   <body>JSAPI支付测试</body>
        //   <mch_id>10000100</mch_id>
        //   <detail><![CDATA[{ "goods_detail":[ { "goods_id":"iphone6s_16G", "wxpay_goods_id":"1001", "goods_name":"iPhone6s 16G", "quantity":1, "price":528800, "goods_category":"123456", "body":"苹果手机" }, { "goods_id":"iphone6s_32G", "wxpay_goods_id":"1002", "goods_name":"iPhone6s 32G", "quantity":1, "price":608800, "goods_category":"123789", "body":"苹果手机" } ] }]]></detail>
        //   <nonce_str>1add1a30ac87aa2db72f57a2375d8fec</nonce_str>
        //   <notify_url>http://wxpay.wxutil.com/pub_v2/pay/notify.v2.php</notify_url>
        //   <openid>oUpF8uMuAJO_M2pxb1Q9zNjWeS6o</openid>
        //   <out_trade_no>1415659990</out_trade_no>
        //   <spbill_create_ip>14.23.150.211</spbill_create_ip>
        //   <total_fee>1</total_fee>
        //   <trade_type>JSAPI</trade_type>
        //   <sign>0CB01533B8C1EF103065174F50BCA001</sign>
        //</xml>
        if($data['return_code'] = 'SUCCESS'){
                Db::startTrans();
                try{
                    $orderNo = $data['out_trade_no'];
                    $order = OrderModel::where('order_no','=',$orderNo)->lock(true)->find();

                    if($order->status = OrderStatusEnum::UNPAID){
                        $orderStatus = Order::checkOrderStock($order['id']);
                        if($orderStatus['pass']){
                            $this->updateOrderStatus($order->id,true);
                            $this->reduceStock($orderStatus);
                        }else{
                            $this->updateOrderStatus($order->id,false);
                        }
                    }

                    Db::commit();
                    return true;
                }catch (Exception $e){
                    Log::error($e->getMessage());
                    Db::rollback();
                    return false;
                }
        }else{
            //这里的true和false只是为了是否继续让微信发送信号，姑且为true告知微信不需要在发送了。
            return true;
        }

    }

    private function reduceStock($orderStatus = []){
        foreach ($orderStatus['pStatusArray'] as $k){
            Product::where('id','=',$k['id'])->setDec('stock',$k['count']);
        }
    }

    private function updateOrderStatus($order_id = -1 ,$status = false){
        $orderStatus = $status?
                OrderStatusEnum::PAID :
                OrderStatusEnum::PAID_BUT_OUT_OF;
        OrderModel::where('id','=',$order_id)->save(['status'=>$orderStatus]);

    }
}