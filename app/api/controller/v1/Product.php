<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/8/22
 * Time: 23:32
 */

namespace app\api\controller\v1;
use app\api\model\Product as ProductModel;
use app\api\validate\Count;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ProductException;

class Product
{
    public function getRencent($count = 15){
        (new Count())->goCheck();
        $result = ProductModel::getRencentByCount($count);
        if($result->isEmpty()){
            throw new ProductException();
        }

        return json($result);
    }

    public function getAllInCategory($id){
        (new IDMustBePositiveInt())->goCheck();
        $result = ProductModel::getByCategory($id);
        if($result->isEmpty()){
            throw new ProductException();
        }
        $result=$result->hidden(['summary']);

        return json($result);
    }
}