<?php
/**
 * Created by PhpStorm.
 * User: ZZHPENG
 * Date: 2017/11/7
 * Time: 22:23
 */

namespace app\api\controller\v1;

use app\api\controller\BaseController;
use app\api\service\DeliveryMessage;
use app\api\v1;
use app\api\validate\IDMustBePositiveInt;
use app\api\validate\OrderPlace;
use app\api\service\Token;
use app\api\service\Order as OrderService;
use app\api\model\Order as OrderModel;
use app\api\validate\PagingParameter;
use app\lib\exception\OrderException;
use app\lib\exception\SuccessMessage;

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

    /**
     * 下单
     * @author: zzhpeng
     * Date: 2019/5/29
     * @return \think\response\Json
     * @throws \app\lib\exception\ParameterException
     * @throws \app\lib\exception\TokenException
     * @throws \think\Exception
     *
     * @api                {POST}  /api/v1/order 下单
     * @apiName            placeOrder
     * @apiGroup           Order
     * @apiVersion         0.0.1
     * @apiSampleRequest   /api/v1/order
     * @apiDescription     下单
     *
     * @apiParam {array} products 	订单的产品id和产品数量的数组
     * @apiParam {int} products.product_id 	products数组下的产品id
     * @apiParam {int} products.count 	products数组下的产品数量
     *
     * @apiSuccess {string} order_id
     * @apiSuccess {string} order_no
     * @apiSuccess {string} create_time
     * @apiSuccess {bool} pass
     *
     * @apiUse             BaseResponse
     *
     * @apiUse             SuccessResponse
     * @apiUse             FailResponse
     */
    public function placeOrder(){
        (new OrderPlace())->goCheck();
        $products = input('post.products/a');
        $uid =Token::getCurrentTokenVar('uid');

        $order = new OrderService();
        $status = $order->place($uid,$products);
        return json($status);
    }

    /**
     * @author: zzhpeng
     * Date: 2019/5/29
     * @param int $pages
     * @param int $size
     *
     * @return array|\think\response\Json
     * @throws \app\lib\exception\ParameterException
     * @throws \app\lib\exception\TokenException
     * @throws \think\Exception
     */
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

    /**
     * @author: zzhpeng
     * Date: 2019/5/29
     * @param int $pages
     * @param int $size
     *
     * @return array|\think\response\Json
     * @throws \app\lib\exception\ParameterException
     * @throws \app\lib\exception\TokenException
     * @throws \think\Exception
     */
    public function getDetail($id = 0){
        (new IDMustBePositiveInt())->goCheck();
        $orderDetail = OrderModel::get($id);
        if(!$orderDetail){
            throw new OrderException();
        }

        return $orderDetail->hidden(['prepay_id']);
    }

    public function delivery($id = 0,$jump_url=''){
        (new IDMustBePositiveInt())->goCheck();
        //判断数据&&发送消息
        $success = OrderService::delivery($id,$jump_url);
        if($success){
            return new SuccessMessage();
        }
    }
}