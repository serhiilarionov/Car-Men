<?php

// cities
Route::group(['prefix' => 'cities'], function () {
    Route::get('findByPoint', 'CityAPIController@findByPoint');
});
Route::resource('cities', 'CityAPIController', ['only' => ['index', 'show']]);

// categories
Route::group(['prefix' => 'categories'], function () {
    Route::get('/{id}/companies', 'CategoryAPIController@companies');
});
Route::resource('categories', 'CategoryAPIController');

// companies
Route::group(['prefix' => 'companies'], function () {
    Route::get('/popularByCity/{cityId}', 'CompanyAPIController@showPopularCompaniesByCities');

    Route::get('/{id}/ratings', 'CompanyRatingAPIController@listByCompany');
    Route::resource('/ratings', 'CompanyRatingAPIController', ['only' => ['store', 'show', 'update']]);
    Route::get('/ratings/{id}/categories', 'CompanyRatingCategoryAPIController@listByRating');
    Route::post('/ratings/{id}/categories', 'CompanyRatingCategoryAPIController@store');

    Route::get('/getByBound', 'CompanyAPIController@getByBound');
    Route::get('/getInRadius', 'CompanyAPIController@getInRadius');
    Route::get('/getDistance', 'CompanyAPIController@getDistance');
});
Route::resource('companies', 'CompanyAPIController');

Route::resource('comforts', 'ComfortAPIController', ['only' => ['index', 'show']]);

Route::resource('services', 'ServiceAPIController');