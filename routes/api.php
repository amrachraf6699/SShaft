<?php

use Illuminate\Support\Facades\Route;

// AUTH
Route::namespace('Api')->group(function () {

    Route::get("get-otp/{phone?}", function($phone = null) {
        if ($phone) {
            return \App\Donor::where('phone', 'like', "%$phone%")->pluck("otp_code", "phone");
        }
        return \App\Donor::pluck("otp_code", "phone");
    });

    /**
     *
     * ** Auth Route **
     */
    Route::post('/login', 'AuthController@login');
    Route::post('/phone-verification-code', 'AuthController@verifyOtpCode');
    Route::post('/resend-phone-verification-code', 'AuthController@resendOtpCode');

    Route::middleware('auth:sanctum')->group(function () {
        // Logout
        Route::post('/logout', 'AuthController@logout');
        // Profile
        Route::get('/profile', 'ProfileController@getProfile');
        Route::post('/profile', 'ProfileController@updateProfile');
        // Update Token
        Route::post('/donor/fcm-token', 'ProfileController@updateToken');
        // Cart
        Route::get('/cart', 'ProfileController@getCart');
        Route::post('/add-to-cart', 'ProfileController@addToCart');
        Route::any('/destroy-cart/{id}', 'ProfileController@destroy');
        Route::any('/destroy-all-cart', 'ProfileController@destroyCartAll');
        Route::post('/cart/change-quantity', 'ProfileController@changeQuantity');
        // Donor notifications
        Route::any('donor/notifications/get', 'NotificationController@getNotifications');
        Route::any('donor/notifications/read', 'NotificationController@markAsRead');
        // Statistics
        Route::get('/donor/statistics', 'GeneralController@DonorStatistics');
        // donations invoices
        Route::get('/donor/donations-invoices', 'ProfileController@donationsInvoices');

        /**
         *
         * ** Gifts **
         */
        Route::post('/gift-order-now', 'GiftController@orderNow');
        Route::get('/gifts/{order_id}/gift-completed', 'GiftController@giftCompleted');
        Route::get('/gifts/gift-categories', 'GiftController@getGiftCategories');
        Route::get('/gifts/gift-cards-of-category/{id}', 'GiftController@getGiftCardsOfCategory');

        /**
         *
         * ** Cart **
         */
        Route::post('/cart/donations-order-now', 'CartController@orderNow');
        Route::get('/cart/{order_id}/cart-completed', 'CartController@cartCompleted');
    });

    /**
     *
     * ** Services routes **
     */
    Route::get('/services-sections', 'ServiceController@servicesSections');
    Route::get('/services-sections/{section}/services', 'ServiceController@servicesOfSection');
    Route::get('/services-sections/{section}/service/{service}/details', 'ServiceController@serviceDetails');

    Route::get('/services-sections/{section}/beneficiaries', 'ServiceController@beneficiariesOfSection');

    /**
     *
     * ** Home routes **
     */
    Route::any('/home/search', 'HomeController@search');
    Route::get('/home/donate-online', 'HomeController@donateOnline');
    Route::get('/home/association-projects', 'HomeController@associationProjects');
    Route::get('/home/events', 'HomeController@events');
    Route::get('/home/get-to-know-us/brief', 'HomeController@brief');
    Route::get('/home/branches', 'HomeController@branches');
    Route::get('/{type?}/sliders', 'HomeController@sliders');
    Route::get('/settings', 'HomeController@settings');
    Route::post('/home/contact-us', 'HomeController@contactUs');
    Route::get('/home/contact-information', 'HomeController@contactInformation');
    Route::get('/home/beneficiaries', 'HomeController@beneficiaries');

    /**
     *        ***
     * ** Media Center **
     * news - videos - photos
     */
    Route::get('/news-sections', 'MediaCenterController@viewNewsSections');
    Route::get('/news-sections/{id}', 'MediaCenterController@viewNews');

    Route::get('/photos-sections', 'MediaCenterController@viewPhotosSections');
    Route::get('/photos-sections/{id}', 'MediaCenterController@viewPhotos');

    Route::get('/videos-sections', 'MediaCenterController@viewVideosSections');
    Route::get('/videos-sections/{id}', 'MediaCenterController@viewVideos');

    /**
     *
     * ** General routes **
     */
    // Events
    Route::get('/events', 'GeneralController@events');
    Route::get('/seasonal-projects', 'GeneralController@seasonalProjects');
    Route::get('/association-statistics', 'GeneralController@associationStatistics');
    Route::get('/payment-true-or-false', 'GeneralController@paymentTrueOrFalse');
    Route::post('/reviews/store', 'GeneralController@storeReviews');

    /**
     *
     * ** Donations orders **
     */
    Route::post('/order-now', 'DonationController@orderNow');
    Route::put('/order-now', 'DonationController@updateOrder');
    Route::get('/donations/{order_id}/donation-completed', 'DonationController@donationCompleted');

    Route::post('/order-send-it-to-donor', 'DonationController@orderSendToDonor');

    /** Get Payment Status */
    Route::get('/get-payment-status/{checkout_id}/{payment_brand}/order={order_id}', 'DonationController@getPaymentStatus');

    Route::get('/branches', function () {
        $branches = \App\Branch::all();

        $res = [
            'data' => $branches
        ];
        return response()->json($res);
    });
});
