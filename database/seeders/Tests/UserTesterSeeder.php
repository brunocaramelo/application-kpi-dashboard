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
                'id' => 1,
                'name' => 'Admin',
                'email' => 'admin@test.com',
                'password' => Hash::make('password'),
            ]
        ];

        foreach($listUsers as $item) {

            if (User::where('id', $item['id'])->exists()) {
                continue;
            }

            User::create($item);
        }

    }
}
