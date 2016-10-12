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

Route::group(['prefix' => 'sts', 'middleware' => ['web']], function(){
	Route::get('/',				['as' => 'sts',				function(){return redirect()->route('sts.index');}]);
	Route::get('list',			['as' => 'sts.index',		'uses' => 'STS\MainController@index']);
	Route::get('flushcache',	['as' => 'sts.flushcache',	'uses' => 'STS\MainController@flushcache']);
	Route::get('doc/{id}',		['as' => 'sts.doc',			'uses' => 'STS\MainController@doc']);
	Route::get('read/{name}',	['as' => 'sts.read',		'uses' => 'STS\MainController@read']);
	Route::get('auto/{id}',		['as' => 'sts.auto',		'uses' => 'STS\MainController@auto']);
	Route::post('doc/{id}',		['as' => 'sts.doc.post',	'uses' => 'STS\MainController@docPost']);

	Route::group(['prefix' => 'report'], function(){
		Route::get('/',				['as' => 'sts.report.index',		'uses' => 'STS\ReportController@index']);
		Route::get('create',		['as' => 'sts.report.create',		'uses' => 'STS\ReportController@create']);
		Route::get('edit/{id}',		['as' => 'sts.report.edit',			'uses' => 'STS\ReportController@edit']);
		Route::get('show/{id}',		['as' => 'sts.report.show',			'uses' => 'STS\ReportController@show']);
		Route::get('delete/{id}',	['as' => 'sts.report.delete',		'uses' => 'STS\ReportController@delete']);
		Route::post('create',		['as' => 'sts.report.create.post',	'uses' => 'STS\ReportController@createPost']);
		Route::post('edit/{id}',	['as' => 'sts.report.edit.post',	'uses' => 'STS\ReportController@editPost']);
	});

	Route::group(['prefix' => 'mail'], function(){
		Route::get('/',							['as' => 'sts.mail.index',			'uses' => 'STS\MailController@index']);
		Route::get('show/{id}',					['as' => 'sts.mail.show',			'uses' => 'STS\MailController@show']);
		Route::get('setting/{id}',				['as' => 'sts.mail.setting',		'uses' => 'STS\MailController@setting']);
		Route::get('recipient/{type}/{id}',		['as' => 'sts.mail.recipient',		'uses' => 'STS\MailController@recipient']);
		Route::post('setting/{id}',				['as' => 'sts.mail.setting.post',	'uses' => 'STS\MailController@settingPost']);
		Route::post('recipient/{type}/{id}',	['as' => 'sts.mail.recipient.post',	'uses' => 'STS\MailController@recipientPost']);
	});
});