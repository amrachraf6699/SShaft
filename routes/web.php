<?php

use Illuminate\Support\Facades\Route;

Route::name('frontend.')->middleware(['donor.activated', 'maintenance'])->namespace('Frontend')->group(function () {
    // HOME
    Route::get('/', 'HomeController@index')->name('home');
    // WHO ARE WE
    Route::get('/about-the-association/brief', 'PageController@viewBrief')->name('about-the-association.brief.view');
    Route::get('/about-the-association/board-of-directors', 'PageController@boardOfDirectors')->name('about-the-association.board-of-director.view');
    Route::get('/about-the-association/services-albir', 'PageController@viewServicesAlbir')->name('about-the-association.services-albir.view');
    Route::get('/about-the-association/organizational-chart', 'PageController@viewOrganizationalChart')->name('about-the-association.organizational-chart.view');
    Route::get('/about-the-association/statistics', 'PageController@viewStatistics')->name('about-the-association.statistics.view');
    Route::get('/about-the-association/events', 'PageController@viewEvents')->name('about-the-association.events.view');
    Route::get('/about-the-association/events/{slug}', 'PageController@viewEventDetails')->name('about-the-association.event.show');
    Route::get('/about-the-association/seasonal-projects', 'PageController@viewSeasonalProjects')->name('about-the-association.seasonal-projects.view');
    Route::get('/about-the-association/seasonal-projects/{slug}', 'PageController@viewSeasonalProjectDetails')->name('about-the-association.seasonal-projects.show');
    Route::get('/about-the-association/governance-material', 'PageController@viewGovernanceMaterial')->name('about-the-association.governance-material.view');
    Route::get('/about-the-association/governance-material/{slug}', 'PageController@viewGovernanceMaterialDetails')->name('about-the-association.governance-material.show');
    // ALBIR FRIENDS
    Route::get('/albir-friends', 'AlbirFriendsController@viewAlbirFriends')->name('albir-friends.view');
    Route::get('/albir-friends/general-assembly-members&type={slug}', 'AlbirFriendsController@formGeneralAssemblyMembers')->name('general-assembly-members.form');
    Route::post('/albir-friends/general-assembly-members&type={slug}', 'AlbirFriendsController@storeGeneralAssemblyMembers')->name('general-assembly-members.store');
    Route::get('/albir-friends/registration-form&type={slug}', 'AlbirFriendsController@viewRegistrationForm')->name('albir-friends.registration-form.view');
    Route::post('/albir-friends/registration-form&type={slug}', 'AlbirFriendsController@storeRegistrationForm')->name('albir-friends.registration-form.store');

    // SERVICES
    Route::get('/services-sections/show/{slug}', 'ServiceController@viewServices')->name('services-sections');
    Route::get('/services-sections/show/{section_slug}/d/{slug}', 'ServiceController@viewServicesDetails')->name('services-sections.service.show');

    /**
     *        ***
     * ** Media Center **
     * news - videos - photos
     */
    Route::get('/news-sections', 'MediaCenterController@viewNewsSections')->name('news-sections.index');
    Route::get('/news-sections/{slug}', 'MediaCenterController@viewNews')->name('news.index');
    Route::get('/news-sections/{section_slug}/d/{new_slug}', 'MediaCenterController@viewNewsDetails')->name('news-details.show');

    Route::get('/photos-sections', 'MediaCenterController@viewPhotosSections')->name('photos-sections.index');
    Route::get('/photos-sections/{slug}', 'MediaCenterController@viewPhotos')->name('photos.index');

    Route::get('/videos-sections', 'MediaCenterController@viewVideosSections')->name('videos-sections.index');
    Route::get('/videos-sections/{slug}', 'MediaCenterController@viewVideos')->name('videos.index');
    Route::get('/videos-sections/{section_slug}/d/{video_slug}', 'MediaCenterController@viewVideosDetails')->name('videos-details.show');

    // CONTACT
    Route::get('/contact-us', 'ContactController@index')->name('contact.index');
    Route::post('/contact-us', 'ContactController@store')->name('contact.store');

    // BRANCHES
    Route::get('/our-branches', 'PageController@viewBranches')->name('branches.index');

    // SURVEYS
    Route::get('/surveys', 'SurveyController@viewSurvey')->name('surveys.index');
    Route::post('/survey/vote/{survey}', 'SurveyController@incrementVote')->name('surveys.vote.increment');

    // BENEFICIARIES REQUESTS
    Route::get('/beneficiaries-requests', 'BeneficiaryController@index')->name('beneficiaries-requests.index');
    Route::post('/beneficiaries-requests', 'BeneficiaryController@store')->name('beneficiaries-requests.store');
    Route::get('/beneficiaries-requests/{section}/show', 'BeneficiaryController@viewBeneficiaries')->name('beneficiaries-requests.section.show');
    Route::get('/beneficiaries-requests/show/{section_slug}/d/{slug}', 'BeneficiaryController@viewBeneficiariesDetails')->name('beneficiaries-requests.details');
    Route::get('/beneficiaries-check-out', 'PaymentProviderController@getAllBeneficiariesCheckout')->name('beneficiaries.check-out');
    Route::get('/beneficiaries-index-check-out', 'PaymentProviderController@getIndexBeneficiariesCheckout')->name('index-beneficiaries.check-out');


    /***
     * *** AUTH ***
     * ****************
    */
    // add gift
    Route::post('/sendOtp', 'DonorController@sendOtp')->name('sendOtp');
    Route::post('/verifyOtp', 'DonorController@verifyOtp')->name('verifyOtp');
    Route::get('/verifyOtp/{phone}', 'DonorController@verifyOtpView')->name('verifyOtpView');
    // quick-donation
    Route::post('quick-donation/sendOtp', 'DonorController@sendOtpDonation')->name('quick-donation.sendOtp');
    Route::post('quick-donation/verifyOtp', 'DonorController@verifyOtpDonation')->name('quick-donation.verifyOtp');
    Route::get('quick-donation/verifyOtp/{phone}', 'DonorController@verifyOtpViewDonation')->name('quick-donation.verifyOtpView');

    // ADD A GIFT
    Route::get('/add-a-gift', 'GiftController@addAGift')->name('add-a-gift');
    Route::post('/add-a-gift', 'GiftController@storeAGift')->name('store-a-gift');
    // Get neighborhoods
    Route::get('/gift-category/{id}', 'GiftController@getGiftCards');

    // ADD quickDonation slider
    Route::post('/add-a-quick-donation', 'HomeController@quickDonationSlider')->name('store.quick-donation-slider');

    // MODULES
    Route::get('/modules-section/{slug}', 'PageController@viewModulesSection')->name('section.modules.show');
    Route::get('/modules/{section_slug}/show/{module_slug}', 'PageController@viewModules')->name('modules.show');
    
    // INAUGURATION
    Route::get('/inauguration', 'PageController@inauguration')->name('inauguration.index');

    Route::middleware(['auth:donor'])->group(function () {
        // PROFILE
        Route::get('/profile/{username}', 'ProfileController@showProfileInformation')->name('profile.show-profile-information');
        Route::post('/profile/{id}', 'ProfileController@updateProfileInformation')->name('profile.update-profile-information');
        Route::any('/profile/destroy/{username}', 'ProfileController@destroyProfile')->name('profile.destroy-profile');
        // Cart
        Route::get('/cart', 'CartController@index')->name('cart.index');
        Route::post('/cart', 'CartController@orderStore')->name('cart.order-store');
        Route::any('/destroy-from-cart/{itemId}', 'CartController@destroy')->name('cart.destroy');
        Route::any('/empty-the-cart', 'CartController@emptyTheCart')->name('cart.empty-the-cart');
        // ADD TO CART
        Route::post('/add-to-cart/{service}', 'CartController@store')->name('service.cart.store');
        // Donation
        Route::get('/donations', 'DonationController@index')->name('donations.index');
        Route::post('/donations', 'DonationController@store')->name('donations.store');
        Route::post('/donate-now/{service}', 'DonationController@donateNowStore')->name('donate-now.store');
        // Bills
        Route::get('/my-bills', 'ProfileController@myBills')->name('my-bills.index');
    });

    // Check out
    Route::get('/service-check-out', 'PaymentProviderController@getServiceCheckout')->name('service.check-out');
    Route::get('/all-services-service-check-out', 'PaymentProviderController@getAllServicesServiceCheckout')->name('all-services.service.check-out');
    Route::get('/services-index-check-out', 'PaymentProviderController@getIndexServicesCheckout')->name('index-services.check-out');
    Route::get('/quick-donation-side-bar-check-out', 'PaymentProviderController@quickDonationSideBarCheckout')->name('quick-donation-side-bar-check-out.check-out');
    Route::get('/add-gift-check-out', 'PaymentProviderController@addGiftCheckout')->name('add-gift.check-out');
    Route::get('/members/choose-payment-method', 'PaymentProviderController@membersChoosePaymentMethodCheckout')->name('members.choose-payment-method.check-out');

    // Payments
    Route::get('/checkout', 'PaymentProviderController@getCheckout')->name('donations.check-out');
    Route::get('/donations/bank-transfer/{donation_code}', 'DonationController@viewBankTransfer')->name('donations.bank-transfer.view');
    Route::post('/donations/bank-transfer/{donation_code}', 'DonationController@storeBankTransfer')->name('donations.bank-transfer.store');
    Route::get('/donations/credit-card/{donation_code}&payment_brand={payment_brand}', 'PaymentController@viewCreditCard')->name('donations.credit-card.view');
    Route::post('/donations/credit-card/{donation_code}', 'PaymentController@storeCreditCard')->name('donations.credit-card.store');
    
    // Pay general assembly members
    Route::get('/pay-general-assembly-members/{membership_no}/choose-payment-method/{invoice_no}', 'PayGeneralAssemblyMemberController@viewChoosePaymentMethod')->name('pay-general-assembly-members.choose-payment-method.view');
    Route::post('/pay-general-assembly-members/{membership_no}/choose-payment-method/{invoice_no}', 'PayGeneralAssemblyMemberController@storeChoosePaymentMethod')->name('pay-general-assembly-members.choose-payment-method.store');
    Route::get('/pay-general-assembly-members/{membership_no}/bank-transfer/{invoice_no}', 'PayGeneralAssemblyMemberController@viewBankTransfer')->name('pay-general-assembly-members.bank-transfer.view');
    Route::post('/pay-general-assembly-members/{membership_no}/bank-transfer/{invoice_no}', 'PayGeneralAssemblyMemberController@storeBankTransfer')->name('pay-general-assembly-members.bank-transfer.store');
    Route::get('/pay-general-assembly-members/{membership_no}&payment_brand={payment_brand}/credit-card/{invoice_no}', 'PayGeneralAssemblyMemberController@viewCreditCard')->name('pay-general-assembly-members.credit-card.view');

    // Unsubscribe Newsletter
    Route::get('/unsubscribe-newsletter/email={email}&username={username}', 'HomeController@unsubscribeNewsletter')->name('unsubscribe-newsletter.unsubscribe');
    
    // Marketers
    Route::get('/marketers/{username}', 'MarketerController@index')->name('marketers.index');
    Route::get('/marketers-service-check-out/{username}', 'PaymentProviderController@getMarketersServiceCheckout')->name('marketers.service.check-out');

    // Review routes
    Route::get('/reviews/{donation_code}', 'HomeController@viewReview')->name('reviews.index');
    Route::post('/reviews/{donation_code}/store', 'HomeController@sendReview')->name('reviews.sendReview');

    // Employment application routes
    Route::get('/employment-application', 'EmploymentApplicationController@index')->name('employment-application.index');
    Route::post('/employment-application', 'EmploymentApplicationController@store')->name('employment-application.store');

    // Certificate of general assembly member
    Route::get('/certificate-of-general-assembly-member/{uuid}', 'AlbirFriendsController@certificateOfGeneralAssemblyMember')->name('certificate-of-general-assembly-member.show');
    // View the list of members of the General Assembly
    Route::get('/list-of-members-of-the-general-assembly', 'AlbirFriendsController@viewTheListOfMembersOfTheGeneralAssembly')->name('list-of-members-of-the-general-assembly.index');
});

Route::get('/maintenance', 'Frontend\HomeController@maintenance')->name('frontend.maintenance');
