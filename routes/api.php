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

use Illuminate\Support\Facades\Route;

$router = app()->router;


$router->group(['prefix' => 'api', 'middleware' => ['cors','auth']], function () use ($router) {

    $router->group(['prefix' => 'users'], function () use ($router) {
        $router->post('', 'UserController@login');
        $router->get('', 'UserController@show');
    });

    $router->group(['prefix' => 'customers'], function () use ($router) {
        $router->get('{id}', 'CustomerController@show');
        $router->get('', 'CustomerController@showCustomers');
        $router->post('', 'CustomerController@store');
        $router->put('{id}', 'CustomerController@update');
        $router->delete('{id}', 'CustomerController@destroy');
    });


    $router->group(['prefix' => 'bills'], function () use ($router) {
        $router->get('{id}', 'BillController@show');
        $router->get('', 'BillController@showBills');
        $router->post('', 'BillController@store');
        $router->put('{id}', 'BillController@update');
        $router->delete('{id}', 'BillController@destroy');
    });

    $router->get('customers/{customerId}/bills','BillController@showCustomerBills');
    $router->delete('customers/{customerId}/bills','BillController@destroyThree');


});





