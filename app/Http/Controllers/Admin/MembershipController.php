<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
class MembershipController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $membership_obj = DB::table('membership')->select('*')->get();
        $data['membership_arr'] = $membership_obj->toarray();
        return view('admin.membership',$data);
    }
    
    public function add(Request $request,$id)
    {
        $data = array();
        
        $exchange_obj = DB::table('exchange')->select('*')->where('status' , 1)->get();
        $data['exchange_arr'] = $exchange_obj->toarray();
        if(!empty($id)){
            $membership_obj = DB::table('membership')->select('*')->where('id' , $id)->get();
            $data['membership_arr'] = $membership_obj->toarray();
            
            $membership_exchange_rel_obj = DB::table('membership_exchange_rel')->select('exchange_id')->where('membership_id' , $id)->get();
            $membership_exchange_rel_arr = $membership_exchange_rel_obj->toarray();
            
            $membership_exchange_rel_ar = array();
            
            if(!empty($membership_exchange_rel_arr)){
                foreach($membership_exchange_rel_arr as $membership){
                    $membership_exchange_rel_ar[] = $membership->exchange_id;
                }
            }
           
            $data['membership_exchange_rel_arr'] = $membership_exchange_rel_ar;
        }
        //##### Surajit ######//
         $membership_duration_obj=DB::table('membership_duration')->select('*')->where('status' ,1)->get();
         $membership_duration_arr=$membership_duration_obj->toarray();
         $data['membership_duration_arr'] = $membership_duration_arr;

         $membership_lavel_obj=DB::table('membership_lavel')->select('*')->where('status' ,1)->get();
         $membership_lavel_arr=$membership_lavel_obj->toarray();
         $data['membership_lavel_arr'] = $membership_lavel_arr;
        //#### End ####//
        return view('admin.membership_add',$data);
        
    }
    public function delete(Request $request,$id)
    {
        DB::table('membership')->where('id', '=', $id)->delete();
        DB::table('membership_exchange_rel')->where('membership_id', '=', $id)->delete();
        return redirect()->action('Admin\MembershipController@index');
    }
    public function save(Request $request)
    {
        $name = $request->input('name');
        $status = $request->input('status');
        $membership_id = $request->input('id');
        
        $details = $request->input('details');
        $duration = $request->input('duration');
        $price = $request->input('price');
        $memebershiplavel = $request->input('memebershiplavel_id');
        
        $exchange_arr = $request->input('exchange_id');
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required',
            'details' => 'required',
            'duration' => 'required',
            'price' => 'required',
            'exchange_id' => 'required'
        ]);
        
        if ($validator->fails()) {
            if(empty($membership_id)){
                $membership_id = 0;
            }
            return redirect()->action('Admin\MembershipController@add', ['id' => $membership_id])
                        ->withErrors($validator)
                        ->withInput();
            
        }
        
        if(!empty($membership_id)){
            DB::table('membership')->where('id', $membership_id)->update(['name' => $name, 'status' => $status, 'details' => $details, 'duration' => $duration, 'price' => $price , 'lavel_id' =>$memebershiplavel]);
            
            if(!empty($exchange_arr)){
                DB::table('membership_exchange_rel')->where('membership_id', '=', $membership_id)->delete();
                foreach($exchange_arr as $exchage){
                    DB::table('membership_exchange_rel')->insertGetId(['exchange_id' => $exchage, 'membership_id' => $membership_id]);
                }
            }
            
            session(['success_message' => 'Data updated successfully.']);
        }else{
            
            
            $membership_id = DB::table('membership')->insertGetId(['name' => $name, 'status' => $status, 'details' => $details, 'duration' => $duration, 'price' => $price, 'lavel_id' =>$memebershiplavel]);
            if(!empty($exchange_arr)){
                
                foreach($exchange_arr as $exchage_id){
                    DB::table('membership_exchange_rel')->insertGetId(['exchange_id' => $exchage_id, 'membership_id' => $membership_id]);
                }
            }
            session(['success_message' => 'Data added successfully.']);
        }

//        return redirect()->route('admin/exchange/add/', ['id' => $exchange_id]);
        return redirect()->action('Admin\MembershipController@add', ['id' => $membership_id]);
        
        
    }
    //#################--- Surajit Kundu ---#################//
    public function membershiplavel()
    {
        $membership_lavel_obj = DB::table('membership_lavel')->select('*')->get();
        $data['membership_lavel_arr'] = $membership_lavel_obj->toarray();
        return view('admin.membershiplavel',$data);
    }
    public function membershiplaveldel(Request $request,$id)
    {

        DB::table('membership_lavel')->where('id', '=', $id)->delete();  
        return redirect()->action('Admin\MembershipController@membershiplavel');
    }
    public function membershiplaveladd(Request $request,$id)
    {

        $data = array();
        if(!empty($id)){
            $membershiplevel_obj = DB::table('membership_lavel')->select('*')->where('id' , $id)->get();
            $data['membershiplevel_arr'] = $membershiplevel_obj->toarray();            

        }
        return view('admin.membershiplavel_add',$data);
        
    }
 
    public function membershiplavelsave(Request $request)
    {

        $name = $request->input('name');
        $status = $request->input('status');
        $id = $request->input('id');
        $details = $request->input('details');

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required',
            'details' => 'required',
            
        ]);
        
        if ($validator->fails()) {
            if(empty($id)){
                $id = 0;
            }
            return redirect()->action('Admin\MembershipController@membershiplaveladd', ['id' => $id])
                        ->withErrors($validator)
                        ->withInput();
            
        }
         $ldate = date('Y-m-d H:i:s');
        if(!empty($id)){
            DB::table('membership_lavel')->where('id', $id)->update(['name' => $name, 'status' => $status, 'description' => $details]);
            
            session(['success_message' => 'Data updated successfully.']);
        }else{          
            $membership_id = DB::table('membership_lavel')->insertGetId(['name' => $name, 'status' => $status, 'description' => $details, 'created_at' => $ldate ]);
            session(['success_message' => 'Data added successfully.']);
        }
         if(empty($id)){
                $id = 0;
            }
        return redirect()->action('Admin\MembershipController@membershiplaveladd', ['id' => $id]);
    }

    //#################-- End ---#################//
}
