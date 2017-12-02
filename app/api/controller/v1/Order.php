<?php
/**
 * Created by PhpStorm.
 * User: ZZHPENG
 * Date: 2017/11/7
 * Time: 22:23
 */

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\v1;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\OrderPlace;
use app\api\service\Token;
use app\api\service\Order as OrderService;
use app\api\model\Order as OrderModel;
use app\api\validate\PagingParameter;
use app\lib\exception\OrderException;

class Order extends BaseController
{
    //传商品信息，判断库存
    //有库存下订单，吊起支付
    //判断库存，支付成功
    //回调，判断库存
    protected $beforeActionList =[
        'needExclusiveScope'=>['only'=>'placeOrder'],
        'needPrimaryScope'=>['only'=>'getSummaryByUser,getDetail']
    ];

    public function placeOrder(){
        (new OrderPlace())->goCheck();
        $products = input('post.products/a');
        $uid =Token::getCurrentTokenVar('uid');

        $order = new OrderService();
        $status = $order->place($uid,$products);
        return json($status);
    }

    public function getSummaryByUser($pages = 1, $size=15){
        (new PagingParameter())->goCheck();
        $uid =Token::getCurrentTokenVar('uid');
        $pagingOrder= OrderModel::getSummaryByUser($uid,$pages,$size);

        if($pagingOrder->isEmpty()){
            return [
              'data'=>[],
                'currentPage' => $pagingOrder->currentPage()
            ];
        }
        $pagingOrder->hidden(['snap_items','snap_address','prepay_id'])->toArray();
        return json([
            'data'=>$pagingOrder,
            'currentPage' => $pagingOrder->currentPage()
        ]);
    }

    public function getDetail($id = 0){
        (new IDMustBePositiveInt())->goCheck();
        $orderDetail = OrderModel::get($id);
        if(!$orderDetail){
            throw new OrderException();
        }

        return $orderDetail->hidden(['prepay_id']);
    }
}