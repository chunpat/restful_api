<?php
namespace app\api\controller\v1;
use app\api\model\Banner as BannerModel;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\BannerMissException;

class Banner{

    /**
     * 获取banner
     * @author: zzhpeng
     * Date: 2019/5/29
     * @param string $id
     *
     * @return \think\response\Json
     * @throws BannerMissException
     * @throws \app\lib\exception\ParameterException
     *
     * @api                {get}  /api/api/v1/banner/{$id} 获取banner
     * @apiName            getBanner
     * @apiGroup           Index
     * @apiVersion         0.0.1
     * @apiSampleRequest   /api/api/v1/banner/{$id}
     * @apiDescription     获取banner
     *
     * @apiParam {sting} id 请求banner的id(放url)
     *
     * @apiSuccess {int}    id
     * @apiSuccess {string} name           banner名
     * @apiSuccess {string} description    描述
     * @apiSuccess {array}  items
     * @apiSuccess {string} items.key_word    主键
     * @apiSuccess {int}    items.type        banner类型
     * @apiSuccess {array}  items.img         图片数组
     * @apiSuccess {string} items.img.url     图片地址
     *
     * @apiUse             BaseResponse
     *
     * @apiUse             SuccessResponse
     * @apiUse             FailResponse
     */
	public static function getBanner($id=''){
		(new IDMustBePositiveInt())->goCheck();
		$banner = BannerModel::getBannerByID($id);
		//获取


		if (!$banner){
            throw new BannerMissException();
        }
       return json($banner);
	}


}
 ?>