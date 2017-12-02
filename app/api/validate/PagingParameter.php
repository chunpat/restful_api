<?php
/**
 * Created by PhpStorm.
 * User: ZZHPENG
 * Date: 2017/11/29
 * Time: 16:28
 */

namespace app\api\validate;


use app\api\controller\BaseController;

class PagingParameter extends BaseValidate
{
    protected $rule = [
        'pages' =>'require|isPositiveInteger',
        'size' =>'require|isPositiveInteger'
    ];

    protected $message = [
        'pages' =>'分页必须为正整数',
        'size' =>'分页数必须为正整数'
    ];
}