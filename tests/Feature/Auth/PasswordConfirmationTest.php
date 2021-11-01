<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use function Pest\Laravel\actingAs;
use function Tests\user;

beforeEach(function(): void {
    $this->user = user();
});

test('confirm password screen can be rendered')
    ->tap(fn () => actingAs($this->user))
    ->get('/confirm-password')
    ->assertOk();

test('password can be confirmed')
    ->tap(fn () => actingAs($this->user))
    ->post('/confirm-password', [
        'password' => 'password',
    ])
    ->assertRedirect()
    ->assertSessionHasNoErrors();

test('password is not confirmed with invalid password')
    ->tap(fn () => actingAs($this->user))
    ->post('/confirm-password', [
        'password' => 'wrong-password',
    ])
    ->assertRedirect()
    ->assertSessionHasErrors();
