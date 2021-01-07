<?php

namespace Database\Seeders;

use App\Models\Chat;
use Database\Factories\ChatFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ChatsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Chat::truncate();

        Chat::factory()->times(5)->create();
    }
}
