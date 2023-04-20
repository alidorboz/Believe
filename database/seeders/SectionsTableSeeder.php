<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Section;

class SectionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sectionRecords=[
            ['id'=>1,'name'=>'Clothes','status'=>1],
            ['id'=>2,'name'=>'Paintings','status'=>1],
            ['id'=>3,'name'=>'Accessories','status'=>1]
        ];
        Section::insert($sectionRecords);
    }
}
