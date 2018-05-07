@extends('layouts.front')
@section('content')
<div class="container">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
<div class="panel-heading">Membership Plan</div>
<div class="panel-body">
<a href="{{URL::to('/login')}}" class="btn btn-danger pull-right">Login</a>
<a href="{{URL::to('/')}}" class="btn btn-success">Home Page</a>
<h1>Membership Plans</h1>
{!! csrf_field() !!}
<?php if(!empty($bitcoin_membership_arr)){ ?>
<div style="padding: 10px; margin-bottom: 10px;">
<select id="membershipplan" class="form-control">
<option value="-1">Select Membership Plan</option>
<?php foreach($bitcoin_membership_arr as $bitcoin_membership){ ?>
<option value="<?php echo $bitcoin_membership->name; ?>"><?php echo $bitcoin_membership->name; ?></option>
<?php } ?>
</select>
<div class="clearfix"></div>
</div>
<div id="addfield"></div>
<div id=adddurationfield></div>
<div id="plandetails"></div>
<?php } ?>
</div>
</div>
</div>
</div>
</div>
@endsection
