<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;

use function Tests\user;

beforeEach(function(): void {
    $this->user = user();
    Notification::fake();
});

test('reset password link screen can be rendered')
    ->get('/forgot-password')
    ->assertOk();

test('reset password link can be requested', function(): void {
    $this->post('/forgot-password', ['email' => $this->user->email]);

    Notification::assertSentTo($this->user, ResetPassword::class);
});

test('reset password screen can be renbeded', function(): void {
    $this->post('/forgot-password', ['email' => $this->user->email]);

    Notification::assertSentTo($this->user, ResetPassword::class, function ($notification) {
        $response = $this->get('/reset-password/'.$notification->token);

        $response->assertStatus(200);

        return true;
    });
});


test('password can be reset with valid token', function(): void {
    $this->post('/forgot-password', ['email' => $this->user->email]);

    Notification::assertSentTo($this->user, ResetPassword::class, function ($notification) {
        $response = $this->post('/reset-password', [
            'token' => $notification->token,
            'email' => $this->user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $response->assertSessionHasNoErrors();

        return true;
    });
});
