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
use JsonPath\JsonObject;
use Spatie\Analytics\Period;
use Spatie\Analytics\AnalyticsFacade as Analytics;
$app->group(['prefix' => 'user/'], function ($app) {
    $app->get('/','UserController@index'); //get all the routes
    $app->post('/','UserController@store'); //store single route
    $app->post('/login','UserController@login'); //store single route
    $app->get('/{id}/', 'UserController@show'); //get single route
    $app->put('/{id}/','UserController@update'); //update single route
    $app->delete('/{id}/','UserController@destroy'); //delete single route
});


$app->get('/reorder_recipies', function () use ($app) {
    $json = file_get_contents(storage_path('app/recipies.json'));
    $jsonObject = new JsonObject($json);

    // get base url nach Aufrufen absteigend sortiert zurück
    $dimen=['dimensions' => 'ga:dimension5'];
    $sort=['sort' => '-ga:totalEvents'];
    $analyticsData = Analytics::performQuery(Period::days(30), "ga:totalEvents", array_merge($dimen, $sort));
    $arrayData['recipiesites']=array();
    foreach ($analyticsData as $data) {

        $jsonObjectData = $jsonObject->get("$.*[?(@.recipieSiteParseModel.baseUrl == '" . $data[0] . "')]");
        $arrayData['recipiesites'] = array_merge($arrayData['recipiesites'], $jsonObjectData);
    }
    file_put_contents(storage_path('app/recipies_neu.json'), json_encode($arrayData), FILE_APPEND | LOCK_EX);

    //echo '...world ';
});




$app->get(env('/'), function () use ($app) {
    echo '...world ';
});
