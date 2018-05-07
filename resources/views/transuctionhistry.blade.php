@extends('layouts.user')
@section('content')

<section class="content-header">
<h1>Transaction <small>History</small></h1>
</section>
<section class="content">
<div class="row">
<div class="col-md-12">
<div class="panel panel-default">
<div class="panel-heading">Transaction  History</div>
<div class="panel-body">
<div class="box box-primary">
<form role="form">
<div class="box-body">
<table id="example" class="table table-bordered" cellspacing="0" width="100%">
<thead>
<tr>
<th>BOT Name</th>
<th>Exchange Name</th>
<th>Market</th>
<th>Trade Type</th>
<th>Qty</th>
<th>Price</th>
<th>Profit OR Loss</th>
{{-- <th>API Return Data</th> --}}
<th>Datetime</th>
</tr>
</thead>
<tbody>
<?php
if(!empty($user_history)){
foreach ($user_history as $key => $value) {
$get_bot_details = DB::table('bots')->where('id', $value->bot_id)->get();
$get_exchange    = DB::table('exchange')->where('id', $value->exchange_id)->get();
?>
<tr>
<td><?php echo !empty($get_bot_details[0]->name)? $get_bot_details[0]->name : '-' ; ?></td>
<td><?php echo !empty($get_exchange[0]->name)? $get_exchange[0]->name : '-'; ?></td>
<td><?php echo $value->market; ?></td>
<td><?php echo $value->type_of_trade; ?></td>
<td><?php echo $value->volume; ?></td>
<td><?php echo $value->price; ?></td>
<td>
<?php
if(!empty($value->type)){
if($value->type == 'Profit'){
echo '<center><a href="#details_'.$value->robot_id.'" data-toggle="modal" class="btn btn-success">Profit</a></center>';
}else{
echo '<center><a href="#details_'.$value->robot_id.'" data-toggle="modal" class="btn btn-danger">Loss</a></center>';
}
}else{
echo '<center><a href="#details_api'.$value->robot_id.'" data-toggle="modal" class="btn btn-warning">API</a></center>';
}
?>
</td>
<td><?php echo $value->datetime; ?>

<div id="details_api<?php echo $value->robot_id; ?>" class="modal fade" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">API DETAILS FOR BUY</h4>
</div>
<div class="modal-body">
<p style="word-wrap: break-word;"><?php echo $value->result; ?></p>
</div>
</div>
</div>
</div>

<div id="details_<?php echo $value->robot_id; ?>" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Result</h4>
</div>
<div class="modal-body">
<h5>BOT <?php echo !empty($get_bot_details[0]->name)? $get_bot_details[0]->name : '-'; ?></h5>
<div class="table-responsive">
<table  class="table table-bordered">
<tr>
<th>Quantity Limit One</th>
<th>Profit (%) Limit One</th>
<th>Quantity Limit Two</th>
<th>Profit (%) Limit Two</th>
<th>Quantity Stop Loss One</th>
<th>Stop Loss (%) One</th>
<th>Quantity Stop Loss Two</th>
<th>Stop Loss (%) Two</th>
</tr>
<tr>
<td><?php echo !empty($get_bot_details[0]->qty)? $get_bot_details[0]->qty : '-' ; ?></td>
<td><?php echo !empty($get_bot_details[0]->amount)? $get_bot_details[0]->amount : '-' ; ?></td>
<td><?php echo !empty($get_bot_details[0]->qty_limit)? $get_bot_details[0]->qty_limit : '-' ; ?></td>
<td><?php echo !empty($get_bot_details[0]->amount_limit)? $get_bot_details[0]->amount_limit : '-' ; ?></td>
<td><?php echo !empty($get_bot_details[0]->qty_stop_loss_one)? $get_bot_details[0]->qty_stop_loss_one : '-' ; ?></td>
<td><?php echo !empty($get_bot_details[0]->amount_stop_loss_one)? $get_bot_details[0]->amount_stop_loss_one : '-' ; ?></td>
<td><?php echo !empty($get_bot_details[0]->qty_stop_loss_two)? $get_bot_details[0]->qty_stop_loss_two : '-' ; ?></td>
<td><?php echo !empty($get_bot_details[0]->amount_stop_loss_two)? $get_bot_details[0]->amount_stop_loss_two : '-' ; ?></td>
</tr>
</table>
</div>
<h5>SELL DETAILS  <?php echo !empty($get_bot_details[0]->name)? $get_bot_details[0]->name : '-'; ?></h5>
<div class="table-responsive">
<table  class="table table-bordered">
<tr>
<th>Exchange Name</th>
<th>Market</th>
<th>Trade Type</th>
<th>Unit</th>
<th>Price</th>
<th>Hit (%)</th>
<th>Profit OR Loss</th>
<th>API DATA</th>
</tr>
<?php
if(!empty($get_bot_details[0]->id)){
$get_robot_trade_sell = DB::table('robot_tradess')->where('bot_id', $get_bot_details[0]->id)->get();
if(!empty($get_robot_trade_sell)){
foreach ($get_robot_trade_sell as $data) {
if($data->type_of_trade == 'Sell'){
$get_exchange_details    = DB::table('exchange')->where('id', $data->exchange_id)->get();
?>
<tr>
<td><?php echo !empty($get_exchange_details[0]->name)? $get_exchange_details[0]->name : '-'; ?></td>
<td><?php echo $data->market; ?></td>
<td><?php echo $data->type_of_trade; ?></td>
<td><?php echo $data->volume; ?></td>
<td><?php echo $data->price; ?></td>
<td><?php echo $data->pl_amount; ?></td>
<td><?php echo $data->type; ?></td>
<td><a href="#details_api_<?php echo $value->robot_id; ?>" data-toggle="modal" class="btn btn-warning">Details</a></td>
</tr>
<div id="details_api_<?php echo $value->robot_id; ?>" class="modal fade" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">API Details</h4>
</div>
<div class="modal-body">
<?php echo $value->result; ?>
</div>
</div>
</div>
</div>
<?php }}}} ?>
</table>
</div>
</div>
</div>
</div>
</div>

</td>
</tr>
<?php }} ?>
</tbody>
</table>
{{ $user_history->links() }}
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</section>
@endsection
