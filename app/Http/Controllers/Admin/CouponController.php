<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Section;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CouponController extends Controller
{
    public function coupons(){
        Session::put('page','coupons');
        $coupons = Coupon::get()->toArray();
        //echo "<pre>";print_r($coupons);die;
        return view('admin.coupons.coupons')->with(compact('coupons'));
    }
    public function updateCouponStatus(Request $request){
        if($request->ajax()){
            $data=$request->all();
            if($data['status']=="Active"){
                $status=0;
            }else{
                $status=1;
            }
            Coupon::where('id',$data['coupon_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'coupon_id'=>$data['coupon_id']]);
        }
    }
    public function addEditCoupon(Request $request,$id=null){
        if($id==""){
            //Add Coupon
            $coupon = new Coupon;
            $selCats=array();
            $selUsers= array();
            $title = "Add Coupon";
            $message = "Coupon added successfully";
            $coupon_code = '';
        }else{
            $coupon=Coupon::find($id);
            $selCats=explode(',',$coupon['categories']);
            $selUsers=explode(',',$coupon['users']);
        
            $title="Edit Coupon";
            $message = "Coupon updated successfully";
            $coupon_code = $coupon->coupon_code; // set the value of $coupon_code from the database record
        }
        
        if($request->isMethod('post')){
            $data=$request->all();
            $users = [];
            $categories = [];
            if(isset($data['users'])){
                $users = implode(',', $data['users']);
            }
            if(isset($data['categories'])){
                $categories = implode(',', $data['categories']);
            }
            if(isset($data['coupon_option'])){
                if($data['coupon_option']=='Automatic'){
                    $coupon_code = Str::random(8);
                }else{
                    $coupon_code=$data['coupon_code'];
                }
                $coupon->coupon_option=$data['coupon_option'];
            }
            
            $coupon->coupon_code=$coupon_code;
            $coupon->categories=$categories;
            $coupon->users=$users;
            $coupon->coupon_type=$data['coupon_type'];
            $coupon->amount_type=$data['amount_type'];
            $coupon->amount=$data['amount'];
            $coupon->expiry_date=$data['expiry_date'];
            $coupon->status=1;
            $coupon->save();
            Session::flash('success_message',$message);
            return redirect('admin/coupons');

        }
        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories),true);
        //Users
        $users= User::select('email')->where('status',1)->get()->toArray();
        return view('admin.coupons.add_edit_coupon')->with(compact('title','coupon','categories','users','selCats','selUsers'));
    }
    public function deleteCoupon($id){
            
        Coupon::where('id',$id)->delete();
        $message='Coupon deleted successfully';
        session::flash('success_message',$message);
        return redirect()->back();
    }
}
