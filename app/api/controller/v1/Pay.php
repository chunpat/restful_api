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