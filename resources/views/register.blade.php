@extends('layouts.front')
@section('content')
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
<div class="panel-heading">User Register</div>
<div class="panel-body">
<a href="{{URL::to('/login')}}" class="btn btn-danger pull-right">Login</a>
<a href="{{URL::to('/')}}" class="btn btn-success">Home Page</a>
<form class="form-horizontal" role="form" method="POST" action="{{URL::to('/register/save')}}">
<?php if(!empty(session('signup_message'))){ ?>
<div class="alert-success alert-dismissible" style="padding: 14px; text-align: center;  margin-bottom: 10px;">
<?php echo session('signup_message');session()->forget('signup_message'); ?>
<script> window.location.href = "{{URL::route('addmoney.paypal')}}"; </script>
</div>
<?php } ?>
{!! csrf_field() !!}
<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
<label class="col-md-3 control-label">Name</label>
<div class="col-md-6">
<input type="name" class="form-control" name="name" value="{{ old('name') }}">
@if ($errors->has('name'))
<span class="help-block">
<strong>{{ $errors->first('name') }}</strong>
</span>
@endif
</div>
</div>
<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
<label class="col-md-3 control-label">E-Mail</label>
<div class="col-md-6">
<input type="email" class="form-control" name="email" value="{{ old('email') }}">
@if ($errors->has('email'))
<span class="help-block">
<strong>{{ $errors->first('email') }}</strong>
</span>
@endif
</div>
</div>
<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
<label class="col-md-3 control-label">Password</label>
<div class="col-md-6">
<input type="password" class="form-control" name="password">
@if ($errors->has('password'))
<span class="help-block">
<strong>{{ $errors->first('password') }}</strong>
</span>
@endif
</div>
</div>
<div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
<label class="col-md-3 control-label">Phone</label>
<div class="col-md-6">
<input type="phone" class="form-control" name="phone">
@if ($errors->has('phone'))
<span class="help-block">
<strong>{{ $errors->first('phone') }}</strong>
</span>
@endif
</div>
</div>
<div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
<label class="col-md-3 control-label">Address</label>
<div class="col-md-6">
<textarea name="address" style="margin: 0px; height: 197px; width: 341px; resize: none;"></textarea>
@if ($errors->has('address'))
<span class="help-block">
<strong>{{ $errors->first('address') }}</strong>
</span>
@endif
</div>
</div>
<div class="form-group">
<div class="col-md-6 col-md-offset-3">
<button type="submit" class="btn btn-primary">Sign Up</button>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
</div>
@endsection
