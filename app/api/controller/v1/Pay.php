<?php
/**
 * Created by PhpStorm.
 * User: ZZHPENG
 * Date: 2017/11/18
 * Time: 17:21
 */

namespace app\api\controller\v1;

use app\api\service\Pay as PayService;
use app\api\controller\BaseController;
use app\api\service\WxNotify;
use app\api\validate\IDMustBePositiveInt;

class Pay  extends BaseController
{
    /**
     * 小程序支付，返回预支付数据
     * @author: zzhpeng
     * Date: 2019/5/29
     * @param string $id
     *
     * @return array
     * @throws \app\lib\exception\ParameterException
     * @throws \think\Exception
     *
     * @api                {POST} /api/v1/pay/pre_order 小程序支付，返回预支付数据
     * @apiName            pre_order
     * @apiGroup           Order
     * @apiVersion         0.0.1
     * @apiSampleRequest   /api/v1/pay/pre_order
     * @apiDescription     小程序支付，返回预支付数据
     *
     * @apiParam {sting} id 订单id
     *
     * @apiSuccess {array} data
     * @apiSuccess {string} data.timeStamp
     * @apiSuccess {string} data.nonceStr
     * @apiSuccess {string} data.package
     * @apiSuccess {string} data.signType
     * @apiSuccess {string} data.paySign
     *
     * @apiUse             BaseResponse
     *
     * @apiUse             SuccessResponse
     * @apiUse             FailResponse
     */
    public function pre_order($id = ''){
        (new IDMustBePositiveInt())->goCheck();
        $payService = new PayService($id);
        return $payService->goPay();
    }

    //微信回调
    public function receiveNotify(){
        //检查库存
        //改变order状态
        //减库存
        //返回true，或者false通知微信处理结果。
        $notyfy = new WxNotify();
        $notyfy->Handle();
    }
}