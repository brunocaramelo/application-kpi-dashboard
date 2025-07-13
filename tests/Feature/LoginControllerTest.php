<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

uses(RefreshDatabase::class);

describe('LoginController', function () {

    test('doLogin with valid credentials returns token', function () {

        $user = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => Hash::make('password'), // Hash a senha
        ]);

        $loginData = [
            'email' => 'admin@test.com',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/login', $loginData);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'status',
                     'message',
                     'access_token',
                 ]);
    });

    test('doLogin with invalid credentials returns error', function () {
        $user = User::factory()->create([
            'email' => 'admin@test.com',
            'password' => Hash::make('correct-password'),
        ]);

        $loginData = [
            'email' => 'admin@test.com',
            'password' => 'password-wrong',
        ];

        $response = $this->postJson('/api/login', $loginData)
                ->assertStatus(400)
                 ->assertJsonStructure([
                     'message',
                     'status',
                 ]);
    });

    test('doLogin with missing email returns validation error', function () {

        $loginData = [
            'password' => 'secret',
        ];

        $response = $this->postJson('/api/login', $loginData)
                ->assertStatus(422)
                ->assertJsonStructure([
                     'message',
                     'errors' => [
                         'email',
                     ],
                 ]);
    });

    test('doLogin with missing password returns validation error', function () {
        $loginData = [
            'email' => 'admin@test.com',
        ];

        $response = $this->postJson('/api/login', $loginData)
                ->assertStatus(422)
                 ->assertJsonValidationErrors(['password']);
    });

    test('doLogin with invalid email format returns validation error', function () {
        $loginData = [
            'email' => 'invalid-email-format',
            'password' => 'password',
        ];

        $response = $this->postJson('/api/login', $loginData)
                ->assertStatus(422)
                 ->assertJsonValidationErrors(['email']);
    });
});
