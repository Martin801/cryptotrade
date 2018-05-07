<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $user_obj = DB::table('applicationusers')->select('*')->get();
        $data['user_arr'] = $user_obj->toarray();
        return view('admin.user',$data);
    }
    public function add(Request $request,$id)
    {
        $data = array();
        if(!empty($id)){
            $user_obj = DB::table('applicationusers')->select('*')->where('id' , $id)->get();
            $data['user_arr'] = $user_obj->toarray();
        }
        return view('admin.user_add',$data);
    }
    public function delete(Request $request,$id)
    {
        DB::table('applicationusers')->where('id', '=', $id)->delete();
        DB::table('bots')->where('user_id', '=', $id)->delete();
        DB::table('robot_tradess')->where('user_id', '=', $id)->delete();
        DB::table('user_membership')->where('user_id', '=', $id)->delete();
        DB::table('user_payment')->where('user_id', '=', $id)->delete();
        session(['success_message' => 'Data deleted successfully.']);
        return redirect()->action('Admin\UserController@index');
    }
    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'status' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'address' => 'required'
        ]);

        $name    = $request->input('name');
        $status  = $request->input('status');
        $user_id = $request->input('id');
        $email   = $request->input('email');
        $phone   = $request->input('phone');
        $address = $request->input('address');
        $password = $request->input('password');
        
        
        
        if ($validator->fails()) {
            if(empty($user_id)){
                $user_id = 0;
            }
            return redirect()->action('Admin\UserController@add', ['id' => $user_id])->withErrors($validator)->withInput();
        }
        if(!empty($user_id)){
            if(!empty($password)){
            DB::table('applicationusers')->where('id', $user_id)
                                         ->update(['name' => $name, 'status' => $status, 'email' => $email,'password' => Hash::make($password),  'phone' => $phone, 'address' => $address]);    
            }else{
            DB::table('applicationusers')->where('id', $user_id)
                                         ->update(['name' => $name, 'status' => $status, 'email' => $email,  'phone' => $phone, 'address' => $address]);

            }
            session(['success_message' => 'Data updated successfully.']);
        }else{
            
            $user_id = DB::table('applicationusers')
                           ->insertGetId(['name' => $name, 'status' => $status, 'email' => $email, 'password' => Hash::make($password), 'phone' => $phone, 'address' => $address]);

            if(!empty($user_id)){
                for ($i=1; $i <=4 ; $i++){
                    DB::table('user_membership')->insertGetId(['user_id' => $user_id , 'membership_id' => 4, 'exchange_id' => $i]);
                }
            }

            DB::table('user_payment')->insertGetId([
            'user_id'            => $user_id,
            'membership_id'      => 20,
            'duration'           => 2,
            'price'              => 2,
            'transaction_id'     => 'Created By Admin',
            'transaction_status' => 'approved' ,
            'exchange_data'      => json_encode('Created By Admin') ,
            'payment_date'       => date('Y-m-d H:i:s'),
            ]);

            session(['success_message' => 'Data added successfully.']);
        }
        return redirect()->action('Admin\UserController@add', ['id' => $user_id]);
    }
    public function adminProfile()
    {
            $user_obj = DB::table('users')->select('*')->where('id' , 1)->get();
            $data['user_details'] = $user_obj->toarray();
            return view('admin.profile',$data);
    }
    public function adminUpdate(Request $request)
    {
        $name   = $request->input('name');
        $email  = $request->input('email'); 
        $user_msg  = $request->input('user_msg'); 

        if(!empty($name) and !empty($email)){
        if ($request->hasFile('input_img')) {
            $image = $request->file('input_img');
            $pic_name = time().'.'.$image->getClientOriginalExtension();
            $destinationPath = public_path('/img');
            $image->move($destinationPath, $pic_name);
            DB::table('users')->where('id', 1)->update(['name' => $name,'email' => $email,'profile_img' => $pic_name]);
        }else{
            DB::table('users')->where('id', 1)->update(['name' => $name,'email' => $email]);
        }  
        session(['success_message' => 'Data updated successfully.']); 
        }
        return redirect()->action('Admin\UserController@adminProfile');
    }

    public function change_password()
    {
        return view('admin.change-password');
    }

    public function update_password(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back();
        }

        $get_user_details =  DB::table('users')->where('id', 1)->get()->toarray();
        if(Hash::check($request->input('old_password'), $get_user_details[0]->password)){ 
        DB::table('users')->where('id', 1)->update([
            'password' => Hash::make($request->input('new_password'))
        ]);
        session(['success_message' => 'Data updated successfully.']);    
        }else{
        session(['error_message' => 'Old password did not match.']);     
        }
        return redirect()->back();
    
    }

    public function setting_view()
    {
        $user_obj = DB::table('users')->select('*')->where('id' , 1)->get();
        $data['user_details'] = $user_obj->toarray();
        return view('admin.setting',$data);
    }

    public function update_setting(Request $request)
    {

        $user_msg  = strip_tags($request->input('user_msg')); 
        DB::table('users')->where('id', 1)->update(['user_msg' => $user_msg]);
        session(['success_message' => 'Data updated successfully.']);  
        return redirect()->back();
    }

//END
}
