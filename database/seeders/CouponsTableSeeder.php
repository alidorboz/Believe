<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Coupon;
class CouponsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $couponRecords = [
            ['id'=>1,'coupon_option'=>'Manual','coupon_code'=>'believe','categories'=>'1,4',
            'users'=>'dorbozali51@gmail.com,dorboza123@gmail.com','coupon_type'=>'single',
            'amount_type'=>'Percentage','amount'=>'20','expiry_date'=>'2023-04-10','status'=>1],

        ];
        Coupon::insert($couponRecords);
    }
}
