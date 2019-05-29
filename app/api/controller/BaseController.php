<?php

/**
 * Created by PhpStorm.
 * User: ZZHPENG
 * Date: 2017/11/7
 * Time: 22:34
 */
namespace app\api\controller;

use app\api\service\Token;
use think\Controller;

/**
 * Class BaseController
*/
class BaseController extends Controller
{

    // ------------------------------------------------------------------------------------------
    // General apiDoc documentation blocks and old history blocks.
    // ------------------------------------------------------------------------------------------


    // ------------------------------------------------------------------------------------------
    // Current Success.
    // ------------------------------------------------------------------------------------------

    /**
     * @apiDefine BaseResponseHeader 基本响应字段
     */

    /**
     * @apiDefine        BaseResponse
     * @apiSuccess (BaseResponseHeader) {int} err_code    状态码，0：请求成功
     * @apiSuccess (BaseResponseHeader) {string} err_message   错误提示信息,error_code为0时候为空字符串
     *
     *
     */


    /**
     * @apiDefine          SuccessResponse
     * @apiSuccessExample  Response (success):
     *     {
     *       "err_code":"0",
     *       "err_message": ""
     *     }
     */

    // ------------------------------------------------------------------------------------------
    // Current Errors.
    // ------------------------------------------------------------------------------------------

    /**
     * @apiDefine        FailResponse
     * @apiErrorExample  Response (fail):
     *     {
     *       "err_code":"1"
     *       "err_message": "接口请求错误"
     *     }
     */

    /**
     * @apiDefine Banner 横条
     */

    protected function needPrimaryScope(){
        Token::needPrimaryScope();
    }

    protected function needExclusiveScope(){
        Token::needExclusiveScope();
    }
}