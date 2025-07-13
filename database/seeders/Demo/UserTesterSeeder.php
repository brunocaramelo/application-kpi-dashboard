<?php

namespace Database\Seeders\Demo;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserTesterSeeder extends Seeder
{

    public function run()
    {
        $listUsers = [
            [
                'name' => 'Admin',
                'email' => 'admin@test.com',
                'password' => Hash::make('password'),

            ]
        ];

        foreach($listUsers as $item) {

            if (User::where('email', $item['email'])->exists()) {
                continue;
            }

            User::create($item);
        }

    }
}
