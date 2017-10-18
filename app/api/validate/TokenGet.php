<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/11
 * Time: 20:54
 */

namespace app\api\validate;


class TokenGet extends BaseValidate
{
    protected $rule =[
        'code' => 'require|isNotEmpty'
    ];

    protected $message = [
        'code' => 'code都没有，休想获取token!'
    ];
}