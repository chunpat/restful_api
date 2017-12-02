<?php
/**
 * Created by PhpStorm.
 * User: ZZHPENG
 * Date: 2017/11/6
 * Time: 23:35
 */

namespace app\lib\exception;


class ForbiddenException extends BaseException
{
    public $code = 403;
    public $msg = '权限不够';
    public $errorCode = 10001;
}