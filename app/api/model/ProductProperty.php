<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/11/2
 * Time: 22:43
 */

namespace app\api\model;


class ProductProperty extends BaseModel
{

    protected $hidden=[
        'delete_time','product_id','id'
    ];
}