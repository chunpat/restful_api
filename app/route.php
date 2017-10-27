<?php

use think\Route;

//banner
Route::get('api/:version/banner/:id','api/:version.Banner/getBanner');


//theme
Route::get('api/:version/theme/','api/:version.Theme/getSimpleThemes');
Route::get('api/:version/theme/:id','api/:version.Theme/getComplexThemes');


//product
Route::get('api/:version/product/recent','api/:version.Product/getRencent');
Route::get('api/:version/product/category','api/:version.Product/getAllInCategory');


//category
Route::get('api/:version/category/all','api/:version.Category/getAllCategories');


//token
Route::post('api/:version/token/user','api/:version.Token/getToken');