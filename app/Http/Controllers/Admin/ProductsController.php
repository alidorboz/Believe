<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductsAttributes;
use App\Models\Section;
use App\Models\Category;
use Session;
use Image;

class ProductsController extends Controller
{
    public function products(){
        Session::put('page','products');
        $products = Product::with(['category'=>function($query){
            $query->select('id','categoryName');
        },'section'=>function($query){
            $query->select('id','name');
        }])->get();
        //$products = json_decode(json_encode($products));

        return view('admin.products.products')->with(compact('products'));
    }
    public function updateProductStatus(Request $request){
        if($request->ajax()){
            $data=$request->all();
            if($data['status']=="Active"){
                $status=0;
            }else{
                $status=1;
            }
            Product::where('id',$data['product_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'product_id'=>$data['product_id']]);
        }
    }
    public function deleteProduct($id){
        Product::where('id',$id)->delete();
        $message='Product has been deleted successfully';
        session::flash('success_message',$message);
        return redirect()->back();
    }
    public function addEditProduct(Request $request,$id=null){
        if($id==""){
            $title="Add Product";
            $product= new Product;
            $productdata= array();
            $message="Product added successfully";
        }else{
            $title="Edit Product";
            $productdata = Product::find($id);
            $productdata=json_decode(json_encode($productdata),true);
            $product = Product::find($id);
            $message="Product updated successfully";
        }
        if($request->isMethod('post')){
            $data = $request->all();
            $rules =[
                'category_id'=>'required',
                'product_name'=>'required',
                'product_code'=>'required',
                'product_price'=>'required',
                'product_color'=>'required'
            ];
            $customMessages =[
                'product_name.required'=>'Name  is required',
                'product_code.required'=>'Code  is required',
                'product_price.required'=>'Price  is required',
                'product_color.required'=>'Color  is required',
            ];
            $this->validate($request,$rules,$customMessages);

          


            if(empty($data['fabric'])){
                $data['fabric'] ="";
            }

            if(empty($data['pattern'])){
                $data['pattern'] ="";
            }


            if(empty($data['sleeve'])){
                $data['sleeve'] ="";
            }

            if(empty($data['fit'])){
                $data['fit'] ="";
            }

            if(empty($data['occasion'])){
                $data['occasion'] ="";
            }

            if(empty($data['meta_title'])){
                $data['meta_title'] ="";
            }

            if(empty($data['meta_keywords'])){
                $data['meta_keywords'] ="";
            }

            if(empty($data['meta_description'])){
                $data['meta_description'] ="";
            }
            if(empty($data['meta_discount'])){
                $data['meta_description'] =0;
            }
            if(empty($data['meta_weight'])){
                $data['meta_description'] =0;
            }
            if(empty($data['description'])){
                $data['description'] ="";
            }
            if(empty($data['wash_care'])){
                $data['wash_care'] ="";
            }
            $product = new Product;
            // Upload Product Image
            if($request->hasFile('main_image')){
                $image_tmp=$request->file('main_image');
                if($image_tmp->isValid()){
                    //Upload images after resize
                    $image_name = $image_tmp->getCLientOriginalName();
                    $extension=$image_tmp->getClientOriginalExtension();
                    $imageName=$image_name.'-'.rand(111,99999).'.'.$extension;
                    $large_image_path='images/product_images/large/'.$imageName;
                    $medium_image_path='images/product_images/medium/'.$imageName;
                    $small_image_path='images/product_images/small/'.$imageName;
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(540,540.417)->save($medium_image_path);
                    Image::make($image_tmp)->resize(260,300)->save($small_image_path);
                    $product->main_image=$imageName;
                }
            }
            //Upload Product Video
            if($request->hasFile('product_video')){
                $video_tmp =$request->hasFile('product_video');
                if($video_tmp->isValid()){
                    //Upload Video
                    $video_name=$video_tmp->getClientOriginalName();
                    $extension=$video_tmp->getClientOriginalExtension();
                    $videoName=$video_name.'-'.rand().'.'.$extension;
                    $video_path='videos/product_videos/';
                    $video_tmp->move($video_path,$videoName);
                    // Save Video im products table
                    $product->product_video=$videoName;
                }
            }

            //Save Product details in products table
            
            $categoryDetails = Category::find($data['category_id']);
            $product->section_id = $categoryDetails['sid'];
            $product->category_id=$data['category_id'];
            $product->product_name=$data['product_name'];
            $product->product_code=$data['product_code'];
            $product->product_color=$data['product_color'];
            $product->group_code=$data['group_code'];
            $product->product_price=$data['product_price'];
            $product->product_discount=$data['product_discount'];
            $product->product_weight=$data['product_weight'];
            $product->description=$data['description'];
            $product->wash_care=$data['wash_care'];
            $product->fabric=$data['fabric'];
            $product->pattern=$data['pattern'];
            $product->sleeve=$data['sleeve'];
            $product->fit=$data['fit'];
            $product->occasion=$data['occasion'];
            $product->meta_title=$data['meta_title'];
            $product->meta_keywords=$data['meta_keywords'];
            $product->meta_description=$data['meta_description'];
            if(!empty($data['is_featured'])){
            
                $product->is_featured=$data['is_featured'];
            }else{
                $product->is_featured = "No";
            }
            $product->status=1;
            $product->save();
            session::flash('success_message',$message);
            return redirect('admin/products');
        }
        //Filter Arrays
        $fabricArray= array('Cotton','Polyster','Wool');
        $sleeveArray= array('Full Sleeve','Half Sleeve','Short Sleeve','Sleeveless');
        $patternArray= array('Checked','Plain','Printed','Self','Solid');
        $fitArray= array('Regular','Slim');
        $occasionArray= array('Casual','Formal');
        // Sections with Categories and Sub Categories
        $categories= Section::with('categories')->get();
        $categories=json_decode(json_encode($categories),true);
        //echo "<pre>";print_r($categories);die;
        return view('admin.products.add_edit_product')->with(compact('title','fabricArray','sleeveArray','patternArray','fitArray','occasionArray','categories','productdata'));
    }
    public function deleteProductImage($id){
        $productImage = Product::select('main_image')->where('id',$id)->first();
        $small_image_path='images/product_images/small/';
        $medium_image_path='images/product_images/medium/';
        $large_image_path='images/product_images/large/';
        if(file_exists($small_image_path.$productImage->main_image)){
            unlink($small_image_path.$productImage->main_image);
        }
        if(file_exists($medium_image_path.$productImage->main_image)){
            unlink($medium_image_path.$productImage->main_image);
        }
        if(file_exists($large_image_path.$productImage->main_image)){
            unlink($large_image_path.$productImage->main_image);
        }
        Product::where('id',$id)->update(['main_image'=>'']);
        $message='Product Image has been deleted successfully';
        session::flash('success_message',$message);
        return redirect()->back();
    }
    public function addAttributes(Request $request,$id){
        if($request->isMethod('post')){
            $data=$request->all();
            foreach($data['sku'] as $key =>$value){
                if(!empty($value)){
                    //SKU already exists check
                    $attrCountSKU = ProductsAttributes::where('sku',$value)->count();
                    if($attrCountSKU>0){
                        $message='SKU already exists. Please add another SKU';
                        session::flash('error_message',$message);
                        return redirect()->back();
                    }
                     //Size already exists check
                     $attrCountSize = ProductsAttributes::where(['product_id'=>$id,'size'=>$data['size'][$key]])->count();
                     if($attrCountSize>0){
                         $message='Size already exists. Please add another Size';
                         session::flash('error_message',$message);
                         return redirect()->back();
                     }
                    $attribute = new ProductsAttributes;
                    $attribute->product_id=$id;
                    $attribute->sku=$value;
                    $attribute->size=$data['size'][$key];
                    $attribute->price=$data['price'][$key];
                    $attribute->stock=$data['stock'][$key];
                    $attribute->status=1;
                    $attribute->save();
                }
            }
        }
        $productdata=Product::select('id','product_name','product_code','product_color','main_image')->with('attributes')->find($id);
        $productdata=json_decode(json_encode($productdata),true);
      //  echo"<pre>";print_r($productdata);die;
        $title ="Product Attributes";
        return view('admin.products.add_attributes')->with(compact('productdata','title'));
    }
    public function editAttributes(Request $request,$id){
        if($request->isMethod('post')){
            $data=$request->all();
            foreach($data['attrId']as $key => $attr){
                if(!empty($attr)){
                    ProductsAttributes::where(['id'=>$data['attrId'][$key]])->update(['price'=>$data['price'][$key],'stock'=>$data['stock'][$key]]);
                }
            }
            $message ='Product attributes has been edited successfully!';
            session::flash('success_message',$message);
            return redirect()->back();
        }
    }
    public function updateAttributeStatus(Request $request){
        if($request->ajax()){
            $data=$request->all();
            if($data['status']=="Active"){
                $status=0;
            }else{
                $status=1;
            }
            ProductsAttributes::where('id',$data['attribute_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'attribute_id'=>$data['attribute_id']]);
        }
    }
    public function deleteAttribute($id){
        ProductsAttributes::where('id',$id)->delete();
        $message='Product Attribute has been deleted successfully';
        session::flash('success_message',$message);
        return redirect()->back();
    }
    public function addImages($id){
        $productdata = Product::with('images')->select('id','product_name','product_code','product_color','main_image')->find($id);
        $productdata=json_decode(json_encode($productdata),true);
        echo "<pre>";print_r($productdata);die;
        $title="Product Images";
        return view('admin.products.add_images')->with(compact('title','productdata'));
    }
}
