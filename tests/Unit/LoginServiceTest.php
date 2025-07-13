<?php

namespace Tests\Feature\Http\Controllers;

use App\Services\LoginService;
use App\Repositories\UserRepository;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->artisan('db:seed', ['--class' => 'DatabaseTestSuiteSeeder']);
});

describe('LoginService', function () {

    test('doLogin with valid credentials returns token', function () {
        $password = 'password123';

        $loginData = [
            'email' => 'user@example.com',
            'password' => $password,
        ];

        $service = new LoginService(new UserRepository());
        $response = $service->doLogin($loginData);

        expect($response)
            ->toBeArray()
            ->toHaveKeys(['status', 'message', 'access_token'])
            ->toHaveKey('status', 'success');

        expect($response['access_token'])->toBeString()->not->toBeEmpty();
    });

    test('doLogin with invalid password returns error', function () {

        $loginData = [
            'email' => 'user@example.com',
            'password' => 'wrong-password',
        ];

        $service = new LoginService(new UserRepository());
        $response = $service->doLogin($loginData);

        expect($response)
            ->toBeArray()
            ->toHaveKeys(['status', 'message'])
            ->toHaveKey('status', 'fail')
            ->toHaveKey('message', 'Email ou senha incorretos'); // Assumindo a mensagem de erro
    });

    test('doLogin with non-existent email returns error', function () {
        $loginData = [
            'email' => 'nonexistent@example.com',
            'password' => 'anypassword',
        ];

        $service = new LoginService(new UserRepository());
        $response = $service->doLogin($loginData);

        expect($response)
            ->toBeArray()
            ->toHaveKeys(['status', 'message'])
            ->toHaveKey('status', 'fail')
            ->toHaveKey('message', 'Email ou senha incorretos');
    });


});
