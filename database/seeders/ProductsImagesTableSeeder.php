<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductsImage;

class ProductsImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productImageRecords = [
            ['id'=>1,'product_id'=>1,'image'=>'cat.jpg-26729.jpg',
            'status'=>1]
        ];
        ProductsImage::insert($productImageRecords);
    }
}
