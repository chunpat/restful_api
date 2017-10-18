<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/30
 * Time: 12:59
 */

namespace app\api\model;
use think\Db;
use think\Exception;
use think\Model;

class Product extends BaseModel
{
    protected $hidden=[

    ];
    public function getMainImgUrlAttr($value, $data){
//        return 'success';
        return $this->prefixImgUrl($value, $data);
    }

    public  static  function getRencentByCount($count){
        $result = self::limit($count)
            ->order('create_time desc')
            ->select();
        return $result;
    }

    public static function getByCategory($id){
        $result = self::where('category_id','=',$id)
                ->order('create_time desc')
                ->select();
        return $result;
    }





}

