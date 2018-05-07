<?php
namespace App\Http\Controllers;
use App\Http\Requests;
use Illuminate\Http\Request;
use Validator;
use URL;
use Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use Illuminate\Support\Facades\DB;
class PaypalController extends Controller{
private $_api_context;
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
public function __construct(){

  $paypal_conf = \Config::get('paypal');
  $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
  $this->_api_context->setConfig($paypal_conf['settings']);
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
public function postPaymentWithpaypal(){

    if(!empty(session('registered_user_membership_id')) && !empty(session('name')) && !empty(session('email'))  && !empty(session('phone')) && !empty(session('password'))){
    $id_new = substr(session('registered_user_membership_id'),2);
    $bitcoin_membership = DB::table('membership')
                            ->select('*')
                            ->where('id' , $id_new)
                            ->where('status' , 1)
                            ->get();
    $bitcoin_membership_arr = $bitcoin_membership->toarray();

    if(!empty($bitcoin_membership_arr)){

    $payer = new Payer();
    $payer->setPaymentMethod('paypal');
    $item_1 = new Item();
    $item_1->setName($bitcoin_membership_arr[0]->name)->setCurrency('USD')->setQuantity(1)->setPrice($bitcoin_membership_arr[0]->price);
    $item_list = new ItemList();
    $item_list->setItems(array($item_1));
    $amount = new Amount();
    $amount->setCurrency('USD')->setTotal($bitcoin_membership_arr[0]->price);
    $transaction = new Transaction();
    $transaction->setAmount($amount)->setItemList($item_list)->setDescription('Your transaction description');
    $redirect_urls = new RedirectUrls();
    $redirect_urls->setReturnUrl(URL::route('payment.status'))->setCancelUrl(URL::route('payment.status'));
    $payment = new Payment();
    $payment->setIntent('Sale')->setPayer($payer)->setRedirectUrls($redirect_urls)->setTransactions(array($transaction));

    try {
        $payment->create($this->_api_context);
    } catch (\PayPal\Exception\PPConnectionException $ex) {
      return redirect()->action('RegisterController@index');
    }

    foreach($payment->getLinks() as $link){
    if($link->getRel() == 'approval_url') {
    $redirect_url = $link->getHref();
    break;
    }
    }

    Session::put('paypal_payment_id', $payment->getId());

    if(isset($redirect_url)) {
        return redirect()->away($redirect_url);
    }

    \Session::put('error','Unknown error occurred');
    return Redirect::route('addmoney.paywithpaypal');
    }else{
    return redirect()->action('RegisterController@membership_plan');
    }
    }else{
    return redirect()->action('RegisterController@membership_plan');
    }
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

public function getPaymentStatus(){

  $payment_id = Session::get('paypal_payment_id');
  Session::forget('paypal_payment_id');
  if (empty(Input::get('PayerID')) || empty(Input::get('token'))){
  \Session::put('error','Payment failed');
  return redirect()->action('RegisterController@membership_plan');
  }
  $payment = Payment::get($payment_id, $this->_api_context);
  $execution = new PaymentExecution();
  $execution->setPayerId(Input::get('PayerID'));
  $result = $payment->execute($execution, $this->_api_context);
  if ($result->getState() == 'approved') {
  $id_new = substr(session('registered_user_membership_id'),2);
  $bitcoin_membership = DB::table('membership')
                          ->select('*')
                          ->where('id' , $id_new)
                          ->where('status' , 1)
                          ->get();
  $bitcoin_membership_arr = $bitcoin_membership->toarray();
  if(!empty($bitcoin_membership_arr)){
  $user_id = DB::table('applicationusers')->insertGetId(
  ['name' => session('name'), 'password' => bcrypt(session('password')), 'email' => session('email'), 'phone' => session('phone'), 'address' => session('address')]
  );
  if(!empty($user_id)){
  for ($i=1; $i <=4 ; $i++){
  DB::table('user_membership')->insertGetId(['user_id' => $user_id , 'membership_id' => $id_new, 'exchange_id' => $i]);
  }
  DB::table('user_payment')->insertGetId([
  'user_id'            => $user_id,
  'membership_id'      => $id_new,
  'duration'           => $bitcoin_membership_arr[0]->duration,
  'price'              => $bitcoin_membership_arr[0]->price,
  'transaction_id'     => $payment_id,
  'transaction_status' => $result->getState() ,
  'exchange_data'      => json_encode($bitcoin_membership_arr) ,
  'payment_date'       => date('Y-m-d H:i:s'),
  ]);
  \Session::put('success','Your payment has been successfully done. Please login and enjoy your trade!');
  return Redirect::route('login');
  }else{
  return Redirect::route('login');
  }
  }else{
  return Redirect::route('login');
  }
  
  }else{
  return Redirect::route('login');
  }
}
//END CLASS
}
