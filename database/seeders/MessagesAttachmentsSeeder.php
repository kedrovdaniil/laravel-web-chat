<?php

namespace Database\Seeders;

use App\Models\Message_attachment;
use Illuminate\Database\Seeder;

class MessagesAttachmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Message_attachment::truncate();

        Message_attachment::factory()->times(20)->create();
    }
}
