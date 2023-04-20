<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function category(){
        return $this->belongsTo('App\Models\Category','category_id');
    }
    public function section(){
        return $this->belongsTo('App\Models\Section','section_id');
    }
    public function attributes(){
        return $this->hasMany('App\Models\ProductsAttributes');
    }
    public function images(){
        return $this->hasMany('App\Models\ProductsImage');
    }
    public static function getDiscountedPrice($product_id){
        $proDetails = Product::select('product_price','product_discount','category_id')->where('id',$product_id)->first()->toArray();
        $catDetails = Category::select('categoryDiscount')->where('id',$proDetails['category_id'])->first()->toArray();
        if($proDetails['product_discount']>0){
            // if product discount is added from admin panel
            $discounted_price=$proDetails['product_price'] - ($proDetails['product_price']*$proDetails['product_discount']/100);
            //Sale Price = cost price - discount price

        }else if($catDetails['categoryDiscount']>0){
            //if product discount is not added and category discount added from admin panel
            $discounted_price=$proDetails['product_price'] - ($proDetails['product_price']*$catDetails['categoryDiscount']/100);

        }else{
            $discounted_price=0;
        }
        return $discounted_price;
    }
    public static function getDiscountAttrPrice($product_id,$size){
        $proAttrPrice = ProductsAttributes::where(['product_id'=>$product_id,'size'=>$size])->first()->toArray();
        $proDetails = Product::select('product_discount','category_id')->where('id',$product_id)->first()->toArray();
        $catDetails = Category::select('categoryDiscount')->where('id',$proDetails['category_id'])->first()->toArray();
        if($proDetails['product_discount']>0){
            // if product discount is added from admin panel
            $final_price=$proAttrPrice['price'] - ($proAttrPrice['price']*$proDetails['product_discount']/100);
            //Sale Price = cost price - discount price
            $discount = $proAttrPrice['price'] - $final_price;
    
        }else if($catDetails['categoryDiscount']>0){
            //if product discount is not added and category discount added from admin panel
            $final_price=$proAttrPrice['price'] - ($proAttrPrice['price']*$catDetails['categoryDiscount']/100);
            $discount = $proAttrPrice['price'] - $final_price;

        }else{
            $final_price=$proAttrPrice['price'];
            $discount = 0;
        }
        return array('product_price'=>$proAttrPrice['price'],'final_price'=>$final_price,'discount'=>$discount);
    }
    public static function getProductImage($product_id){
        $getProductImage=Product::select('main_image')->where('id',$product_id)->first()->toArray();
        return $getProductImage['main_image'];
    }
    public static function getProductStatus($product_id){
        $getProductStatus=Product::select('status')->where('id',$product_id)->first()->toArray();
        return $getProductStatus['status'];
    }
    public static function getProductStock($product_id,$product_size){
       $getProductStock=ProductsAttributes::select('stock')->where(['product_id'=>$product_id,'size'=>$product_size])->first()->toArray();
       return $getProductStock['stock'];

    }
    public static function deleteCartProduct($product_id){
        Cart::where('product_id',$product_id)->delete();
    }
    public static function getAttributeCount($product_id,$product_size){
        $getAttributeCount = ProductsAttributes::where(['product_id'=>$product_id,'size'=>$product_size,'status'=>1])->count();
        return $getAttributeCount;
    }
    public static function getCategoryStatus($category_id){
        $getCategoryStatus= Category::select('status')->where('id',$category_id)->first()->toArray();
        return $getCategoryStatus['status'];
    }
    
}
 