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

    /**
     * 获取最近新品
     * @author: zzhpeng
     * Date: 2019/5/29
     * @param int $count
     *
     * @return \think\response\Json
     * @throws ProductException
     * @throws \app\lib\exception\ParameterException
     *
     * @api                {get}  /api/v1/product/recent 获取最近新品
     * @apiName            getRencent
     * @apiGroup           Index
     * @apiVersion         0.0.1
     * @apiSampleRequest   /api/v1/product/recent
     * @apiDescription     获取主题方式二
     *
     * @apiParam {int} count 产品数量
     *
     * @apiSuccess {int}    id
     * @apiSuccess {string} name     产品名
     * @apiSuccess {string} price    报价
     * @apiSuccess {int}    stock    库存数量
     * @apiSuccess {int}    category_id    分类id
     * @apiSuccess {string}    main_img_url    主图
     * @apiSuccess {string}    summary      总量
     * @apiSuccess {int}    img_id
     *
     * @apiUse             BaseResponse
     *
     * @apiUse             SuccessResponse
     * @apiUse             FailResponse
     */
    public function getRencent($count = 15){
        (new Count())->goCheck();
        $result = ProductModel::getRencentByCount($count);
        if($result->isEmpty()){
            throw new ProductException();
        }

        return json($result);
    }

    /**
     * 获取产品分类
     * @author: zzhpeng
     * Date: 2019/5/29
     * @param $id
     *
     * @return \think\response\Json
     * @throws ProductException
     * @throws \app\lib\exception\ParameterException
     *
     * @api                {get}  /api/v1/product/by_category?id=2 分类下的产品
     * @apiName            getAllInCategory
     * @apiGroup           Product
     * @apiVersion         0.0.1
     * @apiSampleRequest   /api/v1/category/all
     * @apiDescription     分类下的产品
     *
     * @apiParam {int} id   分类id
     *
     * @apiSuccess {id}    id
     * @apiSuccess {string} name     产品名
     * @apiSuccess {string} price    价格
     * @apiSuccess {int} stock    库存
     * @apiSuccess {int} category_id    分类id
     * @apiSuccess {string} main_img_url    url
     * @apiSuccess {int}    img_id    图片id
     *
     * @apiUse             BaseResponse
     *
     * @apiUse             SuccessResponse
     * @apiUse             FailResponse
     */
    public function getAllInCategory($id){

        (new IDMustBePositiveInt())->goCheck();
        $result = ProductModel::getByCategory($id);
        if($result->isEmpty()){
            throw new ProductException();
        }
        $result=$result->hidden(['summary']);

        return json($result);
    }

    /**
     * 获取产品详情
     * @author: zzhpeng
     * Date: 2019/5/29
     *
     * @param $id
     *
     * @return \think\response\Json
     * @throws ProductException
     * @throws \app\lib\exception\ParameterException
     *
     * @api                {get}  /api/v1/product/{$id} 获取产品详情
     * @apiName            getOne
     * @apiGroup           Product
     * @apiVersion         0.0.1
     * @apiSampleRequest  /api/v1/product/{$id}
     * @apiDescription     获取产品详情
     *
     *
     * @apiSuccess {int}    id
     * @apiSuccess {string} name     产品名
     * @apiSuccess {string} price    报价
     * @apiSuccess {string} stock    库存
     * @apiSuccess {int} category_id    分类id
     * @apiSuccess {string} main_img_url    图片url
     * @apiSuccess {string} summary
     * @apiSuccess {string} img_id
     * @apiSuccess {array}  property 规格
     * @apiSuccess {int}  property.id
     * @apiSuccess {string}  property.name
     * @apiSuccess {string}  property.detail
     * @apiSuccess {array}  images 展示图
     * @apiSuccess {int}  images.id
     * @apiSuccess {int}  images.img_id
     * @apiSuccess {int}  images.order 排序
     * @apiSuccess {array}  images.img
     * @apiSuccess {int}  images.img.url url图
     *
     * @apiUse             BaseResponse
     *
     * @apiUse             SuccessResponse
     * @apiUse             FailResponse
     */
    public function getOne($id){
        (new IDMustBePositiveInt())->goCheck();
        $result = ProductModel::getProduct($id);
        if(!$result){
            throw new ProductException();
        }
        return json($result);
    }
}