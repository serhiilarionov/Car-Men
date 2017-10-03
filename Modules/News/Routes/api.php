<?php

//news routes
Route::group(['namespace' => 'Modules\News\Http\Controllers\API'], function() {
    Route::get('articles/popular', 'ArticleAPIController@popular');
    Route::resource('articles', 'ArticleAPIController');
});
