<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Providers\RouteServiceProvider;

Auth::routes(['register' => false]);
Route::prefix(RouteServiceProvider::DASHBOARD)->name('dashboard.')->middleware(['auth' , 'switchLanguage'])->namespace('Dashboard')->group(function () {
    // WELCOME
    Route::get('/', 'DashboardController@index')->name('welcome');
    Route::get('/research-results', 'DashboardController@generalSearch')->name('general-search');

    // ADMIN
    Route::get('profile', 'DashboardController@editAdmin')->name('admin.edit');
    Route::post('profile', 'DashboardController@updateAdmin')->name('admin.update');

    // SLIDERS
    Route::resource('/sliders', 'SliderController');
    Route::delete('/sliders/destroy/all', 'SliderController@multiDelete')->name('sliders.destroy_all');

    // User Groups
    Route::resource('/user-groups', 'UserGroupController')->except(['show']);
    Route::delete('/user-groups/destroy/all', 'UserGroupController@multiDelete')->name('user-groups.destroy_all');
    // USERS
    Route::resource('/users', 'UserController');
    Route::delete('/users/destroy/all', 'UserController@multiDelete')->name('users.destroy_all');
    Route::get('users/change-status/{id}', 'UserController@changeStatus')->name('users.status');

    // PACKAGES
    Route::resource('/packages', 'PackageController');
    Route::delete('/packages/destroy/all', 'PackageController@multiDelete')->name('packages.destroy_all');
    // GENERAL ASSEMBLY MEMBERS
    Route::resource('/general-assembly-members', 'GeneralAssemblyMemberController');
    Route::patch('/general-assembly-members/change-status/{id}', 'GeneralAssemblyMemberController@changeStatus')->name('general-assembly-members.status');
    Route::delete('/general-assembly-members/destroy/all', 'GeneralAssemblyMemberController@multiDelete')->name('general-assembly-members.destroy_all');
    // GENERAL ASSEMBLY INVOICES
    Route::resource('/general-assembly-invoices', 'GeneralAssemblyInvoiceController')->except(['create', 'store', 'show']);
    Route::delete('/general-assembly-invoices/destroy/all', 'GeneralAssemblyInvoiceController@multiDelete')->name('general-assembly-invoices.destroy_all');

    // DONORS
    Route::resource('/donors', 'DonorController')->except(['create', 'store', 'show']);
    Route::delete('/donors/destroy/all', 'DonorController@multiDelete')->name('donors.destroy_all');

    // GIFTS
    Route::resource('/gifts', 'GiftController')->except(['create', 'store', 'show']);
    Route::delete('/gifts/destroy/all', 'GiftController@multiDelete')->name('gifts.destroy_all');
    // GIFT CATEGORY
    Route::resource('/gift-categories', 'GiftCategoryController')->except(['show']);
    Route::delete('/gift-categories/destroy/all', 'GiftCategoryController@multiDelete')->name('gift-categories.destroy_all');
    Route::post('gift-categories/removeCard/{card_id}', 'GiftCategoryController@removeCard')->name('gift-categories.card.destroy');

    // SERVICES
    Route::resource('/service-sections', 'ServiceSectionController')->except(['show']);
    Route::delete('/service-sections/destroy/all', 'ServiceSectionController@multiDelete')->name('service-sections.destroy_all');
    Route::resource('/services', 'ServiceController');
    Route::delete('/services/destroy/all', 'ServiceController@multiDelete')->name('services.destroy_all');

    // MESSAGE MEMBERS
    Route::get('/message-members/individual-messaging', 'PageController@viewIndividualMessaging')->name('message-members.individual-messaging.index');
    Route::post('/message-members/individual-messaging', 'PageController@sendIndividualMessaging')->name('message-members.individual-messaging.send');

    // GET TO KNOW US
    Route::get('/get-to-know-us/brief', 'PageController@viewBrief')->name('get-to-know-us.brief.index');
    Route::patch('/get-to-know-us/brief/{key}', 'PageController@updateBrief')->name('get-to-know-us.brief.update');
    Route::resource('/founders', 'FounderController')->except(['index', 'show']);
    Route::get('/get-to-know-us/board-of-directors', 'PageController@viewDirectors')->name('get-to-know-us.board-of-directors.index');
    Route::patch('/get-to-know-us/board-of-directors/{key}', 'PageController@updateDirectors')->name('get-to-know-us.board-of-directors.update');
    Route::resource('/directors', 'DirectorController')->except(['index', 'show']);
    Route::get('/get-to-know-us/organizational-chart', 'PageController@viewOrganizationalChart')->name('get-to-know-us.organizational-chart.index');
    Route::patch('/get-to-know-us/organizational-chart/{key}', 'PageController@updateOrganizationalChart')->name('get-to-know-us.organizational-chart.update');
    Route::get('/get-to-know-us/statistics', 'PageController@viewStatistics')->name('get-to-know-us.statistics.index');
    Route::patch('/get-to-know-us/statistics/{key}', 'PageController@updateStatistics')->name('get-to-know-us.statistics.update');
    Route::get('/get-to-know-us/services-albir', 'PageController@viewServicesAlbir')->name('get-to-know-us.services-albir.index');
    Route::patch('/get-to-know-us/services-albir/{key}', 'PageController@updateServicesAlbir')->name('get-to-know-us.services-albir.update');
    // SEASONAL-PROJECTS
    Route::resource('/get-to-know-us/seasonal-projects', 'SeasonalProjectController')->except(['show']);
    Route::delete('/get-to-know-us/seasonal-projects/destroy/all', 'SeasonalProjectController@multiDelete')->name('seasonal-projects.destroy_all');

    // ALBIR FRIENDS
    Route::get('/albir-friends/general-assembly-members', 'PageController@viewGeneralAssemblyMembers')->name('albir-friends.general-assembly-members.index');
    Route::patch('/albir-friends/general-assembly-members/{key}', 'PageController@updateGeneralAssemblyMembers')->name('albir-friends.general-assembly-members.update');
    Route::get('/albir-friends/donor-membership', 'PageController@viewDonorMembership')->name('albir-friends.donor-membership.index');
    Route::patch('/albir-friends/donor-membership/{key}', 'PageController@updateDonorMembership')->name('albir-friends.donor-membership.update');
    Route::get('/albir-friends/volunteer-membership', 'PageController@viewVolunteerMembership')->name('albir-friends.volunteer-membership.index');
    Route::patch('/albir-friends/volunteer-membership/{key}', 'PageController@updateVolunteerMembership')->name('albir-friends.volunteer-membership.update');
    Route::get('/albir-friends/beneficiaries-membership', 'PageController@viewBeneficiariesMembership')->name('albir-friends.beneficiaries-membership.index');
    Route::patch('/albir-friends/beneficiaries-membership/{key}', 'PageController@updateBeneficiariesMembership')->name('albir-friends.beneficiaries-membership.update');

    // PHOTOS
    Route::resource('/photo-sections', 'PhotoSectionController')->except(['show']);
    Route::delete('/photo-sections/destroy/all', 'PhotoSectionController@multiDelete')->name('photo-sections.destroy_all');
    Route::resource('/photos', 'PhotoController')->except(['show']);
    Route::delete('/photos/destroy/all', 'PhotoController@multiDelete')->name('photos.destroy_all');

    // BLOGS
    Route::resource('/blog-sections', 'BlogSectionController')->except(['show']);
    Route::delete('/blog-sections/destroy/all', 'BlogSectionController@multiDelete')->name('blog-sections.destroy_all');
    Route::resource('/blogs', 'BlogController')->except(['show']);
    Route::delete('/blogs/destroy/all', 'BlogController@multiDelete')->name('blogs.destroy_all');

    // VIDEOS
    Route::resource('/video-sections', 'VideoSectionController')->except(['show']);
    Route::delete('/video-sections/destroy/all', 'VideoSectionController@multiDelete')->name('video-sections.destroy_all');
    Route::resource('/videos', 'VideoController')->except(['show']);
    Route::delete('/videos/destroy/all', 'VideoController@multiDelete')->name('videos.destroy_all');

    // SETTINGS
    Route::get('/settings', 'SettingController@index')->name('settings.index');
    Route::post('/settings/update', 'SettingController@update')->name('settings.update');
    Route::post('/settings/mail', 'SettingController@mailUpdate')->name('settings.mail_update');
    Route::post('/settings/template-mail', 'SettingController@templateMailUpdate')->name('settings.template_mail_update');
    Route::post('/settings/status', 'SettingController@status')->name('settings.status');
    Route::post('/settings/social-media', 'SettingController@socialMediaUpdate')->name('settings.social-media.update');
    Route::post('/settings/section-id-on-the-home-page/update', 'SettingController@sectionIdOnTheHomePage')->name('settings.section-id-on-the-home-page.update');
    Route::any('/settings/sms-setting/update', 'SettingController@smsSetting')->name('settings.sms_setting_update');
    Route::post('/settings/advanced-settings/update', 'SettingController@updateAdvancedSettings')->name('settings.updateAdvancedSettings');

    // lift-centers
    Route::resource('/lift-centers', 'LiftCenterController')->except(['show', 'edit', 'update']);
    Route::delete('/lift-centers/destroy/all', 'LiftCenterController@multiDelete')->name('lift-centers.destroy_all');

    // CONTACTS
    Route::resource('/contacts', 'ContactController')->except(['create', 'store', 'edit']);
    Route::delete('/contacts/destroy/all', 'ContactController@multiDelete')->name('contacts.destroy_all');

    // NEIGHBORHOODS
    Route::resource('/neighborhoods', 'NeighborhoodController')->except(['show']);
    Route::delete('/neighborhoods/destroy/all', 'NeighborhoodController@multiDelete')->name('neighborhoods.destroy_all');

    // EVENTS
    Route::resource('/events', 'EventController')->except(['show']);
    Route::delete('/events/destroy/all', 'EventController@multiDelete')->name('events.destroy_all');

    // PARTNERS
    Route::resource('/partners', 'PartnerController')->except(['show']);
    Route::delete('/partners/destroy/all', 'PartnerController@multiDelete')->name('partners.destroy_all');

    // BRANCHES
    Route::resource('/branches', 'BranchController')->except(['show']);
    Route::delete('/branches/destroy/all', 'BranchController@multiDelete')->name('branches.destroy_all');

    // ACCOUNTS
    Route::resource('/accounts', 'AccountController')->except(['show']);
    Route::delete('/accounts/destroy/all', 'AccountController@multiDelete')->name('accounts.destroy_all');

    // MODULES
    Route::resource('/module-sections', 'ModuleSectionController')->except(['show']);
    Route::delete('/modules-sections/destroy/all', 'ModuleSectionController@multiDelete')->name('module-sections.destroy_all');
    Route::resource('/modules', 'ModuleController')->except(['show']);
    Route::delete('/modules/destroy/all', 'ModuleController@multiDelete')->name('modules.destroy_all');

    // GOVERNANCE-MATERIAL
    Route::resource('/governance-material', 'GovernmentController')->except(['show']);
    Route::delete('/governance-material/destroy/all', 'GovernmentController@multiDelete')->name('governance-material.destroy_all');

    // SURVEYS
    Route::resource('/surveys', 'SurveyController')->except(['show']);
    Route::delete('/surveys/destroy/all', 'SurveyController@multiDelete')->name('surveys.destroy_all');

    // MARKETER
    Route::resource('/marketers', 'MarketerController');
    Route::delete('/marketers/destroy/all', 'MarketerController@multiDelete')->name('marketers.destroy_all');

    // EMPLOYMENT APPLICATION
    Route::resource('/employment-applications', 'EmploymentApplicationController')->only(['index', 'destroy']);
    Route::delete('/employment-applications/destroy/all', 'EmploymentApplicationController@multiDelete')->name('employment-applications.destroy_all');

    // NOTES
    Route::resource('/notes', 'NoteController')->except(['index', 'create', 'edit', 'show']);

    // ORDERS
    // Route::get('/orders', 'OrderController@index')->name('orders.index');

    // DONATIONS
    Route::resource('/paid-donations', 'PaidDonationController')->except(['show']);
    Route::delete('/paid-donations/destroy/all', 'PaidDonationController@multiDelete')->name('paid-donations.destroy_all');
    Route::get('/paid-donations/export', 'PaidDonationController@export')->name('paid-donations.export');

    Route::resource('/unpaid-donations', 'UnpaidDonationController')->except(['create', 'store', 'show']);
    Route::delete('/unpaid-donations/destroy/all', 'UnpaidDonationController@multiDelete')->name('unpaid-donations.destroy_all');
    Route::get('/unpaid-donations/export', 'UnpaidDonationController@export')->name('unpaid-donations.export');

    Route::resource('/verification-donations', 'VerificationDonationController')->except(['create', 'store', 'show']);
    Route::delete('/verification-donations/destroy/all', 'VerificationDonationController@multiDelete')->name('verification-donations.destroy_all');
    Route::get('/verification-donations/export', 'VerificationDonationController@export')->name('verification-donations.export');

    // Beneficiaries requests
    Route::resource('/beneficiaries-requests', 'BeneficiariesRequestController')->except(['show']);
    Route::delete('/beneficiaries-requests/destroy/all', 'BeneficiariesRequestController@multiDelete')->name('beneficiaries-requests.destroy_all');
    Route::patch('/beneficiaries-requests/{id}/update-status', 'BeneficiariesRequestController@updateStatus')->name('beneficiaries-requests.update-status');
    Route::get('/beneficiaries-requests/{id}/app-notifications/send', 'BeneficiariesRequestController@storeAppNotificationBeneficiary')->name('beneficiaries.app-notifications.send');

    // Reviews
    Route::resource('/reviews', 'ReviewController')->except(['show', 'create', 'store', 'edit', 'update']);
    Route::delete('/reviews/destroy/all', 'ReviewController@multiDelete')->name('reviews.destroy_all');

    // App notifications
    Route::get('/app-notifications', 'DashboardController@indexAppNotifications')->name('app-notifications.index');
    Route::post('/app-notifications', 'DashboardController@storeAppNotifications')->name('app-notifications.store');

    // ****** NOTIFICATIONS ********
    Route::any('user/notifications/get', 'NotificationsController@getNotifications');
    Route::any('user/notifications/read', 'NotificationsController@markAsRead');
    Route::any('user/notifications/read/{id}', 'NotificationsController@markAsReadAndRedirect');

    Route::get('/import-data', 'ImportDataController@importAllEvents');

    //Change Language
    Route::get('switch-language/{lang}', 'DashboardController@switchLang')->name('switchLang');

});

// OPEN FILE ROUTE ----
Route::get('lift-centers/{file_name}', 'Dashboard\LiftCenterController@openFile')->name('lift-centers.file');
// donation invoice
Route::get('/donation-invoice/{donation_code}/show', 'Dashboard\InvoiceController@showInvoice')->name('donation-invoice.show');
// general-assembly-member invoice
Route::get('/general-assembly-member-invoice/{invoice_no}/show/{uuid}', 'Dashboard\InvoiceController@showInvoiceGeneralAssemblyMember')->name('general-assembly-member-invoice.show');
// bulk edit for phone numbers
Route::any('/donors/bulk-edit', 'Dashboard\DonorController@bulkEdit');
