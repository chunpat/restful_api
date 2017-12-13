<?php
/**
 * Created by PhpStorm.
 * User: ZZHPENG
 * Date: 2017/12/12
 * Time: 22:35
 */

namespace app\api\validate;


class ThirdAppValidate extends BaseValidate
{
    protected $rule =[
        'ac' => 'require|isNotEmpty',
        'se' => 'require|isNotEmpty'
    ];

    protected $message = [
        'ac' => '帐号不能为空',
        'se' => '密码不能为空'
    ];
}