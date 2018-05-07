<?php
Route::group(['middleware' => ['web']], function () {
Route::get('admin/login', array('as' => 'web', 'uses' => 'Admin\Auth\LoginController@showLoginForm'));
Route::get('admin/dashboard', array('as' => 'web', 'uses' => 'Admin\Auth\LoginController@showLoginForm'));
Route::post('admin/login', array('as' => 'web', 'uses' => 'Admin\Auth\LoginController@login'));
Route::post('admin/logout', array('as' => 'web', 'uses' => 'Admin\Auth\LoginController@logout'));
Route::get('admin/user', array('as' => 'web', 'uses' => 'Admin\UserController@index'));
Route::get('admin/user/add/{id}', array('as' => 'user', 'uses' => 'Admin\UserController@add'));
Route::post('admin/user/save', array('as' => 'user', 'uses' => 'Admin\UserController@save'));
Route::get('admin/user/delete/{id}', array('as' => 'user', 'uses' => 'Admin\UserController@delete'));
Route::get('admin/exchange', array('as' => 'exchange', 'uses' => 'Admin\ExchangeController@index'));
Route::post('admin/exchange/save', array('as' => 'exchange', 'uses' => 'Admin\ExchangeController@save'));
Route::get('admin/exchange/add/{id}', array('as' => 'exchange', 'uses' => 'Admin\ExchangeController@add'));
Route::get('admin/membership', array('as' => 'Membership', 'uses' => 'Admin\MembershipController@index'));
Route::post('admin/membership/save', array('as' => 'Membership', 'uses' => 'Admin\MembershipController@save'));
Route::get('admin/membership/add/{id}', array('as' => 'Membership', 'uses' => 'Admin\MembershipController@add'));
Route::get('admin/membership/delete/{id}', array('as' => 'Membership', 'uses' => 'Admin\MembershipController@delete'));
Route::get('admin/membershiplavel', array('as' => 'Membership', 'uses' => 'Admin\MembershipController@membershiplavel'));
Route::post('admin/membershiplavel/save', array('as' => 'Membership', 'uses' => 'Admin\MembershipController@membershiplavelsave'));
Route::get('admin/membershiplavel/add/{id}', array('as' => 'Membership', 'uses' => 'Admin\MembershipController@membershiplaveladd'));
Route::get('admin/membershiplavel/delete/{id}', array('as' => 'Membership', 'uses' => 'Admin\MembershipController@membershiplaveldel'));
Route::get('admin/profile', array('as' => 'exchange', 'uses' => 'Admin\UserController@adminProfile'));
Route::post('admin/user/adminUpdate', array('as' => 'exchange', 'uses' => 'Admin\UserController@adminUpdate'));

Route::get('admin/change-password', 'Admin\UserController@change_password');
Route::post('admin/update-password', 'Admin\UserController@update_password');
Route::get('admin/setting-view', 'Admin\UserController@setting_view');
Route::post('admin/setting', 'Admin\UserController@update_setting');

Route::get('/admin/dashboard', 'Admin\HomeController@index')->name('home');
});
Route::get('/login', array('as' => 'login', 'uses' => 'UserLoginController@getUserLogin'));
Route::post('/userAuth', 'UserLoginController@userAuth')->name('home');
Route::get('/membership-plan', 'RegisterController@membership_plan')->name('home');
Route::post('ajax/membership', array('as' => 'membership', 'uses' => 'AjaxController@membership'));
Route::post('ajax/membershiplavel', array('as' => 'membershiplavel', 'uses' => 'AjaxController@membershiplavel'));
Route::post('ajax/getselectedmembership', array('as' => 'getselectedmembership', 'uses' => 'AjaxController@getselectedmembership'));
Route::post('/register/save', array('as' => 'register', 'uses' => 'RegisterController@save'));
Route::get('/register/{id}', array('as' => 'register_user','uses' => 'RegisterController@index',));
Route::post('/register/type-of-payment', array(
	'as'   => 'type-of-payment',
	'uses' => 'RegisterController@which_type_of_payment',));
Route::get('/paywithpaypal', array('as' => 'addmoney.paywithpaypal','uses' => 'PaypalController@payWithPaypal',));
Route::get('/paypal', array('as' => 'addmoney.paypal','uses' => 'PaypalController@postPaymentWithpaypal',));
Route::get('/payment-status', array('as' => 'payment.status','uses' => 'PaypalController@getPaymentStatus',));
Route::group(['middleware' => ['applicationuser']], function () {
Route::get('/home', 'DashboardController@index')->name('home');
Route::get('/balance/{id}', 'DashboardController@balance')->name('balance');
Route::get('/balance-zero/{id}', 'DashboardController@balance_zero')->name('balance');
Route::get('/myplan', 'DashboardController@myplan')->name('myplan');
Route::get('/buytrade', 'DashboardController@buytrade')->name('buytrade');
Route::get('/profile', 'DashboardController@profile');
Route::post('/update-user', 'DashboardController@update_user');
Route::get('/change-password', 'DashboardController@change_password');
Route::post('/update-password', 'DashboardController@update_password');
Route::get('/bot', 'DashboardController@bot')->name('bot');
Route::post('/create-bot', 'DashboardController@createBot')->name('buytrade');
Route::post('/add-sell-bot', 'DashboardController@createBotSell');
Route::post('/update-bot', 'DashboardController@updateBot');
Route::get('/delete-bot/{id}', 'DashboardController@deleteBot');
Route::get('/buytradeaction/{id}/{requestid}', 'DashboardController@buytradeaction')->name('buytradeaction');
Route::get('/transuctionhistry/', 'DashboardController@transuctionhistry')->name('transuctionhistry');
Route::post('/home/validate-credentials', 'DashboardController@validate_credentials')->name('home');
Route::post('/get-currency-ajax', 'DashboardController@get_currency_ajax')->name('home');
Route::post('/get-market-ajax', 'DashboardController@get_market_ajax')->name('home');
Route::get('/logout', array('as' => 'web', 'uses' => 'Admin\Auth\LoginController@logout'));
Route::get('/lsl/{id}', 'DashboardController@lsl');
Route::post('/create-lsl', 'DashboardController@createLsl');
Route::post('/update-lsl', 'DashboardController@updateLsl');
Route::get('/delete-lsl/{id}/{bid}', 'DashboardController@deleteLsl');
});
Route::get('/', function () {
    return view('welcome');
});
Route::get('/britrex-trade', 'BotController@britex_bot')->name('bot');
