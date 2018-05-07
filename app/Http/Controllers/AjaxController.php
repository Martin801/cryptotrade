<?php
namespace App\Http\Controllers;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Hash;
class AjaxController extends Controller
{
public function membership(Request $request)
{
  $membership=$request->input('membership');
  $bitcoin_membership = DB::table('membership')
  ->select('*')
  ->where('name',$membership)
  ->groupBy('lavel_id')
  ->get();
  $html='<div style="padding: 10px; margin-bottom: 10px;">';        
  $html.='<select class="form-control" onchange="durationselect()" id="lavelid">';
  $html.='<option value="-1">Select Your Pack Lavel</option>';  
  $bitcoin_membership_arr = $bitcoin_membership->toarray(); 
  foreach ($bitcoin_membership_arr as $bitcoin_membership) {
  $bitcoin_membership->lavel_id;
  $bitcoin_membership_lavel = DB::table('membership_lavel')
  ->select('*')
  ->where('id',$bitcoin_membership->lavel_id)
  ->first();
  $html.='<option value="'.$bitcoin_membership->lavel_id.'">';
  $html.=$bitcoin_membership_lavel->name;
  $html.='</option>';    
  }
  $html.='</select><div class="clearfix"></div></div>';
  echo $html;
}
public function membershiplavel(Request $request)
{
  $membership=$request->input('membership');
  $lavelid=$request->input('lavelid');
  $bitcoin_membership_duration = DB::table('membership')
  ->where([['lavel_id', '=', $lavelid],['name', '=', $membership]])
  ->get();
  $bitcoin_membership_duration_arr=$bitcoin_membership_duration->toarray();
  $html='<div style="padding: 10px; margin-bottom: 10px;">';
  $html.='<select class="form-control" onchange="getmemberselect()" id="durationid">';
  $html.='<option value="-1">Select Your Membership Duration</option>';
  foreach ($bitcoin_membership_duration_arr as $bitcoin_membership_duration_ind) {
  $bitcoin_membership_duration_name = DB::table('membership_duration')
  ->select('*')
  ->where('id',$bitcoin_membership_duration_ind->duration)
  ->first();
  $html.='<option value="'.$bitcoin_membership_duration_name->id.'">';
  $html.= strtoupper($bitcoin_membership_duration_name->duration);
  $html.='</option>';  
  }  
  $html.='</select><div class="clearfix"></div></div>';
  echo $html;
} 
public function getselectedmembership(Request $request)
{
  $membership=$request->input('membership');
  $lavelid=$request->input('lavelid');
  $duration=$request->input('duration');
  $bitcoin_membership_duration = DB::table('membership')
  ->where([['lavel_id', '=', $lavelid],['name', '=', $membership],['duration', '=', $duration]])
  ->get();
  $bitcoin_membership_duration_arr=$bitcoin_membership_duration->toarray();
  foreach ($bitcoin_membership_duration_arr as $bitcoin_membership_duration_ind) {
  $bitcoin_membership_duration_name = DB::table('membership_duration')
  ->select('*')
  ->where('id',$bitcoin_membership_duration_ind->duration)
  ->first(); 
  $bitcoin_membership_lavel = DB::table('membership_lavel')
  ->select('*')
  ->where('id',$bitcoin_membership_duration_ind->lavel_id)
  ->first();  
  $html='<div style="text-align: center; padding: 10px; margin-bottom: 10px;">';
  $html.='<h2>';
  $html.=$bitcoin_membership_duration_ind->name;
  $html.='</h2>';
  $html.='<p>';
  $html.=$bitcoin_membership_duration_ind->details;
  $html.='</p>';
  $html.='Duration : '.$bitcoin_membership_duration_name->duration.'<br/>';
  $html.='Membership Label : '.$bitcoin_membership_lavel->name.'<br/>';
  $html.='Price : $'.$bitcoin_membership_duration_ind->price.'<br/>';
  $html.='<a class="btn btn-primary" href="register/';
  $html.=rand(10,99).$bitcoin_membership_duration_ind->id.'">BUY </a>';
  $html.='</div>';
  }
  echo $html;
} 
//END
}