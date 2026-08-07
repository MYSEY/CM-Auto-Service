<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatBotResponseSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('chat_bot_responses')->insert([
            ['keyword' => 'hello,hi', 'response' => 'Hello! Welcome to CM Auto Service. How can we help you today?', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['keyword' => 'price,ថ្លៃ,តម្លៃ', 'response' => 'Please tell us the product name or part number, and we will check the price for you.', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['keyword' => 'ecu,ECU', 'response' => 'We offer ECU programming, cloning, and tuning services. What ECU do you need?', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['keyword' => 'shipping,ដឹកជញ្ជូន', 'response' => 'We ship worldwide. Delivery usually takes 3-7 business days.', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['keyword' => 'contact,ទំនាក់ទំនង', 'response' => 'You can reach us at +855 031 486 6777 or the.c.m.auto@gmail.com', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['keyword' => 'thank,thanks,អរគុណ', 'response' => 'You are welcome! Let us know if you need anything else.', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['keyword' => 'product,ផលិតផល', 'response' => 'We sell ECU, auto parts, and tuning files. What product are you looking for?', 'is_active' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
