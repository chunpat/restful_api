<?php
namespace app\api\controller\v1;
use app\api\model\Theme as ThemesModel;
use app\api\validate\IDCollection;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ThemesMissException;

class Theme{

    /**
     * 获取主题方式二
     * @author: zzhpeng
     * Date: 2019/5/29
     * @param string $ids
     *
     * @return string
     * @throws ThemesMissException
     * @throws \app\lib\exception\ParameterException
     *
     * @api                {get}  /api/api/v1/theme?ids=id1,id2,id3,.... 获取主题方式二
     * @apiName            getSimpleThemes
     * @apiGroup           Index
     * @apiVersion         0.0.1
     * @apiSampleRequest   /api/api/v1/theme?ids=id1,id2,id3,....
     * @apiDescription     获取主题方式二
     *
     * @apiParam {sting} ids 请求主题id字符串 id1,id2,id3,....
     *
     * @apiSuccess {int}    id
     * @apiSuccess {string} name           主题名
     * @apiSuccess {string} description    描述
     * @apiSuccess {array} topic_img  展示小图
     * @apiSuccess {string} topic_img.url  展示小图url
     * @apiSuccess {array} head_img   详情大图
     * @apiSuccess {string} head_img.url   详情大图url
     *
     * @apiUse             BaseResponse
     *
     * @apiUse             SuccessResponse
     * @apiUse             FailResponse
     */
	public static function getSimpleThemes($ids=''){
		(new IDCollection())->goCheck();
		$ids = explode(',',$ids);

		$result = ThemesModel::getThemesbyIDs($ids);
		if($result->isEmpty()){
			throw new ThemesMissException();
		}
		return json_encode($result->toArray());

	}

    /**
     * 获取主题方式一
     * @author: zzhpeng
     * Date: 2019/5/29
     * @param string $id
     *
     * @return \think\response\Json
     * @throws ThemesMissException
     * @throws \app\lib\exception\ParameterException
     *
     * @api                {get}  /api/api/v1/theme/id 获取主题方式一
     * @apiName            getComplexThemes
     * @apiGroup           Index
     * @apiVersion         0.0.1
     * @apiSampleRequest   /api/api/v1/theme/id
     * @apiDescription     获取主题方式一
     *
     * @apiParam {sting} id
     *
     * @apiSuccess {int}    id
     * @apiSuccess {string} name           主题名
     * @apiSuccess {string} description    描述
     * @apiSuccess {array} topic_img  展示小图
     * @apiSuccess {string} topic_img.url  展示小图url
     * @apiSuccess {array} head_img   详情大图
     * @apiSuccess {string} head_img.url   详情大图url
     *
     * @apiUse             BaseResponse
     *
     * @apiUse             SuccessResponse
     * @apiUse             FailResponse
     */
    public static function getComplexThemes($id=''){

        (new IDMustBePositiveInt())->goCheck();
        $result = ThemesModel::getThemeWithProducts($id);
        if(!$result){
            throw new ThemesMissException();
        }
        return json($result);
    }
}
 ?>