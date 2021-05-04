<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::get('/storage-link', function() {
    $output = [];
    \Artisan::call('storage:link', $output);
    dd('Done');
});
Route::get('/', 'Website\FrontendController@index');
Route::get('/', 'Website\FrontendController@index')->name('home');
Route::get('contact-us', 'Website\FrontendController@contactPage')->name('contact.us');
Route::get('lotto-prizes', 'Website\FrontendController@lottoPrizes')->name('lotto.prizes');
Route::post('change-lang', 'Website\FrontendController@changeLang')->name('change.lang');
Route::post('submit-contact-form', 'Website\FrontendController@submitContactForm')->name('submit.contact.form');
Route::get('user-register', 'Website\FrontendController@registrationForm')->name('user-register');
Route::post('save-register', 'Website\FrontendController@registerUser')->name('save-register');
Route::get('user-login', 'Website\FrontendController@loginForm')->name('user-login');
Route::post('check-login', 'Website\FrontendController@checkLogin')->name('check-login');
Route::post('check-login-subscription', 'Website\FrontendController@checkLoginSubscription')->name('check-login-subscription');
Route::get('job-list', 'Website\FrontendController@jobList')->name('job-list');
Route::post('get-states', 'Website\FrontendController@getStates')->name('get.states');
Route::post('get-cities', 'Website\FrontendController@getCities')->name('get.cities');
Route::get('job-details/{id}', 'Website\FrontendController@jobDetails')->name('job.details');
Route::get('subscription/checkout/{id}', 'Website\FrontendController@subscriptionCheckout')->name('subscription.checkout');
Route::get('public-profile/{id}', 'Website\FrontendController@publicProfile')->name('public.profile');


/*
|--------------------------------------------------------------------------
| Api Payment Routes Start
|--------------------------------------------------------------------------
*/
Route::get('api-job-checkout/{user_id}/{job_id}/{applicant_id}', 'Website\PaymentController@apiJobCheckout');
Route::post('api-capture-job-payment', 'Website\PaymentController@apiCaptureJobPayment')->name('api.capture.job.payment');

Route::get('api-capture-job-paypal-payment/{user_id}/{job_id}/{applicant_id}', 'Website\PaymentController@apiCaptureJobPaypalPayment')->name('api.make.job.paypal.payment');
Route::get('api-job-cancel-paypal-payment', 'Website\PaymentController@apiJobPaymentCancel')->name('api.job.cancel.paypal.payment');
Route::get('api-job-paypal-payment-success', 'Website\PaymentController@apiJobPaymentSuccess')->name('api.job.success.paypal.payment');

