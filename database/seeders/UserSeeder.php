<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        User::factory()->create([
            'name' => 'Qwe Qwe',
            'avatar_url' => "https://cs16planet.ru/steam-avatars/images/avatar2700.jpg",
            'email' => "qwe@qwe.qwe",
            'email_verified_at' => now(),
            'password' => bcrypt('qweqwe'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        User::factory()->create([
            'name' => 'Asd Asd',
            'avatar_url' => "https://avatarko.ru/img/kartinka/31/multfilm_30781.jpg",
            'email' => "asd@asd.asd",
            'email_verified_at' => now(),
            'password' => bcrypt('asdasd'),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        User::factory()->times(3)->create();
    }
}
