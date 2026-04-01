<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('backend.login');
// });

// Route::get('/greeting', function () {
//     return 'Hello World';
// });

Route::get('/', function () {
    if(Auth::check()){
        return redirect()->back();
    }
    else{
        return view('backend.login');
    }
});

Route::get('followersdata', 'App\Http\Controllers\AuthController@followersdata');

//Login
Route::post('login-check', 'App\Http\Controllers\AuthController@postLogin')->name("login.check");
Route::get('dashboard', 'App\Http\Controllers\AuthController@dashboard')->name("dashboard");
Route::get('logout', 'App\Http\Controllers\AuthController@logout')->name('logout');
Route::get('editAdminProfile', 'App\Http\Controllers\AuthController@editAdminProfile')->name("editAdminProfile");
Route::get('changePassword', 'App\Http\Controllers\AuthController@changePassword')->name('changePassword');
Route::post('updateAdminProfile', 'App\Http\Controllers\AuthController@updateAdminProfile')->name("updateAdminProfile");
Route::post('updatePassword', 'App\Http\Controllers\AuthController@updatePassword')->name("updatePassword");

//Customer
Route::get('customerListingView', 'App\Http\Controllers\CustomerAdminController@listingView')->name('customerListingView');
Route::get('export_customer', 'App\Http\Controllers\CustomerAdminController@export_customer')->name('export_customer');
Route::get('pdf_export_customer', 'App\Http\Controllers\CustomerAdminController@pdf_export_customer')->name('pdf_export_customer');
Route::get('customerListing', 'App\Http\Controllers\CustomerAdminController@listing')->name('customerListing');
Route::get('block/{id}', 'App\Http\Controllers\CustomerAdminController@block')->name('block');
Route::get('unblock/{id}', 'App\Http\Controllers\CustomerAdminController@unblock')->name('unblock');
Route::get('viewCustomerDetail/{id}', 'App\Http\Controllers\CustomerAdminController@viewCustomerDetail')->name('viewCustomerDetail');

//Service Provider
Route::get('providerListingView', 'App\Http\Controllers\ProviderController@listingView')->name('providerListingView');
Route::get('export_provider', 'App\Http\Controllers\ProviderController@export_provider')->name('export_provider');
Route::get('pdf_export_provider', 'App\Http\Controllers\ProviderController@pdf_export_provider')->name('pdf_export_provider');
Route::get('providerListing', 'App\Http\Controllers\ProviderController@listing')->name('providerListing');
Route::get('addProviderView', 'App\Http\Controllers\ProviderController@addProviderView')->name('addProviderView');
Route::post('saveProvider', 'App\Http\Controllers\ProviderController@saveProvider')->name('saveProvider');
Route::get('blockProvider/{id}', 'App\Http\Controllers\ProviderController@blockProvider')->name('blockProvider');
Route::get('unblockProvider/{id}', 'App\Http\Controllers\ProviderController@unblockProvider')->name('unblockProvider');
Route::get('viewProviderDetail/{id}', 'App\Http\Controllers\ProviderController@viewProviderDetail')->name('viewProviderDetail');

//School
Route::get('schoolListingView', 'App\Http\Controllers\SchoolController@listingView')->name('schoolListingView');
Route::get('schoolListing', 'App\Http\Controllers\SchoolController@listing')->name('schoolListing');
Route::get('addSchoolView', 'App\Http\Controllers\SchoolController@addSchoolView')->name('addSchoolView');
Route::post('saveSchool', 'App\Http\Controllers\SchoolController@saveSchool')->name('saveSchool');
Route::get('blockSchool/{id}', 'App\Http\Controllers\SchoolController@blockSchool')->name('blockSchool');
Route::get('unblockSchool/{id}', 'App\Http\Controllers\SchoolController@unblockSchool')->name('unblockSchool');
Route::get('viewSchoolDetail/{id}', 'App\Http\Controllers\SchoolController@viewSchoolDetail')->name('viewSchoolDetail');

