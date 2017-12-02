<?php
/**
 * Created by PhpStorm.
 * User: ZZHPENG
 * Date: 2017/11/5
 * Time: 19:54
 */

namespace app\lib\exception;


class SuccessMessage extends BaseException
{
    public $code = 201;
    public $msg = 'ok';
    public $errorCode = 0;
}