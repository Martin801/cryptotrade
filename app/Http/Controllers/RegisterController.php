<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Classes\CoinPaymentsAPI;
class RegisterController extends Controller{
  
  public function index($id)
  {
    $id_new = substr($id,2);
    if(!empty($id_new)){
    $bitcoin_membership = DB::table('membership')->select('*')->where('id' , $id_new)->where('status' , 1)->get();
    $bitcoin_membership_arr = $bitcoin_membership->toarray();
    if(!empty($bitcoin_membership_arr)){
    session(['registered_user_membership_id' => $id]);
    return view('register');
    }else{
    return redirect()->action('RegisterController@membership_plan');
    }
    }else{
    return redirect()->action('RegisterController@membership_plan');
    }
  }
  //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  public function membership_plan()
  {
    $bitcoin_membership = DB::table('membership')->select('*')->where('status' , 1)->groupBy('name')->get();
    $data['bitcoin_membership_arr'] = $bitcoin_membership->toarray();
    return view('membership_plan',$data);
  }
  //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
  public function save(Request $request)
  {

  $validator = Validator::make($request->all(),[
  'name'     => 'required',
  'email'    => 'required',
  'phone'    => 'required',
  'address'  => 'required',
  'password' => 'required',
  ]);

  if ($validator->fails()){
  return redirect()->route('register_user', ['id' => session('registered_user_membership_id')])->withErrors($validator)->withInput();
  }else{
  session(['name'     => $request->input('name')]);
  session(['email'    => $request->input('email')]);
  session(['password' => $request->input('password')]);
  session(['phone'    => $request->input('phone')]);
  session(['address'  => $request->input('address')]);
  return view('type_of_payment');
  }
  }
  public function which_type_of_payment(Request $request)
  {
  if($request->input('type_of_payment_id') == 1){
  session(['signup_message' => 'Please wait we are redirect to paypal for payment.']);
  return redirect()->route('register_user', ['id' => session('registered_user_membership_id')]);    
  }else{

  $key_one = '0f20c053b524826CcAf5788C740Ff2bbDfe1C59fF5d6B9A9e162f2bf5566Dea7';  
  $key_two = 'e600782c972cd45be989a025da879747a7bdc28c611d768e801bfd0b68e5dcdd';

  if(!empty(session('registered_user_membership_id'))){
  $id_new = substr(session('registered_user_membership_id'),2);
  $bitcoin_membership = DB::table('membership')
                        ->select('*')
                        ->where('id' , $id_new)
                        ->where('status' , 1)
                        ->get();
  $bitcoin_membership_arr = $bitcoin_membership->toarray();
  if(!empty($bitcoin_membership_arr)){
  $cps = new CoinPaymentsAPI();
  $cps->Setup($key_one,$key_two);
  $req = array(
    'amount' => $bitcoin_membership_arr[0]->price,
    'currency1' => 'USD',
    'currency2' => 'BTC',
    'address' => '', // leave blank send to follow your settings on the Coin Settings page
    'item_name' => 'PAYMENT-'.time(true),
    'ipn_url' => '',
  );
  
  $result = $cps->CreateTransaction($req);

  if ($result['error'] == 'ok') {
    
  $le = php_sapi_name() == 'cli' ? "\n" : '<br />';
  if(!empty(session('registered_user_membership_id'))){
  $id_new = substr(session('registered_user_membership_id'),2);
  $bitcoin_membership = DB::table('membership')
                          ->select('*')
                          ->where('id' , $id_new)
                          ->where('status' , 1)
                          ->get();
  $bitcoin_membership_arr = $bitcoin_membership->toarray();
  if(!empty($bitcoin_membership_arr)){
  $user_id = DB::table('applicationusers')->insertGetId([
    'name'     => session('name'), 
    'password' => bcrypt(session('password')), 
    'email'    => session('email'), 
    'phone'    => session('phone'), 
    'address'  => session('address'),
    'status'   => 0
  ]
  );
  if(!empty($user_id)){

  for ($i=1; $i <=4 ; $i++){
  DB::table('user_membership')->insertGetId([
    'user_id' => $user_id , 
    'membership_id' => $id_new, 
    'exchange_id' => $i
  ]);
  }

  DB::table('user_payment')->insertGetId([
  'user_id'            => $user_id,
  'membership_id'      => $id_new,
  'duration'           => $bitcoin_membership_arr[0]->duration,
  'price'              => $bitcoin_membership_arr[0]->price,
  'transaction_id'     => $result['result']['txn_id'].$le,
  'address_id'         => $result['result']['address'].$le,
  'status_url'         => $result['result']['status_url'].$le,
  'qrcode_url'         => $result['result']['qrcode_url'].$le,
  'transaction_status' => 'Pending' ,
  'exchange_data'      => json_encode($bitcoin_membership_arr) ,
  'payment_date'       => date('Y-m-d H:i:s'),
  ]);

  $data_return['result'] =  $result;
  $request->session()->forget('registered_user_membership_id');
  return view('type_of_payment',$data_return);

  }else{
  return Redirect::route('login');  
  }
  }else{
  return Redirect::route('login');
  }
  }else{
  return Redirect::route('login');
  }
  } else {
  return view('type_of_payment');
  }
  }else{
  return Redirect::route('login');  
  }
  }else{
  return Redirect::route('login');   
  }
  }
  }  
//END CLASS
}
