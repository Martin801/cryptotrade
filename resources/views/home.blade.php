@extends('layouts.user')
@section('content')
<?php
function dynamic_curl($url = '')
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
function formate_num($val)
{
    return number_format($val,12);
}
?>
<style type="text/css">
#preloader{
    position: fixed;
    left: 0;
    top: 0;
    z-index: 999999999999999999;
    width: 100%;
    height: 100%;
    overflow: visible;
    background: url('http://signsanddecal.com/images/LoaderA_sign.gif') no-repeat center center;
    background-color: rgba(255, 255, 255, 1);
}
</style>
<section class="content-header">
<h1>Dashboard<small>Panel</small></h1>
</section>
<section class="content">
<?php
$get_admin_details = DB::table('users')->where('id', 1)->get()->toarray();
if(!empty($get_admin_details[0]->user_msg)){
?>
<div class="callout callout-info">
<p><?php echo $get_admin_details[0]->user_msg; ?></p>
</div>
<?php   
}
?>
<div class="row">
<div class="col-lg-4 col-xs-6">
<div class="small-box bg-yellow">
<div class="inner">
<h3><?php echo DB::table('bots')->where('user_id',session('user_id'))->count(); ?></h3>
<p>BOT</p>
</div>
<div class="icon">
<i class="fa fa-circle-o"></i>
</div>
<a href="{{URL::to('bot')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
</div>
</div>
<div class="col-lg-4 col-xs-6">
<div class="small-box bg-red">
<div class="inner">
<h3><?php echo DB::table('bots')->where('user_id',session('user_id'))->where('status','Pending')->count(); ?></h3>
<p>PENDING BOT</p>
</div>
<div class="icon">
<i class="fa fa-circle-o"></i>
</div>
<a href="{{URL::to('bot')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
</div>
</div>
<div class="col-lg-4 col-xs-6">
<div class="small-box bg-green">
<div class="inner">
<h3><?php echo DB::table('bots')->where('user_id',session('user_id'))->where('status','Success')->count(); ?></h3>
<p>SUCCESS BOT</p>
</div>
<div class="icon">
<i class="fa fa-circle-o"></i>
</div>
<a href="{{URL::to('bot')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
</div>
</div>
</div>
<div class="row">
<div class="col-md-12">
<div class="nav-tabs-custom">
<ul class="nav nav-tabs">
<li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Britrex</a></li>
</ul>
<div class="tab-content">
<div class="tab-pane active" id="tab_1">
<div class="table-responsive">
<table class="table table-bordered table-hover dataTable table_c" cellspacing="0" width="100%">
<thead>
<tr>
    <th>Label</th>
    <th>High</th>
    <th>Low</th>
    <th>Volume</th>
    <th>Last</th>
    <th>BaseVolume</th>
    <th>Bid</th>
    <th>Ask</th>
    <th>OpenBuyOrders</th>
    <th>OpenSellOrders</th>
    <th>PrevDay</th>
    <th>Created</th>
    <th>TimeStamp</th>
</tr>
</thead>
<tbody id="britrex_tbody">
<?php
$url = "https://bittrex.com/api/v1.1/public/getmarketsummaries";
$get_result  = dynamic_curl($url);
if(!empty($get_result['result'])){
foreach ($get_result['result'] as $key => $value)
{
?>
<tr>
    <td><?php echo $value['MarketName']; ?></td>
    <td><?php echo formate_num($value['High']); ?></td>
    <td><?php echo formate_num($value['Low']); ?></td>
    <td><?php echo $value['Volume']; ?></td>
    <td><?php echo formate_num($value['Last']); ?></td>
    <td><?php echo $value['BaseVolume']; ?></td>
    <td><?php echo formate_num($value['Bid']); ?></td>
    <td><?php echo formate_num($value['Ask']); ?></td>
    <td><?php echo $value['OpenBuyOrders']; ?></td>
    <td><?php echo $value['OpenSellOrders']; ?></td>
    <td><?php echo formate_num($value['PrevDay']); ?></td>
    <td><?php echo $value['Created']; ?></td>
    <td><?php echo $value['TimeStamp']; ?></td>
</tr>
<?php
}
}
?>
</tbody>
</table>
</div>
</div>

</div>
</div>
</div>
</div>
</section>    
@endsection
