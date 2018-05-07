<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>{{ config('app.name', 'Laravel') }} </title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css">
</head>
<body>
<article><header></header></article>
<br/>
<br/>
@yield('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script type="application/javascript">
var basurl='<?php echo url('/'); ?>';
$( "#membershipplan" ).change(function() {
var membership=$('#membershipplan :selected').val();
var token=$('input[name=_token]').val();
if(membership=='-1')
{
  alert('Please Select Member Ship Plan');
  $('#plandetails').html('');
  $('#addfield').html('');
  $('#adddurationfield').html('');
}else{
  $.ajax({
  type: "POST",
  url: "{{ URL::route('membership') }}",
  data: {'membership': membership,'_token':token},
  success: function( data ) {
  $('#addfield').html(data);
  }
  });
}
});
function durationselect()
{
  var lavelid=$('#lavelid :selected').val();
  var membership=$('#membershipplan :selected').val();
  var token=$('input[name=_token]').val();
  if(membership=='-1')
  {
  alert('Please Select Member Ship Plan');
  $('#plandetails').html('');
  $('#addfield').html('');
  $('#adddurationfield').html('');
  }else if(lavelid=='-1'){
  alert('Please Select Member Ship Lavel');
  $('#plandetails').html('');
  $('#adddurationfield').html('');
  }else{
  $.ajax({
  type: "POST",
  url: "{{ URL::route('membershiplavel') }}",
  data: {'membership': membership,'lavelid':lavelid, '_token':token},
  success: function( data ) {
  $('#adddurationfield').html(data);
  }
  });
  } 
}
function getmemberselect()
{
  var lavelid=$('#lavelid :selected').val();
  var membership=$('#membershipplan :selected').val();
  var duration=$('#durationid :selected').val();
  var token=$('input[name=_token]').val();
  if(membership=='-1'){
  alert('Please Select Member Ship Plan');
  $('#plandetails').html('');
  }else if(lavelid=='-1'){
  alert('Please Select Member Ship Lavel');
  $('#plandetails').html('');
  }else if(duration=='-1')
  {
  alert('Please Select Member Duration');
  $('#plandetails').html('');
  }else{
  $.ajax({
  type: "POST",
  url: "{{ URL::route('getselectedmembership') }}",
  data: {'membership': membership,'lavelid':lavelid,'duration':duration, '_token':token},
  success: function( data ) {
  $('#plandetails').html(data);  
  }
  });
  }
} 
</script>
</body>
</html>