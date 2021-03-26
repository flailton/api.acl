<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'targetit';
        $user->email = 'targetit@targetit.com';
        $user->password = bcrypt('targetit@123');
        $user->phone = '+55 (071) 99191-9191';
        $user->save();
    }
}
