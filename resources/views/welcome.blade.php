<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ config('app.name', 'Laravel') }}</title>
<!-- Fonts -->
<link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="{{url('public/css/app.css')}}"/>
<!-- Styles -->
<style>
html, body
{
	background-color: #fff;
	color: #636b6f;
	font-family: 'Raleway', sans-serif;
	font-weight: 100;
	height: 100vh;
	margin: 0;
	background: url(https://c1.staticflickr.com/9/8723/16848292600_6628d43d72_h.jpg) no-repeat center;
    background-size: cover;
}
.full-height{
	height: 100vh;
}
.flex-center{
	align-items: center;
	display: flex;
	justify-content: center;
}
.position-ref{
	position: relative;
}
.top-right{
	position: absolute;
	right: 10px;
	top: 18px;
}
.content{
	text-align: center;
}
.title{
	font-size: 84px;
}
.links > a{
	color: #636b6f;
	padding: 0 25px;
	font-size: 12px;
	font-weight: 600;
    letter-spacing: .1rem;
	text-decoration: none;
	text-transform: uppercase;
}
.m-b-md{
	margin-bottom: 30px;
}
.btn-data{
background: #FFF;
padding: 10px !important;
}
</style>
</head>
<body>
<div class="flex-center position-ref full-height">
<div class="top-right links">
<a href="{{URL::to('login')}}" class="btn btn-data">User Login</a>
<a href="{{URL::to('admin/login')}}" class="btn btn-data">Admin Login</a>
</div>
<div class="content">
{{-- <div class="title m-b-md"> <a href="{{URL::to('/')}}" >
<img style="height:150px;" src="{{ asset('public/img/logo.jpg')}}" /></a>
</div> --}}
<a href="{{URL::to('/membership-plan')}}" class="btn btn-success">Membership Plans</a>
</div>
</div>
</body>
</html>
