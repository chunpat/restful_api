<?php 
namespace app\api\validate;
// use think\Validate;

/**
* 
*/
class IDMustBePositiveInt extends BaseValidate
{	
	
	protected $rule = [
			'id'=>'require|isPositiveInteger',
		];
	protected $message = [
			'id'=>'id必须为单一正整数',
		];


}
 ?>