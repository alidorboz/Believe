<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Banner;
class BannersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $bannerRecords = [
            ['id'=>1,'image'=>'banner1.jpeg','link'=>'','title'=>'First Pic','alt'=>'nice pic','status'=>1]
        ];
        Banner::insert($bannerRecords);
    }
}
