<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       
        $adminRecords = [
            [
                'id'=>1,'name'=>'admin','type'=>'admin','mobile'=>'96366471','email'=>'dorbozali51@gmail.com','password'=>'$2y$10$Y4dl72QdNKgkOGGLC9d.fOIPeQ5AJL3cgHyN3XU2aIjuRR7aVnDfm','image'=>'','status'=>1
            ],
        ];
       Admin::insert($adminRecords);
    }
}
