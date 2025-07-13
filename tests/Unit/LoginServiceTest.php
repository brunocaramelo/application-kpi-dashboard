<?php

namespace Tests\Feature\Http\Controllers;

use App\Services\LoginService;
use App\Repositories\UserRepository;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

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

    test('create user sucess', function () {
        $loginData = [
            'name' => 'nonexistent_1',
            'email' => 'nonexistent_1@example.com',
            'password' => 'anypassword',
        ];

        $service = new UserRepository();
        $response = $service->create($loginData)->toArray();

        expect($response)
            ->toBeArray()
            ->toHaveKeys(['id', 'email']);
    });

    test( 'update user sucess', function () {

        $loginData = [
            'name' => 'nonexistent_2',
            'email' => 'nonexistent_2@example.com',
            'password' => 'anypassword',
        ];

        $service = new UserRepository();
        $response = $service->update($loginData, 1)->toArray();

        expect($response)
            ->toBeArray()
            ->toHaveKeys(['id', 'email']);
    });


});
