<?php

namespace Database\Seeders\Tests;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class UserTesterSeeder extends Seeder
{

    public function run()
    {
        $listUsers = [
            [
                'name' => 'Example',
                'email' => 'user@example.com',
                'password' => Hash::make('password123'),

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
