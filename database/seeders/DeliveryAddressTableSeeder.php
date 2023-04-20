<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DeliveryAddress;

class DeliveryAddressTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $deliveryRecords=[
            ['id'=>1,'user_id'=>1,'name'=>'Ali DORBOZ','address'=>'Test','governorate'=>'Tunis',
            'delegation'=>'Djbel Jelloud','pincode'=>1046,'mobile'=>96366471,'status'=>1]
        ];
        DeliveryAddress::insert($deliveryRecords);
    }
}
