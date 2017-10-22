<?php
namespace app\api\controller\v1;
use app\api\model\Banner as BannerModel;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\BannerMissException;

class Banner{
	public static function getBanner($id=''){
		(new IDMustBePositiveInt())->goCheck();
		$banner = BannerModel::getBannerByID($id);
		//获取


		if (!$banner){
            throw new BannerMissException('不存在');
        }
       return json($banner);
	}
}
 ?>