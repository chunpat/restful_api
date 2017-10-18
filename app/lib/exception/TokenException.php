<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/12
 * Time: 23:35
 */

namespace app\lib\exception;

class TokenException  extends BaseException
{
    public $code = 404;
    public $msg = 'token已过期或者已经失效';
    public $errorCode = 10001;
}