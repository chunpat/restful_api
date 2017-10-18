<?php 
namespace app\api\controller\v2;

class Banner{
	public static function getBanner($id=''){
		$banner ='this is the V2';
        return json($banner);
	}

} 
 ?>