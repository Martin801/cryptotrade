<?php 
if(!empty(Auth::user()->profile_img)){
$pic_name = Auth::user()->profile_img;
}else{
$pic_name = 'user2-160x160.jpg'; 
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ config('app.name', 'Laravel') }} | Dashboard</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('public/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <link rel="stylesheet" href="{{ asset('public/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('public/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('public/bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('public/css/AdminLTE.min.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('public/css/skins/_all-skins.min.css')}}">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{ asset('public/bower_components/morris.js/morris.css')}}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{ asset('public/bower_components/jvectormap/jquery-jvectormap.css')}}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{ asset('public/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('public/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
  <!-- bootstrap wysihtml5 - text editor -->
  <!--  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">-->

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
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
    <!-- Logo -->
    <a href="{{URL::to('admin/dashboard')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">{{ config('app.name', 'Laravel') }}</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">{{ config('app.name', 'Laravel') }}</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="<?php  echo asset('public/img').'/'.$pic_name; ?> " class="user-image" alt="User Image">
              <span class="hidden-xs"><?php echo Auth::user()->name; ?>( <?php echo Auth::user()->email; ?> ) </span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="<?php echo asset('public/img').'/'.$pic_name; ?> " class="img-circle" alt="User Image">

                <p>
                  <?php echo Auth::user()->name; ?> 
                  <small><?php echo Auth::user()->email; ?> </small>
                </p>
              </li>
              <li class="user-footer">
                <div class="pull-left">
                  <a href="{{URL::to('admin/profile')}}" class="btn btn-default btn-flat">Profile</a>
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
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="<?php echo asset('public/img').'/'.$pic_name; ?>" style="height: 45px;" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo Auth::user()->name; ?> </p>
          <p><?php echo Auth::user()->email; ?></p>
        </div>
      </div>
     
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="">
          <a href="{{URL::to('admin/dashboard')}}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
            
          </a>
          
        </li>
        <li class="">
          <a href="{{URL::to('admin/user')}}">
            <i class="fa fa-users"></i> <span>User</span>
            
          </a>
          
        </li>
        <li class="">
          <a href="{{URL::to('admin/exchange')}}">
            <i class="fa fa-exchange"></i> <span>Exchange</span>
            
          </a>
          
        </li>
    
        <li class="">
          <a href="{{URL::to('admin/membershiplavel')}}">
            <i class="fa  fa-id-card"></i> <span>Membership Level</span>
          </a>
        </li>

        <li class="">
          <a href="{{URL::to('admin/membership')}}">
            <i class="fa  fa-id-card"></i> <span>Membership</span>
          </a>
        </li>

        <li class="">
          <a href="{{URL::to('admin/profile')}}">
            <i class="fa  fa-user"></i> <span>Profile</span>
          </a>
        </li>

        <li class="">
          <a href="{{URL::to('admin/setting-view')}}">
            <i class="fa  fa-gear"></i> <span>Setting</span>
          </a>
        </li>


        <li class="">
          <a href="{{URL::to('admin/change-password')}}">
            <i class="fa  fa-key"></i> <span>Change Password</span>
          </a>
        </li>

        <li class="">
          <a href="javascript:void(0);" onclick="logout();">
            <i class="fa fa-sign-out"></i> <span>Logout</span>
          </a>
        </li>
        
      </ul>
    </section>
  </aside>
  <div class="content-wrapper">
    @yield('content')
  </div>
  <footer class="main-footer">
    <strong>Copyright &copy; <?php echo date('Y'); ?>  All rights
    reserved.
  </footer>
</div>
<!-- ./wrapper -->
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2"></script>
<script>
  $(function () {
    $('#example2').DataTable();
  });
</script>
<script type="text/javascript">
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
