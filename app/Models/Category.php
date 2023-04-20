<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    
    public function subcategories(){
        return $this->hasMany('App\Models\Category','pid')->where('status',1);
    }
    public function section(){
        return $this->belongsTo('App\Models\Section','sid')->select('id','name');
    }
    public function parentcategory(){
        return $this->belongsTo('App\Models\Category','pid')->select('id','categoryName');
    }
    public static function catDetails($url){
        $catDetails = Category::select('id','categoryName','url')->with(['subcategories'=> 
        function($query){
            $query->select('id','pid')->where('status',1);
        }])->
        where('url',$url)->first()->toArray();
        $catIds = array();
        $catIds[]= $catDetails['id'];
        foreach($catDetails['subcategories'] as $key => $subcat){
            $catIds[]=$subcat['id'];
        }
        return array('catIds'=>$catIds,'catDetails'=>$catDetails);
    }
}
