<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/9
 * Time: 22:32
 */

namespace app\api\controller\v1;
use app\api\model\Category as CategoryModel;
use app\lib\exception\CategoryException;

class Category
{
    function getAllCategories(){
        $result = CategoryModel::all([],'img');
        if($result->isEmpty()){
            throw new CategoryException();
        }
        return json($result);
    }


}