<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use Symfony\Component\HttpFoundation\Session\Session;
class ExchangeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $exchange_obj = DB::table('exchange')->select('*')->get();
        $data['exchange_arr'] = $exchange_obj->toarray();
        return view('admin.exchange',$data);
    }
    public function add(Request $request,$id)
    {
        $data = array();
        if(!empty($id)){
            $exchange_obj = DB::table('exchange')->select('*')->where('id' , $id)->get();
            $data['exchange_arr'] = $exchange_obj->toarray();
        }
        return view('admin.exchange_add',$data);
        
    }
    public function save(Request $request)
    {
        $name = $request->input('name');
        $status = $request->input('status');
        $exchange_id = $request->input('id');
        
        if(!empty($exchange_id)){
            DB::table('exchange')->where('id', $exchange_id)->update(['name' => $name, 'status' => $status]);
            session(['success_message' => 'Data updated successfully.']);
        }else{
            $exchange_id = DB::table('exchange')->insertGetId(['name' => $name, 'status' => $status]);
            session(['success_message' => 'Data added successfully.']);
        }
        return redirect()->action('Admin\ExchangeController@add', ['id' => $exchange_id]);
        
    }
}
