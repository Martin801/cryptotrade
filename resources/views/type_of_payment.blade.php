@extends('layouts.front')
@section('content')
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<?php
if(!empty($result)){
?>
<div class="panel panel-default">
<div class="panel-heading">BTC Payment Address</div>
<div class="panel-body">
<a href="{{URL::to('/login')}}" class="btn btn-danger pull-right">Login</a>
<a href="{{URL::to('/')}}" class="btn btn-success">Home Page</a>
<div style="padding: 10px; margin-bottom: 10px;">
<table  class="table table-bordered" cellspacing="0" width="100%">
<tr>
<th>Transaction ID</th>
<td><?php echo $result['result']['txn_id']; ?></td>
</tr>
<tr>
<th>Address ID</th>
<td><?php echo $result['result']['address']; ?></td>
</tr>
<tr>
<th>Status URL</th>
<td><a class="btn btn-info" href="<?php echo $result['result']['status_url']; ?>" target="_blank">Click Me For More Details</a></td>
</tr>
<tr>
<th>QRC CODE</th>
<td><img src="<?php echo $result['result']['qrcode_url']; ?>"></td>
</tr>
</table>
</div>
</div>
</div>
<?php	
}else{
?>
<div class="panel panel-default">
<div class="panel-heading">Payment</div>
<div class="panel-body">
<a href="{{URL::to('/login')}}" class="btn btn-danger pull-right">Login</a>
<a href="{{URL::to('/')}}" class="btn btn-success">Home Page</a>
<h1>Select Payment Type</h1>
<form class="form-horizontal" role="form" method="POST" action="{{URL::to('/register/type-of-payment')}}">
{{ csrf_field() }}	
<div style="padding: 10px; margin-bottom: 10px;">
<select id="type_of_payment_id" name="type_of_payment_id" class="form-control">
<option value="1">Paypal</option>
<option value="2">Coinpayments (BTC)</option>
</select>
</div>
<button type="submit" class="btn btn-info">Pay Now</button>
</form>
</div>
</div>
<?php
}	
?>
</div>
</div>
</div>
@endsection
