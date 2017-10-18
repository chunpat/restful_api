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

class BannerItem extends Model
{
	//隐藏客户端不需要的字段
	protected $hidden =['id','img_id','banner_id'];
    public function img(){
        return $this->belongsTo('Image','img_id','id');
    }

    public static function getBannerByID($id)
        {
            $result = Db::table('cmf_nav')->where('id','=',$id)->select();
            return $result;
        }

}
