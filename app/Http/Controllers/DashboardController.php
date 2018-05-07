<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('applicationuser');
    }
    public function index(){
        $usersPlanDetails = DB::table('user_payment')->where('user_id', session('user_id'))->get();
        $get_exchange = DB::table('exchange')->where('status', 1)->get();
        $data['get_data_memership'] = $this->membership_full_data();
        $data['bot'] = $this->get_all_bot();
        $data['exc'] = $get_exchange;
        session(['membership_id_session' => $usersPlanDetails[0]->membership_id]);
        return view('home',$data);
    }
    public function change_password(){
    return view('change-password');     
    }
    public function update_password(Request $request){

    $validator = Validator::make($request->all(), [
        'old_password'   => 'required',
        'new_password'   => 'required|max:10',
    ]);

    $get_user_details =  DB::table('applicationusers')->where('id', session('user_id'))->get()->toarray();
    
    if(Hash::check($request->input('old_password'), $get_user_details[0]->password)){ 
    DB::table('applicationusers')->where('id', session('user_id'))->update([
        'password' => Hash::make($request->input('new_password'))
    ]);
    session(['success_message' => 'Data updated successfully.']);
    }   

    return redirect()->back();    
    }
    public function profile(){

       $data['profile_dtaa'] = DB::table('applicationusers')->where('id', session('user_id'))->get()->toarray();  
        return view('profile',$data);  
    }
    public function update_user(Request $request){

    $validator = Validator::make($request->all(), [
    'name' => 'required',
    'email' => 'required',
    'phone' => 'required',
    'address' => 'required'
    ]);   

    $name     = $request->input('name');
    $email    = $request->input('email');  
    $phone_no = $request->input('phone');  
    $address  = $request->input('address');  

    if(!empty($name) and !empty($email) and !empty($phone_no) and !empty($address))
    {
    if ($request->hasFile('input_img')) {

        $image    = $request->file('input_img');
        $pic_name = time().'.'.$image->getClientOriginalExtension();
        $destinationPath = public_path('/img');
        $image->move($destinationPath, $pic_name);

        DB::table('applicationusers')->where('id', session('user_id'))->update([
            'name'    => $name,
            'email'   => $email,
            'phone'   => $phone_no,
            'address' => $address,
            'profile_img' => $pic_name
        ]);

    }else{

        DB::table('applicationusers')->where('id', session('user_id'))->update([
            'name'    => $name,
            'email'   => $email,
            'phone'   => $phone_no,
            'address' => $address,
        ]); 
    }
    session(['success_message' => 'Data updated successfully.']);  
    }
    return redirect()->back();
    }
    public function bot()
    {
        $get_exchange = DB::table('exchange')->where('status', 1)->get();

        $data['bot'] = $this->get_all_bot();
        $data['exc'] = $get_exchange;
        return view('bot',$data);
    }
    public function membership_full_data()
    {
    $bitcoin_membership = DB::table('user_membership')
                                ->join('membership', 'membership.id', '=', 'user_membership.membership_id')
                                ->join('exchange', 'exchange.id', '=', 'user_membership.exchange_id')
                                ->select('membership.id as mem_id','membership.name','user_membership.user_id','user_membership.id as user_membership_id','user_membership.api_key','user_membership.api_secret','user_membership.exchange_id', 'exchange.name as exchange_name')
                                ->where('user_membership.user_id' , session('user_id'))
                                ->get();
    return  $bitcoin_membership->toarray();
    }
    public function get_all_bot()
    {
         $userId = session('user_id');
         return $usersPlanDetails = DB::table('bots')->where('user_id', $userId)->orderBy('id', 'desc')->paginate(10);
    }
    public function get_britrex_currency()
    {
        $url = 'https://bittrex.com/api/v1.1/public/getcurrencies';
        return $this->dynamic_curl($url);
    }
    public function dynamic_curl($url = '')
    {
        if(!empty($url)){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; Cryptopia.co.nz API PHP client; FreeBSD; PHP/'.phpversion().')');
        curl_setopt($ch, CURLOPT_URL, $url );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE);
        $res = curl_exec($ch);
        return $result = json_decode($res, true);
        }else{
        return FALSE;
        }
    }
    public function britrex_balance($url,$apisecret)
    {
        if(!empty($url)){

        $sign = hash_hmac('sha512',$url,$apisecret);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; Cryptopia.co.nz API PHP client; FreeBSD; PHP/'.phpversion().')');
        curl_setopt($ch, CURLOPT_URL, $url );
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('apisign:'.$sign));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE);
        $res = curl_exec($ch);
        $result = json_decode($res, true);
        return $result['result'];
        }else{
        return FALSE;
        }
    }
    public function binance_blance($apikey,$apisecret)
    {
        if(!empty($apikey) && !empty($apisecret)){

        $url="https://www.binance.com/api/v3/account";
        $headers[] = "User-Agent: Mozilla/4.0 (compatible; PHP Binance API)\r\nX-MBX-APIKEY: ".$apikey."\r\n";
        $params['timestamp'] = number_format(microtime(true) * 1000, 0, '.', '');
        $query = http_build_query($params, '', '&');
        $signature = hash_hmac('sha256', $query, $apisecret);
        $endpoint=$url.'?'.$query.'&signature='.$signature;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_ENCODING, "");
        $content = curl_exec($ch);
        curl_close($ch);
        $data_array = json_decode($content,true);
        if(!empty($data_array['balances']))
        return $data_array['balances'];
        else
        return FALSE;
        }else{
        return FALSE;
        }
    }
    public function cryptopia_blance($apikey,$apisecret)
    {
        if(!empty($apikey) && !empty($apisecret)){

        $nonce = time();

        $req = array('Currency'=> '') ;
        $url = "https://www.cryptopia.co.nz/Api/GetBalance/";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; Cryptopia.co.nz API PHP client; FreeBSD; PHP/'.phpversion().')');
        $post_data = json_encode( $req );
        $md5_encript = md5( $post_data, true );
        $signature = $apikey . "POST" . strtolower( urlencode( $url ) ) . $nonce . base64_encode( $md5_encript );
        $hmacsignature = base64_encode( hash_hmac("sha256", $signature, base64_decode( $apisecret ), true ) );
        $header_value = "amx " . $apikey . ":" . $hmacsignature . ":" . $nonce;
        $headers = array("Content-Type: application/json; charset=utf-8", "Authorization: $header_value");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url );
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $req ) );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE); // Do Not Cache
        $output = curl_exec($ch);
        curl_close($ch);
        $data_array = json_decode($output,true);
        return $data_array['Data'];
        }else{
        return FALSE;
        }
    }
    public function yobit_blance($apikey,$apisecret)
    {
        if(!empty($apikey) && !empty($apisecret)){

        $nonce = time();

        $req['method'] = 'getInfo';
        $req['nonce']  = $nonce;

        $post_data = http_build_query($req, '', '&');
        $sign      = hash_hmac("sha512", $post_data, $apisecret);
        $headers   = array('Sign: '.$sign,'Key: '.$apikey);

        $ch = null;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; SMART_API PHP client; '.php_uname('s').'; PHP/'.phpversion().')');
        curl_setopt($ch, CURLOPT_URL, 'https://yobit.net/tapi/');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_ENCODING , 'gzip');
        $output = curl_exec($ch);
        curl_close($ch);
        $data_array = json_decode($output,true);
        if(!empty($data_array['return']['funds'])){
        return $data_array['return']['funds'];
        }else{
        return $data = array();
        }
        }else{
        return FALSE;
        }
    }
    public function getBTCBalance($data,$exchange_type)
    {
        $get_result = 0;

        if( ($exchange_type == 1) and !empty($data) )
        {
          foreach ($data as $key => $value) {
              $get_result += $value['Available'];
          }
        }
        if($exchange_type == 2 and !empty($data))
        {
          foreach ($data as $key => $value) {
              $get_result += $value['free'];
          }
        }
        if($exchange_type == 3 and !empty($data))
        {
          foreach ($data as $key => $value) {
              $get_result += $value;
          }
        }
        if($exchange_type == 4 and !empty($data))
        {
          foreach ($data as $key => $value) {
              $get_result += $value['Available'];
          }
        }

        return $get_result;
    }
    public function balance($id='')
    {
        $bitcoin_membership_arr = $this->membership_full_data();
        foreach ($bitcoin_membership_arr as $key => $value) {

        if(($value->exchange_id == 1) and ($id == 1))
        {
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $apikey     = $value->api_key;
        $apisecret  = $value->api_secret;
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $get_balance = $this->cryptopia_blance($apikey,$apisecret);
        $data['get_bal'] = $get_balance;
        $data['exchange_id'] = $id;
        $data['exchange_name'] = $value->exchange_name;
        $data['BTC_balance'] = $this->getBTCBalance($get_balance,1);
        return view('view_balance',$data);
        }

        if(($value->exchange_id == 2) and ($id == 2))
        {
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $apikey     = $value->api_key;
        $apisecret  = $value->api_secret;
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $get_balance = $this->binance_blance($apikey,$apisecret);
        $data['get_bal'] = $get_balance;
        $data['exchange_id'] = $id;
        $data['exchange_name'] = $value->exchange_name;
        $data['BTC_balance'] = $this->getBTCBalance($get_balance,2);
        return view('view_balance',$data);
        }

        if(($value->exchange_id == 3) and ($id == 3))
        {
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $apikey     = $value->api_key;
        $apisecret  = $value->api_secret;
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $get_balance = $this->yobit_blance($apikey,$apisecret);
        $data['get_bal'] = $get_balance;
        $data['exchange_id'] = $id;
        $data['exchange_name'] = $value->exchange_name;
        $data['BTC_balance'] = $this->getBTCBalance($get_balance,3);
        return view('view_balance',$data);
        }

        if(($value->exchange_id == 4) and ($id == 4))
        {
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $apikey     = $value->api_key;
        $apisecret  = $value->api_secret;
        $nonce      = time();
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $url='https://bittrex.com/api/v1.1/account/getbalances?apikey='.$apikey.'&nonce='.$nonce;
        $get_balance = $this->britrex_balance($url,$apisecret);
        $data['get_bal'] = $get_balance;
        $data['exchange_id'] = $id;
        $data['exchange_name'] = $value->exchange_name;
        $data['BTC_balance'] = $this->getBTCBalance($get_balance,4);
        return view('view_balance',$data);
        }

        //End each
        }
    }
    public function balance_zero($id='')
    {
        $bitcoin_membership_arr = $this->membership_full_data();
        foreach ($bitcoin_membership_arr as $key => $value) {

        if(($value->exchange_id == 1) and ($id == 1))
        {
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $apikey     = $value->api_key;
        $apisecret  = $value->api_secret;
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $get_balance = $this->cryptopia_blance($apikey,$apisecret);
        $data['get_bal'] = $get_balance;
        $data['exchange_id'] = $id;
        $data['exchange_name'] = $value->exchange_name;
        $data['BTC_balance'] = $this->getBTCBalance($get_balance,1);
        return view('view_balance_zero',$data);
        }

        if(($value->exchange_id == 2) and ($id == 2))
        {
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $apikey     = $value->api_key;
        $apisecret  = $value->api_secret;
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $get_balance = $this->binance_blance($apikey,$apisecret);
        $data['get_bal'] = $get_balance;
        $data['exchange_id'] = $id;
        $data['exchange_name'] = $value->exchange_name;
        $data['BTC_balance'] = $this->getBTCBalance($get_balance,2);
        return view('view_balance_zero',$data);
        }

        if(($value->exchange_id == 3) and ($id == 3))
        {
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $apikey     = $value->api_key;
        $apisecret  = $value->api_secret;
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $get_balance = $this->yobit_blance($apikey,$apisecret);
        $data['get_bal'] = $get_balance;
        $data['exchange_id'] = $id;
        $data['exchange_name'] = $value->exchange_name;
        $data['BTC_balance'] = $this->getBTCBalance($get_balance,3);
        return view('view_balance_zero',$data);
        }

        if(($value->exchange_id == 4) and ($id == 4))
        {
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $apikey     = $value->api_key;
        $apisecret  = $value->api_secret;
        $nonce      = time();
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $url='https://bittrex.com/api/v1.1/account/getbalances?apikey='.$apikey.'&nonce='.$nonce;
        $get_balance = $this->britrex_balance($url,$apisecret);
        $data['get_bal'] = $get_balance;
        $data['exchange_id'] = $id;
        $data['exchange_name'] = $value->exchange_name;
        $data['BTC_balance'] = $this->getBTCBalance($get_balance,4);
        return view('view_balance_zero',$data);
        }

        //End each
        }
    }
    public function buytrade(Request $request)
    {
        $data['bitcoin_membership_arr'] = $this->membership_full_data();
        return view('buy_trade',$data);
    }
    public function myplan(Request $request)
    {
         $userId = session('user_id');
         $usersPlanDetails = DB::table('user_payment')->where('user_id', $userId)->get();
         $data['userdetails']= $usersPlanDetails;
         return view('myplan')->with($data);
    }
    public function transuctionhistry(Request $request)
    {
       $userId = session('user_id');
       $usersPlanDetails = DB::table('robot_tradess')->where('user_id', $userId)->orderBy('robot_id', 'desc')->paginate(10);
       $data['user_history']= $usersPlanDetails;
       return view('transuctionhistry',$data);
    }
    public function validate_credentials(Request $request)
    {
        $id            =      $request->input('id');
        $apikey        =      $request->input('api_key');
        $apisecret     =      $request->input('api_secret');
        $e_id          =      $request->input('e_id');

        if(!empty($apikey) && !empty($apisecret) && !empty($e_id) && ($e_id == 4))
        {

            $apikey     = $apikey;
            $apisecret  = $apisecret;
            $nonce      = time();

            $ch   = curl_init();
            $url  ='https://bittrex.com/api/v1.1/account/getbalances?apikey='.$apikey.'&nonce='.$nonce;
            $sign = hash_hmac('sha512',$url,$apisecret);
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_USERAGENT, "MozillaXYZ/1.0");
            curl_setopt($ch, CURLOPT_HEADER, 0);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('apisign:'.$sign));
            $output = curl_exec($ch);
            curl_close($ch);
            $obj = json_decode($output);

            if($obj->success == 1)
            {
                 DB::table('user_membership')->where('id', $id)->update(['api_key' => $apikey, 'api_secret' => $apisecret]);
            }
            echo $output;
        }

        if(!empty($apikey) && !empty($apisecret) && !empty($e_id) && ($e_id == 3))
        {

            $apikey     = $apikey;
            $apisecret  = $apisecret;
            $nonce      = time();

            $req['method'] = 'getInfo';
            $req['nonce']  = $nonce;

            $post_data = http_build_query($req, '', '&');
            $sign      = hash_hmac("sha512", $post_data, $apisecret);
            $headers   = array('Sign: '.$sign,'Key: '.$apikey);

            $ch = null;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; SMART_API PHP client; '.php_uname('s').'; PHP/'.phpversion().')');
            curl_setopt($ch, CURLOPT_URL, 'https://yobit.net/tapi/');
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_ENCODING , 'gzip');
            $output = curl_exec($ch);
            curl_close($ch);
            $obj = json_decode($output);

            if($obj->success == 1)
            {
                DB::table('user_membership')->where('id', $id)->update(['api_key' => $apikey, 'api_secret' => $apisecret]);
            }
            echo $output;
        }

        if(!empty($apikey) && !empty($apisecret) && !empty($e_id) && ($e_id == 2))
        {

            $apikey     = $apikey;
            $apisecret  = $apisecret;
            $nonce      = number_format(microtime(true) * 1000, 0, '.', '');

            $url="https://www.binance.com/api/v3/account";

            $headers[] = "User-Agent: Mozilla/4.0 (compatible; PHP Binance API)\r\nX-MBX-APIKEY: ".$apikey."\r\n";
            $params['timestamp'] = $nonce;
            $query = http_build_query($params, '', '&');
            $signature = hash_hmac('sha256', $query, $apisecret);
            $endpoint=$url.'?'.$query.'&signature='.$signature;
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $endpoint);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_ENCODING, "");
            $output = curl_exec($ch);
            curl_close($ch);
            $obj = json_decode($output);

            if(empty($obj->msg))
            {
                DB::table('user_membership')->where('id', $id)->update(['api_key' => $apikey, 'api_secret' => $apisecret]);
                $data['success'] = true;
            }else{
                $data['success'] = false;
            }
            echo json_encode($data);
        }

        if(!empty($apikey) && !empty($apisecret) && !empty($e_id) && ($e_id == 1))
        {

            $apikey     = $apikey;
            $apisecret  = $apisecret;
            $nonce      = time();

            $req = array('Currency'=> '') ;
            $url = "https://www.cryptopia.co.nz/Api/GetBalance/";

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; Cryptopia.co.nz API PHP client; FreeBSD; PHP/'.phpversion().')');
            $post_data = json_encode( $req );
            $md5_encript = md5( $post_data, true );
            $signature = $apikey . "POST" . strtolower( urlencode( $url ) ) . $nonce . base64_encode( $md5_encript );
            $hmacsignature = base64_encode( hash_hmac("sha256", $signature, base64_decode( $apisecret ), true ) );
            $header_value = "amx " . $apikey . ":" . $hmacsignature . ":" . $nonce;
            $headers = array("Content-Type: application/json; charset=utf-8", "Authorization: $header_value");
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_URL, $url );
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $req ) );
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE); // Do Not Cache
            $output = curl_exec($ch);
            curl_close($ch);
            $obj = json_decode($output);

            if(!empty($obj)){
                if($obj->Success == 1)
                {
                    DB::table('user_membership')->where('id', $id)->update(['api_key' => $apikey, 'api_secret' => $apisecret]);
                    $data['success'] = true;
                }
            }else{
                $data['success'] = false;
            }
            echo json_encode($data);
        }

    }

    public function bittrex_balance_single($apikey,$apisecret,$currency)
    {

        $nonce = time();
        $uri   = 'https://bittrex.com/api/v1.1/account/getbalance?apikey='.$apikey.'&currency='.$currency.'&nonce='.$nonce;
        $sign  = hash_hmac('sha512',$uri,$apisecret);

        $ch    = curl_init($uri);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('apisign:'.$sign));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $execResult = curl_exec($ch);
        curl_close($ch);
        $obj = json_decode($execResult, true);

        if(!empty($obj['result']['Available'])){
        return $obj['result']['Available'];
        }

    }

    public function cryptopia_blance_single($apikey,$apisecret,$currency)
    {
        if(!empty($apikey) && !empty($apisecret)){

        $nonce = time();

        $req = array('Currency'=> $currency) ;
        $url = "https://www.cryptopia.co.nz/Api/GetBalance/";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; Cryptopia.co.nz API PHP client; FreeBSD; PHP/'.phpversion().')');
        $post_data = json_encode( $req );
        $md5_encript = md5( $post_data, true );
        $signature = $apikey . "POST" . strtolower( urlencode( $url ) ) . $nonce . base64_encode( $md5_encript );
        $hmacsignature = base64_encode( hash_hmac("sha256", $signature, base64_decode( $apisecret ), true ) );
        $header_value = "amx " . $apikey . ":" . $hmacsignature . ":" . $nonce;
        $headers = array("Content-Type: application/json; charset=utf-8", "Authorization: $header_value");
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_URL, $url );
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode( $req ) );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE); // Do Not Cache
        $output = curl_exec($ch);
        curl_close($ch);
        $data_array = json_decode($output,true);
        return $data_array['Data'];
        }else{
        return FALSE;
        }
    }

    public function yobit_blance_single($apikey,$apisecret,$currency)
    {
        if(!empty($apikey) && !empty($apisecret)){

        $currency = strtolower($currency);

        $nonce = microtime(time());

        $req['method'] = 'getInfo';
        $req['nonce']  = $nonce;

        $post_data = http_build_query($req, '', '&');
        $sign      = hash_hmac("sha512", $post_data, $apisecret);
        $headers   = array('Sign: '.$sign,'Key: '.$apikey);

        $ch = null;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; SMART_API PHP client; '.php_uname('s').'; PHP/'.phpversion().')');
        curl_setopt($ch, CURLOPT_URL, 'https://yobit.net/tapi/');
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_ENCODING , 'gzip');
        $output = curl_exec($ch);
        curl_close($ch);
        $data_array = json_decode($output,true);

        if(!empty($data_array['return']['funds'])){
        foreach ($data_array['return']['funds'] as $key => $value) {
        if($key == $currency){
        return $value;
        exit();
        }
        }
        }

        }else{
        return FALSE;
        }
    }

    public function get_api_key_for_user($exchange_id,$user_id)
    {
        if(!empty($exchange_id) and !empty($user_id)){
            return DB::table('user_membership')->where('exchange_id', $exchange_id)->where('user_id', $user_id)->get();
        }else{
            return 0;
        }

    }

    public function createBot(Request $request)
    {
        
        $NAME = 'BOT-'.time();
        $exchange_id = $request->input('exchange_id');
        $currency = $request->input('currency');
        $currency_to_spend_earn = $request->input('currency_to_spend_earn');
        $qty = $request->input('qty');

        if(!empty($exchange_id) && !empty($currency) && !empty($qty) && !empty($currency_to_spend_earn) && !empty($request->input('qty_one')) && !empty($request->input('amount')) && !empty($request->input('qty_limit')) && !empty($request->input('qty_stop_loss_one')) && !empty($request->input('amount_stop_loss_one')) && !empty($request->input('qty_stop_loss_two'))  && !empty($request->input('amount_stop_loss_two')))
        {
            $get_user_details = $this->get_api_key_for_user($exchange_id,session('user_id'));

            if($exchange_id == 1)
            {
            $get_balance = $this->cryptopia_blance_single($get_user_details[0]->api_key,$get_user_details[0]->api_secret,$currency_to_spend_earn);
            $avail_bal = $get_balance[0]['Available'];
            }else if($exchange_id == 3)
            {
            $get_balance = $this->yobit_blance_single($get_user_details[0]->api_key,$get_user_details[0]->api_secret,$currency_to_spend_earn);
            $avail_bal = $get_balance;
            }else if($exchange_id == 4)
            {
            $get_balance = $this->bittrex_balance_single($get_user_details[0]->api_key,$get_user_details[0]->api_secret,$currency_to_spend_earn);
            $avail_bal = $get_balance;
            }else{
            $avail_bal = 0;    
            }

            $avail_bal  = number_format($avail_bal,8);
            if(!empty($avail_bal) && ($avail_bal > $qty)){
            //===============================================================================================
            $id = DB::table('bots')->insertGetId([
                'user_id' => session('user_id'),
                'name' => $NAME,
                'exchange_id' => $exchange_id,
                'type' => 'Buy',
                'currency' => $currency,
                'qty' => $qty,
                'currency_to_spend_earn' => $currency_to_spend_earn,
                'created_date' => date('Y-m-d')
            ]);
            //===============================================================================================
            DB::table('bots')->insertGetId([
                'user_id' => session('user_id'),
                'name' => $NAME,
                'parent_id' => $id,
                'exchange_id' => $exchange_id,
                'type' => 'Sell',
                'currency' => $currency_to_spend_earn,
                'qty' => !empty($request->input('qty_one')) ? $request->input('qty_one') : 0,
                'amount' => !empty($request->input('amount')) ? $request->input('amount') : 0,
                'qty_limit' => !empty($request->input('qty_limit')) ? $request->input('qty_limit') : 0 ,
                'amount_limit' => !empty($request->input('amount_limit')) ? $request->input('amount_limit') : 0 ,
                'qty_stop_loss_one' => !empty($request->input('qty_stop_loss_one')) ? $request->input('qty_stop_loss_one') : 0 ,
                'amount_stop_loss_one' => !empty($request->input('amount_stop_loss_one')) ? $request->input('amount_stop_loss_one') : 0 ,
                'qty_stop_loss_two' => !empty($request->input('qty_stop_loss_two')) ? $request->input('qty_stop_loss_two') : 0 ,
                'amount_stop_loss_two' => !empty($request->input('amount_stop_loss_two')) ? $request->input('amount_stop_loss_two') : 0 ,
                'currency_to_spend_earn' => $currency,
                'created_date' => date('Y-m-d')
            ]);
            //===============================================================================================
            echo 'SUCCESS';
            }else{
            echo 'INSUFFICIENT BALANCE FOR '.strtoupper($currency_to_spend_earn);
        }
        }else{
            echo 'FILDS CANNOT BE BLANK';  
        }

    }

    // public function updateBot(Request $request)
    // {

    //     $id = $request->input('id');
    //     $exchange_id = $request->input('exchange_id');
    //     $type = $request->input('type');
    //     $currency = $request->input('currency');
    //     $qty = $request->input('qty');
    //     $currency_to_spend_earn = $request->input('currency_to_spend_earn');

    //     if(!empty($id) && !empty($exchange_id) && !empty($type) && !empty($currency) && !empty($qty) && !empty($currency_to_spend_earn) )
    //     {
    //           DB::table('bots')->where('id', $id)->update([
    //             'exchange_id' => $exchange_id,
    //             'type' => $type,
    //             'currency' => $currency,
    //             'qty' => $qty,
    //             'currency_to_spend_earn' => $currency_to_spend_earn,
    //         ]);
    //     }

    //     return redirect()->action('DashboardController@bot');
    // }

    // public function createBotSell(Request $request)
    // {

    //     $qty = $request->input('qty');
    //     $amount = $request->input('amount');
    //     $currency = $request->input('currency');
    //     $parent_id = $request->input('parent_id');
    //     $currency_to_spend_earn = $request->input('currency_to_spend_earn');

    //     if(!empty($parent_id)){
    //     $get_details = DB::table('bots')->where('id', $parent_id)->get();
    //     if(!empty($get_details)){
    //     $exchange_id = $get_details[0]->exchange_id;
    //     $type = 'Sell';
    //     if( !empty($exchange_id) && !empty($type) && !empty($currency) && !empty($qty) && !empty($amount) && !empty($currency_to_spend_earn) )
    //     {
    //         $id = DB::table('bots')->insertGetId([
    //             'user_id' => session('user_id'),
    //             'name' => 'BOT-'.time(),
    //             'parent_id' => $parent_id,
    //             'exchange_id' => $exchange_id,
    //             'type' => $type,
    //             'currency' => $currency,
    //             'qty' => $qty,
    //             'amount' => $amount,
    //             'qty_limit' => !empty($request->input('qty_limit')) ? $request->input('qty_limit') : 0 ,
    //             'amount_limit' => !empty($request->input('amount_limit')) ? $request->input('amount_limit') : 0 ,
    //             'qty_stop_loss_one' => !empty($request->input('qty_stop_loss_one')) ? $request->input('qty_stop_loss_one') : 0 ,
    //             'amount_stop_loss_one' => !empty($request->input('amount_stop_loss_one')) ? $request->input('amount_stop_loss_one') : 0 ,
    //             'qty_stop_loss_two' => !empty($request->input('qty_stop_loss_two')) ? $request->input('qty_stop_loss_two') : 0 ,
    //             'amount_stop_loss_two' => !empty($request->input('amount_stop_loss_two')) ? $request->input('amount_stop_loss_two') : 0 ,
    //             'currency_to_spend_earn' => $currency_to_spend_earn,
    //             'created_date' => date('Y-m-d')
    //         ]);
    //     }
    //     }
    //     }
    //     return redirect()->action('DashboardController@bot');
    // }

    public function deleteBot($id ='')
    {
        if(!empty($id))
        {
            DB::table('bots')->where('id', $id)->delete();
        }
        return redirect()->action('DashboardController@bot');
    }

    public function filter_data_currency_order($get_balance,$exchange_id)
    {
        if(!empty($get_balance) and !empty($exchange_id))
        {

        if($exchange_id == 1){
        foreach ($get_balance as $key => $value) {
        $new_array_data[] = $value['Symbol'];
        }
        }

        if($exchange_id == 2){
        foreach ($get_balance as $key => $value) {
        $new_array_data[] = $value['asset'];
        }
        }
        if($exchange_id == 3){
        foreach ($get_balance as $key => $value) {
        $new_array_data[] = $key;
        }
        }
        if($exchange_id == 4){
        foreach ($get_balance as $key => $value) {
        $new_array_data[] = $value['Currency'];
        }
        }
        sort($new_array_data);
        return $new_array_data;
        }
    }

    public function get_currency_ajax(Request $request)
    {

        $userId      = session('user_id');
        $exchange_id = $request->input('id');

        $get_details = DB::table('user_membership')->where('user_id', $userId)->where('exchange_id', $exchange_id)->get();

        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
        $apikey     = $get_details[0]->api_key;
        $apisecret  = $get_details[0]->api_secret;
        $nonce      = time();
        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

        if(($exchange_id == 1))
        {

        $get_balance = $this->cryptopia_blance($apikey,$apisecret);
        $get_balance = $this->filter_data_currency_order($get_balance,1);

        $data  = '<select class="form-control sel" id="currency" name="currency" >';
        $data .= '<option value="">Select Currency</option>';

        if(!empty($get_balance)){
        foreach ($get_balance as $key => $value) {
        //if($value['Available'] != 0){
        $data .='<option value="'.strtoupper($value).'">'.strtoupper($value).'</option>';
        //}
        }
        }

        $data .='</select>';

        }

        if(($exchange_id == 2))
        {
        $get_balance = $this->binance_blance($apikey,$apisecret);
        $get_balance = $this->filter_data_currency_order($get_balance,2);

        $data  = '<select class="form-control sel" id="currency" name="currency" >';
        $data .= '<option value="">Select Currency</option>';

        if(!empty($get_balance)){
        foreach ($get_balance as $key => $value) {
        //if($value['free'] != 0){
        $data .='<option value="'.strtoupper($value).'">'.strtoupper($value).'</option>';
        //}
        }
        }

        $data .='</select>';

        }

        if(($exchange_id == 3))
        {
        $get_balance = $this->yobit_blance($apikey,$apisecret);
        $get_balance = $this->filter_data_currency_order($get_balance,3);

        $data  = '<select class="form-control sel" id="currency" name="currency" >';
        $data .= '<option value="">Select Currency</option>';

        if(!empty($get_balance)){
        foreach ($get_balance as $key => $value) {
        //if($value != 0){
        $data .='<option value="'.strtoupper($value).'">'.strtoupper($value).'</option>';
        //}
        }
        }

        $data .='</select>';

        }

        if(($exchange_id == 4))
        {
        $url='https://bittrex.com/api/v1.1/account/getbalances?apikey='.$apikey.'&nonce='.$nonce;
        $get_balance = $this->britrex_balance($url,$apisecret);
        $get_balance = $this->filter_data_currency_order($get_balance,4);

        $data  = '<select class="form-control sel" id="currency" name="currency" >';
        $data .= '<option value="">Select Currency</option>';

        if(!empty($get_balance)){
        foreach ($get_balance as $key => $value) {
        //if($value['Available']  != 0){
        $data .='<option value="'.strtoupper($value).'">'.strtoupper($value).'</option>';
        //}
        }
        }

        $data .='</select>';

        }

        echo $data;

    }
    function formate_num($val)
    {
        return number_format($val,12);
    }
    public function get_market_ajax(Request $request)
    {
         $HTML = '';
         $exchange_id = $request->input('id');

         if ($exchange_id == 1)
         {
            $url = "https://www.cryptopia.co.nz/api/GetMarkets/BTC";
            $get_result  = $this->dynamic_curl($url);
            if(!empty($get_result['Data'])){
            foreach ($get_result['Data'] as $key_one => $value_one)
            {
                $HTML .= '<tr>';
                $HTML .= '<td>'.$value_one['TradePairId'].'</td>';
                $HTML .= '<td>'.$value_one['Label'].'</td>';
                $HTML .= '<td>'.$this->formate_num($value_one['AskPrice']).'</td>';
                $HTML .= '<td>'.$this->formate_num($value_one['BidPrice']).'</td>';
                $HTML .= '<td>'.$this->formate_num($value_one['Low']).'</td>';
                $HTML .= '<td>'.$this->formate_num($value_one['High']).'</td>';
                $HTML .= '<td>'.$value_one['Volume'].'</td>';
                $HTML .= '<td>'.$this->formate_num($value_one['LastPrice']).'</td>';
                $HTML .= '<td>'.$value_one['BuyVolume'].'</td>';
                $HTML .= '<td>'.$value_one['SellVolume'].'</td>';
                $HTML .= '<td>'.$this->formate_num($value_one['Change']).'</td>';
                $HTML .= '<td>'.$this->formate_num($value_one['Open']).'</td>';
                $HTML .= '<td>'.$this->formate_num($value_one['Close']).'</td>';
                $HTML .= '<td>'.$value_one['BaseVolume'].'</td>';
                $HTML .= '<td>'.$value_one['BuyBaseVolume'].'</td>';
                $HTML .= '<td>'.$value_one['SellBaseVolume'].'</td>';
                $HTML .= '</tr>';
            }
            }
         }

         if ($exchange_id == 2)
         {
            $url = "https://www.binance.com/api/v1/exchangeInfo";
            $get_result  = $this->dynamic_curl($url);
            if(!empty($get_result['symbols'])){
            foreach ($get_result['symbols'] as $key => $value)
            {
                $HTML .= '<tr>';
                $HTML .= '<td>'.$value['symbol'].'</td>';
                $HTML .= '<td>'.$value['status'].'</td>';
                $HTML .= '<td>'.$value['baseAsset'].'</td>';
                $HTML .= '<td>'.$value['baseAssetPrecision'].'</td>';
                $HTML .= '<td>'.$value['quoteAsset'].'</td>';
                $HTML .= '<td>'.$value['quotePrecision'].'</td>';
                $HTML .= '<td>'.$value['icebergAllowed'].'</td>';
                $HTML .= '</tr>';
            }
            }
         }


         if ($exchange_id == 3)
         {
            $url = "https://yobit.net/api/3/info";
            $get_result  = $this->dynamic_curl($url);
            if(!empty($get_result['pairs'])){
            foreach ($get_result['pairs'] as $key => $value)
            {
                $HTML .= '<tr>';
                $HTML .= '<td>'.$value['decimal_places'].'</td>';
                $HTML .= '<td>'.$value['min_price'].'</td>';
                $HTML .= '<td>'.$value['max_price'].'</td>';
                $HTML .= '<td>'.$value['min_amount'].'</td>';
                $HTML .= '<td>'.$value['min_total'].'</td>';
                $HTML .= '<td>'.$value['hidden'].'</td>';
                $HTML .= '<td>'.$value['fee'].'</td>';
                $HTML .= '<td>'.$value['fee_buyer'].'</td>';
                $HTML .= '<td>'.$value['fee_seller'].'</td>';
                $HTML .= '</tr>';
            }
            }
         }


         if ($exchange_id == 4)
         {
            $url = "https://bittrex.com/api/v1.1/public/getmarketsummaries";
            $get_result  = $this->dynamic_curl($url);
            if(!empty($get_result['result'])){
            foreach ($get_result['result'] as $key => $value)
            {
                $HTML .= '<tr>';
                $HTML .= '<td>'.$value['MarketName'].'</td>';
                $HTML .= '<td>'.$this->formate_num($value['High']).'</td>';
                $HTML .= '<td>'.$this->formate_num($value['Low']).'</td>';
                $HTML .= '<td>'.$value['Volume'].'</td>';
                $HTML .= '<td>'.$this->formate_num($value['Last']).'</td>';
                $HTML .= '<td>'.$value['BaseVolume'].'</td>';
                $HTML .= '<td>'.$this->formate_num($value['Bid']).'</td>';
                $HTML .= '<td>'.$this->formate_num($value['Ask']).'</td>';
                $HTML .= '<td>'.$value['OpenBuyOrders'].'</td>';
                $HTML .= '<td>'.$value['OpenSellOrders'].'</td>';
                $HTML .= '<td>'.$this->formate_num($value['PrevDay']).'</td>';
                $HTML .= '<td>'.$value['Created'].'</td>';
                $HTML .= '<td>'.$value['TimeStamp'].'</td>';
                $HTML .= '</tr>';
            }
            }
         }

         echo $HTML;
    }

    function lsl($id = '')
    {
        if(!empty($id)){
        $get_all_lsl = DB::table('bots_lsl')->where('bot_id', $id)->get();
        $data['get_lsl'] = $get_all_lsl;
        $data['get_id'] = $id;
        return view('lsl',$data);
        }else{
        return redirect()->action('DashboardController@bot');
        }
    }

    function createLsl(Request $request)
    {
        $qty    = $request->input('qty');
        $type   = $request->input('type');
        $bot_id = $request->input('bot_id');
        $persentage = $request->input('persentage');

        if(!empty($bot_id) && !empty($type) && !empty($qty) && !empty($persentage) )
        {
            DB::table('bots_lsl')->insertGetId([
                'bot_id' => $bot_id,
                'type' => $type,
                'qty' => $qty,
                'persentage' => $persentage,
                'created_date' => date('Y-m-d')
            ]);
        }

        return redirect()->action('DashboardController@lsl', ['id' => $bot_id] );
    }

    function updateLsl(Request $request)
    {

        $id         = $request->input('id');
        $bot_id     = $request->input('bot_id');
        $qty        = $request->input('qty');
        $type       = $request->input('type');
        $persentage = $request->input('persentage');

        if(!empty($id) && !empty($type) && !empty($qty) && !empty($persentage) )
        {
            DB::table('bots_lsl')->where('id', $id)->update([
                'type' => $type,
                'qty' => $qty,
                'persentage' => $persentage,
            ]);
        }

        return redirect()->action('DashboardController@lsl', ['id' => $bot_id] );

    }

    function deleteLsl($id = '',$bot_id = '')
    {

        if(!empty($id) and !empty($bot_id)){
            DB::table('bots_lsl')->where('id', $id)->delete();
        }
        return redirect()->action('DashboardController@lsl', ['id' => $bot_id] );

    }




//END
}
