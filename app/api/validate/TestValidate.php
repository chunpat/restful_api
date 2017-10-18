<?php 
namespace app\api\validate;
use think\Validate;


/**
* 
*/
class TestValidate extends Validate
{
	
	// function __construct(argument)
	// {
	// 	# code...
	// }
	protected $rule = [
			'name'=>'require|max:11',
			'email'=>'email'
		];
}
 ?>