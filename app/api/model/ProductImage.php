<?php
/**
 * Created by PhpStorm.
 * User: zzhpeng
 * Date: 2017/11/2
 * Time: 22:56
 */

namespace app\api\model;


class ProductImage extends BaseModel
{

    protected $hidden=[
        'delete_time','product_id','id'
    ];

    public function img(){
        return $this->belongsTo('Image','img_id','id');
    }
}