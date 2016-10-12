<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['prefix' => 'test', 'middleware' => ['web']], function () {
	Route::get('/',								['as' => 'test',							'uses' => 'TestController@index']);
	Route::get('file',							['as' => 'test.file',						'uses' => 'TestController@files']);
	Route::get('segment',						['as' => 'test.segment',					'uses' => 'TestController@segment']);
	Route::get('timeline',						['as' => 'test.timeline',					'uses' => 'TestController@timeline']);
	Route::get('menu',							['as' => 'test.menu',						'uses' => 'TestController@menu']);
//	Route::get('test/test',						['as' => 'test.test',						'uses' => 'HomeController@test']);
//	Route::get('test/test/test',				['as' => 'test.test.test',					'uses' => 'HomeController@test']);
//	Route::get('test/test/test/test',			['as' => 'test.test.test.test',				'uses' => 'HomeController@test']);
//	Route::get('test/test/test/test/test',		['as' => 'test.test.test.test.test',		'uses' => 'HomeController@test']);
//	Route::get('test/test/test/test/test/test',	['as' => 'test.test.test.test.test.test',	'uses' => 'HomeController@test']);
});