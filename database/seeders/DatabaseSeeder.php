<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Storage::deleteDirectory('public/posts-images');
        Storage::makeDirectory('public/posts-images');

        $this->call(UserSeeder::class);

        \App\Models\Post::factory(100)->create();
    }
}
