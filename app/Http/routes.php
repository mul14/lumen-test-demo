<?php

$app->group(['prefix' => '/api/v1', 'namespace' => 'App\Http\Controllers'], function() use ($app)
{
    $app->post('users/register', 'UsersController@postRegister');
    $app->post('users/login', 'UsersController@postLogin');
});
