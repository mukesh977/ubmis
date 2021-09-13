<?php
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');



Route::get('/', 'Auth\LoginController@showLoginForm')->name('auth.login');
Auth::routes();

Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function(){
	Route::get('/dashboard', ['as' => 'admin.dashboard', 'uses' => 'Admin\DashboardController@index']);

	Route::get('/notifications', ['as' => 'admin.notifications', 'uses' => 'Admin\DashboardController@showNotifications']);
	
	Route::get('/notification/{id}', ['as' => 'admin.notification', 'uses' => 'Admin\DashboardController@showIndividualNotification']);

	Route::get('/purchase-notification/{id}', ['as' => 'admin.purchase.notifications', 'uses' => 'Admin\DashboardController@showIndividualPNotification']);

	Route::post('/request/change/{id}', ['as' => 'admin.change', 'uses' => 'Admin\DashboardController@requestChange']);
	
	Route::post('/request/purchasechange/{id}', ['as' => 'admin.purchase.change', 'uses' => 'Admin\DashboardController@requestPurchaseChange']);

	Route::get('/request/nochange/{id}', ['as' => 'admin.nochange', 'uses' => 'Admin\DashboardController@requestNoChange']);

	Route::get('/employee-detail/create', ['uses' => 'Employee\EmployeeController@create']);
	Route::post('/employee-detail/store', ['uses' => 'Employee\EmployeeController@store']);
	Route::get('/employee-detail/list', ['uses' => 'Employee\EmployeeController@show']);
	Route::get('/employee-detail/edit/{id}', ['uses' => 'Employee\EmployeeController@create']);
	Route::post('/employee-detail/delete', ['uses' => 'Employee\EmployeeController@destroy']);
	Route::get('/employee-detail/view/{id}', ['uses' => 'Employee\EmployeeController@showIndividualEmployee']);


	Route::get('/add-company', 'Company\CompanyController@create');
	Route::post('/store-company', 'Company\CompanyController@storeCompany');
	Route::get('/edit-company/{id}', 'Company\CompanyController@edit');
	Route::get('/list-company', 'Company\CompanyController@index');
	Route::post('/delete-company', 'Company\CompanyController@destroy');
	Route::get('/show-office', 'Company\CompanyController@ajaxShowCompany');
	Route::get('/list-company/search', 'Company\CompanyController@searchCompany');
	
	Route::get('/add-shop', 'Shop\ShopController@create');
	Route::post('/store-shop', 'Shop\ShopController@storeShop');
	Route::get('/list-shop', 'Shop\ShopController@index');
	Route::get('/edit-shop/{id}', 'Shop\ShopController@edit');
	Route::post('/store-edit-shop', 'Shop\ShopController@update');
	Route::post('/delete-shop', 'Shop\ShopController@destroy');
	Route::get('/show-shop', 'Shop\ShopController@show');
	Route::get('/list-shop/search', 'Shop\ShopController@searchShop');


	Route::get('/add-visit-category', 'VisitCategory\VisitCategoryController@create');
	Route::post('/store-visit-category', 'VisitCategory\VisitCategoryController@store');
	Route::get('/list-visit-category', 'VisitCategory\VisitCategoryController@index');
	Route::get('/edit-visit-category/{id}', 'VisitCategory\VisitCategoryController@edit');
	Route::post('/delete-visit-category', 'VisitCategory\VisitCategoryController@destroy');

	Route::get('/payment-method/create', 'PaymentMethod\PaymentMethodController@create');
	Route::post('/payment-method', 'PaymentMethod\PaymentMethodController@store');
	Route::get('/payment-method', 'PaymentMethod\PaymentMethodController@index');
	Route::get('/payment-method/{id}/edit', 'PaymentMethod\PaymentMethodController@edit');
	Route::put('/payment-method/{id}', 'PaymentMethod\PaymentMethodController@update');
	Route::delete('/payment-method', 'PaymentMethod\PaymentMethodController@destroy');

	Route::get('/seo-package/create', 'Package\SeoPackageController@create');
	Route::post('/seo-package', 'Package\SeoPackageController@store');
	Route::get('/seo-package', 'Package\SeoPackageController@index');
	Route::get('/seo-package/{id}/edit', 'Package\SeoPackageController@edit');
	Route::put('/seo-package/{id}', 'Package\SeoPackageController@update');

	Route::get('/amc-package/create', 'Package\AmcPackageController@create');
	Route::post('/amc-package', 'Package\AmcPackageController@store');
	Route::get('/amc-package', 'Package\AmcPackageController@index');
	Route::get('/amc-package/{id}/edit', 'Package\AmcPackageController@edit');
	Route::put('/amc-package/{id}', 'Package\AmcPackageController@update');

	Route::get('/referred/create', 'ProjectReferred\ProjectReferredController@create');
	Route::post('/referred', 'ProjectReferred\ProjectReferredController@store');
	Route::get('/referred', 'ProjectReferred\ProjectReferredController@index');
	Route::get('/referred/edit', 'ProjectReferred\ProjectReferredController@editOverall');
	Route::get('/referred/{id}/edit/{salesTransactionId}', 'ProjectReferred\ProjectReferredController@edit');
	Route::post('/referred/{id}/{mainId}', 'ProjectReferred\ProjectReferredController@update');

	Route::get('notification-calendar', 'Admin\DashboardController@notificationCalendar');
	Route::get('client-follow-up/create', 'Admin\ClientFollowUp@create');
	Route::post('client-follow-up', 'Admin\ClientFollowUp@store');
	Route::get('client-follow-up/{id}/edit', 'Admin\ClientFollowUp@edit');
	Route::patch('client-follow-up/{id}', 'Admin\ClientFollowUp@update');
	Route::get('client-follow-up', 'Admin\ClientFollowUp@index');


	// for tickets	
	Route::get('/ticket-dashboard', 'Ticket\DashboardController@dashboard');
	Route::resource('/status', 'Ticket\StatusController');
	Route::resource('/priorities', 'Ticket\PrioritiesController');
	Route::resource('/categories', 'Ticket\CategoriesController');
});

