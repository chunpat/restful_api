<?php
/**
 * Created by PhpStorm.
 * User: ZZHPENG
 * Date: 2017/11/12
 * Time: 23:22
 */

namespace app\api\model;


class Order extends BaseModel
{
    protected $hidden=[
        'create_time','update_time','delete_time'
    ];
    protected $autoWriteTimestamp =true;


    protected function getSnapItemsAttr($value){
        if(empty($value)){
            return null;
        }
        return json_decode($value);
    }

    protected function getSnapAddressAttr($value){
        if(empty($value)){
            return null;
        }
        return json_decode($value);
    }

    public static function getSummaryByUser($uid,$pages,$size){
        return self::where('user_id','=',$uid)
                ->order('create_time desc')
                ->paginate($size,true,['page'=>$pages]);

    }
}