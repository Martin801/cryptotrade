@extends('layouts.app')
@section('content')
<section class="content">
<div class="row">
<div class="col-xs-12">
<div class="box">
<div class="box-header">
<h3 class="box-title">Setting</h3>
</div>
<div>
<div class="box box-primary">
<form role="form" method="POST" enctype="multipart/form-data" action="{{URL::to('/admin/setting')}}">
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
<div class="col-md-12">
<div class="form-group">
<label for="Message For The User">Message For The User</label>
<textarea class="form-control" style="height: 80px; resize: none;" name="user_msg"><?php echo $user_details[0]->user_msg; ?></textarea>
</div>
</div>
</div>
<!-- /.box-body -->
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

