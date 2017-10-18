<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/30
 * Time: 12:59
 */

namespace app\api\model;
use think\Model;
class Image extends BaseModel
{

    protected $hidden = ['id', 'from', 'delete_time','update_time'];

    public function getUrlAttr($value, $data){
//        return 'success';
        return $this->prefixImgUrl($value, $data);
    }

}
