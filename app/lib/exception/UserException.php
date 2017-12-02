<?php
/**
 * Created by PhpStorm.
 * User: ZZHPENG
 * Date: 2017/11/5
 * Time: 20:04
 */

namespace app\lib\exception;


class UserException extends BaseException
{
    public $code = 401;
    public $msg = '用户不存在';
    public $errorCode = '60000';
}