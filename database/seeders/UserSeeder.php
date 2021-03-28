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
        $user->name = 'admin';
        $user->email = 'admin@admin.com';
        $user->password = bcrypt('admin@123');
        $user->phone = '+55 (071) 99191-9191';
        $user->save();

        $user = new User();
        $user->name = 'user';
        $user->email = 'user@user.com';
        $user->password = bcrypt('user@123');
        $user->phone = '+55 (071) 99191-9191';
        $user->save();


    }
}
