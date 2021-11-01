<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;

use function Pest\Laravel\post;
use function Tests\user;

beforeEach(function(): void {
    $this->user = user();
});

test('login screen can be rendered')
    ->get('/login')
    ->assertOk();

test('users can authenticate using the login screen')
    ->expect(fn () => post('login', [
        'email' => $this->user->email,
        'password' => 'password',
    ]))
    ->assertRedirect(RouteServiceProvider::HOME)
    ->and(fn () => $this)
    ->assertAuthenticated();

test('users can not authenticate with invalid password')
    ->expect(fn () => post('login', [
        'email' => $this->user->email,
        'password' => 'wrong-password',
    ]))
    ->assertRedirect()
    ->and(fn () => $this)
    ->assertGuest();
