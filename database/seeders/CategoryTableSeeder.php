<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categoryRecords =[
            ['id'=>1,'pid'=>0,'sid'=>1,'categoryName'=>'Hoodies','categoryImage'=>'','categoryDiscount'=>0,'description'=>'','url'=>'Hoodies','metaTitle'=>'','metaDescription'=>'','metaKeywords'=>'','status'=>1]
        ];
        Category::insert($categoryRecords);
    }
}
