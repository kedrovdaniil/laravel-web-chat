<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            ChatsSeeder::class,
            FilesSeeder::class,
            MessagesAttachmentsSeeder::class,
            MessagesSeeder::class,
            UserSeeder::class,
            ChatUserSeeder::class
        ]);
    }
}
