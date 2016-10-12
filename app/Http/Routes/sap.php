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

Route::group(['prefix' => 'sap', 'middleware' => ['web']], function () {
	Route::get('flushcache',	['as' => 'sap.flushcache',		'uses' => 'SAP\MainController@flushcache']);

	Route::group(['prefix' => 'rfc'], function(){
		Route::get('dono',		['as' => 'sap.rfc.dono',		'uses' => 'SAP\DonoController@dono']);
		Route::get('getdono',	['as' => 'sap.rfc.getdono',		'uses' => 'SAP\DonoController@getdono']);
		Route::get('autodono',	['as' => 'sap.rfc.autodono',	'uses' => 'SAP\DonoController@autodono']);

		Route::get('getsono',	['as' => 'sap.rfc.getsono',		'uses' => 'SAP\SonoController@getsono']);
	});
});