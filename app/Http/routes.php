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

$app->group(['namespace' => 'App\Http\Controllers'] , function($app){
    $api = 'api';
    $app->get($api.'/', ['uses' => 'BlameurlController@getBlameurls', 'as' => 'allBlameurls']);
    $app->get($api.'/blameurl/{id}', ['uses' => 'BlameurlController@getBlameurl', 'as' => 'singleBlameurl']);
    $app->post($api.'/blameurl', ['uses' => 'BlameurlController@saveBlameurl', 'as' => 'saveArticle']);
    $app->put($api.'/blameurl/{id}', ['uses' => 'BlameurlController@updateBlameurl', 'as' => 'updateBlameurl']);
    $app->delete($api.'/blameurl/{id}', ['uses' => 'BlameurlController@deleteBlameurl', 'as' => 'deleteBlameurl']);
});


$app->get('/', function () use ($app) {
    return $app->version();
});
