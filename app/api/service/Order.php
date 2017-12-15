<?php
/**
 * Created by PhpStorm.
 * User: ZZHPENG
 * Date: 2017/11/8
 * Time: 23:02
 */

namespace app\api\service;
use app\api\model\OrderProduct;
use app\api\model\Product;
use app\api\model\UserAddress;
use app\lib\enum\OrderStatusEnum;
use app\lib\exception\OrderException;
use app\lib\exception\UserException;
use think\Db;

class Order
{
    public function place($uid,$oProducts){
        $this->uid = $uid;
        $this->oProducts = $oProducts;
        $this->products = $this->getProductsByOrder($oProducts);
        $result = $this->getOrderStatus();

        if(!$result['pass']){
            $result['order_id'] = -1;
            return $result;
        }

        //创建订单
        $snap = $this->getSnapOrder($result);
        $order = $this->makeOrder($snap);
        $order['pass'] = true;
        return $order;
    }

    private function makeOrder($snap){
        Db::startTrans();
        try{
                $orderSN = self::makeOrderNo();
                $orderModel = new \app\api\model\Order();
                $orderModel->order_no = $orderSN;
                $orderModel->user_id =  $this->uid;
                $orderModel->total_price = $snap['orderPrice'];
                $orderModel->snap_img = $snap['snapImg'];
                $orderModel->snap_name = $snap['snapName'];
                $orderModel->total_count = $snap['totalCount'];
                $orderModel->snap_items = json_encode($snap['pStatus']);
                $orderModel->snap_address = $snap['snapAddress'];
                $orderModel->save();

                $orderId = $orderModel->id;
                foreach ($this->oProducts as &$p){
                    $p['order_id'] = $orderId;
                }
                $orderProductModel = new OrderProduct();
                $orderProductModel->saveAll($this->oProducts);
                Db::commit();
                return [
                    'order_id'=>$orderId,
                    'order_no'=>$orderSN,
                    'create_time'=>$orderModel->create_time
                ];

        }catch (Exception $ex){
                 Db::rollback();
                throw $ex;
        }
    }

    private function getSnapOrder($result){
        $snap = [
            'orderPrice'=>0,
            'totalCount'=>0,
            'pStatus' => [],
            'snapAddress'=>'',
            'snapName'=>'',
            'snapImg'=>'',
        ];
        $snap['orderPrice'] = $result['orderPrice'];
        $snap['totalCount'] = $result['totalCount'];
        $snap['pStatus'] = $result['pStatusArray'];
        $snap['snapAddress'] = json_encode($this->getUserAddress($this->uid));
        $snap['snapName'] = $result['pStatusArray'][0]['name'];
        $snap['snapImg'] = $result['pStatusArray'][0]['main_img_url'];

        if(count($result['pStatusArray']) > 1){
            $snap['snapName'] = $snap['snapName'].' 等';
        }
        return $snap;
    }


    public function checkOrderStock($order_id){

        $oProduct = OrderProduct::where('order_id','=',$order_id)->select();
        $this->oProducts = $oProduct;
        $this->products = $this->getProductsByOrder($oProduct);
        $status = $this->getOrderStatus();
        return $status;
    }

    private function getOrderStatus(){

        $Status = [
            'pass'=>true,
            'orderPrice'=>0,
            'totalCount'=>0,
            'pStatusArray' => []
        ];
        foreach ($this->oProducts as $v){
            $pStatus = $this->getProductStatus($v['product_id'],$v['count'],$this->products);

            if(!$pStatus['haveStack']){
                $Status['pass'] = false;
            }
            $Status['orderPrice'] += $pStatus['totalPrice'];
            $Status['totalCount'] += $pStatus['count'];

            array_push($Status['pStatusArray'],$pStatus);
        }
        return $Status;


    }

    private function getProductStatus($oPID,$oCount,$products)
    {
        $pIndex = -1;
        $pStatus =[
            'id' => null,
            'count' =>0,
            'name'=>'',
            'totalPrice' =>0,
             'haveStack'=>false
        ];
        for($i = 0;$i<count($this->products); $i++){
            if($oPID == $this->products[$i]['id']){
                $pIndex = $i;
            }
        }

        if($pIndex == -1){
            throw new OrderException(['msg'=>$oPID.'商品不存在，创建订单失败']);
        }
        $product = $products[$pIndex];
        $pStatus['id'] = $product['id'];
        $pStatus['count'] = $oCount;
        $pStatus['name'] = $product['name'];
        $pStatus['main_img_url'] = $product['main_img_url'];
        $pStatus['totalPrice'] = $product['price']*$oCount;

        if($products[$pIndex]['stock'] >= $oCount){
            $pStatus['haveStack'] = true;
        }

        return $pStatus;
    }



    private function getProductsByOrder($oProducts){
        $arr = [];
        foreach ($oProducts as $k=>$v){
            array_push($arr,$v['product_id']);
        }
        $products = Product::All($arr)->visible(['id','price','stock','name','main_img_url'])->toArray();
        return $products;
    }

    private function getUserAddress(){
        $userAddress = UserAddress::where('user_id','=',$this->uid)->find();
        if(!$userAddress){
            throw new UserException([
                "msg"=>'用户地址不存在,下单失败',
                'errorCode'=>60000
            ]);
        }

        return $userAddress->toArray();
    }

    public static function makeOrderNo()
    {
        $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
        $orderSn =
            $yCode[intval(date('Y')) - 2017] . strtoupper(dechex(date('m'))) . date(
                'd') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf(
                '%02d', rand(0, 99));
        return $orderSn;
    }



    public function delivery($orderID,$jumpUrl = ''){
        $orderDetail = OrderModel::get($orderID);
        if(!$orderDetail){
            throw new OrderException();
        }
        if($orderDetail->status != OrderStatusEnum::PAID){
            throw new OrderException(
                [
                    'msg' =>'还没支付呢，想干嘛？或许你已经更新了订单，别再刷了！',
                    'code'=>403,
                    'errorCode'=>80002
                ]
            );
        }
        $orderDetail->status = OrderStatusEnum::DELIVERED;
        $orderDetail->save();
        $delivery = new DeliveryMessage();
        return $delivery->sendDeliveryMessage($orderDetail,$jumpUrl);

    }
}