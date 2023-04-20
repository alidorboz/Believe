<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Section;
use Session;
use Image;
class CategoryController extends Controller
{
    public function categories(){
        Session::put('page','categories');
        $categories = Category::with(['section','parentcategory'])->get();
         //$categories=json_decode(json_encode($categories));
        // // echo "<pre>";print_r($categories);die;
        return view('admin.categories.categories')->with(compact('categories'));
    }
    public function updateCategoryStatus(Request $request){
        if($request->ajax()){
            $data=$request->all();
            if($data['status']=="Active"){
                $status=0;
            }else{
                $status=1;
            }
            Category::where('id',$data['c_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'c_id'=>$data['c_id']]);
        }
    }
    public function addEditCategory(Request $request,$id=null){
        if($id==''){
            $title='Add Category';
            $categorydata=array();
            $getCategories= array();
            $message = "Category added successfully!";
        }else{
            $title='Edit Category';
            $categorydata=Category::where('id',$id)->first();
            $categorydata= json_decode(json_encode($categorydata),true);
            $getCategories= Category::with('subcategories')->where(['pid'=>0,'sid'=>$categorydata['sid']])->get();
            $getCategories=json_decode(json_encode($getCategories),true);
            $category = Category::find($id);
            $message = "Category updated successfully!";
        }

        if($request->isMethod('post')){
            $category= new Category;
            $rules =[
                'categoryName'=>'required',
                'sid'=>'required',
                'url'=>'required',
                'categoryImage'=>'image'
            ];
            $customMessages =[
                'categoryName.required'=>'Name  is required',
                'sid.required'=>'Section is requied',
                'url.required'=>'URL is required',
                'categoryImage.image'=>'Valid Image is required',
            ];
            $this->validate($request,$rules,$customMessages);
            
            //echo "<pre>";print_r($data);die;
           //Upload Image
           if($request->hasFile('categoryImage')){
            $image_tmp = $request->file('categoryImage');
            if($image_tmp->isValid()){
                //Get Image EXtension
                $extension=$image_tmp->getClientOriginalExtension();
                //Generate New Image Name
                $imageName = rand(111,9999).'.'.$extension;
                $imagePath = 'images/categoryImages/'.$imageName;
                //Upload the Image
                Image::make($image_tmp)->save($imagePath);
            }else if(!empty($data['current_category_image'])){
                //$imageName = $data['current_category_image'];
            }else{
                $imageName="";
            }
        }
            if(empty($request->categoryDiscount)){
                $request->categoryDiscount="";
            }
            if(empty($request->description)){
                $request->description="";
            }
            if(empty($request->metaTitle)){
                $request->metaTitle="";
            }
            if(empty($request->metaDescription)){
                $request->metaDescription="";
            }
            if(empty($request->metaKeywords)){
                $request->metaKeywords="";
            }
              $data = $request->all();
              $category->pid=$data['pid'];
              $category->sid=$data['sid'];
              $category->categoryName=$data['categoryName'];
             //$category->categoryImage=$data['categoryImage'];
              $category->categoryDiscount=$data['categoryDiscount'];
              $category->description=$data['description'];
              $category->url=$data['url'];
              $category->metaTitle=$data['metaTitle'];
              $category->metaDescription=$data['metaDescription'];
              $category->metaKeywords=$data['metaKeywords'];
              $category->status=1;

              $category->save();
              session::flash('success_message',$message);
              return redirect('admin/categories');
        }
        //Get All Sections
        $getSections=Section::get();
        return view('admin.categories.add_edit_category')->with(compact('title','getSections','categorydata','getCategories'));
    }
    public function appendCategoryLevel(Request $request){
        if($request->ajax()){
            $data=$request->all();
            $getCategories= Category::with('subcategories')->where(['sid'=>$data['sid'],'pid'=>0,'status'=>1])->get();
            $getCategories = json_decode(json_encode($getCategories),true);
            return view('admin.categories.append_categories_level')->with(compact('getCategories'));
        }
    }
    public function deleteCategory($id){
        Category::where('id',$id)->delete();
        $message='Category has been deleted successfully';
        session::flash('success_message',$message);
        return redirect()->back();
    }
}
