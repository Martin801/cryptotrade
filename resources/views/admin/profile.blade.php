@extends('layouts.app')
@section('content')
<section class="content">
<div class="row">
<div class="col-xs-12">
<div class="box">
<div class="box-header">
<h3 class="box-title">Update Admin Profile</h3>
</div>
<div>
<div class="box box-primary">
<form role="form" method="POST" enctype="multipart/form-data" action="{{URL::to('/admin/user/adminUpdate')}}">
{{ csrf_field() }}
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
<div class="col-md-4">
<div class="form-group">
<label for="Name">Name</label>
<input class="form-control" value="<?php echo $user_details[0]->name; ?>" id="name" name="name" placeholder="Name" type="input">
</div>
</div>
<div class="col-md-4">
<div class="form-group">
<label for="Email">Email</label>
<input class="form-control" value="<?php echo $user_details[0]->email; ?>" id="email" name="email" placeholder="Email" type="email">
</div>
</div>
<div class="col-md-4">
<div class="form-group">
<label for="Profile Picture">Profile Picture</label>
<input type="file" class="form-control" name="input_img">
</div>
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

