<?php

Route::resource('cities', 'CityController');

Route::resource('comforts', 'ComfortController');

Route::resource('categories', 'CategoryController');

Route::resource('companies', 'CompanyController');

Route::resource('services', 'ServiceController');

Route::post('services', ['as' => 'services.createService', 'uses' => 'ServiceController@createService']);
Route::delete('services', ['as' => 'services.deleteService', 'uses' => 'ServiceController@deleteService']);

Route::resource('companyRatings', 'CompanyRatingController');