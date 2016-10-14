<?php

Route::group(['prefix' => 'user'], function() {
    Route::get('/account/setting', 'User\Account\SettingController@getSetting');
    Route::post('/account/setting', 'User\Account\SettingController@postSetting');

    Route::get('/account/password', 'User\Account\PasswordController@getPassword');
    Route::post('/account/password', 'User\Account\PasswordController@postPassword');
});