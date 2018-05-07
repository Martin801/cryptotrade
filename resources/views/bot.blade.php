@extends('layouts.user')
@section('content')
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
<h1>Bot <small>listing</small></h1>
</section>
<section class="content">
<div id="preloader" style="display: none;"></div>
<div class="row">
<div class="col-md-12">
<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#myModal" style="margin-bottom: 20px;">Add BOT</button>
<div class="panel panel-default">
<div class="panel-heading"> <?php echo strtoupper('Bot List'); ?></div>
<div class="panel-body">
<div class="box box-primary">
<div class="box-header with-border">
<div class="table-responsive">
<table  class="table table-bordered" cellspacing="0" width="100%">
<thead>
<tr>
    <th>BOT Name</th>
    <th>Exchange Name</th>
    <th>Type</th>
    <th>Base Currency</th>
    <th>Currency to Pump</th>
    <th>Quantity to Spend</th>
    <th>BOT Status</th>
    <th>TimeStamp</th>
    <th>Details</th>
    <th>Delete</th>
</tr>
</thead>
<tbody>
<?php
if(!empty($bot)){
foreach ($bot as $key => $value){
$get_exchange       = DB::table('exchange')->where('id', $value->exchange_id)->get();
$get_count          = DB::table('bots')->where('parent_id', $value->id)->count();
$get_count_payment  = DB::table('robot_tradess')->where('bot_id', $value->id)->count();
?>
<tr>
<td><?php echo $value->name; ?></td>
<td><?php echo $get_exchange[0]->name; ?></td>
<td><?php echo ($value->type == 'Buy')? '<button type="button" class="btn btn-info">Buy</button>' : '<button type="button" class="btn btn-warning">Sell</button>' ; ?></td>
<td><?php echo $value->currency; ?></td>
<td><?php echo $value->currency_to_spend_earn; ?></td>
<td><?php echo ($value->type == 'Buy')? $value->qty : ''; ?></td>
<td><?php echo ($value->status == 'Pending')? '<button type="button" class="btn btn-danger">Pending</button>' : '<button type="button" class="btn btn-success">Success</button>' ; ?>
</td>
<td><?php echo $value->created_date; ?></td>
<td>
<?php if($value->type == 'Sell'){ ?>
<a href="#detils_<?php echo $value->id; ?>" data-toggle="modal" class="btn btn-warning">Details</a>
<?php }else{
if($value->status != 'Pending'){ ?>
<a href="#buy_details_<?php echo $value->id; ?>" data-toggle="modal" class="btn btn-info">Details</a>
<?php }} ?>
</td>
<td>
<?php if($value->status == 'Pending'){ ?>
<a href="{{URL::to('/delete-bot')}}<?php echo '/'.$value->id; ?>"><span class="glyphicon glyphicon-trash"></span></a>
<?php } ?>
<div id="detils_<?php echo $value->id; ?>" class="modal fade" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Sell Details</h4>
</div>
<div class="modal-body">
<table  class="table table-bordered" cellspacing="0" width="100%">
<tr>
<th>Quantity Limit One</th>
<td><?php echo $value->qty; ?></td>
</tr>
<tr>
<th>Profit (%) Limit One</th>
<td><?php echo $value->amount; ?></td>
</tr>
<tr>
<th>Quantity Limit Two</th>
<td><?php echo $value->qty_limit; ?></td>
</tr>
<tr>
<th>Profit (%) Limit Two</th>
<td><?php echo $value->amount_limit; ?></td>
</tr>
<tr>
<th>Quantity Stop Loss One</th>
<td><?php echo $value->qty_stop_loss_one; ?></td>
</tr>
<tr>
<th>Stop Loss (%) One</th>
<td><?php echo $value->amount_stop_loss_one; ?></td>
</tr>
<tr>
<th>Quantity Stop Loss Two</th>
<td><?php echo $value->qty_stop_loss_two; ?></td>
</tr>
<tr>
<th>Stop Loss (%) Two</th>
<td><?php echo $value->amount_stop_loss_two; ?></td>
</tr>
</table>
</div>
</div>
</div>
</div>
<?php
if($get_count_payment > 0){
$get_payment_details = DB::table('robot_tradess')->where('bot_id', $value->id)->get();
?>
<div id="buy_details_<?php echo $value->id; ?>" class="modal fade" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Buy Details</h4>
</div>
<div class="modal-body">
<table  class="table table-bordered" cellspacing="0" width="100%">
<tr>
<th>Base Currency</th>
<td><?php echo $value->currency; ?></td>
</tr>
<tr>
<th>Unit</th>
<td><?php echo $get_payment_details[0]->volume; ?></td>
</tr>
<tr>
<th>Price</th>
<td><?php echo $get_payment_details[0]->price; ?></td>
</tr>
</table>
</div>
</div>
</div>
</div>
<?php } ?>
</td>
</tr>
<?php
}
}
?>
</tbody>
</table>
{{ $bot->links() }}
</div>
</div>
</div>
</div>
</div>
</div>
<div id="myModal" class="modal fade" role="dialog">
<div class="modal-dialog modal-lg">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title"><center>CREATE BOT</center></h4>
</div>
<div class="modal-body">
<div class="row">
<div class="col-md-6">
<div class="form-group">
<label for="Select Exchange">Select Exchange</label>
<select style="width:100%" class="form-control" id="exchange_id_form" name="exchange_id" onchange="get_currency(this.value);">
<option value="">Select Exchange</option>
<?php
if(!empty($exc)){
foreach ($exc as $result) {
if($result->id == 4 || $result->id == 3){      
$get_count_exchange  = DB::table('membership_exchange_rel')
                       ->where('membership_id', session('membership_id_session'))->where('exchange_id', $result->id)->count();
if($get_count_exchange > 0){
?>
<option value="<?php echo $result->id;?>"><?php echo $result->name;?></option>
<?php }}}} ?>
</select>
</div>
<div class="form-group">
<label for="Select Base Currency">Base Currency</label>
<select style="width:100%" class="form-control sel" id="currency_form" name="currency" >
<option value="">Select Currency</option>
</select>
</div>
<div class="form-group">
<label for="Select Trading Currency">Currency to Pump</label>
<select style="width:100%" class="form-control sel" id="currency_to_spend_earn_form"  name="currency_to_spend_earn" >
<option value="">Select Currency</option>
</select>
</div>
<div class="form-group">
<label for="Qty">Quantity to Spend</label>
<input type="text" value="" id="qty_form" name="qty"  class="form-control">
</div>
<p id="msg" style="font-size: 20px; color: red; text-align: center; margin-top: 110px;"></p>
</div>
<div class="col-md-6">
<legend style="color: green; font-size: 17px; text-align: left;">Limit One:</legend>
<div class="form-group">
<label for="Qty">Qty To Spend</label>
<input type="text" value="" placeholder="Qty" id="qty_one_form" name="qty_one"  class="form-control">
</div>
<div class="form-group">
<label for="Amount">Profit Persentage (%)</label>
<input type="text" value="" placeholder="Profit Persentage (%)" id="amount_form" name="amount" class="form-control">
</div>
<legend style="color: green; font-size: 17px; text-align: left;">Limit Two:</legend>
<div class="form-group">
<label for="Qty">Qty To Spend</label>
<input type="text" value="" placeholder="Qty" id="qty_limit_form" name="qty_limit"  class="form-control">
</div>
<div class="form-group">
<label for="Amount">Profit Persentage (%)</label>
<input type="text" value="" placeholder="Profit Persentage (%)" id="amount_limit_form" name="amount_limit" class="form-control">
</div>
<legend style="color: green; font-size: 17px; text-align: left;">Stop Limit One:</legend>
<div class="form-group">
<label for="Qty">Qty To Spend</label>
<input type="text" value="" placeholder="Qty" id="qty_stop_loss_one_form" name="qty_stop_loss_one"  class="form-control">
</div>
<div class="form-group">
<label for="Amount">Loss Persentage (%)</label>
<input type="text" value="" placeholder="Profit Persentage (%)" id="amount_stop_loss_one_form" name="amount_stop_loss_one" class="form-control">
</div>
<legend style="color: green; font-size: 17px; text-align: left;">Stop Limit Two:</legend>
<div class="form-group">
<label for="Qty">Qty To Spend</label>
<input type="text" value="" placeholder="Qty" id="qty_stop_loss_two_form" name="qty_stop_loss_two"  class="form-control">
</div>
<div class="form-group">
<label for="Amount">Loss Persentage (%)</label>
<input type="text" value="" placeholder="Profit Persentage (%)" id="amount_stop_loss_two_form" name="amount_stop_loss_two" class="form-control">
</div>
</div>
<div class="col-md-12">
<button type="button" class="btn btn-success btn-lg" onclick="create_bot();">Create BOT</button>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</section>
<script type="text/javascript">
function get_currency(id)
{
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: "{{URL::to('get-currency-ajax')}}",
        type: "post",
        dataType: 'html',
        beforeSend: function(){
        $('#preloader').show();
        },
        data: {
            'id':id,
            '_token': CSRF_TOKEN,
        },
        success: function(data){
        $('#preloader').hide();
        $('.sel').html('');
        $('.sel').html(data);
        }
    });
}
function create_bot()
{
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $.ajax({
        url: "{{URL::to('create-bot')}}",
        type: "post",
        dataType: 'html',
        beforeSend: function(){
        $('#preloader').show();
        },
        data: {
            '_token': CSRF_TOKEN,
            'exchange_id': $("#exchange_id_form").val(),
            'currency': $("#currency_form").val(),
            'currency_to_spend_earn': $("#currency_to_spend_earn_form").val(),
            'qty': $("#qty_form").val(),
            'qty_one': $("#qty_one_form").val(),
            'amount': $("#amount_form").val(),
            'qty_limit': $("#qty_limit_form").val(),
            'amount_limit': $("#amount_limit_form").val(),
            'qty_stop_loss_one': $("#qty_stop_loss_one_form").val(),
            'amount_stop_loss_one': $("#amount_stop_loss_one_form").val(),
            'qty_stop_loss_two': $("#qty_stop_loss_two_form").val(),
            'amount_stop_loss_two': $("#amount_stop_loss_two_form").val(),
        },
        success: function(data){
        $('#preloader').hide();
        if(data == 'SUCCESS'){
        location.reload();
        }else{
        $('#msg').html(data);
        }
        }
    });
}
</script>
@endsection
