<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
$app->group(['prefix' => 'user/'], function ($app) {
    $app->get('/','UserController@index'); //get all the routes
    $app->post('/','UserController@store'); //store single route
    $app->get('/{id}/', 'UserController@show'); //get single route
    $app->put('/{id}/','UserController@update'); //update single route
    $app->delete('/{id}/','UserController@destroy'); //delete single route
});



$app->get(env('/'), function () use ($app) {
    echo '...world ';
});
