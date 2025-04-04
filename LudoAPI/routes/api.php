<?php

use App\Http\Controllers\FriendController;
use App\Http\Controllers\UserController;
use App\Settings\ServerMaintenanceSetting;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::prefix('v1')->group(function () {
    Route::get('/time', function () {
        return [
            'current_time' => now()
        ];
    });

    Route::get('/maintenance-mode', function (ServerMaintenanceSetting  $setting) {
        return [
            'enable' => $setting->enable,
            'start_date' => $setting->start_date,
            'end_date' => $setting->end_date,
        ];
    });
    Route::post('/register', [AuthController::class,'register']);
    Route::post('/check-user', [AuthController::class,'checkUser']);
    Route::get('/user/search', [UserController::class,'search']);


    Route::delete('users/remove', [App\Http\Controllers\UserController::class, 'remove']);
    Route::apiResource('users', App\Http\Controllers\UserController::class)->only('update','show');

    Route::get('friends/blocked-list', [FriendController::class, 'blockedList'])->name('friends.blocked-list');
    Route::apiResource('friends', App\Http\Controllers\FriendController::class)->only('index');
    Route::get('friends/my-friend-request', [FriendController::class, 'myFriendRequests'])->name('friends.my.friend_requests');
    Route::post('friends/make-friend-request', [FriendController::class, 'makeFriendRequest'])->name('friends.make.friend_request');
    Route::post('friends/accept-reject-friend-request', [FriendController::class, 'acceptOrReject'])->name('friends.accept-reject.friend_request');
    Route::post('friends/accept-reject-friend-all-request', [FriendController::class, 'acceptOrRejectAll'])->name('friends.accept-reject.friend_all_request');
    Route::delete('friends/make-unfriend', [FriendController::class, 'makeUnFriend'])->name('friends.make.unfriend');
    Route::post('friends/block-unblock', [FriendController::class, 'blockUnblock'])->name('friends.make.block-unblock');
    Route::post('notifications/send-notifications', [\App\Http\Controllers\NotificationController::class, 'sendNotifications'])->name('notification.send-notifications');

    Route::controller(App\Http\Controllers\SpinWheelController::class)->group(function () {
        Route::get('spin-wheel', 'index');
        Route::post('spin-wheel', 'spinWheel');
        Route::post('spin-wheel-status', 'spinWheelStatus');
    });

    Route::controller(App\Http\Controllers\RewardController::class)->group(function () {
        Route::get('rewards', 'index');
        Route::post('rewards/claim', 'claim');
        Route::post('rewards/available', 'available');
    });

    Route::apiResource('spin-wheels', App\Http\Controllers\SpinWheelController::class)->only('index');
    Route::apiResource('collections', App\Http\Controllers\CollectionController::class)->only('index');
    Route::apiResource('online-tables', App\Http\Controllers\OnlineTableController::class)->only('index', 'show');
    Route::get('online-tables/{id}/{externalId}', [App\Http\Controllers\OnlineTableController::class, 'check'])->name('online-tables.check');

    Route::apiResource('private-tables', App\Http\Controllers\PrivateTableController::class)->only('index', 'show');
    Route::get('private-tables/{id}/{externalId}', [App\Http\Controllers\PrivateTableController::class, 'check'])->name('private-tables.check');
    Route::get('settings/api', [App\Http\Controllers\SettingController::class, 'ip'])->name('settings.ip');

    Route::apiResource('offers', App\Http\Controllers\OfferController::class)->only('index');
    Route::controller(App\Http\Controllers\TransactionController::class)->group(function () {
        Route::post('transactions/user', 'userTransactions');
        Route::post('transactions/buy-coins', 'buyCoins');
        Route::post('transactions/buy-gems', 'buyGems');
        Route::post('transactions/buy-collections', 'buyCollections');
    });
    Route::apiResource('transactions', App\Http\Controllers\TransactionController::class)->except('update', 'show', 'destroy');
});
