<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class BotController extends Controller
{
public function __construct()
{

}
public function printrr($data)
{
	echo "<pre>";
	print_r($data);
	die();
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
public function britex_bot()
{
    
    //+++++++++++++++++++++++++++++++++
	$to = "aquadevjd@gmail.com";
	$subject = "Bitcoin Trading Bot";
	$message = "The bot cronjob is working.......";
	$header  = "From:aquadevjd@gmail.com \r\n";
	$header .= "Cc:aquadevjd@gmail.com \r\n";
	$header .= "MIME-Version: 1.0\r\n";
	$header .= "Content-type: text/html\r\n";
	mail ($to,$subject,$message,$header);
    //++++++++++++++++++++++++++++++++++

    $this->bitrex_buy_bot();
    $this->bitrex_sell_bot();
    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    $this->yobit_buy_bot();
    $this->yobit_sell_bot();
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
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
/*
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
BRITREX API BOT
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
public function britrex_curl_with_header($url,$apisecret)
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
return $result = json_decode($res, true);
}else{
return FALSE;
}
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
public function get_britex_url($buy_currency,$sell_currency)
{
$url = 'https://bittrex.com/api/v1.1/public/getmarketsummary?market='.$buy_currency.'-'.$sell_currency.'';
$get_result = $this->dynamic_curl($url);
if(!empty($get_result['result'])){
return $url;
}else{
$url = 'https://bittrex.com/api/v1.1/public/getmarketsummary?market='.$sell_currency.'-'.$buy_currency.'';
$get_result = $this->dynamic_curl($url);
if(!empty($get_result['result'])){
return $url;
}else{
return $url = 0;
}
}
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
public function bittrex_balance($apikey,$apisecret,$currency)
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
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
public function bittrex_buy($apikey,$apisecret,$symbol,$quant,$rate)
{
$nonce = time();
$uri   = 'https://bittrex.com/api/v1.1/market/buylimit?apikey='.$apikey.'&market='.$symbol.'&quantity='.$quant.'&rate='.$rate.'&nonce='.$nonce;
$sign  = hash_hmac('sha512',$uri,$apisecret);
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; Cryptopia.co.nz API PHP client; FreeBSD; PHP/'.phpversion().')');
curl_setopt($ch, CURLOPT_URL, $uri );
curl_setopt($ch, CURLOPT_HTTPHEADER, array('apisign:'.$sign));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE);
$res = curl_exec($ch);
curl_close($ch);
return $res;
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
public function bittrex_sell($apikey,$apisecret,$symbol,$quant,$rate)
{
$nonce = time();
$url   = 'https://bittrex.com/api/v1.1/market/selllimit?apikey='.$apikey.'&market='.$symbol.'&quantity='.$quant.'&rate='.$rate.'&nonce='.$nonce;
$sign  = hash_hmac('sha512',$url,$apisecret);
$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; Cryptopia.co.nz API PHP client; FreeBSD; PHP/'.phpversion().')');
curl_setopt($ch, CURLOPT_URL, $url );
curl_setopt($ch, CURLOPT_HTTPHEADER, array('apisign:'.$sign));
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_FRESH_CONNECT, TRUE);
$res = curl_exec($ch);
curl_close($ch);
return $res;
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
public function get_all_bot_exchange_wise($exchange_id='')
{
if(!empty($exchange_id)){
return  DB::table('bots')->where('exchange_id', $exchange_id)->where('status', 'Pending')->get()->toArray();
}else{
return 0;
}
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
public function get_api_key_for_user($exchange_id,$user_id)
{
if(!empty($exchange_id) and !empty($user_id)){
return DB::table('user_membership')->where('exchange_id', $exchange_id)->where('user_id', $user_id)->get();
}else{
return 0;
}
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
public function bitrex_buy_bot()
{
$get_bot = $this->get_all_bot_exchange_wise(4);
if(!empty($get_bot))
{
foreach ($get_bot as $key => $value)
{
if($value->type == 'Buy'){
$get_user_details = $this->get_api_key_for_user($value->exchange_id,$value->user_id);
if(!empty($get_user_details[0]->api_key) and !empty($get_user_details[0]->api_secret))
{
$get_url = $this->get_britex_url($value->currency,$value->currency_to_spend_earn);
$get_result =  $this->dynamic_curl($get_url);
if(!empty($get_result['result']))
{
$get_balance = $this->bittrex_balance($get_user_details[0]->api_key,$get_user_details[0]->api_secret,$value->currency_to_spend_earn);
if(!empty($get_balance) and ($get_balance >= $value->qty ) and ($value->qty >= 0.00100000 ))
{
if(!empty($value->qty)){
$qty = ($value->qty / $get_result['result'][0]['Ask']);
}else{
$qty = $value->qty;
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$__api_key = $get_user_details[0]->api_key;
$__api_sec = $get_user_details[0]->api_secret;
$__api_man = $get_result['result'][0]['MarketName'];
$__api_qty = $qty;
$__api_ask = $get_result['result'][0]['Ask'];
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
$get_buy_data = $this->bittrex_buy($__api_key,$__api_sec,$__api_man,$__api_qty,$__api_ask);
$arry = json_decode($get_buy_data, true);
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if($arry['success']){
$get_id = DB::table('robot_tradess')->insertGetId([
'user_id'       => $value->user_id,
'bot_id'        => $value->id,
'exchange_id'   => $value->exchange_id,
'market'        => $__api_man,
'type_of_trade' => 'Buy',
'volume'        => $value->qty,
'price'         => $__api_ask,
'result'        => $get_buy_data
]);
DB::table('bots')->where('id', $value->id)->update(['status' => 'Success']);
}
}
}
}
}
}
}
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
public function bitrex_sell_bot()
{
$get_bot = $this->get_all_bot_exchange_wise(4);
if(!empty($get_bot)){
foreach ($get_bot as $key => $value){
if( ($value->type == 'Sell') && (!empty($value->parent_id)) ) {
$get_parent_details  = DB::table('bots')->where('id', $value->parent_id)->get();
if( $get_parent_details[0]->status == 'Success'){
$get_buy_bot_details = DB::table('robot_tradess')->where('bot_id', $get_parent_details[0]->id)->get();
$get_user_details = $this->get_api_key_for_user($value->exchange_id,$value->user_id);
if(!empty($get_user_details[0]->api_key) and !empty($get_user_details[0]->api_secret) and !empty($get_buy_bot_details)){
$get_url = $this->get_britex_url($value->currency,$value->currency_to_spend_earn);
$get_result =  $this->dynamic_curl($get_url);
if(!empty($get_result['result'])){
$get_balance = $this->bittrex_balance($get_user_details[0]->api_key,$get_user_details[0]->api_secret,$value->currency_to_spend_earn);
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//LIMIT ONE
if(!empty($get_balance) and ($get_balance >= $value->qty )){
if(!empty($get_buy_bot_details[0]->price) && ($get_result['result'][0]['Bid'] > $get_buy_bot_details[0]->price) ){
$profit = (($get_result['result'][0]['Bid'] - $get_buy_bot_details[0]->price)  / $get_buy_bot_details[0]->price)*100;
if($profit >= $value->amount){
if(!empty($value->qty)){
$qty = ($value->qty / $get_result['result'][0]['Bid']);
}else{
$qty = $value->qty;
}
if(!empty($qty))
{
$__api_key = $get_user_details[0]->api_key;
$__api_sec = $get_user_details[0]->api_secret;    
$get_buy_data = $this->bittrex_sell($__api_key,$__api_sec,$get_result['result'][0]['MarketName'],$qty,$get_result['result'][0]['Bid']);
$arry = json_decode($get_buy_data, true);
if($arry['success']){
$get_id = DB::table('robot_tradess')->insertGetId([
'user_id' => $value->user_id,
'bot_id' => $value->id,
'exchange_id' => $value->exchange_id,
'market' => $get_result['result'][0]['MarketName'],
'type_of_trade' => 'Sell',
'volume' => $value->qty,
'price' => $get_result['result'][0]['Bid'],
'pl_amount' => $value->amount,
'type' => 'Profit',
'result' => $get_buy_data
]);
$get_count_p_l = DB::table('robot_tradess')->where('bot_id', $value->id)->where('type', 'Profit')->count();
if($get_count_p_l > 1){
DB::table('bots')->where('id', $value->id)->update(['status' => 'Success']);
}
}
}
}
}
}
//LIMIT ONE
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//LIMIT TWO
if(!empty($get_balance) and ($get_balance >= $value->qty_limit )){
if(!empty($get_buy_bot_details[0]->price) && ($get_result['result'][0]['Bid'] > $get_buy_bot_details[0]->price) ){
$profit = (($get_result['result'][0]['Bid'] - $get_buy_bot_details[0]->price)  / $get_buy_bot_details[0]->price)*100;
if($profit >= $value->amount_limit){
if(!empty($value->qty_limit)){
$qty = ($value->qty_limit / $get_result['result'][0]['Bid']);
}else{
$qty = $value->qty_limit;
}
if(!empty($qty)){
$__api_key = $get_user_details[0]->api_key;
$__api_sec = $get_user_details[0]->api_secret;      
$get_buy_data = $this->bittrex_sell($__api_key,$__api_sec,$get_result['result'][0]['MarketName'],$qty,$get_result['result'][0]['Bid']);
$arry = json_decode($get_buy_data, true);
if($arry['success']){
$get_id = DB::table('robot_tradess')->insertGetId([
'user_id' => $value->user_id,
'bot_id' => $value->id,
'exchange_id' => $value->exchange_id,
'market' => $get_result['result'][0]['MarketName'],
'type_of_trade' => 'Sell',
'volume' => $value->qty,
'price' => $get_result['result'][0]['Bid'],
'pl_amount' => $value->amount_limit,
'type' => 'Profit',
'result' => $get_buy_data
]);
$get_count_p_l = DB::table('robot_tradess')->where('bot_id', $value->id)->where('type', 'Profit')->count();
if($get_count_p_l > 1){
DB::table('bots')->where('id', $value->id)->update(['status' => 'Success']);
}
}
}
}
}
}
//LIMIT TWO
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//STOP LOSS ONE
if(!empty($get_balance) and ($get_balance >= $value->qty_stop_loss_one )){
if(!empty($get_buy_bot_details[0]->price) && ($get_result['result'][0]['Bid'] < $get_buy_bot_details[0]->price) ){
$loss = (($get_buy_bot_details[0]->price - $get_result['result'][0]['Bid'])  / $get_buy_bot_details[0]->price)*100;
if($loss >= $value->amount_stop_loss_one){
if(!empty($value->qty_stop_loss_one)){
$qty = ($value->qty_stop_loss_one / $get_result['result'][0]['Bid']);
}else{
$qty = $value->qty_stop_loss_one;
}
if(!empty($qty)){
$__api_key = $get_user_details[0]->api_key;
$__api_sec = $get_user_details[0]->api_secret;     
$get_buy_data = $this->bittrex_sell($__api_key,$__api_sec,$get_result['result'][0]['MarketName'],$qty,$get_result['result'][0]['Bid']);
$arry = json_decode($get_buy_data, true);
if($arry['success']){
$get_id = DB::table('robot_tradess')->insertGetId([
'user_id' => $value->user_id,
'bot_id' => $value->id,
'exchange_id' => $value->exchange_id,
'market' => $get_result['result'][0]['MarketName'],
'type_of_trade' => 'Sell',
'volume' => $value->qty,
'price' => $get_result['result'][0]['Bid'],
'pl_amount' => $value->amount_stop_loss_one,
'type' => 'Loss',
'result' => $get_buy_data
]);
$get_count_p_l = DB::table('robot_tradess')->where('bot_id', $value->id)->where('type', 'Loss')->count();
if($get_count_p_l > 1){
DB::table('bots')->where('id', $value->id)->update(['status' => 'Success']);
}
}
}
}
}
}
//STOP LOSS ONE
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//STOP LOSS TWO
if(!empty($get_balance) and ($get_balance >= $value->qty_stop_loss_two )){
if(!empty($get_buy_bot_details[0]->price) && ($get_result['result'][0]['Bid'] < $get_buy_bot_details[0]->price) ){
$loss = (($get_buy_bot_details[0]->price - $get_result['result'][0]['Bid'])  / $get_buy_bot_details[0]->price)*100;
if($loss >= $value->amount_stop_loss_two){
if(!empty($value->qty_stop_loss_two)){
$qty = ($value->qty_stop_loss_two / $get_result['result'][0]['Bid']);
}else{
$qty = $value->qty_stop_loss_two;
}
if(!empty($qty)){
$__api_key = $get_user_details[0]->api_key;
$__api_sec = $get_user_details[0]->api_secret;     
$get_buy_data = $this->bittrex_sell($__api_key,$__api_sec,$get_result['result'][0]['MarketName'],$qty,$get_result['result'][0]['Bid']);
$arry = json_decode($get_buy_data, true);
if($arry['success']){
$get_id = DB::table('robot_tradess')->insertGetId([
'user_id' => $value->user_id,
'bot_id' => $value->id,
'exchange_id' => $value->exchange_id,
'market' => $get_result['result'][0]['MarketName'],
'type_of_trade' => 'Sell',
'volume' => $value->qty,
'price' => $get_result['result'][0]['Bid'],
'pl_amount' => $value->amount_stop_loss_two,
'type' => 'Loss',
'result' => $get_buy_data
]);
$get_count_p_l = DB::table('robot_tradess')->where('bot_id', $value->id)->where('type', 'Loss')->count();
if($get_count_p_l > 1){
DB::table('bots')->where('id', $value->id)->update(['status' => 'Success']);
}
}
}
}
}
}
//STOP LOSS TWO
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
}
}
}
}
}
}
}
/*
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
CRYPTOPIA API BOT
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
public function get_crytopia_url($buy_currency,$sell_currency)
{
$url = 'https://www.cryptopia.co.nz/api/GetMarket/'.$buy_currency.'_'.$sell_currency.'';
$get_result = $this->dynamic_curl($url);
if(!empty($get_result['Data'])){
return $url;
}else{
$url = 'https://www.cryptopia.co.nz/api/GetMarket/'.$sell_currency.'_'.$buy_currency.'';
$get_result = $this->dynamic_curl($url);
if(!empty($get_result['Data'])){
return $url;
}else{
return $url = 0;
}
}
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
public function cryptopia_blance($apikey,$apisecret,$currency)
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
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
public function cryptopia_buy_sell($apikey,$apisecret,$type,$rate,$amount,$market)
{
if(!empty($apikey) && !empty($apisecret)){
$nonce = microtime(time());
$req = array('Market'=> $market, 'Type'=> $type, 'Rate'=> number_format((float)$rate, 8, '.', ''), 'Amount'=> number_format((float)$amount, 8, '.', '')) ;
$url = "https://www.cryptopia.co.nz/Api/SubmitTrade";
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
return $output;
}else{
return FALSE;
}
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
public function criptopia_buy_bot()
{
$get_bot = $this->get_all_bot_exchange_wise(1);
if(!empty($get_bot)){
foreach ($get_bot as $key => $value){
if($value->type == 'Buy'){
$get_user_details = $this->get_api_key_for_user($value->exchange_id,$value->user_id);
if(!empty($get_user_details[0]->api_key) and !empty($get_user_details[0]->api_secret)){
$get_url = $this->get_crytopia_url($value->currency,$value->currency_to_spend_earn);
$get_result =  $this->dynamic_curl($get_url);
if(!empty($get_result['Data'])){
$get_balance = $this->cryptopia_blance($get_user_details[0]->api_key,$get_user_details[0]->api_secret,$value->currency_to_spend_earn);
if(!empty($get_balance[0]['Available']) and ($get_balance[0]['Available'] >= $value->qty ) and ($value->qty >= 0.00050000 )){
$qqty = $value->qty;
$get_buy_data = $this->cryptopia_buy_sell($get_user_details[0]->api_key,$get_user_details[0]->api_secret,'Buy',$get_result['Data']['AskPrice'],$qqty,$get_result['Data']['Label']);
$arry = json_decode($get_buy_data, true);
//if($arry['Success']){
$get_id = DB::table('robot_tradess')->insertGetId([
'user_id' => $value->user_id,
'bot_id' => $value->id,
'exchange_id' => $value->exchange_id,
'market' => $get_result['Data']['Label'],
'type_of_trade' => 'Buy',
'volume' => $value->qty,
'price' => $get_result['Data']['AskPrice'],
'result' => $get_buy_data
]);
DB::table('bots')->where('id', $value->id)->update(['status' => 'Success']);
//}
}
}
}
}
}
}
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
public function criptopia_sell_bot(){
$get_bot = $this->get_all_bot_exchange_wise(1);
if(!empty($get_bot)){
foreach ($get_bot as $key => $value){
if( ($value->type == 'Sell') && (!empty($value->parent_id)) ){
$get_parent_details  = DB::table('bots')->where('id', $value->parent_id)->get();
if($get_parent_details[0]->status == 'Success'){
$get_buy_bot_details = DB::table('robot_tradess')->where('bot_id', $get_parent_details[0]->id)->get();
$get_user_details = $this->get_api_key_for_user($value->exchange_id,$value->user_id);
if(!empty($get_user_details[0]->api_key) and !empty($get_user_details[0]->api_secret) and !empty($get_buy_bot_details)){
$get_url    = $this->get_crytopia_url($value->currency,$value->currency_to_spend_earn);
$get_result =  $this->dynamic_curl($get_url);
if(!empty($get_result['Data'])){
$get_balance = $this->cryptopia_blance($get_user_details[0]->api_key,$get_user_details[0]->api_secret,$value->currency_to_spend_earn);
//LIMIT ONE
if(!empty($get_balance[0]['Available']) and ($get_balance[0]['Available'] >= $value->qty )){
if(!empty($get_buy_bot_details[0]->price) && ($get_result['Data']['BidPrice'] > $get_buy_bot_details[0]->price) ){
$profit = (($get_result['Data']['BidPrice'] - $get_buy_bot_details[0]->price)  / $get_buy_bot_details[0]->price)*100;
if($profit >= $value->amount){
if(!empty($value->qty)){
$get_buy_data = $this->cryptopia_buy_sell($get_user_details[0]->api_key,$get_user_details[0]->api_secret,'Sell',$get_result['Data']['BidPrice'],$value->qty,$get_result['Data']['Label']);
$get_id = DB::table('robot_tradess')->insertGetId([
'user_id' => $value->user_id,
'bot_id' => $value->id,
'exchange_id' => $value->exchange_id,
'market' => $get_result['Data']['Label'],
'type_of_trade' => 'Sell',
'volume' => $value->qty,
'price' => $get_result['Data']['BidPrice'],
'pl_amount' => $value->amount,
'type' => 'Profit',
'result' => $get_buy_data
]);
$get_count_p_l = DB::table('robot_tradess')->where('bot_id', $value->id)->where('type', 'Profit')->count();
if($get_count_p_l > 1){
DB::table('bots')->where('id', $value->id)->update([
'status' => 'Success',
]);
}
}
}
}
}
//LIMIT ONE
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//LIMIT TWO
if(!empty($get_balance[0]['Available']) and ($get_balance[0]['Available'] >= $value->qty_limit )){
if(!empty($get_buy_bot_details[0]->price) && ($get_result['Data']['BidPrice'] > $get_buy_bot_details[0]->price) ){
$profit = (($get_result['Data']['BidPrice'] - $get_buy_bot_details[0]->price)  / $get_buy_bot_details[0]->price)*100;
if($profit >= $value->amount_limit){
if(!empty($value->qty_limit)){
$get_buy_data = $this->cryptopia_buy_sell($get_user_details[0]->api_key,$get_user_details[0]->api_secret,'Sell',$get_result['Data']['BidPrice'],$value->qty_limit,$get_result['Data']['Label']);
$get_id = DB::table('robot_tradess')->insertGetId([
'user_id' => $value->user_id,
'bot_id' => $value->id,
'exchange_id' => $value->exchange_id,
'market' => $get_result['Data']['Label'],
'type_of_trade' => 'Sell',
'volume' => $value->qty_limit,
'price' => $get_result['Data']['BidPrice'],
'pl_amount' => $value->amount_limit,
'type' => 'Profit',
'result' => $get_buy_data
]);
$get_count_p_l = DB::table('robot_tradess')->where('bot_id', $value->id)->where('type', 'Profit')->count();
if($get_count_p_l > 1){
DB::table('bots')->where('id', $value->id)->update([
'status' => 'Success',
]);
}
}
}
}
}
//LIMIT TWO
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//STOP LOSS ONE
if(!empty($get_balance[0]['Available']) and ($get_balance[0]['Available'] >= $value->qty_stop_loss_one )){
if(!empty($get_buy_bot_details[0]->price) && ($get_result['Data']['BidPrice'] < $get_buy_bot_details[0]->price) ){
$loss = (($get_buy_bot_details[0]->price - $get_result['Data']['BidPrice'])  / $get_buy_bot_details[0]->price)*100;
if($loss >= $value->amount_stop_loss_one){
if(!empty($value->qty_stop_loss_one)){
$get_buy_data = $this->cryptopia_buy_sell($get_user_details[0]->api_key,$get_user_details[0]->api_secret,'Sell',$get_result['Data']['BidPrice'],$value->qty_stop_loss_one,$get_result['Data']['Label']);
$get_id = DB::table('robot_tradess')->insertGetId([
'user_id' => $value->user_id,
'bot_id' => $value->id,
'exchange_id' => $value->exchange_id,
'market' => $get_result['Data']['Label'],
'type_of_trade' => 'Sell',
'volume' => $value->qty_stop_loss_one,
'price' => $get_result['Data']['BidPrice'],
'pl_amount' => $value->amount_stop_loss_one,
'type' => 'Loss',
'result' => $get_buy_data
]);
$get_count_p_l = DB::table('robot_tradess')->where('bot_id', $value->id)->where('type', 'Loss')->count();
if($get_count_p_l > 1){
DB::table('bots')->where('id', $value->id)->update([
'status' => 'Success',
]);
}
}
}
}
}
//STOP LOSS ONE
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//STOP LOSS TWO
if(!empty($get_balance[0]['Available']) and ($get_balance[0]['Available'] >= $value->qty_stop_loss_two )){
if(!empty($get_buy_bot_details[0]->price) && ($get_result['Data']['BidPrice'] < $get_buy_bot_details[0]->price) ){
$loss = (($get_buy_bot_details[0]->price - $get_result['Data']['BidPrice'])  / $get_buy_bot_details[0]->price)*100;
if($loss >= $value->amount_stop_loss_two){
if(!empty($value->qty_stop_loss_two)){
$get_buy_data = $this->cryptopia_buy_sell($get_user_details[0]->api_key,$get_user_details[0]->api_secret,'Sell',$get_result['Data']['BidPrice'],$value->qty_stop_loss_two,$get_result['Data']['Label']);
$get_id = DB::table('robot_tradess')->insertGetId([
'user_id' => $value->user_id,
'bot_id' => $value->id,
'exchange_id' => $value->exchange_id,
'market' => $get_result['Data']['Label'],
'type_of_trade' => 'Sell',
'volume' => $value->qty_stop_loss_two,
'price' => $get_result['Data']['BidPrice'],
'pl_amount' => $value->amount_stop_loss_two,
'type' => 'Loss',
'result' => $get_buy_data
]);
$get_count_p_l = DB::table('robot_tradess')->where('bot_id', $value->id)->where('type', 'Loss')->count();
if($get_count_p_l > 1){
DB::table('bots')->where('id', $value->id)->update([
'status' => 'Success',
]);
}
}
}
}
}
//STOP LOSS TWO
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
}
}
}
}
}
}
}
/*
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
YOBIT API BOT
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
*/
public function yobit_buy_sell($apikey,$apisecret,$market,$type,$rate,$amount)
{
if(!empty($apikey) && !empty($apisecret)){

	$nonce = microtime(time());

	$req['method'] = 'Trade';
	$req['pair']   = $market;
	$req['type']   = $type;
	$req['rate']   = $rate;
	$req['amount'] = $amount;
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
	return $output;
	}else{
	return FALSE;
	}
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
public function yobit_blance($apikey,$apisecret,$currency)
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
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
public function get_youbit_url($buy_currency,$sell_currency)
{
	$url = 'https://yobit.net/api/3/trades/'.$buy_currency.'_'.$sell_currency.'';
	$get_result = $this->dynamic_curl($url);
	if(empty($get_result['error'])){
	return array('url' => $url, 'C1' => $buy_currency, 'C2' => $sell_currency );
	}else{
	$url = 'https://yobit.net/api/3/trades/'.$sell_currency.'_'.$buy_currency.'';
	$get_result = $this->dynamic_curl($url);
	if(empty($get_result['error'])){
	return array('url' => $url, 'C1' => $sell_currency, 'C2' => $buy_currency );
	}else{
	return $url = array();
	}
	}
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
public function yobit_buy_bot()
{

$get_bot = $this->get_all_bot_exchange_wise(3);
if(!empty($get_bot)){
foreach ($get_bot as $key => $value){
if($value->type == 'Buy'){
$get_user_details = $this->get_api_key_for_user($value->exchange_id,$value->user_id);
if(!empty($get_user_details[0]->api_key) and !empty($get_user_details[0]->api_secret)){
$get_url = $this->get_youbit_url(strtolower($value->currency),strtolower($value->currency_to_spend_earn));
$get_market_name = strtolower($get_url['C1'].'_'.$get_url['C2']);
$get_result =  $this->dynamic_curl($get_url['url']);
if(!empty($get_result[$get_market_name])){
$get_balance = $this->yobit_blance($get_user_details[0]->api_key,$get_user_details[0]->api_secret,$value->currency_to_spend_earn);
if(!empty($get_balance) and ($get_balance >= $value->qty ) ){
foreach ($get_result[$get_market_name] as $key_one => $value_one) {
$qty = number_format((float)$value->qty, 8, '.', '');
if( ($value_one['type'] == 'ask') and ($qty >= $value_one['amount'])){
$get_count_p_l = DB::table('bots')->where('id', $value->id)->where('status', 'Success')->count();	
if($get_count_p_l  == 0){
$get_buy_data = $this->yobit_buy_sell($get_user_details[0]->api_key,$get_user_details[0]->api_secret,$get_market_name,'buy',$value_one['price'],$qty);
$arry = json_decode($get_buy_data, true);
if($arry['success'] == 1){
$get_id = DB::table('robot_tradess')->insertGetId([
    'user_id' => $value->user_id,
    'bot_id' => $value->id,
    'exchange_id' => $value->exchange_id,
    'market' => strtoupper($get_market_name),
    'type_of_trade' => 'Buy',
    'volume' => $qty,
    'price' => $value_one['price'],
    'result' => $get_buy_data
]);
DB::table('bots')->where('id', $value->id)->update(['status' => 'Success']);
}
}
}
}
}
}
}
}
}
}
}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
public function yobit_sell_bot()
{
$get_bot = $this->get_all_bot_exchange_wise(3);

if(!empty($get_bot)){
foreach ($get_bot as $key => $value){
if( ($value->type == 'Sell') && (!empty($value->parent_id)) ) {
$get_parent_details  = DB::table('bots')->where('id', $value->parent_id)->get();
if( $get_parent_details[0]->status == 'Success'){
$get_buy_bot_details = DB::table('robot_tradess')->where('bot_id', $get_parent_details[0]->id)->get();
$get_user_details = $this->get_api_key_for_user($value->exchange_id,$value->user_id);
if(!empty($get_user_details[0]->api_key) and !empty($get_user_details[0]->api_secret) and !empty($get_buy_bot_details)){
$get_url = $this->get_youbit_url(strtolower($value->currency),strtolower($value->currency_to_spend_earn));
$get_market_name = strtolower($get_url['C1'].'_'.$get_url['C2']);
$get_result =  $this->dynamic_curl($get_url['url']);
if(!empty($get_result[$get_market_name])){
$get_balance = $this->yobit_blance($get_user_details[0]->api_key,$get_user_details[0]->api_secret,$value->currency_to_spend_earn);	
foreach ($get_result[$get_market_name] as $key_one => $value_one) {
if( ($value_one['type'] == 'bid') ){

$get_count_ppl = DB::table('bots')->where('id', $value->id)->where('status', 'Success')->count();	
if($get_count_ppl  == 0){

//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//LIMIT ONE
if(!empty($get_balance) and ($get_balance >= $value->qty )){
if(!empty($get_buy_bot_details[0]->price) && ($value_one['price'] > $get_buy_bot_details[0]->price) ){
$profit = (($value_one['price'] - $get_buy_bot_details[0]->price)  / $get_buy_bot_details[0]->price)*100;
if($profit >= $value->amount){
$qty = number_format((float)$value->qty, 8, '.', '');
if(!empty($qty))
{
$__api_key = $get_user_details[0]->api_key;
$__api_sec = $get_user_details[0]->api_secret;    
$get_buy_data = $this->yobit_buy_sell($__api_key,$__api_sec,$get_market_name,'sell',$value_one['price'],$qty);
$arry = json_decode($get_buy_data, true);
if($arry['success'] == 1){
$get_id = DB::table('robot_tradess')->insertGetId([
'user_id' => $value->user_id,
'bot_id' => $value->id,
'exchange_id' => $value->exchange_id,
'market' => $get_market_name,
'type_of_trade' => 'Sell',
'volume' => $value->qty,
'price' => $value_one['price'],
'pl_amount' => $value->amount,
'type' => 'Profit',
'result' => $get_buy_data
]);
$get_count_p_l = DB::table('robot_tradess')->where('bot_id', $value->id)->where('type', 'Profit')->count();
if($get_count_p_l > 1){
DB::table('bots')->where('id', $value->id)->update(['status' => 'Success']);
}
}
}
}
}
}
//LIMIT ONE
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//LIMIT TWO
if(!empty($get_balance) and ($get_balance >= $value->qty_limit )){
if(!empty($get_buy_bot_details[0]->price) && ($value_one['price'] > $get_buy_bot_details[0]->price) ){
$profit = (($value_one['price'] - $get_buy_bot_details[0]->price)  / $get_buy_bot_details[0]->price)*100;
if($profit >= $value->amount_limit){
$qty = number_format((float)$value->qty_limit, 8, '.', '');
if(!empty($qty)){
$__api_key = $get_user_details[0]->api_key;
$__api_sec = $get_user_details[0]->api_secret;      
$get_buy_data = $this->yobit_buy_sell($__api_key,$__api_sec,$get_market_name,'sell',$value_one['price'],$qty);
$arry = json_decode($get_buy_data, true);
if($arry['success'] == 1){
$get_id = DB::table('robot_tradess')->insertGetId([
'user_id' => $value->user_id,
'bot_id' => $value->id,
'exchange_id' => $value->exchange_id,
'market' => $get_market_name,
'type_of_trade' => 'Sell',
'volume' => $value->qty,
'price' => $value_one['price'],
'pl_amount' => $value->amount_limit,
'type' => 'Profit',
'result' => $get_buy_data
]);
$get_count_p_l = DB::table('robot_tradess')->where('bot_id', $value->id)->where('type', 'Profit')->count();
if($get_count_p_l > 1){
DB::table('bots')->where('id', $value->id)->update(['status' => 'Success']);
}
}
}
}
}
}
//LIMIT TWO
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

}

}
}
}
}
}
}
}
}
}



//END
}
