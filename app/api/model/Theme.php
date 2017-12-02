<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/30
 * Time: 12:59
 */

namespace app\api\model;

class Theme extends BaseModel
{

    protected $hidden = [
        'delete_time','update_time','topic_img_id','head_img_id'
    ];

    /**
     * @return \think\model\relation\BelongsTo
     */
    public function topicImg()
    {
        //        $this->hasOne()
        return $this->belongsTo('Image', 'topic_img_id', 'id');
    }

    public function headImg()
    {
        return $this->belongsTo('Image', 'head_img_id', 'id');
    }

    public function products()
    {
        return $this->belongsToMany('Product', 'theme_product', 'product_id',
            'theme_id');
    }

    static function getThemesbyIDs($ids = ''){

        $themes = self::with('topicImg,headImg')->select($ids);
        return $themes;
    }

    public static function getThemeWithProducts($id)
    {
        $theme = self::with('products,topicImg,headImg')
            ->find($id);
        return $theme;
    }


}

