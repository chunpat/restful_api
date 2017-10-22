<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/30
 * Time: 12:59
 */

namespace app\api\model;
use think\Model;

class BaseModel extends Model
{
	public function prefixImgUrl($val,$data){
		if($data['from'] == 1){
			return config('setting.img_prefix').$val;
		}
		return $val;

	}
}
