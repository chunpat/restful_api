<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/4
 * Time: 19:52
 */

namespace app\lib\exception;


use Exception;
use think\exception\Handle;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;
    public function render(Exception $e)
    {
        if ($e instanceof BaseException){
            //如果是自定义异常
            $this ->code = $e->code;
            $this ->msg = $e->msg;
            $this ->errorCode = $e->errorCode;
        }
        else
        {
            //线上环境下，代码错误 不用给前端用户看到详细的返回数据
            if (config('app_debug')){
                return parent::render($e);
            }
            $this->code = 500;
            $this->msg = '服务器内部错误！！';
            $this->errorCode = 999;
            $this->recordErrorLog($e);
        }
        $request = Request::instance();
        $result =[
            'msg'=>$this->msg,
            'errorCode'=>$this->errorCode,
            'request_url' =>$request->url(),
        ];
        return json($result,$this->code);
    }
    private function recordErrorLog(Exception $e){
        Log::init([
            'type'=>'File',
            'path'=>LOG_PATH,
            'level'=>['error'],
        ]);
        Log::record($e ->getMessage(),'error');
    }
}