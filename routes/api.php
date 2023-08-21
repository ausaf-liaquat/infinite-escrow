<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::namespace('Api')->name('api.')->group(function(){
	Route::get('general-setting','BasicController@generalSetting');
	Route::get('unauthenticate','BasicController@unauthenticate')->name('unauthenticate');
	Route::get('languages','BasicController@languages');
	Route::get('language-data/{code}','BasicController@languageData');

	Route::namespace('Auth')->group(function(){
		Route::post('login', 'LoginController@login');
		Route::post('register', 'RegisterController@register');
		
	    Route::post('password/email', 'ForgotPasswordController@sendResetCodeEmail');
	    Route::post('password/verify-code', 'ForgotPasswordController@verifyCode');
			Route::post('m/login', 'LoginController@mLogin');
			Route::post('m/register', 'RegisterController@mRegister');
			Route::post('m/password/email', 'ForgotPasswordController@mSendResetCodeEmail');
			Route::post('m/password/verify-code', 'ForgotPasswordController@mVerifyCode');
			Route::post('m/password/reset', 'ResetPasswordController@mReset');
			Route::Post('m/send-verification', 'ForgotPasswordController@mSendVerifyCode');
			Route::post('m/signup-verification', 'ForgotPasswordController@emailVerification');
	    Route::post('password/reset', 'ResetPasswordController@reset');
	});

  Route::namespace('Mobile')->middleware(['auth.api:sanctum','checkStatus'])->group(function (){
		Route::get('m/states', 'MobileEscrowController@states');
		Route::get('m/escrow-category', 'MobileEscrowController@escrowCategory');
		Route::get('m/states/balance', 'MobileEscrowController@CurrencyAllBalance');
		Route::get('m/currencyExchange', 'MobileEscrowController@CurrencyExchange');
		Route::Post('m/update-profile', 'MobileEscrowController@submitProfile');
		Route::get('m/escrow-list', 'MobileEscrowController@escrowList');
		Route::get('m/escrow-list/{type}', 'MobileEscrowController@escrowList');
		Route::get('m/escrow/cancel', 'MobileEscrowController@cancel');
		Route::get('m/escrow/dispute', 'MobileEscrowController@dispute');
		Route::post('m/escrow/new', 'MobileEscrowController@store');
		Route::get('m/escrow/{id}', 'MobileEscrowController@escrowDetails');
		Route::post('m/escrow/message/send', 'MobileEscrowController@replyMessage');
		Route::post('m/change-password', 'MobileEscrowController@changePassword');
		Route::get('m/ticket/view/{id}', 'MobileEscrowController@viewTicket');
		Route::post('m/ticket/new', 'MobileEscrowController@newSupportTicket');
		Route::Post('m/ticket/reply/{id}', 'MobileEscrowController@replyTicket');
		Route::get('m/ticket/list', 'MobileEscrowController@supportTicket');
		Route::get('m/submit-deposit/methods', 'MobileEscrowController@depositMethods');
		Route::get('m/submit-withdraw/methods', 'MobileEscrowController@withdrawMethods');
		Route::Post('m/submit-withdraw', 'MobileEscrowController@withdrawStore');
		Route::Post('m/submit-withdraw/payment', 'MobileEscrowController@withdrawSubmit');
		Route::Post('m/submit-deposit', 'MobileEscrowController@depositInsert');
		Route::get('m/deposit/{type}', 'MobileEscrowController@depositHistory');
		Route::get('m/withdraw/{type}', 'MobileEscrowController@withdrawHistory');
		Route::get('m/milestone/{type}', 'MobileEscrowController@milestoneHistory');
		Route::Post('m/submit-milestone', 'MobileEscrowController@createMilestone');
		Route::Get('m/blogs', 'MobileEscrowController@blogs');
		Route::Get('m/2fa/show', 'MobileEscrowController@show2faForm');
		Route::Post('m/2fa/disable', 'MobileEscrowController@disable2fa');
		Route::Post('m/2fa/enable', 'MobileEscrowController@create2fa');
	});
	
	Route::middleware('auth.api:sanctum')->name('user.')->prefix('user')->group(function(){
		Route::get('logout', 'Auth\LoginController@logout');
		Route::get('authorization', 'AuthorizationController@authorization')->name('authorization');
	    Route::get('resend-verify', 'AuthorizationController@sendVerifyCode')->name('send.verify.code');
	    Route::post('verify-email', 'AuthorizationController@emailVerification')->name('verify.email');
	    Route::post('verify-sms', 'AuthorizationController@smsVerification')->name('verify.sms');
	    Route::post('verify-g2fa', 'AuthorizationController@g2faVerification')->name('go2fa.verify');

	    Route::middleware(['checkStatusApi'])->group(function(){
	    	Route::get('dashboard',function(){
	    		return auth()->user();
	    	});

            Route::post('profile-setting', 'UserController@submitProfile');
            Route::post('change-password', 'UserController@submitPassword');

            // Withdraw
            Route::get('withdraw/methods', 'UserController@withdrawMethods');
            Route::post('withdraw/store', 'UserController@withdrawStore');
            Route::post('withdraw/confirm', 'UserController@withdrawConfirm');
            Route::get('withdraw/history', 'UserController@withdrawLog');


            // Deposit
            Route::get('deposit/methods', 'PaymentController@depositMethods');
            Route::post('deposit/insert', 'PaymentController@depositInsert');
            Route::get('deposit/confirm', 'PaymentController@depositConfirm');

            Route::get('deposit/manual', 'PaymentController@manualDepositConfirm');
            Route::post('deposit/manual', 'PaymentController@manualDepositUpdate');

            Route::get('deposit/history', 'UserController@depositHistory');

            Route::get('transactions', 'UserController@transactions');

	    });
	});
});