Route::group(['middleware' => ['web', 'auth']], function () {
	Route::get('/home', 'DashboardController@index')->name('home');
	Route::resource('user', 'User\UserController');
	Route::resource('office', 'Company\CompanyController')->only('store');
	Route::post('officesales', 'Company\CompanyController@storeOfficeSales');
	Route::post('/shop', 'Shop\ShopController@store');
	/*
	 *  Routes For Users Field Visits
	 */
	Route::get('field-visits', 'FieldVisit\FieldVisitController@getAllFieldVisits')->name('fieldVisits.all');
	Route::post('assigned-user-field-visits/{visit_id}', 'FieldVisit\FieldVisitController@assignedUserToFieldVisit')->name('fieldVisits.assigned');
	Route::get('follow-ups','FieldVisit\FieldVisitController@getAssignedFieldVisits')->name('get.assigned.field.visits');
	Route::get('positive-field-visits','FieldVisit\FieldVisitController@getAssignedPositiveFieldVisits')->name('get.assigned.positive.field.visits');
	Route::resource('daily-field-visits', 'FieldVisit\FieldVisitController');
	Route::get('weekly-field-visits', 'FieldVisit\UserFieldVisitController@weeklyFieldVisit')->name('weekly.field.visits');
	Route::get('monthly-field-visits', 'FieldVisit\UserFieldVisitController@monthlyFieldVisit')->name('monthly.field.visits');
	Route::get('quarterly-field-visits', 'FieldVisit\UserFieldVisitController@quarterlyFieldVisit')->name('quarterly.field.visits');
	Route::resource('next-field-visits', 'FieldVisit\NextFieldVisitController')->only('create', 'store');
	Route::get('calender', 'FieldVisit\FieldVisitController@getCalenderWorkloads');

	/*
	 *  Routes For Setting User  Daily, Weekly, Monthly, Quarterly,Targets
	 */
	Route::get('daily-users-targets', 'Targets\UserTargetController@dailyUserTargets')->name('daily.users.targets');
	Route::get('weekly-users-targets', 'Targets\UserTargetController@weeklyUserTargets')->name('weekly.users.targets');
	Route::get('quarterly-users-targets', 'Targets\UserTargetController@quarterlyUserTargets')->name('quarterly.users.targets');
	Route::get('monthly-users-targets', 'Targets\UserTargetController@monthlyUserTargets')->name('monthly.users.targets');
	Route::resource('users-targets', 'Targets\UserTargetController');

	/*
	 *  Routes For Setting User Sales Targets
	 */
	Route::get('daily-users-sales', 'Sales\UserSalesController@dailyUserSales')->name('daily.users.sales');
	Route::get('weekly-users-sales', 'Sales\UserSalesController@weeklyUserSales')->name('weekly.users.sales');
	Route::get('quarterly-users-sales', 'Sales\UserSalesController@quarterlyUserSales')->name('quarterly.users.sales');
	Route::get('monthly-users-sales', 'Sales\UserSalesController@monthlyUserSales')->name('monthly.users.sales');
	Route::resource('users-sales', 'Sales\UserSalesController');

	/*
	 *  Routes For User Sales Details
	 */
	Route::resource('sales-categories', 'Sales\SalesCategoryController');
	Route::resource('sales', 'Sales\SalesController')->except('show');

	/*
	 *  User Reports( Sales , Daily Visits )
	 */
	Route::get('users-sales-reports', 'Reports\ReportController@getUserSalesReports')->name('users.sales.reports');
	Route::get('users-visit-reports', 'Reports\ReportController@getUserVisitReports')->name('users.visit.reports');
});




