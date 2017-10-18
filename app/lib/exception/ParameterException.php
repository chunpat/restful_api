<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/5
 * Time: 23:47
 */

namespace app\lib\exception;


use Throwable;

class ParameterException extends BaseException
{
    public $code = 400;
    public $msg = '参数错误';
    public $errorCode = '10000';
    public function __construct($params =array() )
    {
        if (!is_array($params)){
            return;
        }
        if (array_key_exists('code',$params)){
            $this->code = $params['code'];
        }

        if (array_key_exists('msg',$params)){
            $this->msg = $params['msg'];
        }

        if (array_key_exists('errorCode',$params)){
            $this->errorCode = $params['errorCode'];
       }


    }
}