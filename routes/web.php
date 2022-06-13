<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes(/*['register' => false]*/ ['verify' => true] );

Route::middleware(['auth', 'status'])->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('user/{id}/invoices', 'InvoiceController@user_invoices')->name('UserInvoices');

    Route::prefix('invoices')->group(function () {
        Route::get('trashed', 'InvoiceController@trashed')->name('invoices.trashed');
        Route::any('restore/{id}', 'InvoiceController@restore')->name('invoices.restore');
        Route::get('payment_status/{id}', 'InvoiceController@show')->name('showStatus');
        Route::post('update_payment_status/{id}', 'InvoiceController@update_status')->name('updateStatus');
        Route::get('details/{id}', 'InvoiceDetailsController@details')->name('Invoice_Details');
        Route::get('paid', 'InvoiceController@paid_invoices')->name('PaidInvoices');
        Route::get('unpaid', 'InvoiceController@unpaid_invoices')->name('unPaidInvoices');
        Route::get('partial_paid', 'InvoiceController@partial_paid_invoices')->name('PartialPaidInvoices');
        Route::get('print/{id}', 'InvoiceController@print_invoice')->name('PrintInvoice');
        Route::get('export', 'InvoiceController@export')->name('ExportInvoices');

        Route::get('invoice_reports',  'ReportController@index')->name('InvoicesReports');
        Route::post('search_invoices', 'ReportController@search_invoices')->name('SearchInvoices');

        Route::get('category_reports', 'ReportController@category_index')->name('CategoryReports');
        Route::post('search_category', 'ReportController@search_categories')->name('SearchCategories');

        Route::get('invoices_category', 'ReportController@all_index')->name('AllInvoices');
        Route::post('search_invoices_category', 'ReportController@search_all')->name('SearchAll');

        Route::get('profile/{id}', 'ProfileController@index')->name('UserProfile');
        Route::get('profile/edit/{id}', 'ProfileController@edit')->name('EditProfile');
        Route::post('profile/update/{id}', 'ProfileController@update')->name('UpdateProfile');
    });
    Route::resource('invoices', 'InvoiceController');

    Route::resource('categories', 'CategoryController');

    Route::resource('invoice_attachments', 'InvoiceAttachmentController');

    Route::get('products/trashed',      'ProductController@trashed')->name('products.trashed');
    Route::any('products/restore/{id}', 'ProductController@restore')->name('products.restore');
    Route::resource('products',         'ProductController');

    // Ajax Route to get data of products when selecting a category
    Route::get('category/{id}', 'InvoiceController@getproducts')->name('getproducts');
    // File Operations View File
    Route::get('view_file/{invoice_number}/{file_name}', 'InvoiceDetailsController@open_file')->name('open_file');
    // Download File
    Route::get('download/{invoice_number}/{file_name}', 'InvoiceDetailsController@download')->name('Download');
    // Delete File
    Route::post('delete_file', 'InvoiceDetailsController@destroy')->name('Delete_File');

    // Start Spatie Users & Roles Permission
    Route::resource('roles', 'RoleController');
    Route::resource('users', 'UserController');
    Route::get('markAsRead', function(){
        auth()->user()->unreadNotifications->markAsRead();
        return redirect()->back();
    })->name('mark');
    Route::get('invoice/all-notifications', function ()
    {
        return view('Invoices.allNotifications');
    })->name('allNotifications');
    Route::get('/{page}', 'AdminController@index');
});

