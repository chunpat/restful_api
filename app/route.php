<?php

use think\Route;

//banner
Route::get('api/:version/banner/:id','api/:version.Banner/getBanner');


//theme
Route::get('api/:version/theme','api/:version.Theme/getSimpleThemes');
Route::get('api/:version/theme/:id','api/:version.Theme/getComplexThemes');


//product
Route::get('api/:version/product/:id','api/:version.Product/getOne',[],['id'=>'\d+']);
Route::get('api/:version/product/recent','api/:version.Product/getRencent');
Route::get('api/:version/product/by_category','api/:version.Product/getAllInCategory');



//category
Route::get('api/:version/category/all','api/:version.Category/getAllCategories');


//token
Route::post('api/:version/token/user','api/:version.Token/getToken');
Route::post('api/:version/token/verify','api/:version.Token/verifyToken');
Route::post('api/:version/token/app','api/:version.Token/getAppToken');

//address
Route::post('api/:version/address','api/:version.Address/CreateorUpdateAddress');


//order
Route::post('api/:version/order','api/:version.Order/placeOrder');
Route::get('api/:version/order/:id','api/:version.Order/getDetail',[],['id'=>'\d+']);
Route::get('api/:version/order/getSummary','api/:version.Order/getSummaryByUser');

//pay
Route::post('api/:version/pay/pre_order','api/:version.Pay/pre_order');
Route::post('api/:version/pay/notify','api/:version.Pay/receiveNotify');
