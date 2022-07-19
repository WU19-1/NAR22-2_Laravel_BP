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
        User::create([
            'name' => 'elianna',
            'email' => 'itsnotsoeli@gmail.com',
            'password' => bcrypt('malamala'),
            'role' => 'admin'
        ]);
        User::create([
            'name' => 'wuwu',
            'email' => 'wuwu@gmail.com',
            'password' => bcrypt('malamala'),
            'role' => 'user'
        ]);
    }
}
