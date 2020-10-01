<?php

if(version_compare(PHP_VERSION, '7.2.0', '>=')) {
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);
}

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
//     return view('index');
// });

Route::get('/', 'WebController@index')->name('index');
Route::get('/teachers', 'WebController@teachers')->name('teachers');
Route::get('/contact-us', 'WebController@contactus')->name('contactus');
Route::get('/teacher-information/{uuid}', 'WebController@teacherinfo')->name('teacherinfo');
Route::get('/lgas/{state}', 'WebController@lgas')->name('lgas');
// Route::get('/download', 'WebController@download');

Route::get('/my-notifications', 'HomeController@mynotifications');


Route::namespace('Account')->prefix('account')->as('account.')->group(function(){
    Route::get('login', 'HomeController@login')->name('login');
    Route::post('auth', 'HomeController@auth')->name('auth');

    Route::middleware('school_account')->group(function(){
        Route::get('dashboard', 'HomeController@dashboard')->name('dashboard');
        Route::post('logout', 'HomeController@logout')->name('logout');
        Route::post('download', 'HomeController@download')->name('download');
        Route::post('atg-callback', 'HomeController@atg_callback')->name('atg_callback');
        Route::get('/watch-video/{filename}', 'HomeController@watchVideoAttachment')->name('watch_video_attachment');
    });
});


Auth::routes(['verify' => true]);

Route::get('/send/email', 'HomeController@mail');

Route::get('/home', 'HomeController@index')->name('home');



Route::get('read_file/{file}', 'WebController@read_file')->name('read_file');
Route::post('/coupon-recharge', 'HomeController@couponRecharge')->name('couponRecharge');




    Route::get('/become-an-agent', 'AgentController@applyagent')->name('applyagent');
    Route::post('/send-agent-application', 'AgentController@submitAgentApplication')->name('submitAgentApplication');

    Route::group(['middleware'=> ['agent']],function(){
        Route::get('/agent-area', 'AgentController@agent_area')->name('agent_area');
    });

    Route::group(['middleware'=> ['parent']],function(){
        Route::get('/quick-tutors', 'HomeController@quicktutors')->name('quicktutors');
        Route::get('/home-schooling', 'HomeController@homeschooling')->name('homeschooling');
        Route::get('/get-tutors', 'HomeController@getTutors')->name('getTutors');
        Route::post('/request-teacher', 'HomeController@requestTeacher')->name('requestTeacher');
    });
    Route::get('/lesson-requests', 'HomeController@lessonrequests')->name('lessonrequests');

    Route::get('/get-notifications', 'HomeController@getnotify')->name('getnotify');
    // Route::get('/test', 'HomeController@test')->name('test');


    Route::post('/submit-teacher-application', 'TeacherController@submitTeacher')->name('submitTeacher');
    Route::get('/become-a-teacher', 'TeacherController@applyteacher')->name('applyteacher');
    Route::group(['middleware'=> ['teacher']],function(){
        Route::get('/my-information', 'TeacherController@myinfo')->name('myinfo');
    });

    Route::post('/update-profile', 'HomeController@updateProfile')->name('updateProfile');

    Route::get('/my-transactions', 'HomeController@transactions')->name('transactions');

    Route::post('/make-deposit', 'HomeController@deposit')->name('deposit');

    Route::post('/make-withdrawal', 'HomeController@withdraw')->name('withdraw');

    Route::post('/verify-bank', 'HomeController@verifybank')->name('verifybank');

    Route::post('/make-investment', 'HomeController@makeInvestment')->name('makeInvestment');

    Route::get('/available-books-and-videos', 'MediaController@available_books')->name('available_books');

    Route::get('/search-media', 'MediaController@search_media')->name('search_media');

    Route::post('/download-books-and-videos', 'MediaController@userDownloadAttachment')->name('user_download_attachment');

// });

    Route::post('/upload-receipt', 'HomeController@uploadreceipt')->name('uploadreceipt');

Route::post('/upload-avatar', 'HomeController@uploadAvatar')->name('uploadAvatar');
Route::post('/complete-profile', 'HomeController@completeProfile')->name('completeProfile');
Route::post('/add-bank-account', 'HomeController@createbank')->name('createbank');
Route::post('/transaction-comment/{id}', 'HomeController@tranComment')->name('tranComment');
Route::post('/transaction-response/{id}', 'HomeController@tranResponse')->name('tranResponse');

Route::get('/tre', 'HomeController@transReceipts')->name('transReceipts');

Route::group(['middleware'=> ['admin']],function(){
    Route::get('/admin', 'AdminController@index')->name('admin');

    Route::get('/admin/users', 'AdminController@users')->name('users');
    Route::post('/admin/users/update/{user}', 'AdminController@update_user')->name('update_user');

    Route::get('/admin/requests', 'AdminController@requests')->name('requests');
    Route::get('/admin/deposits', 'AdminController@deposits')->name('deposits');
    Route::get('/admin/withdrawals', 'AdminController@withdrawals')->name('withdrawals');

    Route::get('/admin/teacher-applications', 'TeacherController@teachersapply')->name('teacherapply');
    Route::get('/admin/user-info/{id}', 'AdminController@userinfo')->name('userinfo');
    Route::post('/admin/teacher-status/{id}', 'TeacherController@teacherstatus')->name('agentstatus');
    Route::post('/admin/reject-teacher/{id}', 'TeacherController@rejectteacher')->name('rejectteacher');

    Route::get('/admin/payment-receipts', 'AdminController@receipts')->name('receipts');
    Route::post('/receipt-deposit/{id}', 'AdminController@receiptdeposit')->name('receiptdeposit');
    Route::post('/manual-deposit', 'AdminController@manualdeposit')->name('manualdeposit');

    Route::resource('invests','InvestController');
    Route::get('investors','InvestController@investors')->name('investors');
    Route::get('investments/{user}','InvestController@investments')->name('investments');
    Route::post('store-investor','InvestController@store_investor')->name('store_investor');

    Route::resource('coupons','CouponController');

    Route::get('/agents', 'AgentController@index')->name('agents');
    Route::get('/agent-coupons/{id}', 'AgentController@agent_coupons')->name('agent_coupons');
    Route::get('/admin/agents-applications', 'AgentController@agentsapply')->name('agentsapply');

    Route::resource('/media', 'MediaController');
    Route::get('/watch-video/{filename}', 'MediaController@watchVideoAttachment')->name('watch_video_attachment');
    Route::post('/download-attachment', 'MediaController@downloadAttachment')->name('download_attachment');

    Route::post('/admin/agent-status/{id}', 'AgentController@agentstatus')->name('agentstatus');

    Route::namespace('Admin')->prefix('admin')->as('admin.')->group(function(){
        Route::resource('schools', 'SchoolController');
        Route::resource('schools/accounts', 'SchoolAccountController');
    });


});



Route::get('/m', function() {
    $output = [];
    \Artisan::call('migrate', $output);
    dd($output);
});




