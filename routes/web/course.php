<?php

Route::group(['prefix' => 'course'], function() {
    Route::get('/', 'Course\ManageController@getCourse');
    Route::get('/create', 'Course\CreateController@getCreate');
    Route::post('/create', 'Course\CreateController@postCreate');
});