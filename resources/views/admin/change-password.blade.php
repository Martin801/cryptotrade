@extends('layouts.app')
@section('content')
<section class="content">
<div class="row">
<div class="col-xs-12">
<div class="box">
<div class="box-header">
<h3 class="box-title">Update Password</h3>
</div>
<div>
<div class="box box-primary">
<form role="form" method="POST" enctype="multipart/form-data" action="{{URL::to('admin/update-password')}}">
{{ csrf_field() }}
<div class="box-body">
<div class="col-md-12">
<?php if(!empty(session('success_message'))){ ?>
<div class="alert alert-success alert-dismissible">
<?php echo session('success_message');session()->forget('success_message'); ?>
</div>
<?php } ?>
<?php if(!empty(session('error_message'))){ ?>
<div class="alert alert-danger alert-dismissible">
<?php echo session('error_message');session()->forget('error_message'); ?>
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
<div class="col-md-6">
<div class="form-group">
<label for="Old Password">Old Password</label>
<input class="form-control" value="" id="old_password" name="old_password" placeholder="" type="password">
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<label for="New Password">New Password</label>
<input class="form-control" value="" id="new_password" name="new_password" placeholder="" type="password">
</div>
</div>
<div class="col-md-12">
<div class="box-footer">
<button type="submit" class="btn btn-primary">Submit</button>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
</section>
@endsection

