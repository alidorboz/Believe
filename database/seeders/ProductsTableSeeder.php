<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productRecords=[
            ['id'=>1,'category_id'=>1,'section_id'=>1,'product_name'=>'Blue T-shirt','product_code'=>'BT001',
            'product_color'=>'Blue','product_price'=>1500,'product_discount'=>10,'product_weight'=>200,'product_video'=>'',
            'main_image'=>'','description'=>'Test Product','wash_care'=>'','fabric'=>'','pattern'=>'','sleeve'=>'',
            'fit'=>'','occasion'=>'','meta_title'=>'','meta_description'=>'','meta_keywords'=>'','is_featured'=>'No',
            'status'=>1
        ],
        ];
        Product::insert($productRecords);
    }
}
