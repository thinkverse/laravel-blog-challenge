<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;

test('registration screen can be rendered')
    ->skip('registration disabled')
    ->get('/register')
    ->assertOk();

test('new users can register')
    ->skip('registration disabled')
    ->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])
    ->assertRedirect(RouteServiceProvider::HOME)
    ->and(fn () => $this)
    ->assertAuthenticated();
