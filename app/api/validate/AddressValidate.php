<?php
/**
 * Created by PhpStorm.
 * User: ZZHPENG
 * Date: 2017/11/5
 * Time: 17:33
 */

namespace app\api\validate;


class AddressValidate extends BaseValidate
{
        protected $rule=[
            'name'=>'require|isNotEmpty',
            'mobile'=>'require|isMobile',
            'province'=>'require|isNotEmpty',
            'city'=>'require|isNotEmpty',
            'country'=>'require|isNotEmpty',
            'detail'=>'require|isNotEmpty',

        ];

}