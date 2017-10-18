<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/9
 * Time: 22:33
 */

namespace app\lib\exception;

class CategoryException extends BaseException
{
    //HTTP 状态码 301
    public $code = 500;

    //错误具体信息
    public $msg = 无分类;

    //自定义的错误码
    public $errorCode = 50000;

}