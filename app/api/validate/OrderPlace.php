<?php
/**
 * Created by PhpStorm.
 * User: ZZHPENG
 * Date: 2017/11/7
 * Time: 23:33
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;

class OrderPlace extends BaseValidate
{
    protected $rule = [
        'products' => 'checkProducts|require',
    ];

    protected $singleRule=[
        'product_id' => 'isPositiveInteger',
        'count' => 'isPositiveInteger'
    ];

    protected function checkProducts($values){
        if(!is_array($values)){
            throw new ParameterException(['msg'=>'参数格式不是数组']);
        }

        if(empty($values)){
            throw new ParameterException(['msg'=>'参数错误null！']);
        }

        foreach($values as $v){
            $this->checkProduct($v);
        }
        return true;
    }

    protected function checkProduct($value){
        $result = (new BaseValidate())->check($value,$this->singleRule);
//        $validate = new BaseValidate($this->singleRule);
//        $result= $validate ->check($value);

        if(!$result){
            throw new ParameterException(['msg'=>'商品列表参数错误！']);
        }
    }
}