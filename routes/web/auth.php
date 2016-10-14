<?php

Route::get('/register', 'Auth\RegisterController@getRegister');
Route::post('/register', 'Auth\RegisterController@postRegister');

Route::get('/login', 'Auth\LoginController@getLogin');
Route::post('/login', 'Auth\LoginController@postLogin');
Route::post('/logout', 'Auth\LogoutController@postLogout');

Route::get('password/reset', 'Auth\ForgotPasswordController@getReset');
Route::post('password/email', 'Auth\ForgotPasswordController@postEmail');

Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');
