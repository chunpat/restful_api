<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/4
 * Time: 19:57
 */

namespace app\lib\exception;


class ThemesMissException extends BaseException
{
    public $code = 404;
    public $msg = '请求的themes不存在';
    public $errorCode = '30000';

}