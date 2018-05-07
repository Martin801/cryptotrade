@extends('layouts.app')
@section('content')
<section class="content">
<div class="row">
<div class="col-xs-12">
<?php if(!empty(session('success_message'))){ ?>
<div class="alert alert-success alert-dismissible">
<?php echo session('success_message');session()->forget('success_message'); ?>
</div>
<?php } ?>	
<div class="box">
<div class="box-header">
<h3 class="box-title">User List</h3>
<a href="{{URL::to('/admin/user/add/0')}}" style="float: right;width:10%;" class="btn btn-block btn-danger">Create User</a>
</div>
<!-- /.box-header -->
<div class="box-body">
<table class="table table-bordered table-hover">
<thead>
<tr>
<th>Name</th>
<th>Email</th>
<th>Phone</th>
<th>Address</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php if(!empty($user_arr)){ ?>
<?php foreach($user_arr as $user){ ?>
<tr>
<td><?php echo strtoupper($user->name) ?></td>
<td><?php echo $user->email ?></td>
<td><?php echo $user->phone ?></td>
<td><?php echo $user->address ?></td>
<td><?php echo !empty($user->status)? '<span class="badge bg-green">Active</span>':'<span class="badge bg-red">Inactive</span>'; ?></td>
<td>
<a href="{{URL::to('/admin/user/add/'.$user->id)}}" style="margin-right: 10px;"><span class="glyphicon glyphicon-pencil"></span></a>
<a href="{{URL::to('/admin/user/delete/'.$user->id)}}"><span class="glyphicon glyphicon-trash"></span></a></td>
</tr>
<?php } ?>
<?php } ?>
</tbody>
</table>
</div>
</div>
</div>
</div>
</section>
@endsection

