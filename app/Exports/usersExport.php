<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class usersExport implements WithHeadings,FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //return User::all();
        $usersData = User::select('id','name','address','city','pincode','mobile','email','created_at')->where('status',1)->orderBy('id','Desc')->get();
        return $usersData;
    }
    public function headings():array{
        return [
            'id','Name','Address','City','Postal Code','Mobile','E-Mail','Registred on'
        ];
    }
}
