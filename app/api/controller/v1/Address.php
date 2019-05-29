<?php
/**
 * Created by PhpStorm.
 * User: ZZHPENG
 * Date: 2017/11/5
 * Time: 17:34
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\model\User as UserModel;
use app\api\service\Token as TokenService;
use app\api\validate\AddressValidate;
use app\lib\exception\SuccessMessage;
use app\lib\exception\UserException;

class Address extends BaseController
{
//    protected $beforeActionList =[
//        'needPrimaryScope'=>['only'=>'CreateorUpdateAddress']
//    ];
    /**
     * 创建或更新地址
     * @author: zzhpeng
     * Date: 2019/5/29
     * @return \think\response\Json
     * @throws UserException
     * @throws \app\lib\exception\ParameterException
     * @throws \think\Exception
     * @throws \think\exception\DbException
     *
     * @api                {POST}  /api/v1/address 创建或更新地址（当前只能一个收获地址）
     * @apiName            CreateorUpdateAddress
     * @apiGroup           My
     * @apiVersion         0.0.1
     * @apiSampleRequest   /api/v1/address
     * @apiDescription     创建或更新地址
     *
     * @apiParam {sting} token 	token放header
     * @apiParam {sting} name 	收货人
     * @apiParam {sting} mobile 	手机号
     * @apiParam {sting} province 	省份名
     * @apiParam {sting} city 	城市名
     * @apiParam {sting} country 	街道
     * @apiParam {sting} detail 	详情
     *
     *
     * @apiUse             BaseResponse
     *
     * @apiUse             SuccessResponse
     * @apiUse             FailResponse
     */
    public function CreateorUpdateAddress(){
        $AddressValidate = new AddressValidate();
        $AddressValidate->goCheck();
        (new AddressValidate())->goCheck();
        //通过token 获取uid
        //uid  查找用户，不存在报错
        //获取提交过来的数组
        //判断提交过来的地址是否存在，新增or更新

        $uid = TokenService::getCurrentUId();
        $user = UserModel::get($uid);

        if(!$user){
            throw new UserException();
        }
        $addressArr = $AddressValidate->getDataByRule(input('post.'));
        $userAddress = $user->address;

        if(!$userAddress){
            //新增

            $user->address()->save($addressArr);
        }else{
            //update
            $user->address->save($addressArr);
        }


        return json(new SuccessMessage(),'202');
    }
}