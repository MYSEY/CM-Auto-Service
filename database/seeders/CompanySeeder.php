<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $exists = DB::table('companies')->first();
        if (!$exists) {
            DB::table('companies')->insert([
                'name_kh'     => 'ស៊ីអិម អូតូ សេវីស',
                'name_en'     => 'CM Auto Service',
                'company_logo' => asset('frontends/assets/img/logo.png'),
                'address_kh'  => 'ភ្នំពេញ កម្ពុជា',
                'address_en'  => 'Phnom Penh, Cambodia',
                'phone_number' => '+855 0314866777',
                'email'       => 'the.c.m.auto@gmail.com',
                'website'     => 'https://cmautoservic.com',
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}