Route::group(['middleware' => ['auth']], function () {
    Route::get('task-worker-list', 'Website\FrontendController@taskWorkerList')->name('task-worker-list');
    Route::get('applied-jobs', 'Website\ServiceProviderController@appliedJobs')->name('applied.jobs');
    Route::get('active-jobs', 'Website\ServiceProviderController@activeJobs')->name('active.jobs');
    Route::get('delivered-jobs', 'Website\ServiceProviderController@deliveredJobs')->name('delivered.jobs');
    Route::get('completed-jobs', 'Website\ServiceProviderController@completedJobs')->name('completed.jobs');

    Route::get('posted-jobs', 'Website\CustomerDashboardController@postedJobs')->name('posted.jobs');
    Route::get('hired-jobs', 'Website\CustomerDashboardController@hiredJobs')->name('hired.jobs');
    Route::get('customer-delivered-jobs', 'Website\CustomerDashboardController@deliveredJobs')->name('customer.delivered.jobs');
    Route::get('customer-completed-jobs', 'Website\CustomerDashboardController@completedJobs')->name('customer.completed.jobs');

    Route::get('subscription/confirm/{id}', 'Website\FrontendController@subscriptionConfirm')->name('subscription.confirm');
    Route::get('dashboard', 'Website\FrontendController@dashboard')->name('dashboard');
    Route::get('user-logout', 'Website\FrontendController@userLogout')->name('user-logout');
    Route::get('my-profile', 'Website\FrontendController@myProfile')->name('my.profile');
    Route::get('edit-profile', 'Website\FrontendController@editprofileForm')->name('edit.profile');
    Route::post('update-profile', 'Website\FrontendController@updateProfile')->name('update.profile');
    Route::post('remove-doc', 'Website\FrontendController@removeDoc')->name('remove.doc');
    Route::get('post-job', 'Website\FrontendController@jobPostForm')->name('job-post');
    Route::post('save-job', 'Website\FrontendController@saveJob')->name('save-job');
    Route::post('apply-job', 'Website\FrontendController@applyJob')->name('apply-job');
    Route::get('job-applications/{id}', 'Website\CustomerDashboardController@jobApplications')->name('job.applications');
    Route::get('job-apply/checkout', 'Website\FrontendController@jobApplyCheckout')->name('job.apply.checkout');
    /*
    |--------------------------------------------------------------------------
    | Payment Routes Start
    |--------------------------------------------------------------------------
    */
    Route::get('job-checkout/{jobId}/{serviceProviderId}', 'Website\PaymentController@jobCheckout')->name('job.checkout');
    Route::post('capture-job-payment', 'Website\PaymentController@captureJobPayment')->name('capture.job.payment');
    Route::post('capture-subscription-payment', 'Website\PaymentController@captureSubscriptionPayment')->name('capture.subscription.payment');
    Route::post('capture-job-application-payment', 'Website\PaymentController@captureJobApplicationPayment')->name('capture.job.application.payment');

    Route::get('handle-job-application-paypal-payment', 'Website\PaymentController@handleJobApplicationPaypalPayment')->name('handle.job.application.paypal.payment');
    Route::get('cancel-job-application-paypal-payment', 'Website\PaymentController@paymentJobApplicationCancel')->name('cancel.job.application.paypal.payment');
    Route::get('paypal-job-application-payment-success', 'Website\PaymentController@paymentJobApplicationSuccess')->name('success.job.application.paypal.payment');
    Route::get('handle-paypal-payment/{jobId}/{serviceProviderId}', 'Website\PaymentController@handlePaypalPayment')->name('make.paypal.payment');
    Route::get('cancel-paypal-payment', 'Website\PaymentController@paymentCancel')->name('cancel.paypal.payment');
    Route::get('paypal-payment-success', 'Website\PaymentController@paymentSuccess')->name('success.paypal.payment');
    Route::get('handle-subs-paypal-payment/{planId}', 'Website\PaymentController@captureSubscriptionPaypalPayment')->name('make.subs.paypal.payment');
    Route::get('cancel-subs-paypal-payment', 'Website\PaymentController@paymentSubsCancel')->name('subscription.cancel.paypal.payment');
    Route::get('paypal-subs-payment-success', 'Website\PaymentController@paymentSubsSuccess')->name('subscription.success.paypal.payment');
    Route::get('paypal', array('as' => 'status','uses' => 'PaymentController@getPaymentStatus',));
    Route::get('download-job-delivery-file/{file}', 'Website\CustomerDashboardController@downloadDeliveryFile')->name('download.job.delivery.file');

    /*
    |--------------------------------------------------------------------------
    | Profile Promote Payment Routes
    |--------------------------------------------------------------------------
    */
    Route::get('promote-profile', 'Website\PaymentController@promoteProfileCheckout')->name('promote.profile');
    Route::post('capture-profile-promote-payment', 'Website\PaymentController@stripePaymentForProfilePromote')->name('capture.profile.promote.payment');
    Route::post('capture-profile-promote-paypal-payment', 'Website\PaymentController@paypalPaymentForProfilePromote')->name('capture.profile.promote.paypal.payment');
    Route::get('paypal-promote-payment-success', 'Website\PaymentController@paymentPromoteSuccess')->name('promote.success.paypal.payment');
    Route::get('cancel-promote-paypal-payment', 'Website\PaymentController@paymentPromoteCancel')->name('promote.cancel.paypal.payment');
    /*
    |--------------------------------------------------------------------------
    | Payment Routes End
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | Withdraw Routes
    |--------------------------------------------------------------------------
    */

    Route::get('withdraw', 'Website\WithdrawController@index')->name('withdraw');
    Route::post('update-withdraw-method', 'Website\WithdrawController@updateWithdrawMethod')->name('update.withdraw.method');
    Route::post('withdraw-request', 'Website\WithdrawController@withdrawRequest')->name('withdraw.request');

    Route::get('accept-application/{jobId}/{serviceProviderId}', 'Website\CustomerDashboardController@acceptApplication')->name('accept.job.application');
    Route::get('manage-job/{jobId}', 'Website\ServiceProviderController@manageJob')->name('manage.job');
    Route::post('mark-job-completed', 'Website\ServiceProviderController@markJobComleted')->name('mark.job.completed');
    Route::get('manage-my-job/{jobId}', 'Website\CustomerDashboardController@manageJob')->name('manage.my.job');
    Route::get('approve-job-delivery/{jobId}', 'Website\CustomerDashboardController@approveJobDelivery')->name('approve.job.delivery');
    Route::post('dispute-job-delivery', 'Website\CustomerDashboardController@disputeJobDelivery')->name('dispute.job.delivery');
    Route::post('save-job-feedback', 'Website\CustomerDashboardController@saveJobFeedback')->name('save.job.feedback');

    /*
    |--------------------------------------------------------------------------
    | Message Routes
    |--------------------------------------------------------------------------
    */
    Route::get('messages', 'Website\MessageController@index')->name('messages');
    Route::get('message/{id}', 'Website\MessageController@chat')->name('message');
    Route::get('get-current-time', 'Website\MessageController@getCurrentTime')->name('get.current.time');
    Route::post('chat-update-time', 'Website\MessageController@chatUpdateTime')->name('chat.update.time');
    Route::post('save-chat-file', 'Website\MessageController@saveChatFile')->name('save.chat.file');
    Route::get('download-message-file/{file}', 'Website\MessageController@downloadChatFile')->name('download.chat.file');
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::get('admin/login', 'Admin\AdminAuthController@loginForm')->name('admin-login');
Route::post('admin/checkLogin', 'Admin\AdminAuthController@checkLogin')->name('admin.check.login');

Route::group(['middleware' => ['admin']], function () {
    Route::get('admin-dashboard', 'Admin\DashboardController@index')->name('admin.dashboard');
    Route::get('admin-charge', 'Admin\DashboardController@editCharge')->name('edit.charge');
    Route::post('admin-update-charge', 'Admin\DashboardController@updateCharge')->name('update.charge');
    Route::post('admin-get-states', 'Website\FrontendController@adminGetStates')->name('admin.get.states');
    Route::post('admin-get-cities', 'Website\FrontendController@adminGetCities')->name('admin.get.cities');
    Route::get('admin-logout', 'Website\FrontendController@adminLogout')->name('admin-logout');
    /*
    |--------------------------------------------------------------------------
    | Country Routes
    |--------------------------------------------------------------------------
    */
    Route::get('admin-country', 'Admin\LocationController@country')->name('admin.country');
    Route::get('admin-add-country', 'Admin\LocationController@addCountry')->name('admin.add.country');
    Route::post('admin-save-country', 'Admin\LocationController@saveCountry')->name('admin.save.country');
    Route::get('admin-edit-country/{id}', 'Admin\LocationController@editCountryForm')->name('admin.edit.country');
    Route::post('admin-update-country', 'Admin\LocationController@updateCountry')->name('admin.update.country');
    Route::get('admin-delete-country/{id}', 'Admin\LocationController@deleteCountry')->name('admin.delete.country');

    /*
    |--------------------------------------------------------------------------
    | State Routes
    |--------------------------------------------------------------------------
    */
    Route::get('admin-states', 'Admin\LocationController@states')->name('admin.states');
    Route::get('admin-add-state', 'Admin\LocationController@addState')->name('admin.add.state');
    Route::post('admin-save-state', 'Admin\LocationController@saveState')->name('admin.save.state');
    Route::get('admin-edit-state/{id}', 'Admin\LocationController@editStateForm')->name('admin.edit.state');
    Route::post('admin-update-state', 'Admin\LocationController@updateState')->name('admin.update.state');
    Route::get('admin-delete-state/{id}', 'Admin\LocationController@deleteState')->name('admin.delete.state');

    /*
    |--------------------------------------------------------------------------
    | City Routes
    |--------------------------------------------------------------------------
    */
    Route::get('admin-cities', 'Admin\LocationController@cities')->name('admin.cities');
    Route::get('admin-add-city', 'Admin\LocationController@addCity')->name('admin.add.city');
    Route::post('admin-save-city', 'Admin\LocationController@saveCity')->name('admin.save.city');
    Route::get('admin-edit-city/{id}', 'Admin\LocationController@editCityForm')->name('admin.edit.city');
    Route::post('admin-update-city', 'Admin\LocationController@updateCity')->name('admin.update.city');
    Route::get('admin-delete-city/{id}', 'Admin\LocationController@deleteCity')->name('admin.delete.city');

    /*
    |--------------------------------------------------------------------------
    | Customer Routes
    |--------------------------------------------------------------------------
    */
    Route::get('admin-customers', 'Admin\CustomerController@customers')->name('admin.customers');
    Route::get('admin-edit-customer/{id}', 'Admin\CustomerController@editCustomerForm')->name('admin.edit.customer');
    Route::post('admin-update-customer', 'Admin\CustomerController@updateCustomer')->name('admin.update.customer');
    Route::get('admin-delete-customer/{id}', 'Admin\CustomerController@deleteCustomer')->name('admin.delete.customer');

    /*
    |--------------------------------------------------------------------------
    |  Admin Job Category Routes
    |--------------------------------------------------------------------------
    */
    Route::get('admin-job-categories', 'Admin\JobCategoryController@jobCategories')->name('admin.job.categories');
    Route::get('admin-add-job-category', 'Admin\JobCategoryController@addJobCategoryForm')->name('admin.add.job.category');
    Route::post('admin-save-job-category', 'Admin\JobCategoryController@saveJobCategory')->name('admin.save.job.category');
    Route::get('admin-edit-job.category/{id}', 'Admin\JobCategoryController@editJobCategoryForm')->name('admin.edit.job.category');
    Route::post('admin-update-job-category', 'Admin\JobCategoryController@updateJobCategory')->name('admin.update.job.category');
    Route::get('admin-delete-job-category/{id}', 'Admin\JobCategoryController@deleteJobCategory')->name('admin.delete.job.category');

    /*
    |--------------------------------------------------------------------------
    |  Admin Job Sub Category Routes
    |--------------------------------------------------------------------------
    */
    Route::get('admin-job-subcategories', 'Admin\JobSubCategoryController@categories')->name('admin.job.subcategories');
    Route::get('admin-add-job-subcategory', 'Admin\JobSubCategoryController@add')->name('admin.add.job.subcategory');
    Route::post('admin-save-job-subcategory', 'Admin\JobSubCategoryController@store')->name('admin.save.job.subcategory');
    Route::get('admin-edit-job.subcategory/{id}', 'Admin\JobSubCategoryController@edit')->name('admin.edit.job.subcategory');
    Route::post('admin-update-job-subcategory', 'Admin\JobSubCategoryController@update')->name('admin.update.job.subcategory');
    Route::get('admin-delete-job-subcategory/{id}', 'Admin\JobSubCategoryController@delete')->name('admin.delete.job.subcategory');

    /*
    |--------------------------------------------------------------------------
    | Customer Routes
    |--------------------------------------------------------------------------
    */
    Route::get('admin-contractors', 'Admin\ContractorController@index')->name('admin.contractors');
    Route::get('admin-edit-contractor/{id}', 'Admin\ContractorController@edit')->name('admin.edit.contractor');
    Route::get('admin-update-contractor-status/{id}/{status}', 'Admin\ContractorController@updateStatus')->name('admin.update.contractor.status');
    Route::post('admin-update-contractor', 'Admin\ContractorController@update')->name('admin.update.contractor');
    Route::get('admin-delete-contractor/{id}', 'Admin\ContractorController@delete')->name('admin.delete.contractor');

    /*
    |--------------------------------------------------------------------------
    |  Admin Job Routes
    |--------------------------------------------------------------------------
    */
    Route::get('admin-jobs', 'Admin\JobController@index')->name('admin.jobs');
    Route::get('admin-edit-job/{id}', 'Admin\JobController@edit')->name('admin.edit.job');
    Route::post('admin-update-job', 'Admin\JobController@update')->name('admin.update.job');
    Route::get('admin-delete-job/{id}', 'Admin\JobController@delete')->name('admin.delete.job');
    Route::get('admin-view-job/{id}', 'Admin\JobController@jobDetails')->name('admin.view.job');
    Route::get('admin-disputed-jobs', 'Admin\JobController@disputedJobs')->name('admin.disputed.jobs');
    Route::get('admin-disputed-jobs', 'Admin\JobController@disputedJobs')->name('admin.disputed.jobs');
    Route::get('admin-view-dispute-job/{id}', 'Admin\JobController@disputJobDetails')->name('admin.view.dispute.job');

    /*
    |--------------------------------------------------------------------------
    | Subscription Plan Routes
    |--------------------------------------------------------------------------
    */
    Route::get('admin-subscription-plans', 'Admin\SubscriptionPlanController@index')->name('admin.subscription.plans');
    Route::get('admin-add-subscription-plan', 'Admin\SubscriptionPlanController@add')->name('admin.subscription.plan.add');
    Route::post('admin-save-subscription-plan', 'Admin\SubscriptionPlanController@save')->name('admin.subscription.plan.save');
    Route::get('admin-edit-subscription-plan/{id}', 'Admin\SubscriptionPlanController@edit')->name('admin.subscription.plan.edit');
    Route::post('admin-update-subscription-plan', 'Admin\SubscriptionPlanController@update')->name('admin.subscription.plan.update');
    Route::get('admin-delete-subscription-plan/{id}', 'Admin\SubscriptionPlanController@delete')->name('admin.subscription.plan.delete');

    /*
    |--------------------------------------------------------------------------
    | Transactions Routes
    |--------------------------------------------------------------------------
    */
    Route::get('admin-transactions', 'Admin\TransactionController@index')->name('admin.transactions');

    /*
    |--------------------------------------------------------------------------
    | Contact Support Routes
    |--------------------------------------------------------------------------
    */
    Route::get('admin-supports', 'Admin\ContactSupportController@index')->name('admin.supports');
    Route::get('admin-support-reply/{id}', 'Admin\ContactSupportController@reply')->name('admin.support.reply');
    Route::post('admin-support-reply-store', 'Admin\ContactSupportController@replyStore')->name('admin.support.reply.store');
    Route::get('admin-support-delete/{id}', 'Admin\ContactSupportController@delete')->name('admin.support.delete');

    /*
    |--------------------------------------------------------------------------
    | Customer Service Person
    |--------------------------------------------------------------------------
    */
    Route::get('admin-cs-persons', 'Admin\CustomerServicePersonController@index')->name('admin.cs.persons');
    Route::get('admin-create-cs-person', 'Admin\CustomerServicePersonController@create')->name('admin.create.cs.person');
    Route::post('admin-store-cs-person', 'Admin\CustomerServicePersonController@store')->name('admin.store.cs.person');
    Route::get('admin-edit-cs-person/{id}', 'Admin\CustomerServicePersonController@edit')->name('admin.edit.cs.person');
    Route::post('admin-update-cs-person', 'Admin\CustomerServicePersonController@update')->name('admin.update.cs.person');
    Route::get('admin-delete-cs-person/{id}', 'Admin\CustomerServicePersonController@delete')->name('admin.delete.cs.person');

    /*
    |--------------------------------------------------------------------------
    | Banner
    |--------------------------------------------------------------------------
    */
    Route::get('admin-banners', 'Admin\SliderController@index')->name('admin.banners');
    Route::get('admin-create-banner', 'Admin\SliderController@create')->name('admin.create.banner');
    Route::post('admin-store-banner', 'Admin\SliderController@store')->name('admin.store.banner');
    Route::get('admin-edit-banner/{id}', 'Admin\SliderController@edit')->name('admin.edit.banner');
    Route::get('admin-delete-banner/{id}', 'Admin\SliderController@delete')->name('admin.delete.banner');
    Route::post('admin-update-banner', 'Admin\SliderController@update')->name('admin.update.banner');

    /*
    |--------------------------------------------------------------------------
    | Skills
    |--------------------------------------------------------------------------
    */
    Route::get('admin-skills', 'Admin\SkillController@index')->name('admin.skills');
    Route::get('admin-create-skill', 'Admin\SkillController@create')->name('admin.create.skill');
    Route::post('admin-store-skill', 'Admin\SkillController@store')->name('admin.store.skill');
    Route::get('admin-edit-skill/{id}', 'Admin\SkillController@edit')->name('admin.edit.skill');
    Route::get('admin-delete-skill/{id}', 'Admin\SkillController@delete')->name('admin.delete.skill');
    Route::post('admin-update-skill', 'Admin\SkillController@update')->name('admin.update.skill');
    /*
    |--------------------------------------------------------------------------
    | Lotto Users
    |--------------------------------------------------------------------------
    */
    Route::get('admin-lotto-users', 'Admin\ContractorController@lottoUsers')->name('admin.lotto.users');

    /*
    |--------------------------------------------------------------------------
    | Notification
    |--------------------------------------------------------------------------
    */
    Route::get('admin-create-notification', 'Admin\NotificationController@create')->name('admin.create.notification');
    Route::post('admin-store-notification', 'Admin\NotificationController@store')->name('admin.store.notification');

    /*
    |--------------------------------------------------------------------------
    | Lotto Prize
    |--------------------------------------------------------------------------
    */
    Route::get('admin-lotto-prizes', 'Admin\LottoPrizController@index')->name('admin.lotto.prizes');
    Route::get('admin-create-prize', 'Admin\LottoPrizController@create')->name('admin.create.prize');
    Route::post('admin-store-prize', 'Admin\LottoPrizController@store')->name('admin.store.prize');
    Route::get('admin-edit-prize/{id}', 'Admin\LottoPrizController@edit')->name('admin.edit.prize');
    Route::get('admin-delete-prize/{id}', 'Admin\LottoPrizController@delete')->name('admin.delete.prize');
    Route::post('admin-update-prize', 'Admin\LottoPrizController@update')->name('admin.update.prize');
});

