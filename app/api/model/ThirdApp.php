<?php
/**
 * Created by PhpStorm.
 * User: ZZHPENG
 * Date: 2017/12/14
 * Time: 23:43
 */

namespace app\api\model;


class ThirdApp extends BaseModel
{
    public static function check($ac,$se){
        $rst = self::where('app_id','=',$ac)->where('app_secret','=',$se)->find();
        return $rst;
    }

}