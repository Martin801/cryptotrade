@extends('layouts.user')
@section('content')
<section class="content-header">
<h1>User Activated<small>Plan</small></h1>
</section>
<section class="content">
<div class="row">
<div class="col-md-12">
<div class="panel panel-default">
<div class="panel-heading">User Activated Plan</div>
<div class="panel-body" style="text-align: center;">
<?php 
$i=0;
$totalnumberpayment = count($userdetails);
foreach ($userdetails as $userdetail) {
$i=$i+1;
?>    
<p><strong>Transaction Id:</strong> <?php echo $userdetail->transaction_id; ?></p>
<p><strong>Transaction Status:</strong> <?php echo $userdetail->transaction_status; ?></p>
<p><strong>Transaction Date:</strong> <?php echo date('d M Y', strtotime($userdetail->payment_date)); ?></p>
<p><strong>Price:</strong> <?php echo '$'.$userdetail->price; ?></p>
<p><strong>Membership Duration:</strong> <?php if($userdetail->duration==1){echo 'Monthly';}else if($userdetail->duration==2){echo 'Yearly';}?></p>
<?php if($i==$totalnumberpayment){ ?>
<p><strong>Next Subscription renewal date:</strong> <?php if($userdetail->duration==1){
$time = strtotime($userdetail->payment_date);
$final = date("Y-m-d", strtotime("+30 day", $time));
echo date('d M Y', strtotime($final));
}elseif($userdetail->duration==2){$time = strtotime($userdetail->payment_date);
$final = date("Y-m-d", strtotime("+364 day", $time));echo date('d M Y', strtotime($final));}?></p>
<?php } ?>
<p><strong>Membership plan:</strong> 
<?php 
$membershipplan=$userdetail->membership_id;  
$membershipplanname = DB::table('membership')->where('id',$membershipplan)->first();
echo $membershipplanname->name;
?></p>
<?php 
$cuurentdate=date('Y-m-d H:i:s');   
$interval = date_diff(date_create($cuurentdate), date_create($final)); 
$intervalday=$interval->format('%a');
//$intervalday=5;
if($intervalday<=7 && $i==$totalnumberpayment){
?> 
<a class="btn btn-primary" href="register/8114">BUY </a>
<?php  
}
?>
<?php 
} 
?>
</div>
</div>
</div>
</div>
</section>
@endsection