//Scholarship Programs
Route::get('programListingView', 'App\Http\Controllers\ProgramController@listingView')->name('programListingView');
Route::get('programListing', 'App\Http\Controllers\ProgramController@listing')->name('programListing');
Route::get('addProgramView', 'App\Http\Controllers\ProgramController@addProgramView')->name('addProgramView');
Route::post('saveProgram', 'App\Http\Controllers\ProgramController@saveProgram')->name('saveProgram');
Route::get('blockProgram/{id}', 'App\Http\Controllers\ProgramController@blockProgram')->name('blockProgram');
Route::get('unblockProgram/{id}', 'App\Http\Controllers\ProgramController@unblockProgram')->name('unblockProgram');
Route::get('viewProgramDetail/{id}', 'App\Http\Controllers\ProgramController@viewProgramDetail')->name('viewProgramDetail');

//Job Management
Route::get('ongoingJobListingView', 'App\Http\Controllers\JobController@listingView')->name('ongoingJobListingView');
Route::get('ongoingJobListing', 'App\Http\Controllers\JobController@listing')->name('ongoingJobListing');
Route::get('upcomingJobListingView', 'App\Http\Controllers\JobController@upcomingJobListingView')->name('upcomingJobListingView');
Route::get('upcomingJobListing', 'App\Http\Controllers\JobController@upcomingJobListing')->name('upcomingJobListing');
Route::get('pastJobListingView', 'App\Http\Controllers\JobController@pastJobListingView')->name('pastJobListingView');
Route::get('pastJobListing', 'App\Http\Controllers\JobController@pastJobListing')->name('pastJobListing');
Route::get('bookingDetail/{id}', 'App\Http\Controllers\JobController@bookingDetail')->name('bookingDetail');

//Rating Review Management

Route::get('reviewRatingView', 'App\Http\Controllers\RatingController@listingView')->name('reviewRatingView');
Route::get('reviewListing', 'App\Http\Controllers\RatingController@listing')->name('reviewListing');


//notifications routes
Route::get('notifications', 'App\Http\Controllers\AuthController@notifications');
Route::get('dynamicnotifiy','App\Http\Controllers\AuthController@dynamicnotifiy');
Route::get('countnotifiy','App\Http\Controllers\AuthController@countnotifiy');

//Contact us Management

Route::get('contactUsView', 'App\Http\Controllers\ContactController@listingView')->name('contactUsView');
Route::get('contactUsListing', 'App\Http\Controllers\ContactController@listing')->name('contactUsListing');

//commission's routes
Route::get('admin/commission/all','App\Http\Controllers\CommisionController@getAllCommission');
Route::get('admin/commission/allData','App\Http\Controllers\CommisionController@getAllCommissionData');
Route::get('admin/commission/addCommission','App\Http\Controllers\CommisionController@getaddCommission');
Route::post('admin/commission/add','App\Http\Controllers\CommisionController@postAddCommission');
Route::get('admin/commission/del/{id}','App\Http\Controllers\CommisionController@DelCommission');
Route::get('admin/commission/editCommission/{id}','App\Http\Controllers\CommisionController@editCommission');
Route::post('admin/commission/postEdit/{id}','App\Http\Controllers\CommisionController@postEdit');

//account's routes

Route::get('admin/account/all','App\Http\Controllers\AuthController@gettotalearning');
Route::post('admin/account/get_mon_earn','App\Http\Controllers\AuthController@get_mon_earn');
Route::get('admin/account/allData','App\Http\Controllers\AuthController@allData');

Route::get('/paypal',function(){
    return view('myOrder');
});

// route for processing payment 
Route::post('/paypal', 'App\Http\Controllers\PaymentController@payWithpaypal')->name('paypal');

// route for check status of the payment 
Route::get('/status', 'App\Http\Controllers\PaymentController@getPaymentStatus')->name('status');




