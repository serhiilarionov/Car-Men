<?php

//auth routes
Route::group(['namespace' => 'Modules\Auth\Http\Controllers\API'], function() {
    Route::group(['prefix' => 'users'], function () {
        Route::post('login', 'UserAPIController@login');
        Route::get('logout', 'UserAPIController@logout');
        Route::post('register', 'UserAPIController@register');
        Route::get('me', 'UserAPIController@me');
        Route::get('me/companies/favorites', 'UserAPIController@favoriteCompanies');
        Route::post('me/companies/{id}/favorites', 'UserAPIController@addFavoriteCompanies');
        Route::delete('me/companies/{id}/favorites', 'UserAPIController@destroyFavoriteCompanies');
        Route::get('me/articles/favorites', 'UserAPIController@favoriteArticles');
        Route::post('me/articles/{id}/favorites', 'UserAPIController@addFavoriteArticle');
        Route::delete('me/articles/{id}/favorites', 'UserAPIController@destroyFavoriteArticle');
        Route::put('update/{id}', 'UserAPIController@update');
        Route::get('me/companies/lastViewed', 'UserAPIController@lastViewedCompanies');
    });
    Route::post('/devices/init', 'DeviceAPIController@init');
    Route::put('notifications/{id}/read', 'PushLogAPIController@setRead');
    Route::resource('pushLogs', 'PushLogAPIController');
});


//catalog routes
Route::group(['namespace' => 'Modules\Catalog\Http\Controllers\API'], function() {
    Route::get('/users/{id}/ratings', 'CompanyRatingAPIController@listByUser');
});
