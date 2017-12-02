<?php
/**
 * Created by PhpStorm.
 * User: ZZHPENG
 * Date: 2017/11/9
 * Time: 23:41
 */

namespace app\lib\exception;


class OrderException extends BaseException
{
    public $code = 404;
    public $msg = '订单错误';
    public $errorCode = 80000;
}