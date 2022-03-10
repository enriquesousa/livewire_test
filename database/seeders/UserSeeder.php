<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Enrique Sousa',
            'email' => 'enrique.sousa@gmail.com',
            'password' => bcrypt('sousa1234'),
        ]);

        // User::factory(99)->create();
    }
}
