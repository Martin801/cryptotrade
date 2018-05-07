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
    background: url('https://www.tof-paris.com/_t/_/images/loading.svg') no-repeat center center; 
    background-size: 50px 50px;
    background-color: rgba(241, 242, 249, .4);
}    
</style>
<section class="content-header">
<h1>Bot <small>List</small></h1>
</section>
<section class="content">
<div id="preloader" style="display: none;"></div>    
<div class="row">
<div class="col-md-12">
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal" style="margin-bottom: 20px;">Add L & SL</button>  
<div class="panel panel-default">
<div class="panel-heading"> <?php echo strtoupper('Bot List'); ?></div>
<div class="panel-body">
<div class="box box-primary">
<div class="box-header with-border">
<table  class="display table_c" cellspacing="0" width="100%">
<thead>
<tr>
    <th>Exchange Name</th>
    <th>Exchange Type</th>
    <th>Base Currency</th>
    <th>Trade Curency</th>
    <th>L & SL Type</th>
    <th>Qty</th>
    <th>Persentage</th>
    <th>TimeStamp</th>
    <th>Edit</th>
    <th>Delete</th>
</tr>
</thead>
<tbody>
<?php    
if(!empty($get_lsl)){
foreach ($get_lsl as $key => $value)
{  
$get_bot = DB::table('bots')->where('id', $value->bot_id)->get(); 
$get_exchange = DB::table('exchange')->where('id', $get_bot[0]->exchange_id)->get(); 
?>
<tr>
    <td><?php echo $get_exchange[0]->name; ?></td>
    <td><?php echo $get_bot[0]->type; ?></td>
    <td><?php echo $get_bot[0]->currency; ?></td>
    <td><?php echo $get_bot[0]->currency_to_spend_earn; ?></td>
    <td><?php echo ($value->type == 'L')? 'Limit' : 'Stop Loss'; ?></td>
    <td><?php echo $value->qty; ?></td>
    <td><?php echo $value->persentage; ?></td>
    <td><?php echo $value->created_date; ?></td>
    <td><?php if($get_bot[0]->status == 'Pending'){ ?> 
        <a href="#myModal_<?php echo $value->id; ?>" data-toggle="modal"><span class="glyphicon glyphicon-pencil"></span></a> <?php } ?>
    </td>
    <td><?php if($get_bot[0]->status == 'Pending'){ ?> 
        <a href="{{URL::to('/delete-lsl')}}<?php echo '/'.$value->id.'/'.$value->bot_id; ?>"><span class="glyphicon glyphicon-trash"></span></a> <?php } ?>
    </td>
</tr>

<div id="myModal_<?php echo $value->id; ?>" class="modal fade" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Update L & SL</h4>
</div>
<div class="modal-body">
<form method="POST" action="{{url('update-lsl')}}">
{{ csrf_field() }}    
<input type="hidden" name="id" value="<?php echo $value->id; ?>">
<input type="hidden" name="bot_id" value="<?php echo $value->bot_id; ?>">
<div class="form-group"> 
<label for="Select Exchange">Select Type</label> 
<select class="form-control" id="type" name="type">
<option value="">Select Type</option>     
<option value="L" <?php if('L' == $value->type){?> selected <?php } ?>>Limit</option>  
<option value="SL" <?php if('SL' == $value->type){?> selected <?php } ?>>Stop Loss</option>  
</select>
</div>
<div class="form-group">
<label for="Qty">Qty</label>     
<input type="text" value="<?php echo $value->qty; ?>" placeholder="Qty" id="qty" name="qty"  class="form-control"> 
</div>
<div class="form-group"> 
<label for="Persentage">Persentage (%)</label> 
<input type="text" value="<?php echo $value->persentage; ?>" placeholder="Persentage" id="persentage" name="persentage" class="form-control">  
</div>
<button type="submit" class="btn btn-danger">Update</button> 
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

<div id="myModal" class="modal fade" role="dialog">
<div class="modal-dialog">
<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal">&times;</button>
<h4 class="modal-title">Create L & SL</h4>
</div>
<div class="modal-body">
<form method="POST" action="{{url('create-lsl')}}">
{{ csrf_field() }}    
<input type="hidden" name="bot_id" value="<?php echo $get_id; ?>">
<div class="form-group"> 
<label for="Select Exchange">Select Type</label> 
<select class="form-control" id="type" name="type">
<option value="">Select Type</option>     
<option value="L">Limit</option>  
<option value="SL">Stop Loss</option>  
</select>
</div>
<div class="form-group">
<label for="Qty">Qty</label>     
<input type="text" value="" placeholder="Qty" id="qty" name="qty"  class="form-control"> 
</div>
<div class="form-group"> 
<label for="Persentage">Persentage (%)</label> 
<input type="text" value="" placeholder="Persentage" id="persentage" name="persentage" class="form-control">  
</div>
<button type="submit" class="btn btn-danger">Create</button> 
</form>
</div>
</div>
</div>
</div>

</div>
</section>
@endsection