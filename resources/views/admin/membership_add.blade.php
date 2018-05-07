@extends('layouts.app')

@section('content')
<section class="content">
<div class="row">
<div class="col-xs-12">
<div class="box">
<div class="box-header">
<h3 class="box-title"><?php echo !empty($membership_arr[0]->id)?'Edit':'Add'; ?> Membership</h3>
<a href="{{URL::to('/admin/membership/')}}" style="float: right;width:15%;" class="btn btn-block btn-success">Membership List</a>
</div>
<div>
<div class="box box-primary">
<form role="form" method="POST" action="{{URL::to('/admin/membership/save')}}">
{{ csrf_field() }}
<input type="hidden" id="id" name="id" value="<?php echo !empty($membership_arr[0]->id)?$membership_arr[0]->id:''; ?>" />
<div class="box-body">


<div class="col-md-12">
<?php if(!empty(session('success_message'))){ ?>
<div class="alert alert-success alert-dismissible">
<?php echo session('success_message');session()->forget('success_message'); ?>
</div>
<?php } ?>
@if ($errors->any()) 
<div class="alert alert-danger alert-dismissible">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&Cross;</button>
@foreach ($errors->all() as $error)
<h4>{{ $error }}</h4>
@endforeach
</div>
@endif
</div>


<div class="form-group">
<label for="Name">Name</label>
<input class="form-control" value="<?php echo !empty($membership_arr[0]->name)?$membership_arr[0]->name:''; ?>" id="name" name="name" placeholder="Name" type="input">
</div>

<div class="form-group">
<label for="Detail">Detail</label>
<textarea style="resize: none;" class="form-control" rows="3" placeholder="Detail" id="details" name="details"><?php echo !empty($membership_arr[0]->details)?$membership_arr[0]->details:''; ?></textarea>
</div>

<div class="form-group">
<label for="Membership Lavel">Membership Lavel</label>
<select id="memebershiplavel_id" name="memebershiplavel_id"  class="form-control">
<?php 
if(!empty($membership_lavel_arr)){
foreach($membership_lavel_arr as $membership_lavel){
?>
<option value="<?php echo $membership_lavel->id; ?>" ><?php echo $membership_lavel->name; ?></option>
<?php } } ?>
</select> 
</div>

<div class="form-group">
<label for="Duration in days">Duration in days</label>
<select id="duration_id" name="duration"  class="form-control">
<?php 
if(!empty($membership_duration_arr)){
foreach($membership_duration_arr as $membership_duration){
?>
<option value="<?php echo $membership_duration->id; ?>" ><?php echo $membership_duration->duration; ?></option>
<?php } }?>
</select> 
</div>

<div class="form-group">
<label for="price">Price</label>
<input class="form-control" value="<?php echo !empty($membership_arr[0]->price)?$membership_arr[0]->price:''; ?>" id="price" name="price" placeholder="Price" type="input">
</div>

<div class="form-group">
<label>Select Exchange</label>
<select id="exchange_id" name="exchange_id[]" multiple="" class="form-control">
<?php 
if(!empty($exchange_arr)){
foreach($exchange_arr as $exchange){
?>
<option value="<?php echo $exchange->id; ?>" 
<?php if(!empty($membership_exchange_rel_arr) && in_array($exchange->id,$membership_exchange_rel_arr)){ ?> selected <?php } ?> >
<?php echo $exchange->name; ?></option>
<?php
}
}
?>
</select>
</div>

<div class="form-group">
<label for="status">Status</label>
<select class="form-control" name="status">
<option value="1" <?php if(isset($membership_arr[0]->status) && ($membership_arr[0]->status == 1)){ ?> selected <?php } ?>>Active</option>
<option value="0" <?php if(isset($membership_arr[0]->status) && ($membership_arr[0]->status == 0)){ ?> selected <?php } ?>>InActive</option>
</select>
</div>

</div>
<div class="box-footer">
<button type="submit" class="btn btn-primary">Submit</button>
</div>
</form>
</div>
</div>
<!-- /.box-body -->
</div>
</div>
</div>
</section>


@endsection

