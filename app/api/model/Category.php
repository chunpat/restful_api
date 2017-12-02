<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/9
 * Time: 22:33
 */

namespace app\api\model;


use think\Model;

class Category extends BaseModel
{
    protected $hidden=[
        'delete_time','create_time','update_time','topic_img_id'
    ];
    public function img(){
        return $this->belongsTo('image','topic_img_id','id');
    }
}