<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pimages;

class PimagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $productImageRecords = [
            ['id'=>1,'pid'=>1,'img'=>'cat.jpg-26729.jpg','status'=>1]
        ];
        Pimages::insert($productImageRecords);
    }
}
