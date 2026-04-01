<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//Customer API's
Route::post('customer/signInWithEmail', 'App\Http\Controllers\CustomerController@signInWithEmail');
Route::post('customer/signInWithPhone', 'App\Http\Controllers\CustomerController@signInWithPhone');
Route::post('customer/signUp', 'App\Http\Controllers\CustomerController@signUp');
Route::post('customer/socialLogin', 'App\Http\Controllers\CustomerController@socialLogin');
Route::post('customer/forgotPassword', 'App\Http\Controllers\CustomerController@forgotPassword');
Route::post('customer/resetPassword', 'App\Http\Controllers\CustomerController@resetPassword');
Route::post('customer/changePassword', 'App\Http\Controllers\CustomerController@changePassword');
Route::post('customer/addChild', 'App\Http\Controllers\CustomerController@addChild');
Route::post('customer/getHomeData', 'App\Http\Controllers\CustomerController@getHomeData');
Route::post('customer/makeProviderFav', 'App\Http\Controllers\CustomerController@makeProviderFav');
Route::post('customer/viewProviderDetails', 'App\Http\Controllers\CustomerController@viewProviderDetails');
Route::post('customer/giveReviewToProvider', 'App\Http\Controllers\CustomerController@giveReviewToProvider');
Route::post('customer/getFavouriteProviders', 'App\Http\Controllers\CustomerController@getFavouriteProviders');
Route::post('customer/bookProvider', 'App\Http\Controllers\CustomerController@bookProvider');
Route::post('customer/getbookamount', 'App\Http\Controllers\CustomerController@getbookamount');
Route::post('customer/editProfile', 'App\Http\Controllers\CustomerController@editProfile');
Route::post('customer/editChildProfile', 'App\Http\Controllers\CustomerController@editChildProfile');
Route::post('customer/getChildReport', 'App\Http\Controllers\CustomerController@getChildReport');
Route::post('customer/getChildMeals', 'App\Http\Controllers\CustomerController@getChildMeals');
Route::post('customer/getChildActivities', 'App\Http\Controllers\CustomerController@getChildActivities');
Route::post('customer/getChildPhotos', 'App\Http\Controllers\CustomerController@getChildPhotos');
Route::post('customer/getCustomerProfile', 'App\Http\Controllers\CustomerController@getCustomerProfile');
Route::post('customer/editCustomerProfile', 'App\Http\Controllers\CustomerController@editCustomerProfile');
Route::post('customer/addQuestion', 'App\Http\Controllers\CustomerController@addQuestion');
Route::post('customer/getQuestion', 'App\Http\Controllers\CustomerController@getQuestion');
Route::post('customer/feedback', 'App\Http\Controllers\CustomerController@feedback');
Route::post('customer/getAttendenceHistory', 'App\Http\Controllers\CustomerController@getAttendenceHistory');
Route::post('customer/getchat', 'App\Http\Controllers\CustomerController@getchat');
Route::post('customer/postchat', 'App\Http\Controllers\CustomerController@postchat');
Route::post('customer/getUserchat', 'App\Http\Controllers\CustomerController@getUserchat');
Route::post('customer/postContactUs', 'App\Http\Controllers\CustomerController@postContactUs');
Route::post('customer/uploaddoc', 'App\Http\Controllers\CustomerController@uploaddoc');
Route::post('customer/getdoc', 'App\Http\Controllers\CustomerController@getdoc');
Route::post('customer/deldoc', 'App\Http\Controllers\CustomerController@deldoc');
Route::post('customer/getAllContracts', 'App\Http\Controllers\CustomerController@getAllContracts');

//Provider API's
Route::post('provider/psignInWithEmail', 'App\Http\Controllers\ProviderAppController@psignInWithEmail');
Route::post('provider/psignUp', 'App\Http\Controllers\ProviderAppController@psignUp');
Route::post('provider/pforgotPassword', 'App\Http\Controllers\ProviderAppController@pforgotPassword');
Route::post('provider/presetPassword', 'App\Http\Controllers\ProviderAppController@presetPassword');
Route::post('provider/pchangePassword', 'App\Http\Controllers\ProviderAppController@pchangePassword');
Route::post('provider/pgetProfile', 'App\Http\Controllers\ProviderAppController@pgetProfile');
Route::post('provider/peditProfile', 'App\Http\Controllers\ProviderAppController@peditProfile');
Route::post('provider/getRequests', 'App\Http\Controllers\ProviderAppController@getRequests');
Route::post('provider/changeBookingStatus', 'App\Http\Controllers\ProviderAppController@changeBookingStatus');
Route::post('provider/getChildDetails', 'App\Http\Controllers\ProviderAppController@getChildDetails');
Route::post('provider/checkIn', 'App\Http\Controllers\ProviderAppController@checkIn');
Route::post('provider/checkOut', 'App\Http\Controllers\ProviderAppController@checkOut');
Route::post('provider/getAllChildren', 'App\Http\Controllers\ProviderAppController@getAllChildren');
Route::post('provider/getAllChildrenAttendance', 'App\Http\Controllers\ProviderAppController@getAllChildrenAttendance');
Route::post('provider/getAllContracts', 'App\Http\Controllers\ProviderAppController@getAllContracts');
Route::post('provider/getContractDetail', 'App\Http\Controllers\ProviderAppController@getContractDetail');
Route::post('provider/deleteChild', 'App\Http\Controllers\ProviderAppController@deleteChild');
Route::post('provider/postAnswer', 'App\Http\Controllers\ProviderAppController@postAnswer');
Route::post('provider/postParentBehaviour', 'App\Http\Controllers\ProviderAppController@postParentBehaviour');
Route::get('provider/getAllQuestion', 'App\Http\Controllers\ProviderAppController@getAllQuestion');

//Food API's

Route::post('provider/addFood', 'App\Http\Controllers\ProviderAppController@addFood');
Route::post('provider/getFoodDetails', 'App\Http\Controllers\ProviderAppController@getFoodDetails');

//Photos of Child Activities Photos

Route::post('provider/addPhotos', 'App\Http\Controllers\ProviderAppController@addPhotos');
Route::post('provider/getPhotos', 'App\Http\Controllers\ProviderAppController@getPhotos');

//Photos of Child Activities

Route::post('provider/addActivity', 'App\Http\Controllers\ProviderAppController@addActivity');
Route::post('provider/getActivities', 'App\Http\Controllers\ProviderAppController@getActivities');

//Child Reports
Route::post('provider/addReport', 'App\Http\Controllers\ProviderAppController@addReport');
Route::post('provider/getReportInProvider', 'App\Http\Controllers\ProviderAppController@getReportInProvider');

//Report Customer
Route::post('provider/report', 'App\Http\Controllers\ProviderAppController@reportCus');
Route::post('provider/reportcount', 'App\Http\Controllers\ProviderAppController@reportcount');


Route::get('provider/download', 'App\Http\Controllers\ProviderAppController@download');


// route for processing payment 
Route::post('/paypal', 'App\Http\Controllers\PaymentController@payWithpaypal')->name('paypal');
