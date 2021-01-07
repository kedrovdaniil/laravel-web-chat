<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('chat_user')->insert([
            'chat_id' => 1,
            'user_id' => 1,
        ]);
        DB::table('chat_user')->insert([
            'chat_id' => 1,
            'user_id' => 2,
        ]);
        DB::table('chat_user')->insert([
            'chat_id' => 2,
            'user_id' => 1,
        ]);
        DB::table('chat_user')->insert([
            'chat_id' => 2,
            'user_id' => 2,
        ]);
        DB::table('chat_user')->insert([
            'chat_id' => 2,
            'user_id' => 3,
        ]);
    }
}
