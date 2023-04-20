<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class IndexController extends Controller
{
    public function index(){
        //Get Featured Items
        $featuredItemsCount= Product::where('is_featured','Yes')->count();
        $featuredItems = Product::where('is_featured','Yes')->where('status',1)->get()->toArray();
        $featuredItemsChunk= array_chunk($featuredItems,4);
        //echo"<pre>";print_r($featuredItemsChunk);die;
        //dd  ($featuredItems);die;

        // Get New Products
        $newProducts = Product::orderBy('id','Desc')->where('status',1)->limit(6)->get()->toArray();
       
        //echo "<pre>"; print_r($newProducts);die;
        $page_name="index";
        return view('front.index')->with(compact('page_name','featuredItemsChunk','featuredItemsCount','newProducts'));
    }
}
