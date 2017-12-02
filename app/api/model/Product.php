<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/30
 * Time: 12:59
 */

namespace app\api\model;

class Product extends BaseModel
{
    protected $hidden = [
        'delete_time','update_time','create_time','from','pivot'
    ];

    public function property(){
        return $this->hasMany('ProductProperty','product_id','id')->order(array('update_time desc'));
    }

    public function images(){
        return $this->hasMany('ProductImage','product_id','id')->order(array('order'=>'asc'));
    }

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

    public static function getProduct($id){
        return self::with(['property','images.img'])
                ->find($id);
    }



}