Route::group(['middleware' => ['auth', 'role:admin|accountant']], function () {
    /*
	 *  Routes For Sales Transactions
	 */
    Route::get('add-sales', 'SalesTransaction\SalesTransactionController@create');
    Route::post('store-sales', 'SalesTransaction\SalesTransactionController@store');
    Route::get('list-sales', 'SalesTransaction\SalesTransactionController@show');
    Route::get('list-sales/search', 'SalesTransaction\SalesTransactionController@searchSales');
    Route::get('edit-sales/{id}', 'SalesTransaction\SalesTransactionController@create');
    Route::post('update-sales', 'SalesTransaction\SalesTransactionController@update');
    Route::post('delete-sales', 'SalesTransaction\SalesTransactionController@destroy');
    Route::get('show-sales', 'SalesTransaction\SalesTransactionController@ajaxShow');
    Route::get('show-company', 'SalesTransaction\SalesTransactionController@ajaxShowCompany');
    Route::get('show-company-with-field-contact', 'SalesTransaction\SalesTransactionController@companyWithFieldVisitContact');
    Route::get('pay-sales/{id}', 'SalesTransaction\SalesTransactionController@salesPay');
    Route::post('pay-processing', 'SalesTransaction\SalesTransactionController@payProcessing');
    Route::get('pay-sales/edit/{id}', 'SalesTransaction\SalesTransactionController@editPayForm');
    Route::post('pay-sales/edit', 'SalesTransaction\SalesTransactionController@editPay');

    Route::get('due-transactions', 'SalesTransaction\SalesTransactionController@getDueTransactions');
    Route::post('due-transactions/pay', 'SalesTransaction\SalesTransactionController@payDueTransaction');
    Route::get('due-transactions/search', 'SalesTransaction\SalesTransactionController@searchDueTransaction');
    Route::get('due-transactions/{id}', 'SalesTransaction\SalesTransactionController@getTransaction');

    Route::get('client-transactions', 'SalesTransaction\SalesTransactionController@getClientTransactions');
    Route::get('client-transaction/{id}', 'SalesTransaction\SalesTransactionController@getSpecificClientTransaction');
    Route::get('client-transactions/search', 'SalesTransaction\SalesTransactionController@searchClientTransaction');

    Route::get('seo-amc-information', 'SalesTransaction\SalesTransactionController@getSeoAmcInformation');
    Route::get('ac-notification/{id}', 'SalesTransaction\AccountantNotification@getSingleNotication');
    Route::get('commands', 'SalesTransaction\SalesTransactionController@commands');



	/*
	 *  Routes For Purchase Transactions
	 */
	Route::get('add-purchase', 'PurchaseTransaction\PurchaseTransactionController@create');
	Route::post('store-purchase', 'PurchaseTransaction\PurchaseTransactionController@store');
	Route::get('list-purchases', 'PurchaseTransaction\PurchaseTransactionController@show');
	Route::get('edit-purchase/{id}', 'PurchaseTransaction\PurchaseTransactionController@create');
	Route::post('delete-purchase', 'PurchaseTransaction\PurchaseTransactionController@destroy');
	Route::get('show-purchase', 'PurchaseTransaction\PurchaseTransactionController@ajaxShow');
	Route::get('show-shop', 'PurchaseTransaction\PurchaseTransactionController@ajaxShowShop');
	Route::get('pay-purchase/{id}', 'PurchaseTransaction\PurchaseTransactionController@purchasePay');
	Route::post('purchase-pay-processing', 'PurchaseTransaction\PurchaseTransactionController@purchasePayProcessing');
	Route::get('pay-purchase/edit/{id}', 'PurchaseTransaction\PurchaseTransactionController@editPayForm');
	Route::post('pay-purchase/edit', 'PurchaseTransaction\PurchaseTransactionController@editPay');


	//for creating pdf files
	Route::get('/invoice-companies', 'SalesTransaction\PdfController@getCompanies');
	Route::get('/invoice-pdf-export/{id}/get', 'SalesTransaction\PdfController@getInvoicePdf');
	Route::get('/invoices', 'SalesTransaction\PdfController@getInvoices');
	Route::get('/invoices/{id}', 'SalesTransaction\PdfController@getInvoice');
	Route::get('/invoice/download/{companyName}', 'SalesTransaction\PdfController@download');

	Route::get('notification-calendar', 'SalesTransaction\AccountantNotification@notificationCalendar');
	Route::get('client-follow-up/create', 'SalesTransaction\ClientFollowUp@create');
	Route::post('client-follow-up', 'SalesTransaction\ClientFollowUp@store');
	Route::get('client-follow-up/{id}/edit', 'SalesTransaction\ClientFollowUp@edit');
	Route::patch('client-follow-up/{id}', 'SalesTransaction\ClientFollowUp@update');
	Route::get('client-follow-up', 'SalesTransaction\ClientFollowUp@index');

	Route::get('due-tasks', 'SalesTransaction\TaskController@getDueTasks');
	Route::get('completed-tasks', 'SalesTransaction\TaskController@getCompletedTasks');
	Route::post('marked', 'SalesTransaction\TaskController@markTaskAsComplete');
	Route::post('unmarked', 'SalesTransaction\TaskController@unmarkTaskAsComplete');
});



