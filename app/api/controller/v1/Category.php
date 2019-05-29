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
    /**
     * @author: zzhpeng
     * Date: 2019/5/29
     * @return \think\response\Json
     * @throws CategoryException
     * @throws \think\exception\DbException
     *
     * @api                {get}  /api/v1/category/all 获取所有分类
     * @apiName            getAllInCategory
     * @apiGroup           Category
     * @apiVersion         0.0.1
     * @apiSampleRequest   /api/v1/category/all
     * @apiDescription     获取所有分类
     *
     *
     * @apiSuccess {int}    id
     * @apiSuccess {string} name     分类名
     * @apiSuccess {string} description    描述
     * @apiSuccess {array} img
     * @apiSuccess {string} img.url    分类图
     *
     * @apiUse             BaseResponse
     *
     * @apiUse             SuccessResponse
     * @apiUse             FailResponse
     */
    function getAllCategories(){
        $result = CategoryModel::all([],'img');
        if($result->isEmpty()){
            throw new CategoryException();
        }
        return json($result);
    }


}