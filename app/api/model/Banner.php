<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/30
 * Time: 12:59
 */

namespace app\api\model;

class Banner extends BaseModel
{
    protected $hidden=[

    ];


    public function items(){
        return $this->hasMany('banner_item','banner_id','id')->order('id', 'desc');
    }
    public static function getBannerByID($id)
        {
            $result = $banner = self::with(['items','items.img'])->find($id);
            return $result;
        }

}

