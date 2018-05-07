@extends('layouts.user')
@section('content')
<style type="text/css">
#preloader{
    position: fixed;
    left: 0;
    top:  0;
    z-index: 999999999999999999;
    width: 100%;
    height: 100%;
    overflow: visible;
    background: url('http://www.ladybirdmagazine.com/images/preloader-sm.gif') no-repeat center center;
    background-size: 100px 100px;
    background-color: rgba(241, 242, 249, .4);
}
</style>
<section class="content-header">
<h1>User <small>Credentials</small></h1>
</section>
<section class="content">
<div id="preloader" style="display: none;"></div>
<?php if(!empty($bitcoin_membership_arr)){ ?>
<?php
foreach($bitcoin_membership_arr as $bitcoin_membership){
if($bitcoin_membership->exchange_id == 4 || $bitcoin_membership->exchange_id == 3){      
$get_count_exchange  = DB::table('membership_exchange_rel')->where('membership_id', session('membership_id_session'))
                       ->where('exchange_id', $bitcoin_membership->exchange_id)->count();
if($get_count_exchange > 0){
?>
<div class="col-md-6">
<div class="box box-warning">
<div class="box-header with-border">
<h3 class="box-title"><?php echo $bitcoin_membership->exchange_name; ?></h3>
</div>
<div class="form-horizontal">
<div class="box-body">
<div class="form-group">
<label for="Api Key" class="col-sm-2 control-label">Api Key</label>
<div class="col-sm-10">
<input class="form-control" name="api_key_<?php echo $bitcoin_membership->user_membership_id; ?>" id="api_key_<?php echo $bitcoin_membership->user_membership_id; ?>" placeholder="Api Key" type="text" value="<?php echo $bitcoin_membership->api_key; ?>">
<?php if(empty($bitcoin_membership->api_key)){ ?>
<p class="help-block">Please give <?php echo $bitcoin_membership->exchange_name; ?> Api Key</p>
<?php } ?>
</div>
</div>
<div class="form-group">
<label for="Api Secret" class="col-sm-2 control-label">Api Secret</label>
<div class="col-sm-10">
<input class="form-control" name="api_secret_<?php echo $bitcoin_membership->user_membership_id; ?>" id="api_secret_<?php echo $bitcoin_membership->user_membership_id; ?>" placeholder="Api Secret" type="text" value="<?php echo $bitcoin_membership->api_secret; ?>">
<?php if(empty($bitcoin_membership->api_secret)){ ?>
<p class="help-block">Please give <?php echo $bitcoin_membership->exchange_name; ?> Api Secret</p>
<?php }?>
</div>
</div>
</div>
<div class="box-footer">
<button type="button" class="btn btn-warning pull-right" onclick="validate_credentials('<?php echo $bitcoin_membership->user_membership_id; ?>','<?php echo $bitcoin_membership->exchange_id; ?>');">Validate</button>
</div>
</div>
</div>
</div>
<?php }}}} ?>
</section>
<script type="text/javascript">
function validate_credentials(id,e_id)
{
    var api_key = $('#api_key_'+id).val();
    var api_secret = $('#api_secret_'+id).val();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    if(api_key == ''){
        alert("Please give Api Key.");
        $('#api_key_'+id).focus();
        return false;
    }
    if(api_secret == ''){
        alert("Please give Api Secret.");
        $('#api_secret_'+id).focus();
        return false;
    }
    $.ajax({
        url: "{{URL::to('/home/validate-credentials')}}",
        type: "post",
        dataType: 'html',
        beforeSend: function(){
        $('#preloader').show();
        },
        data: {
            'id':id,
            '_token': CSRF_TOKEN,
            'api_key': api_key,
            'api_secret' : api_secret,
            e_id : e_id,
        },
        success: function(data){
        $('#preloader').hide();
        var obj = JSON.parse(data);
        if(obj.success){
            alert("THE API HAS BEEN SUCCESSFULLY VALIDATED AND UPDATED");
        }else{
            alert('SORRY !!! ERROR API KEY NOT VALID');
        }
        }
    });
}
</script>
@endsection
