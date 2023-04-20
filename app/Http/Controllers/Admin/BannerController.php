<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use Session;
use Image;
class BannerController extends Controller
{
    public function banners(){
        Session::put('page','banners');
        $banners = Banner::get()->toArray();
        //dd($banners);die;
        return view('admin.banners.banners')->with(compact('banners'));
    }
    public function addeditBanner($id=null, Request $request){
        if($id==null){
            //Add Banner
            $banner = new Banner; 
            $title =" Add Banner Image";
            $message="Banner added successfully";
        } else{
            $banner = Banner::find($id);
            $title = "Edit Banner Image";
            $message = "Banner updated successfully";
        }

        if($request->isMethod('post')){
            $data = $request->all();
            
            $banner->link = $data['link'];
          
            $banner->alt = $data['alt']; 
            $banner->title = $data['title'];
              // Upload Product Image
              if($request->hasFile('image')){
                $image_tmp=$request->file('image');
                if($image_tmp->isValid()){
                    //Upload images after resize
                    $image_name = $image_tmp->getCLientOriginalName();
                    $extension=$image_tmp->getClientOriginalExtension();
                    $imageName=$image_name.'-'.rand(111,99999).'.'.$extension;
                    $banner_image_path='images/banner_images/'.$imageName;
                   
                    
                    Image::make($image_tmp)->resize(1170,480)->save($banner_image_path);
                   
                    $banner->image=$imageName;
                }
            }
            $banner->save();
            session::flash('success_message',$message);
            return redirect('admin/banners');
        }

        return view('admin.banners.add_edit_banner')->with(compact('title','banner'));
    }
    public function updateBannerStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            if($data['status'] == "Active"){
                $status = 0;
            } else{
                $status = 1;
            }
            Banner::where('id',$data['banner_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'banner_id'=>$data['banner_id']]);
        }
    }
    public function deleteBanner($id){
        $bannerImage= Banner::where('id',$id)->first();
        $banner_image_path = 'images/banner_images/';
        if(file_exists($banner_image_path.$bannerImage->image)){
            unlink($banner_image_path.$bannerImage->image);
        }
        Banner::where('id',$id)->delete();
        session::flash('success_message','Banner deleted successfully');
        return redirect()->back();
    }

}
