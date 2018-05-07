<?php
$icon_colour = '#07cdff';
$get_user_details = DB::table('applicationusers')->where('id', session('user_id'))->get()->toarray();
if(!empty($get_user_details[0]->profile_img)){
$pic_name = $get_user_details[0]->profile_img;
}else{
$pic_name = 'bitcoin-2136339_960_720.png'; 
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ config('app.name', 'Bitcoin') }} | Dashboard</title>
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="{{ asset('public/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{ asset('public/bower_components/datatablesbs/css/dataTables.bootstrap.min.css')}}">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<!-- Font Awesome -->
<link rel="stylesheet" href="{{ asset('public/bower_components/font-awesome/css/font-awesome.min.css')}}">
<!-- Ionicons -->
<link rel="stylesheet" href="{{ asset('public/bower_components/Ionicons/css/ionicons.min.css')}}">
<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('public/css/AdminLTE.min.css')}}">
<link rel="stylesheet" href="{{ asset('public/css/skins/_all-skins.min.css')}}">
<!-- Morris chart -->
<link rel="stylesheet" href="{{ asset('public/bower_components/morris.js/morris.css')}}">
<!-- jvectormap -->
<link rel="stylesheet" href="{{ asset('public/bower_components/jvectormap/jquery-jvectormap.css')}}">
<!-- Date Picker -->
<link rel="stylesheet" href="{{ asset('public/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
<!-- Daterange picker -->
<link rel="stylesheet" href="{{ asset('public/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
<style type="text/css" media="screen">
.swal2-popup {
    font-size: 1.7rem !important;
}  
</style>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<header class="main-header">
<a href="{{URL::to('admin/dashboard')}}" class="logo">
<span class="logo-mini">{{ config('app.name', 'Bitcoin') }}</span>
<span class="logo-lg">{{ config('app.name', 'Bitcoin') }}</span>
</a>
<nav class="navbar navbar-static-top">
<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
<span class="sr-only">Toggle navigation</span>
</a>
<div class="navbar-custom-menu">
<ul class="nav navbar-nav">
<li class="dropdown user user-menu">
<a href="#" class="dropdown-toggle" data-toggle="dropdown">
<img src="<?php  echo asset('public/img').'/'.$pic_name; ?> " class="user-image" alt="User Image">
<span class="hidden-xs"><?php echo session('user_name').'('.session('email_id').')'; ?></span>
</a>
<ul class="dropdown-menu">
<li class="user-header">
<img src="<?php echo asset('public/img').'/'.$pic_name; ?> " class="img-circle" alt="User Image">
<p><?php echo session('user_name'); ?><small><?php echo session('email_id'); ?></small></p>
</li>
<li class="user-footer">
<div class="pull-left">
<a href="{{URL::to('/profile')}}" class="btn btn-default btn-flat">Profile</a>
</div>
<div class="pull-right">
<a class="btn btn-default btn-flat" href="javascript:void(0);" onclick="logout();"> Logout</a>    
</div>
</li>
</ul>
</li>
</ul>
</div>
</nav>
</header>
<aside class="main-sidebar">
<section class="sidebar">
<div class="user-panel">
<div class="pull-left image">
<img src="<?php echo asset('public/img').'/'.$pic_name; ?>" style="height: 45px;" class="img-circle" alt="User Image">
</div>
<div class="pull-left info">
<p><?php echo session('user_name'); ?> </p>
<p><?php echo session('email_id'); ?> </p>
</div>
</div>
<ul class="sidebar-menu" data-widget="tree">
<li class=""><a href="{{URL::to('/home')}}"><i class="fa fa-dashboard" style="color: <?php echo $icon_colour; ?>"></i> <span>Dashboard</span></a>
</li><li class=""><a href="{{URL::to('/buytrade')}}"><i class="fa fa-key" style="color: <?php echo $icon_colour; ?>"></i> <span>API Credentials</span></a></li>
<li class="treeview">
<a href="#">
<i class="fa fa-bank" style="color: <?php echo $icon_colour; ?>"></i> <span>Balance</span>
<span class="pull-right-container">
<i class="fa fa-angle-left pull-right"></i>
</span>
</a>
<ul class="treeview-menu">
<?php
$get_exchange = DB::table('exchange')->where('status', 1)->get();
if(!empty($get_exchange)){
foreach ($get_exchange as $result){
if($result->id == 4 || $result->id == 3){  
$get_count_exchange  = DB::table('membership_exchange_rel')
                       ->where('membership_id', session('membership_id_session'))->where('exchange_id', $result->id)->count();
if($get_count_exchange > 0){
$url_link = "/balance/".$result->id;
?>
<li><a href="<?php echo URL::to($url_link); ?>"><i class="fa fa-circle-o" style="color: <?php echo $icon_colour; ?>"></i> <?php echo $result->name;?></a></li>
<?php }}}} ?>
</ul>
</li>
<li><a href="{{URL::to('/bot')}}"><i class="fa fa-bitcoin" style="color: <?php echo $icon_colour; ?>"></i> <span>BOT</span></a></li>
<li><a href="{{URL::to('/transuctionhistry')}}"><i class="fa  fa-dollar" style="color: <?php echo $icon_colour; ?>"></i> <span>Transaction</span></a></li>
<!-- <li><a href="{{URL::to('/myplan')}}"><i class="fa  fa-diamond"></i> <span>Membership Plan</span></a></li> -->
<li><a href="{{URL::to('/profile')}}"><i class="fa  fa-users" style="color: <?php echo $icon_colour; ?>"></i> <span>Profile</span></a></li>
<li><a href="{{URL::to('/change-password')}}"><i class="fa  fa-key" style="color: <?php echo $icon_colour; ?>"></i> <span>Change Password</span></a></li>
<li><a href="javascript:void(0)" onclick="logout();"><i class="fa fa-sign-out" style="color: <?php echo $icon_colour; ?>"></i> <span>Logout</span></a></li>
</ul>
</section>
</aside>
<div class="content-wrapper">
@yield('content')
</div>
<footer class="main-footer">
<strong>Copyright &copy; <?php echo date('Y'); ?> &nbsp;&nbsp; <a href="http://cointradepro.tech/tos" target="_blank">Terms and Conditions</a> &nbsp;&nbsp; <a href="http://cointradepro.tech/support" target="_blank">Support</a></strong>
</footer>
</div>
<!-- jQuery 3 -->
<script src="{{ asset('public/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('public/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('public/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- Morris.js charts -->
<script src="{{ asset('public/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- datepicker -->
<script src="{{ asset('public/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<script src="{{ asset('public/bower_components/datatables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('public/bower_components/datatablesbs/js/dataTables.bootstrap.min.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<!--<script src="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>-->
<!-- Slimscroll -->
<script src="{{ asset('public/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{ asset('public/bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('public/js/adminlte.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ asset('public/js/pages/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('public/js/demo.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2"></script>
<script>
$(function () {
  $('#example2').DataTable();
});
$(document).ready(function() {
    $('.table_d').DataTable({
    "pageLength": 60
    });
});
$(document).ready(function() {
    $('.table_c').DataTable();
});
$(document).ready(function() {
    $('select').select2();
});
function logout(){
swal({
title: 'Are you sure?',
text: "You want to logout!!!!!",
type: 'warning',
showCancelButton: true,
confirmButtonColor: '#d33',
cancelButtonColor: '#3085d6',
confirmButtonText: 'Yes, do it!'
}).then((result) => {
if (result.value) {
document.getElementById('frm-logout').submit(); 
}
})
}
</script>
<form id="frm-logout" action="{{URL::to('/admin/logout')}}" method="POST" style="display: none;">
{{ csrf_field() }}
</form>
</body>
</html>
