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

Route::group(['middleware' => ['web']], function () {
	Route::get('/',						['as' => 'root',			function(){return redirect()->route('home');}]);

	Route::get('home',					['as' => 'home',			'uses' => 'HomeController@index']);
	Route::get('calendar',				['as' => 'calendar',		'uses' => 'HomeController@calendar']);
	
	Route::get('file/download/{id}',	['as' => 'file.download',	'uses' => 'HomeController@fileDownload']);
	Route::get('file/delete/{id}',		['as' => 'file.delete',		'uses' => 'HomeController@fileDelete']);

	Route::get('login',					['as' => 'login',			'uses' => 'Auth\AccessController@login']);
	Route::get('logout',				['as' => 'logout',			'uses' => 'Auth\AccessController@logout']);
	Route::get('switchlogin',			['as' => 'switchlogin',		'uses' => 'Auth\AccessController@switchlogin']);	
});