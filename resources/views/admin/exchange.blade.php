@extends('layouts.app')
@section('content')
<section class="content">
<div class="row">
<div class="col-xs-12">
<div class="box">
<div class="box-header">
<h3 class="box-title">Exchange List</h3>
<!-- <a href="{{URL::to('/admin/exchange/add/0')}}" style="float: right;width:15%;" class="btn btn-block btn-primary">Create Exchange</a> -->
</div>
<!-- /.box-header -->
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
<?php if(!empty($exchange_arr)){ ?>
<?php foreach($exchange_arr as $exchange){ ?>
<tr>
<td><?php echo $exchange->name; ?></td>
<td><?php echo !empty($exchange->status) ? '<span class="badge bg-green">Active</span>':'<span class="badge bg-red">Inactive</span>' ; ?></td>
<td><a href="{{URL::to('/admin/exchange/add/'.$exchange->id)}}"><span class="glyphicon glyphicon-pencil"></span></a></td>
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

