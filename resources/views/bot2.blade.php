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
<div class="container-fluid">
<div id="preloader" style="display: none;"></div>    
<div class="row">
<div class="col-md-12">
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="margin-bottom: 20px;">Add BOT</button>  
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
    <th>Currency To Buy</th>
    <th>Currency To Spend</th>
    <th>BOT Status</th>
    <th>TimeStamp</th>
    <th>Details</th>
    <th>Action</th>
    <th>Edit</th>
    <th>Delete</th>
</tr>
</thead>
<tbody>
<?php    
if(!empty($bot)){
foreach ($bot as $key => $value){  
$get_exchange = DB::table('exchange')->where('id', $value->exchange_id)->get(); 
$get_count  = DB::table('bots')->where('parent_id', $value->id)->count(); 
?>

<tr>
<td><?php echo $value->name; ?></td>
<td><?php echo $get_exchange[0]->name; ?></td>
<td><?php echo ($value->type == 'Buy')? '<button type="button" class="btn btn-info">Buy</button>' : '<button type="button" class="btn btn-warning">Sell</button>' ; ?></td>
<td><?php echo $value->currency; ?></td>
<td><?php echo $value->currency_to_spend_earn; ?></td>
<td><?php echo ($value->status == 'Pending')? '<button type="button" class="btn btn-danger">Pending</button>' : '<button type="button" class="btn btn-success">Success</button>' ; ?></td>
<td><?php echo $value->created_date; ?></td>
<td><?php if($value->type == 'Sell'){ ?> 
    <a href="#detils_<?php echo $value->id; ?>" data-toggle="modal" class="btn btn-warning">Details</a> <?php } ?>
</td>
<td>
<?php if(($get_count < 1) and ($value->type == 'Buy')){ ?> 
<a href="#myModalSell_<?php echo $value->id; ?>" data-toggle="modal" class="btn btn-primary">Sell</a> <?php } ?></td>
<td><?php if($value->status == 'Pending' && $value->type == 'Buy'){ ?> 
<a href="#myModal_<?php echo $value->id; ?>" data-toggle="modal"><span class="glyphicon glyphicon-pencil"></span></a> <?php } ?>
</td>
<td>
<a href="{{URL::to('/delete-bot')}}<?php echo '/'.$value->id; ?>"><span class="glyphicon glyphicon-trash"></span></a>
<div id="detils_<?php echo $value->id; ?>" class="modal fade" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Details</h4>
</div>
<div class="modal-body">

<table  class="table table-bordered" cellspacing="0" width="100%">
<tr>
<th>Qty Limit One</th>
<td><?php echo $value->qty; ?></td>
</tr>
<tr>
<th>Profit (%) Limit One</th>
<td><?php echo $value->amount; ?></td>
</tr>
<tr>
<th>Qty Limit Two</th>
<td><?php echo $value->qty_limit; ?></td>
</tr>
<tr>
<th>Profit Limit Two</th>
<td><?php echo $value->amount_limit; ?></td>
</tr>
<tr>
<th>Qty Stop Loss One</th>
<td><?php echo $value->qty_stop_loss_one; ?></td>
</tr>
<tr>
<th>Stop Loss (%) One</th>
<td><?php echo $value->amount_stop_loss_one; ?></td>
</tr>
<tr>
<th>Qty Stop Loss Two</th>
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
</td>
</tr>

<div id="myModalSell_<?php echo $value->id; ?>" class="modal fade" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Add Sell</h4>
</div>
<div class="modal-body">
<form method="POST" action="{{url('add-sell-bot')}}">
{{ csrf_field() }}   
<input type="hidden" name="parent_id" value="<?php echo $value->id; ?>"> 
<div class="form-group">  
<label for="Select Base Currency">Currency to Buy</label>     
<select class="form-control sel" id="currency" name="currency" >
<option value="<?php echo $value->currency_to_spend_earn; ?>"><?php echo $value->currency_to_spend_earn; ?></option>  
</select>
</div>
<div class="form-group">  
<label for="Select Trading Currency">Currency To Spend</label>    
<select class="form-control sel" id="currency_to_spend_earn" name="currency_to_spend_earn" >
<option value="<?php echo $value->currency; ?>"><?php echo $value->currency; ?></option>  
</select>
</div>
<legend style="color: red; font-size: 17px; text-align: center;">Limit One:</legend>
<div class="form-group">
<label for="Qty">Qty To Spend</label>     
<input type="text" value="<?php echo $value->qty; ?>" placeholder="Qty" id="qty" name="qty"  class="form-control"> 
</div>
<div class="form-group"> 
<label for="Amount">Profit Persentage (%)</label> 
<input type="text" value="" placeholder="Profit Persentage (%)" id="amount" name="amount" class="form-control">  
</div>
<legend style="color: red; font-size: 17px; text-align: center;">Limit Two:</legend>
<div class="form-group">
<label for="Qty">Qty To Spend</label>     
<input type="text" value="" placeholder="Qty" id="qty_limit" name="qty_limit"  class="form-control"> 
</div>
<div class="form-group"> 
<label for="Amount">Profit Persentage (%)</label> 
<input type="text" value="" placeholder="Profit Persentage (%)" id="amount_limit" name="amount_limit" class="form-control">  
</div>
<legend style="color: red; font-size: 17px; text-align: center;">Stop Limit One:</legend>
<div class="form-group">
<label for="Qty">Qty To Spend</label>     
<input type="text" value="" placeholder="Qty" id="qty_stop_loss_one" name="qty_stop_loss_one"  class="form-control"> 
</div>
<div class="form-group"> 
<label for="Amount">Loss Persentage (%)</label> 
<input type="text" value="" placeholder="Profit Persentage (%)" id="amount_stop_loss_one" name="amount_stop_loss_one" class="form-control">  
</div>
<legend style="color: red; font-size: 17px; text-align: center;">Stop Limit Two:</legend>
<div class="form-group">
<label for="Qty">Qty To Spend</label>     
<input type="text" value="" placeholder="Qty" id="qty_stop_loss_two" name="qty_stop_loss_two"  class="form-control"> 
</div>
<div class="form-group"> 
<label for="Amount">Loss Persentage (%)</label> 
<input type="text" value="" placeholder="Profit Persentage (%)" id="amount_stop_loss_two" name="amount_stop_loss_two" class="form-control">  
</div>
<button type="submit" class="btn btn-danger">Add Bot</button> 
</form>
</div>
</div>
</div>
</div>


<div id="myModal_<?php echo $value->id; ?>" class="modal fade" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Update Bot</h4>
</div>
<div class="modal-body">
<form method="POST" action="{{url('update-bot')}}">
{{ csrf_field() }}   
<input type="hidden" name="id" value="<?php echo $value->id; ?>"> 
<div class="form-group"> 
<label for="Select Exchange">Select Exchange</label> 
<select class="form-control" id="exchange_id" name="exchange_id" onchange="get_currency(this.value);">
<option value="">Select Exchange</option>     
<?php if(!empty($exc)){ 
foreach ($exc as $result) {
if( ($result->id == 4 ) || ($result->id == 1) || ($result->id == 3 )){
?>
<option value="<?php echo $result->id;?>" <?php if($result->id == $value->exchange_id){?> selected <?php } ?>><?php echo $result->name;?></option>  
<?php }}} ?> 
</select>
</div>
<div class="form-group"> 
<label for="Type">Select Type Of Trade</label>  
<select class="form-control" id="type" name="type">
<option value="Buy" <?php if('Buy' == $value->type){?> selected <?php } ?>>Buy</option>  
<!-- <option value="Sell" <?php if('Sell' == $value->type){?> selected <?php } ?>>Sell</option>   -->
</select>
</div>
<div class="form-group">  
<label for="Select Base Currency">Currency to Buy</label>     
<select class="form-control sel" id="currency" name="currency" >
<option value="<?php echo $value->currency; ?>"><?php echo $value->currency; ?></option>  
</select>
</div>
<div class="form-group">  
<label for="Select Trading Currency">Currency To Spend</label>    
<select class="form-control sel" id="currency_to_spend_earn" name="currency_to_spend_earn" >
<option value="<?php echo $value->currency_to_spend_earn; ?>"><?php echo $value->currency_to_spend_earn; ?></option>  
</select>
</div>
<div class="form-group">
<label for="Qty">Qty To Spend</label>     
<input type="text" value="<?php echo $value->qty; ?>" placeholder="Qty" id="qty" name="qty"  class="form-control"> 
</div>
<!-- <div class="form-group"> 
<label for="Amount">Amount</label> 
<input type="text" value="<?php echo $value->amount; ?>" placeholder="Amount" id="amount" name="amount" class="form-control">  
</div> -->
<button type="submit" class="btn btn-danger">Update Bot</button> 
</form>
</div>
</div>
</div>
</div>
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
<div id="myModal" class="modal fade" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Create Bot</h4>
</div>
<div class="modal-body">
<form method="POST" action="{{url('create-bot')}}">
{{ csrf_field() }}    
<div class="form-group"> 
<label for="Select Exchange">Select Exchange</label> 
<select class="form-control" id="exchange_id" name="exchange_id" onchange="get_currency(this.value);">
<option value="">Select Exchange</option>     
<?php if(!empty($exc)){ 
foreach ($exc as $result) {
if( ($result->id == 4 ) || ($result->id == 1) || ($result->id == 3 )){
?>
<option value="<?php echo $result->id;?>"><?php echo $result->name;?></option>  
<?php }}} ?> 
</select>
</div>
<div class="form-group"> 
<label for="Type">Select Type Of Trade</label>  
<select class="form-control" id="type" name="type" >
<option value="Buy">Buy</option>  
<!-- <option value="Sell">Sell</option>   -->
</select>
</div>
<div class="form-group">  
<label for="Select Base Currency">Currency to Buy</label>     
<select class="form-control sel" id="currency" name="currency" >
<option value="">Select Currency</option>  
</select>
</div>
<div class="form-group">  
<label for="Select Trading Currency">Currency To Spend</label>    
<select class="form-control sel" id="currency_to_spend_earn" name="currency_to_spend_earn" >
<option value="">Select Currency</option>  
</select>
</div>
<div class="form-group">
<label for="Qty">Qty To Spend</label>     
<input type="text" value="" placeholder="Qty" id="qty" name="qty"  class="form-control"> 
</div>
<!-- <div class="form-group"> 
<label for="Amount">Amount</label> 
<input type="text" value="" placeholder="Amount" id="amount" name="amount" class="form-control">  
</div> -->
<button type="submit" class="btn btn-danger">Create Bot</button> 
</form>
</div>
</div>
</div>
</div>

</div>
</div>
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
</script>
@endsection