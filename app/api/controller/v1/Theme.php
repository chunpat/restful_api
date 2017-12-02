<?php
namespace app\api\controller\v1;
use app\api\model\Theme as ThemesModel;
use app\api\validate\IDCollection;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ThemesMissException;

class Theme{
    /**
     * @url /theme?ids=id1,id2,id3,....
     * @return 一组theme模型
     */
	public static function getSimpleThemes($ids=''){
		(new IDCollection())->goCheck();
		$ids = explode(',',$ids);

		$result = ThemesModel::getThemesbyIDs($ids);
		if($result->isEmpty()){
			throw new ThemesMissException();
		}
		return json_encode($result->toArray());

	}
    /**
     * @url /theme/id
     * @return 一组theme模型
     */
    public static function getComplexThemes($id=''){

        (new IDMustBePositiveInt())->goCheck();
        $result = ThemesModel::getThemeWithProducts($id);
        if(!$result){
            throw new ThemesMissException();
        }
        return json($result);
    }
}
 ?>