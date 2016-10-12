<?php

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

Route::group(['prefix' => 'tp', 'middleware' => ['web']], function(){
	Route::get('/',				['as' => 'tp',				function(){return redirect()->route('tp.index');}]);
	Route::get('list',			['as' => 'tp.index',		'uses' => 'TP\MainController@index']);
	Route::get('flushcache',	['as' => 'tp.flushcache',	'uses' => 'TP\MainController@flushcache']);
	Route::get('admin',			['as' => 'tp.admin',		'uses' => 'TP\MainController@admin']);
	Route::post('admin',		['as' => 'tp.admin.post',	'uses' => 'TP\MainController@adminPost']);

	Route::group(['prefix' => 'reason'], function(){
		Route::get('/',				['as' => 'tp.reason.index',			'uses' => 'TP\ReasonController@index']);
		Route::get('create',		['as' => 'tp.reason.create',		'uses' => 'TP\ReasonController@create']);
		Route::get('edit/{id}',		['as' => 'tp.reason.edit',			'uses' => 'TP\ReasonController@edit']);
		Route::get('show/{id}',		['as' => 'tp.reason.show',			'uses' => 'TP\ReasonController@show']);
		Route::get('delete/{id}',	['as' => 'tp.reason.delete',		'uses' => 'TP\ReasonController@delete']);
		Route::post('create',		['as' => 'tp.reason.create.post',	'uses' => 'TP\ReasonController@createPost']);
		Route::post('edit/{id}',	['as' => 'tp.reason.edit.post',		'uses' => 'TP\ReasonController@editPost']);
	});

	Route::group(['prefix' => 'voter'], function(){
		Route::get('/',				['as' => 'tp.voter.index',			'uses' => 'TP\VoterController@index']);
		Route::get('create',		['as' => 'tp.voter.create',			'uses' => 'TP\VoterController@create']);
		Route::get('edit/{id}',		['as' => 'tp.voter.edit',			'uses' => 'TP\VoterController@edit']);
		Route::get('show/{id}',		['as' => 'tp.voter.show',			'uses' => 'TP\VoterController@show']);
		Route::get('delete/{id}',	['as' => 'tp.voter.delete',			'uses' => 'TP\VoterController@delete']);
		Route::get('backup/{id}',	['as' => 'tp.voter.backup',			'uses' => 'TP\VoterController@backup']);
		Route::post('create',		['as' => 'tp.voter.create.post',	'uses' => 'TP\VoterController@createPost']);
		Route::post('edit/{id}',	['as' => 'tp.voter.edit.post',		'uses' => 'TP\VoterController@editPost']);
		Route::post('backup/{id}',	['as' => 'tp.voter.backup.post',	'uses' => 'TP\VoterController@backupPost']);
	});
});