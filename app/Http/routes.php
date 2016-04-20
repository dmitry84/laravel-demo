<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::get('/', function () {
    return view('welcome');
});

Route::group(array('prefix' => 'api/v1'), function() {
   
    Route::get('customers', ['as' => 'customers', 'uses' => 'CustomersController@index']);
    
    Route::post('customers', ['as' => 'customers', 'uses' => 'CustomersController@store']);      
    Route::get('customers/{id}', ['as' => 'customers', 'uses' => 'CustomersController@show']);  
    Route::put('customers/{id}', ['as' => 'customers', 'uses' => 'CustomersController@update']);  
    Route::patch('customers/{id}', ['as' => 'customers', 'uses' => 'CustomersController@update']);  
    Route::delete('customers/{id}', ['as' => 'customers', 'uses' => 'CustomersController@destroy']); 
});

Route::macro('after', function ($callback) {
    $this->events->listen('router.filter:after:newrelic-patch', $callback);
});