Route::group(['prefix' => 'client', 'middleware' => ['auth', 'client']], function () {
	/*
	 *  Routes For Clients
	 */
	Route::get('/account-information', 'Client\ClientController@showAccountInformation');
	Route::get('/change-password-form', 'Client\ClientController@changePasswordForm');
	Route::post('/change-password', 'Client\ClientController@changePassword');
});




Route::group(['prefix' => 'supporter', 'middleware' => ['auth', 'supporter']], function () {
	Route::get('/project-information', 'Supporter\SupporterController@showProjectInformation');
	Route::get('/change-password-form', 'Supporter\SupporterController@changePasswordForm');
	Route::post('/change-password', 'Supporter\SupporterController@changePassword');
});


// ticket routes
Route::group(['prefix' => 'tickets', 'middleware' => ['auth', 'role:admin|agent|client']], function () {
	Route::get('/create', 'Ticket\TicketController@create')->middleware('client');
	Route::post('', 'Ticket\TicketController@store');
	Route::get('', 'Ticket\TicketController@getActiveTickets');
	Route::get('/complete', 'Ticket\TicketController@getCompletedTickets');
	Route::get('/{id}', 'Ticket\TicketController@show')->middleware('ticketUrlBound');
	Route::post('/comment', 'Ticket\CommentController@store');
	Route::get('/{id}/complete', 'Ticket\TicketController@complete');
	Route::get('/{id}/reopen', 'Ticket\TicketController@reopen');

	Route::patch('/{id}', 'Ticket\TicketController@update')->middleware('role:admin|agent');
	Route::post('/delete', 'Ticket\TicketController@destroy')->middleware('role:admin');

	Route::get('/search/active-ticket', 'Ticket\TicketController@searchActive');
	Route::get('/search/completed-ticket', 'Ticket\TicketController@searchCompleted');
});