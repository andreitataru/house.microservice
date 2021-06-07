<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});



// API route group
$router->group(['prefix' => 'api'], function () use ($router) {

    $router->post('addHouse', 'HouseController@addHouse');
    $router->get('getAllHouses', 'HouseController@getAllHouses');
    $router->get('getHouseById/{id}', 'HouseController@getHouseById');   
    $router->post('updateHouse', 'HouseController@updateHouse');
    $router->get('deleteHouseById/{id}', 'HouseController@deleteHouseById');
    $router->post('getHousesWithFilter', 'HouseController@getHousesWithFilter');
    $router->get('getHousesWithOwnerId/{id}', 'HouseController@getHousesWithOwnerId');
    $router->post('getRentersWithHouseFromOwner', 'HouseController@getRentersWithHouseFromOwner');
    $router->post('addInterest', 'HouseController@addInterest');
    $router->get('getInterestsByHouseId/{id}', 'HouseController@getInterestsByHouseId');
    $router->get('getInterestsByUserId/{id}', 'HouseController@getInterestsByUserId');
    $router->post('rateHouse', 'HouseController@rateHouse');
});