@extends('layouts.app')
@section('content')
<section class="content">
<div class="row">
<div class="col-xs-12">
<div class="box">
<div class="box-header">
<h3 class="box-title"><?php echo !empty($user_arr[0]->id)?'Edit':'Add'; ?> User</h3>
<a href="{{URL::to('/admin/user/')}}" style="float: right;width:15%;" class="btn btn-block btn-success">User List</a>
</div>
<div>
<div class="box box-primary">
<form role="form" method="POST" action="{{URL::to('/admin/user/save')}}">
{{ csrf_field() }}
<input type="hidden" id="id" name="id" value="<?php echo !empty($user_arr[0]->id)?$user_arr[0]->id:''; ?>" />

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
<input class="form-control" value="<?php echo !empty($user_arr[0]->name)?$user_arr[0]->name:''; ?>" id="name" name="name" placeholder="Name" type="input">
</div>

<div class="form-group">
<label for="Email">Email</label>
<input class="form-control" value="<?php echo !empty($user_arr[0]->email)?$user_arr[0]->email:''; ?>" id="email" name="email" placeholder="Email" type="email">
</div>

<div class="form-group">
<label for="Phone">Password</label>
<input class="form-control" value="" id="password" name="password" placeholder="Password" type="password">
</div>

<div class="form-group">
<label for="Phone">Phone</label>
<input class="form-control" value="<?php echo !empty($user_arr[0]->phone)?$user_arr[0]->phone:''; ?>" id="phone" name="phone" placeholder="Phone" type="phone">
</div>

<div class="form-group">
<label for="Address">Address</label>
<textarea style="resize: none;" class="form-control" rows="3" id="address" name="address" placeholder="Address"><?php echo !empty($user_arr[0]->address)?$user_arr[0]->address:''; ?></textarea>
</div>

<div class="form-group">
<label for="status">Status</label>
<select class="form-control" name="status">
<option value="1" <?php if(isset($user_arr[0]->status) && ($user_arr[0]->status == 1)){ ?> selected <?php } ?>>Active</option>
<option value="0" <?php if(isset($user_arr[0]->status) && ($user_arr[0]->status == 0)){ ?> selected <?php } ?>>InActive</option>
</select>
</div>

</div>
<div class="box-footer">
<button type="submit" class="btn btn-primary">Submit</button>
</div>
</form>


</div>
</div>
</div>
</div>
</div>
</section>
@endsection

