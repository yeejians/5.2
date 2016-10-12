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

Route::group(['prefix' => 'qrs', 'middleware' => ['web']], function () {
	Route::get('/',							['as' => 'qrs',						function(){return redirect()->route('qrs.index');}]);
	Route::get('list',						['as' => 'qrs.index',				'uses' => 'QRS\MainController@index']);
	Route::get('flushcache',				['as' => 'qrs.flushcache',			'uses' => 'QRS\MainController@flushcache']);
	Route::get('create/{id}',				['as' => 'qrs.create',				'uses' => 'QRS\MainController@create']);
	Route::get('edit/{id}',					['as' => 'qrs.edit',				'uses' => 'QRS\MainController@edit']);
	Route::get('attachment/{id}',			['as' => 'qrs.attachment',			'uses' => 'QRS\MainController@attachment']);
	Route::get('show/{id}',					['as' => 'qrs.show',				'uses' => 'QRS\MainController@show']);
	Route::get('notify/{id}',				['as' => 'qrs.notify',				'uses' => 'QRS\MainController@notify']);
	Route::get('send/{id}',					['as' => 'qrs.send',				'uses' => 'QRS\MainController@send']);
	Route::post('create/{id}',				['as' => 'qrs.create.post',			'uses' => 'QRS\MainController@createPost']);
	Route::post('edit/{id}',				['as' => 'qrs.edit.post',			'uses' => 'QRS\MainController@editPost']);
	Route::post('attachment/{id}',			['as' => 'qrs.attachment.post',		'uses' => 'QRS\MainController@attachmentPost']);

	Route::group(['prefix' => 'assignment'], function(){
		Route::get('{id}',			['as' => 'qrs.assignment.index',		'uses' => 'QRS\AssignmentController@index']);
		Route::get('notify/{id}',	['as' => 'qrs.assignment.notify',		'uses' => 'QRS\AssignmentController@notify']);
		Route::get('send/{id}',		['as' => 'qrs.assignment.send',			'uses' => 'QRS\AssignmentController@send']);
		Route::get('edit/{id}',		['as' => 'qrs.assignment.edit',			'uses' => 'QRS\AssignmentController@edit']);
		Route::post('edit/{id}',	['as' => 'qrs.assignment.edit.post',	'uses' => 'QRS\AssignmentController@editPost']);
	});

	Route::group(['prefix' => 'caseleader'], function(){
		Route::get('{id}',					['as' => 'qrs.caseleader.index',		'uses' => 'QRS\CaseleaderController@index']);
		Route::get('notify/{type}/{id}',	['as' => 'qrs.caseleader.notify',		'uses' => 'QRS\CaseleaderController@notify']);
		Route::get('send/{type}/{id}',		['as' => 'qrs.caseleader.send',			'uses' => 'QRS\CaseleaderController@send']);
		Route::get('edit/{id}',				['as' => 'qrs.caseleader.edit',			'uses' => 'QRS\CaseleaderController@edit']);
		Route::post('edit/{id}',			['as' => 'qrs.caseleader.edit.post',	'uses' => 'QRS\CaseleaderController@editPost']);
	});

	Route::group(['prefix' => 'feedback'], function(){
		Route::get('{id}',				['as' => 'qrs.feedback.index',				'uses' => 'QRS\FeedbackController@index']);
		Route::get('notify/{id}',		['as' => 'qrs.feedback.notify',				'uses' => 'QRS\FeedbackController@notify']);
		Route::get('send/{id}',			['as' => 'qrs.feedback.send',				'uses' => 'QRS\FeedbackController@send']);
		Route::get('create/{id}',		['as' => 'qrs.feedback.create',				'uses' => 'QRS\FeedbackController@create']);
		Route::get('attachment/{id}',	['as' => 'qrs.feedback.attachment',			'uses' => 'QRS\FeedbackController@attachment']);
		Route::post('create/{id}',		['as' => 'qrs.feedback.create.post',		'uses' => 'QRS\FeedbackController@createPost']);
		Route::post('attachment/{id}',	['as' => 'qrs.feedback.attachment.post',	'uses' => 'QRS\FeedbackController@attachmentPost']);
	});

	Route::group(['prefix' => 'external'], function(){
		Route::get('{id}',				['as' => 'qrs.external.index',				'uses' => 'QRS\ExternalController@index']);
		Route::get('edit/{id}',			['as' => 'qrs.external.edit',				'uses' => 'QRS\ExternalController@edit']);
		Route::get('attachment/{id}',	['as' => 'qrs.external.attachment',			'uses' => 'QRS\ExternalController@attachment']);
		Route::post('edit/{id}',		['as' => 'qrs.external.edit.post',			'uses' => 'QRS\ExternalController@editPost']);
		Route::post('attachment/{id}',	['as' => 'qrs.external.attachment.post',	'uses' => 'QRS\ExternalController@attachmentPost']);
	});

	Route::group(['prefix' => 'report'], function(){
		Route::get('{id}',					['as' => 'qrs.report.index',			'uses' => 'QRS\ReportController@index']);
		Route::get('notify/{type}/{id}',	['as' => 'qrs.report.notify',			'uses' => 'QRS\ReportController@notify']);
		Route::get('send/{type}/{id}',		['as' => 'qrs.report.send',				'uses' => 'QRS\ReportController@send']);
		Route::get('edit/{id}',				['as' => 'qrs.report.edit',				'uses' => 'QRS\ReportController@edit']);
		Route::get('attachment/{id}',		['as' => 'qrs.report.attachment',		'uses' => 'QRS\ReportController@attachment']);
		Route::post('edit/{id}',			['as' => 'qrs.report.edit.post',		'uses' => 'QRS\ReportController@editPost']);
		Route::post('attachment/{id}',		['as' => 'qrs.report.attachment.post',	'uses' => 'QRS\ReportController@attachmentPost']);
	});

	Route::group(['prefix' => 'review'], function(){
		Route::get('{id}',				['as' => 'qrs.review.index',			'uses' => 'QRS\ReviewController@index']);
		Route::get('notify/{id}',		['as' => 'qrs.review.notify',			'uses' => 'QRS\ReviewController@notify']);
		Route::get('send/{id}',			['as' => 'qrs.review.send',				'uses' => 'QRS\ReviewController@send']);
		Route::get('edit/{id}',			['as' => 'qrs.review.edit',				'uses' => 'QRS\ReviewController@edit']);
		Route::get('attachment/{id}',	['as' => 'qrs.review.attachment',		'uses' => 'QRS\ReviewController@attachment']);
		Route::post('edit/{id}',		['as' => 'qrs.review.edit.post',		'uses' => 'QRS\ReviewController@editPost']);
		Route::post('attachment/{id}',	['as' => 'qrs.review.attachment.post',	'uses' => 'QRS\ReviewController@attachmentPost']);
	});

	Route::group(['prefix' => 'response'], function(){
		Route::get('{id}',				['as' => 'qrs.response.index',				'uses' => 'QRS\ResponseController@index']);
		Route::get('notify/{id}',		['as' => 'qrs.response.notify',				'uses' => 'QRS\ResponseController@notify']);
		Route::get('send/{id}',			['as' => 'qrs.response.send',				'uses' => 'QRS\ResponseController@send']);
		Route::get('edit/{id}',			['as' => 'qrs.response.edit',				'uses' => 'QRS\ResponseController@edit']);
		Route::get('attachment/{id}',	['as' => 'qrs.response.attachment',			'uses' => 'QRS\ResponseController@attachment']);
		Route::post('edit/{id}',		['as' => 'qrs.response.edit.post',			'uses' => 'QRS\ResponseController@editPost']);
		Route::post('attachment/{id}',	['as' => 'qrs.response.attachment.post',	'uses' => 'QRS\ResponseController@attachmentPost']);
	});

	Route::group(['prefix' => 'timeline'], function(){
		Route::get('{id}',				['as' => 'qrs.timeline.index',				'uses' => 'QRS\TimelineController@index']);
	});

	Route::group(['prefix' => 'verification'], function(){
		Route::get('{id}',				['as' => 'qrs.verification.index',				'uses' => 'QRS\VerificationController@index']);
		Route::get('notify/{id}',		['as' => 'qrs.verification.notify',				'uses' => 'QRS\VerificationController@notify']);
		Route::get('send/{id}',			['as' => 'qrs.verification.send',				'uses' => 'QRS\VerificationController@send']);
		Route::get('edit/{id}',			['as' => 'qrs.verification.edit',				'uses' => 'QRS\VerificationController@edit']);
		Route::get('lock/{id}',			['as' => 'qrs.verification.lock',				'uses' => 'QRS\VerificationController@lock']);
		Route::get('unlock/{id}',		['as' => 'qrs.verification.unlock',				'uses' => 'QRS\VerificationController@unlock']);
		Route::get('attachment/{id}',	['as' => 'qrs.verification.attachment',			'uses' => 'QRS\VerificationController@attachment']);
		Route::post('edit/{id}',		['as' => 'qrs.verification.edit.post',			'uses' => 'QRS\VerificationController@editPost']);
		Route::post('attachment/{id}',	['as' => 'qrs.verification.attachment.post',	'uses' => 'QRS\VerificationController@attachmentPost']);
	});

	Route::group(['prefix' => 'claims'], function(){
		Route::get('{id}',				['as' => 'qrs.claims.index',				'uses' => 'QRS\ClaimsController@index']);
		Route::get('notify/{id}',		['as' => 'qrs.claims.notify',				'uses' => 'QRS\ClaimsController@notify']);
		Route::get('send/{id}',			['as' => 'qrs.claims.send',					'uses' => 'QRS\ClaimsController@send']);
		Route::get('create/{id}',		['as' => 'qrs.claims.create',				'uses' => 'QRS\ClaimsController@create']);
		Route::get('edit/{cid}/{id}',	['as' => 'qrs.claims.edit',					'uses' => 'QRS\ClaimsController@edit']);
		Route::get('attachment/{id}',	['as' => 'qrs.claims.attachment',			'uses' => 'QRS\ClaimsController@attachment']);
		Route::get('lock/{id}',			['as' => 'qrs.claims.lock',					'uses' => 'QRS\ClaimsController@lock']);
		Route::get('unlock/{id}',		['as' => 'qrs.claims.unlock',				'uses' => 'QRS\ClaimsController@unlock']);
		Route::post('{id}',				['as' => 'qrs.claims.index.post',			'uses' => 'QRS\ClaimsController@indexPost']);
		Route::post('create/{id}',		['as' => 'qrs.claims.create.post',			'uses' => 'QRS\ClaimsController@createPost']);
		Route::post('edit/{cid}/{id}',	['as' => 'qrs.claims.edit.post',			'uses' => 'QRS\ClaimsController@editPost']);
		Route::post('attachment/{id}',	['as' => 'qrs.claims.attachment.post',		'uses' => 'QRS\ClaimsController@attachmentPost']);
	});

	Route::group(['prefix' => 'information'], function(){
		Route::get('{id}',				['as' => 'qrs.information.index',			'uses' => 'QRS\InformationController@index']);
		Route::get('edit/{id}',			['as' => 'qrs.information.edit',			'uses' => 'QRS\InformationController@edit']);
		Route::get('attachment/{id}',	['as' => 'qrs.information.attachment',		'uses' => 'QRS\InformationController@attachment']);
		Route::post('edit/{id}',		['as' => 'qrs.information.edit.post',		'uses' => 'QRS\InformationController@editPost']);
		Route::post('attachment/{id}',	['as' => 'qrs.information.attachment.post',	'uses' => 'QRS\InformationController@attachmentPost']);
	});

	Route::group(['prefix' => 'summary'], function(){
		Route::get('{id}',			['as' => 'qrs.summary.index',		'uses' => 'QRS\SummaryController@index']);
		Route::get('edit/{id}',		['as' => 'qrs.summary.edit',		'uses' => 'QRS\SummaryController@edit']);
		Route::post('{id}',			['as' => 'qrs.summary.index.post',	'uses' => 'QRS\SummaryController@indexPost']);
		Route::post('edit/{id}',	['as' => 'qrs.summary.edit.post',	'uses' => 'QRS\SummaryController@editPost']);
	});

	Route::group(['prefix' => 'reminder'], function(){
		Route::get('/',				['as' => 'qrs.reminder.index',		'uses' => 'QRS\ReminderController@index']);
		Route::get('notify/{id}',	['as' => 'qrs.reminder.notify',		'uses' => 'QRS\ReminderController@notify']);
		Route::get('send/{id}',		['as' => 'qrs.reminder.send',		'uses' => 'QRS\ReminderController@send']);
		Route::get('all',			['as' => 'qrs.reminder.all',		'uses' => 'QRS\ReminderController@all']);
	});

	Route::group(['prefix' => 'master'], function(){
		Route::get('/',		['as' => 'qrs.master',		function(){return redirect()->route('qrs.index');}]);

		Route::group(['prefix' => 'packing'], function(){
			Route::get('/',				['as' => 'qrs.packing.index',			'uses' => 'QRS\MasterController@index']);
			Route::get('create',		['as' => 'qrs.packing.create',			'uses' => 'QRS\MasterController@create']);
			Route::get('edit/{id}',		['as' => 'qrs.packing.edit',			'uses' => 'QRS\MasterController@edit']);
			Route::get('show/{id}',		['as' => 'qrs.packing.show',			'uses' => 'QRS\MasterController@show']);
			Route::get('delete/{id}',	['as' => 'qrs.packing.delete',			'uses' => 'QRS\MasterController@delete']);
			Route::post('create',		['as' => 'qrs.packing.create.post',		'uses' => 'QRS\MasterController@createPost']);
			Route::post('edit/{id}',	['as' => 'qrs.packing.edit.post',		'uses' => 'QRS\MasterController@editPost']);
		});

		Route::group(['prefix' => 'country'], function(){
			Route::get('/',				['as' => 'qrs.country.index',			'uses' => 'QRS\MasterController@index']);
			Route::get('create',		['as' => 'qrs.country.create',			'uses' => 'QRS\MasterController@create']);
			Route::get('edit/{id}',		['as' => 'qrs.country.edit',			'uses' => 'QRS\MasterController@edit']);
			Route::get('show/{id}',		['as' => 'qrs.country.show',			'uses' => 'QRS\MasterController@show']);
			Route::get('delete/{id}',	['as' => 'qrs.country.delete',			'uses' => 'QRS\MasterController@delete']);
			Route::post('create',		['as' => 'qrs.country.create.post',		'uses' => 'QRS\MasterController@createPost']);
			Route::post('edit/{id}',	['as' => 'qrs.country.edit.post',		'uses' => 'QRS\MasterController@editPost']);
		});

		Route::group(['prefix' => 'stuffing'], function(){
			Route::get('/',				['as' => 'qrs.stuffing.index',			'uses' => 'QRS\MasterController@index']);
			Route::get('create',		['as' => 'qrs.stuffing.create',			'uses' => 'QRS\MasterController@create']);
			Route::get('edit/{id}',		['as' => 'qrs.stuffing.edit',			'uses' => 'QRS\MasterController@edit']);
			Route::get('show/{id}',		['as' => 'qrs.stuffing.show',			'uses' => 'QRS\MasterController@show']);
			Route::get('delete/{id}',	['as' => 'qrs.stuffing.delete',			'uses' => 'QRS\MasterController@delete']);
			Route::post('create',		['as' => 'qrs.stuffing.create.post',	'uses' => 'QRS\MasterController@createPost']);
			Route::post('edit/{id}',	['as' => 'qrs.stuffing.edit.post',		'uses' => 'QRS\MasterController@editPost']);
		});

		Route::group(['prefix' => 'document'], function(){
			Route::get('/',				['as' => 'qrs.document.index',			'uses' => 'QRS\MasterController@index']);
			Route::get('create',		['as' => 'qrs.document.create',			'uses' => 'QRS\MasterController@create']);
			Route::get('edit/{id}',		['as' => 'qrs.document.edit',			'uses' => 'QRS\MasterController@edit']);
			Route::get('show/{id}',		['as' => 'qrs.document.show',			'uses' => 'QRS\MasterController@show']);
			Route::get('delete/{id}',	['as' => 'qrs.document.delete',			'uses' => 'QRS\MasterController@delete']);
			Route::post('create',		['as' => 'qrs.document.create.post',	'uses' => 'QRS\MasterController@createPost']);
			Route::post('edit/{id}',	['as' => 'qrs.document.edit.post',		'uses' => 'QRS\MasterController@editPost']);
		});

		Route::group(['prefix' => 'claimstype'], function(){
			Route::get('/',				['as' => 'qrs.claimstype.index',		'uses' => 'QRS\MasterController@index']);
			Route::get('create',		['as' => 'qrs.claimstype.create',		'uses' => 'QRS\MasterController@create']);
			Route::get('edit/{id}',		['as' => 'qrs.claimstype.edit',			'uses' => 'QRS\MasterController@edit']);
			Route::get('show/{id}',		['as' => 'qrs.claimstype.show',			'uses' => 'QRS\MasterController@show']);
			Route::get('delete/{id}',	['as' => 'qrs.claimstype.delete',		'uses' => 'QRS\MasterController@delete']);
			Route::post('create',		['as' => 'qrs.claimstype.create.post',	'uses' => 'QRS\MasterController@createPost']);
			Route::post('edit/{id}',	['as' => 'qrs.claimstype.edit.post',	'uses' => 'QRS\MasterController@editPost']);
		});

		Route::group(['prefix' => 'currency'], function(){
			Route::get('/',				['as' => 'qrs.currency.index',			'uses' => 'QRS\MasterController@index']);
			Route::get('create',		['as' => 'qrs.currency.create',			'uses' => 'QRS\MasterController@create']);
			Route::get('edit/{id}',		['as' => 'qrs.currency.edit',			'uses' => 'QRS\MasterController@edit']);
			Route::get('show/{id}',		['as' => 'qrs.currency.show',			'uses' => 'QRS\MasterController@show']);
			Route::get('delete/{id}',	['as' => 'qrs.currency.delete',			'uses' => 'QRS\MasterController@delete']);
			Route::post('create',		['as' => 'qrs.currency.create.post',	'uses' => 'QRS\MasterController@createPost']);
			Route::post('edit/{id}',	['as' => 'qrs.currency.edit.post',		'uses' => 'QRS\MasterController@editPost']);
		});

		Route::group(['prefix' => 'classification'], function(){
			Route::get('/',				['as' => 'qrs.classification.index',		'uses' => 'QRS\MasterController@index']);
			Route::get('create',		['as' => 'qrs.classification.create',		'uses' => 'QRS\MasterController@create']);
			Route::get('edit/{id}',		['as' => 'qrs.classification.edit',			'uses' => 'QRS\MasterController@edit']);
			Route::get('show/{id}',		['as' => 'qrs.classification.show',			'uses' => 'QRS\MasterController@show']);
			Route::get('delete/{id}',	['as' => 'qrs.classification.delete',		'uses' => 'QRS\MasterController@delete']);
			Route::post('create',		['as' => 'qrs.classification.create.post',	'uses' => 'QRS\MasterController@createPost']);
			Route::post('edit/{id}',	['as' => 'qrs.classification.edit.post',	'uses' => 'QRS\MasterController@editPost']);
		});
	});

	Route::group(['prefix' => 'member'], function(){
		Route::get('/',				['as' => 'qrs.member',						function(){return redirect()->route('qrs.index');}]);
		Route::get('caseleader',	['as' => 'qrs.member.caseleader',			'uses' => 'QRS\MemberController@caseleader']);
		Route::get('defaultcc',		['as' => 'qrs.member.defaultcc',			'uses' => 'QRS\MemberController@defaultcc']);
		Route::get('defaultqa',		['as' => 'qrs.member.defaultqa',			'uses' => 'QRS\MemberController@defaultqa']);
		Route::get('claims',		['as' => 'qrs.member.claims',				'uses' => 'QRS\MemberController@claims']);
		Route::post('caseleader',	['as' => 'qrs.member.caseleader.post',		'uses' => 'QRS\MemberController@caseleaderPost']);
		Route::post('defaultcc',	['as' => 'qrs.member.defaultcc.post',		'uses' => 'QRS\MemberController@defaultccPost']);
		Route::post('defaultqa',	['as' => 'qrs.member.defaultqa.post',		'uses' => 'QRS\MemberController@defaultqaPost']);
		Route::post('claims',		['as' => 'qrs.member.claims.post',			'uses' => 'QRS\MemberController@claimsPost']);
	});

	Route::group(['prefix' => 'notification'], function(){
		Route::get('/',				['as' => 'qrs.notification.index',			'uses' => 'QRS\NotificationController@index']);
		Route::get('create',		['as' => 'qrs.notification.create',			'uses' => 'QRS\NotificationController@create']);
		Route::get('edit/{id}',		['as' => 'qrs.notification.edit',			'uses' => 'QRS\NotificationController@edit']);
		Route::get('show/{id}',		['as' => 'qrs.notification.show',			'uses' => 'QRS\NotificationController@show']);
		Route::get('delete/{id}',	['as' => 'qrs.notification.delete',			'uses' => 'QRS\NotificationController@delete']);
		Route::post('create',		['as' => 'qrs.notification.create.post',	'uses' => 'QRS\NotificationController@createPost']);
		Route::post('edit/{id}',	['as' => 'qrs.notification.edit.post',		'uses' => 'QRS\NotificationController@editPost']);
	});
});