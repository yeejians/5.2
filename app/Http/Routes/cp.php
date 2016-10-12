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

Route::group(['prefix' => 'cp', 'middleware' => ['web']], function(){
	Route::get('/',				['as' => 'cp',				function(){return redirect()->route('cp.index');}]);
	Route::get('list',			['as' => 'cp.index',		'uses' => 'CP\MainController@index']);
	Route::get('flushcache',	['as' => 'cp.flushcache',	'uses' => 'CP\MainController@flushcache']);

	Route::group(['prefix' => 'menu'], function(){
		Route::get('/',				['as' => 'cp.menu.index',			'uses' => 'CP\MenuController@index']);
		Route::get('create',		['as' => 'cp.menu.create',			'uses' => 'CP\MenuController@create']);
		Route::get('create/{id}',	['as' => 'cp.menu.create.sub',		'uses' => 'CP\MenuController@create']);
		Route::get('edit/{id}',		['as' => 'cp.menu.edit',			'uses' => 'CP\MenuController@edit']);
		Route::get('assign/{id}',	['as' => 'cp.menu.assign',			'uses' => 'CP\MenuController@assign']);
		Route::get('delete/{id}',	['as' => 'cp.menu.delete',			'uses' => 'CP\MenuController@delete']);
		Route::get('show/{id}',		['as' => 'cp.menu.show',			'uses' => 'CP\MenuController@index']);
		Route::get('tree/{id}',		['as' => 'cp.menu.tree',			'uses' => 'CP\MenuController@tree']);
		Route::get('refresh',		['as' => 'cp.menu.refresh',			'uses' => 'CP\MenuController@refresh']);
		Route::post('create',		['as' => 'cp.menu.create.post',		'uses' => 'CP\MenuController@createPost']);
		Route::post('create/{id}',	['as' => 'cp.menu.create.post.sub',	'uses' => 'CP\MenuController@createPost']);
		Route::post('edit/{id}',	['as' => 'cp.menu.edit.post',		'uses' => 'CP\MenuController@editPost']);
		Route::post('assign/{id}',	['as' => 'cp.menu.assign.post',		'uses' => 'CP\MenuController@assignPost']);
	});

	Route::group(['prefix' => 'group'], function(){
		Route::get('/',				['as' => 'cp.group.index',			'uses' => 'CP\GroupController@index']);
		Route::get('create',		['as' => 'cp.group.create',			'uses' => 'CP\GroupController@create']);
		Route::get('edit/{id}',		['as' => 'cp.group.edit',			'uses' => 'CP\GroupController@edit']);
		Route::get('assign/{id}',	['as' => 'cp.group.assign',			'uses' => 'CP\GroupController@assign']);
		Route::get('show/{id}',		['as' => 'cp.group.show',			'uses' => 'CP\GroupController@show']);
		Route::get('delete/{id}',	['as' => 'cp.group.delete',			'uses' => 'CP\GroupController@delete']);
		Route::post('create',		['as' => 'cp.group.create.post',	'uses' => 'CP\GroupController@createPost']);
		Route::post('edit/{id}',	['as' => 'cp.group.edit.post',		'uses' => 'CP\GroupController@editPost']);
		Route::post('assign/{id}',	['as' => 'cp.group.assign.post',	'uses' => 'CP\GroupController@assignPost']);
	});

	Route::group(['prefix' => 'site'], function(){
		Route::get('/',				['as' => 'cp.site.index',			'uses' => 'CP\SiteController@index']);
		Route::get('create',		['as' => 'cp.site.create',			'uses' => 'CP\SiteController@create']);
		Route::get('edit/{id}',		['as' => 'cp.site.edit',			'uses' => 'CP\SiteController@edit']);
		Route::get('show/{id}',		['as' => 'cp.site.show',			'uses' => 'CP\SiteController@show']);
		Route::get('delete/{id}',	['as' => 'cp.site.delete',			'uses' => 'CP\SiteController@delete']);
		Route::post('create',		['as' => 'cp.site.create.post',		'uses' => 'CP\SiteController@createPost']);
		Route::post('edit/{id}',	['as' => 'cp.site.edit.post',		'uses' => 'CP\SiteController@editPost']);
	});
});