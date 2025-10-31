<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *php artisan db:seed --class=CompanySeeder
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name_kh' => 'ចំការកៅស៊ូមេមត់ ខូអិលធីឌី',
                'name_en'=> 'MRP,.Col.Ltd',
                'company_logo'=> 'logo.jpg',
                'address_kh'=> 'ត្បូងឃ្មុំ',
                'address_en'=> 'Tbong Khmun',
                'phone_number'=> '012356956',
                'email'=> 'example@gmail.com',
                'website'=> 'www.mrp.com.kh',
                'created_by'  => '1',
            ],
        ];
        foreach ($data as $value) {
            Company::firstOrCreate($value);
        }
    }
}
