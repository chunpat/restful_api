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


class BaseController extends Controller
{
    protected function needPrimaryScope(){
        Token::needPrimaryScope();
    }

    protected function needExclusiveScope(){
        Token::needExclusiveScope();
    }
}