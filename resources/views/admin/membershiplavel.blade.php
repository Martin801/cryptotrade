@extends('layouts.app')
@section('content')
<section class="content">
<div class="row">
<div class="col-xs-12">
<div class="box">
<div class="box-header">
<h3 class="box-title">Membership List</h3>
<a href="{{URL::to('/admin/membershiplavel/add/0')}}" style="float: right;width:15%;" class="btn btn-block btn-danger">Create Membership</a>
</div>
<div class="box-body">
<table class="table table-bordered table-hover">
<thead>
<tr>
<th>Name</th>
<th>Status</th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php if(!empty($membership_lavel_arr)){ ?>
<?php foreach($membership_lavel_arr as $membership_lavel){ ?>
<tr>
<td><?php echo $membership_lavel->name; ?></td>
<td><?php echo !empty($membership_lavel->status)? '<span class="badge bg-green">Active</span>':'<span class="badge bg-red">Inactive</span>' ; ?></td>
<td>
<a href="{{URL::to('/admin/membershiplavel/add/'.$membership_lavel->id)}}" style="margin-right: 10px;"><span class="glyphicon glyphicon-pencil"></span></a>
<a href="{{URL::to('/admin/membershiplavel/delete/'.$membership_lavel->id)}}"><span class="glyphicon glyphicon-trash"></span></a>
</td>
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

