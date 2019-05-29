<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/11
 * Time: 20:53
 */

namespace app\api\controller\v1;

use app\api\service\AppToken;
use app\api\validate\ThirdAppValidate;
use app\api\validate\TokenGet;
use app\api\service\UserToken;
use app\lib\exception\ParameterException;
use app\api\service\Token as TokenService;

class Token
{
    /**
     * 小程序登录获取token
     * @author: zzhpeng
     * Date: 2019/5/29
     * @param string $code
     *
     * @return \think\response\Json
     * @throws ParameterException
     * @throws \think\Exception
     *
     * @api                {POST}  /api/v1/token/user 小程序登录获取token
     * @apiName            getToken
     * @apiGroup           User
     * @apiVersion         0.0.1
     * @apiSampleRequest   /api/v1/token/user
     * @apiDescription     小程序登录获取token
     *
     * @apiParam {sting} code 	客户端请求微信小程序服务器得到的code
     *
     * @apiSuccess {string} token
     *
     * @apiUse             BaseResponse
     *
     * @apiUse             SuccessResponse
     * @apiUse             FailResponse
     */
    public function getToken($code = ''){
        (new TokenGet())->goCheck();
        $tk = new UserToken($code);
        $token =$tk->get();
//        $token =UserToken::get();
        return json([
           'token' => $token,
        ]);

    }

    /**
     * 账号密码登录
     * @author: zzhpeng
     * Date: 2019/5/29
     * @param string $ac
     * @param string $se
     *
     * @return \think\response\Json
     * @throws ParameterException
     * @throws \app\lib\exception\TokenException
     *
     * @api                {POST}  /api/v1/token/app 账号密码登录
     * @apiName            getAppToken
     * @apiGroup           User
     * @apiVersion         0.0.1
     * @apiSampleRequest   /api/v1/token/app
     * @apiDescription     账号密码登录
     *
     * @apiParam {sting} ac 	账号
     * @apiParam {sting} se 	密码
     *
     * @apiSuccess {string} token
     *
     * @apiUse             BaseResponse
     *
     * @apiUse             SuccessResponse
     * @apiUse             FailResponse
     */
    public function getAppToken($ac = '',$se = ''){
        (new ThirdAppValidate())->goCheck();
        $app = new AppToken();
        $token = $app->get($ac,$se);
        return json([
            'token'=>$token
        ]);
    }

    /**
     * 验证token
     * @author: zzhpeng
     * Date: 2019/5/29
     * @param string $token
     *
     * @return \think\response\Json
     * @throws ParameterException
     *
     * @api                {POST}  /api/v1/token/verify 验证token
     * @apiName            verifyToken
     * @apiGroup           User
     * @apiVersion         0.0.1
     * @apiSampleRequest   /api/v1/token/verify
     * @apiDescription     验证token
     *
     * @apiParam {sting} token
     *
     * @apiSuccess {string} isValid  返回true 或 false
     *
     * @apiUse             BaseResponse
     *
     * @apiUse             SuccessResponse
     * @apiUse             FailResponse
     */
    public function verifyToken($token = ''){
        if(!$token){
            throw new ParameterException(
                [
                    'msg' => 'token参数不能为空'
                ]
            );
        }

        $valid = TokenService::verifyToken($token);
        return json([
            'isValid' =>$valid
        ]);
    }
}