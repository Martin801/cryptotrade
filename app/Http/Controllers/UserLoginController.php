<?php
namespace App\Http\Controllers;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Hash;
class UserLoginController extends Controller
{
use AuthenticatesUsers;
protected $redirectTo = '/';
public function __construct()
{
	$this->middleware('guest', ['except' => 'logout']);
}
// USER AUTH VIEW
public function getUserLogin()
{
	return view('userLogin');
}
//USER AUTH
public function userAuth(Request $request)
{
	$this->validate($request, [
	'email' => 'required|email',
	'password' => 'required',
	]);
	if (auth('applicationuser')->attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'status' => 1])){
	$user = auth('applicationuser')->user();
	$user_details = $user->toarray();
	Session::put('user_name',$user_details['name']);
	Session::put('user_id',$user_details['id']);
	Session::put('email_id',$user_details['email']);
	Session::put('phone_no',$user_details['phone']);
	return redirect()->action('DashboardController@index');
	}else{
	session(['login_message' => 'Please give correct username & password.']);
	return redirect()->action('UserLoginController@getUserLogin');
	}
}
}
