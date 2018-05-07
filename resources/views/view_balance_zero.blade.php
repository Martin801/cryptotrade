@extends('layouts.user')
@section('content')
<?php
function dynamic_curl($url = ''){
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
function convert_number($n1,$n2){
return $n1*$n2;
}
?>
<section class="content-header">
<h1><?php echo $exchange_name; ?> <small>Account Balance</small></h1>
</section>
<section class="content">
<div class="row">
<div class="col-md-12">
<div class="panel panel-default">
<div class="panel-heading"><?php echo $exchange_name; ?> Account Balance</div>
<div class="panel-body">
<div class="box box-primary">
<form role="form">
<div class="box-body">
<a href="<?php echo URL::to('/balance/'.$exchange_id); ?>" class="btn btn-danger">Full Balances</a>	
<div class="page-header">
<h1 style="float: right; margin-top: -43px;">BTC <small><?php echo !empty($BTC_balance)? $BTC_balance : 0 ?> </small></h1>
</div>
<table id="example2" class="table table-bordered table-striped dataTable" cellspacing="0" width="100%">
<thead>
<tr>
<?php if($exchange_id == 1){ ?>
<th>CurrencyId</th>
<th>Symbol</th>
<th>Total</th>
<th>Available</th>
<th>Unconfirmed</th>
<th>HeldForTrades</th>
<th>PendingWithdraw</th>
<th>Address</th>
<th>Status</th>
<th>StatusMessage</th>
<th>Altcoin USD</th>
<?php } ?>
<?php if($exchange_id == 2){ ?>
<th>Currency</th>
<th>Free</th>
<th>Locked</th>
<th>Altcoin USD</th>
<?php } ?>
<?php if($exchange_id == 3){ ?>
<th>Currency</th>
<th>Amount</th>
<th>Altcoin USD</th>
<?php } ?>
<?php if($exchange_id == 4){ ?>
<th>Currency</th>
<th>Balance</th>
<th>Available</th>
<th>Pending</th>
<th>Altcoin USD</th>
<th>CryptoAddress</th>
<?php } ?>
</tr>
</thead>
<tbody>
<?php if($exchange_id == 1){ ?>
<?php
if(!empty($get_bal)){
foreach ($get_bal as $key => $value) {
if($value['Available'] != 0){
$url = 'https://api.cryptonator.com/api/ticker/'.strtolower($value['Symbol']).'-usd/';
$get_data = dynamic_curl($url);
if(!empty($get_data['ticker'])){
$usd = convert_number($value['Available'],$get_data['ticker']['price']);
}else{
$usd = '-';
}
?>
<tr>
<td><?php echo $value['CurrencyId']; ?></td>
<td><?php echo $value['Symbol']; ?></td>
<td><?php echo $value['Total']; ?></td>
<td><?php echo $value['Available']; ?></td>
<td><?php echo $value['Unconfirmed']; ?></td>
<td><?php echo $value['HeldForTrades']; ?></td>
<td><?php echo $value['PendingWithdraw']; ?></td>
<td><?php echo $value['Address']; ?></td>
<td><?php echo $value['Status']; ?></td>
<td><?php echo $value['StatusMessage']; ?></td>
<td><?php echo $usd; ?></td>
</tr>
<?php }}} ?>
<?php } ?>
<?php if($exchange_id == 2){ ?>
<?php
if(!empty($get_bal)){
foreach ($get_bal as $key => $value) {
if($value['free']  != 0){
$url = 'https://api.cryptonator.com/api/ticker/'.strtolower($value['asset']).'-usd/';
$get_data = dynamic_curl($url);
if(!empty($get_data['ticker'])){
$usd = convert_number($value['free'],$get_data['ticker']['price']);
}else{
$usd = '-';
}
?>
<tr>
<td><?php echo $value['asset']; ?></td>
<td><?php echo $value['free']; ?></td>
<td><?php echo $value['locked']; ?></td>
<td><?php echo $usd; ?></td>
</tr>
<?php }}} ?>
<?php } ?>
<?php if($exchange_id == 3){ ?>
<?php
if(!empty($get_bal)){
foreach ($get_bal as $key => $value) {
if($value  != 0){
$url = 'https://api.cryptonator.com/api/ticker/'.strtolower($key).'-usd/';
$get_data = dynamic_curl($url);
if(!empty($get_data['ticker'])){
$usd = convert_number($value,$get_data['ticker']['price']);
}else{
$usd = '-';
}
?>
<tr>
<td><?php echo $key; ?></td>
<td><?php echo $value; ?></td>
<td><?php echo $usd; ?></td>
</tr>
<?php }}} ?>
<?php } ?>
<?php if($exchange_id == 4){ ?>
<?php
if(!empty($get_bal)){
foreach ($get_bal as $key => $value) {
if($value['Available']  != 0){
$coin = number_format($value['Available'],8);
$url = 'https://api.cryptonator.com/api/ticker/'.strtolower($value['Currency']).'-usd/';
$get_data = dynamic_curl($url);
if(!empty($get_data['ticker'])){
$usd = convert_number($coin,$get_data['ticker']['price']);
}else{
$usd = '-';
}
?>
<tr>
<td><?php echo $value['Currency']; ?></td>
<td><?php echo number_format($value['Balance'],8); ?></td>
<td><?php echo $coin; ?></td>
<td><?php echo $value['Pending']; ?></td>
<td><?php echo $usd; ?></td>
<td><?php echo $value['CryptoAddress']; ?></td>
</tr>
<?php }}} ?>
<?php } ?>
</tbody>
</tbody>
</table>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</section>
@endsection
