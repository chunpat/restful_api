<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/4
 * Time: 22:44
 */

namespace app\api\validate;


class Count extends BaseValidate
{
    protected $rule=[
        'count' => 'isPositiveInteger|between:1,15',
    ];
}