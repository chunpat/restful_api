<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/4
 * Time: 23:54
 */

namespace app\lib\exception;

class ProductException extends BaseException
{
    public $code = 404;
    public $msg = '无产品信息';
    public $errorCode = '20000';
}