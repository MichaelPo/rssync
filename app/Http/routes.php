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
    $api = '/api';
    $app->get(env('BASE_PATH','').$api.'/blameurl', ['uses' => 'BlameurlController@getBlameurls', 'as' => 'allBlameurls']);
    $app->get(env('BASE_PATH','').$api.'/blameurl/{id}', ['uses' => 'BlameurlController@getBlameurl', 'as' => 'singleBlameurl']);
    $app->post(env('BASE_PATH','').$api.'/blameurl', ['uses' => 'BlameurlController@saveBlameurl', 'as' => 'saveArticle']);
    $app->put(env('BASE_PATH','').$api.'/blameurl/{id}', ['uses' => 'BlameurlController@updateBlameurl', 'as' => 'updateBlameurl']);
    $app->delete(env('BASE_PATH','').$api.'/blameurl/{id}', ['uses' => 'BlameurlController@deleteBlameurl', 'as' => 'deleteBlameurl']);

    //$app->get(env('BASE_PATH','').$api.'/user', ['uses' => 'UserController@getUser', 'as' => 'allUsers']);
    $app->get(env('BASE_PATH','').$api.'/user/{id}', ['uses' => 'UserController@getUser', 'as' => 'singleUser']);
    //$app->post(env('BASE_PATH','').$api.'/user', ['uses' => 'UserController@saveUser', 'as' => 'saveUser']);
    $app->put(env('BASE_PATH','').$api.'/user/{id}', ['uses' => 'UserController@updateUser', 'as' => 'saveUser']);
    $app->delete(env('BASE_PATH','').$api.'/user/{id}', ['uses' => 'UserController@deleteUser', 'as' => 'deleteUser']);
    
});
$app->group(['namespace' => 'App\Http\Controllers'] , function($app) {
    $app->get(env('BASE_PATH', '') . '/{avatar}', ['uses' => 'UserController@getFavorite', 'as' => 'getFavorite']);
});



$app->get(env('BASE_PATH',''), function () use ($app) {
    echo '...world ';
});
