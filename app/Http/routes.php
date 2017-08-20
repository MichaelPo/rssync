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
    $app->get('/{id}/', 'UserController@show'); //get single route
    $app->put('/{id}/','UserController@update'); //update single route
    $app->delete('/{id}/','UserController@destroy'); //delete single route
});


$app->get('/reorder_recipies', function () use ($app) {
    //$json = file_get_contents('/recipies.json');
    //$jsonObject = new JsonObject($json);
    //$analyticsData = Analytics::fetchVisitorsAndPageViews(Period::days(7));
    $dimen=['dimensions' => 'ga:dimension5'];

    $analyticsData = Analytics::performQuery(Period::days(30), "ga:totalEvents", $dimen);

    foreach ($analyticsData as $data) {
        echo 'site: '. $data[0];
        echo '<p><p></p>';
    }


    //echo '...world ';
});




$app->get(env('/'), function () use ($app) {
    echo '...world ';
});
