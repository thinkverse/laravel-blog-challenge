<?php

declare(strict_types=1);

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\URL;

use function Pest\Laravel\actingAs;
use function Tests\user;

beforeEach(function(): void {
    $this->user = user([
        'email_verified_at' => null,
    ]);
});

test('email verification screen can be rendered', function(): void {
    actingAs($this->user)
        ->get('/verify-email')
        ->assertOk();
});

test('email can be verified', function(): void {
    Event::fake();

    $verificationUrl = URL::temporarySignedRoute(
        'verification.verify',
        now()->addMinutes(60),
        ['id' => $this->user->id, 'hash' => sha1($this->user->email)]
    );

    actingAs($this->user)
        ->get($verificationUrl)
        ->assertRedirect(RouteServiceProvider::HOME.'?verified=1');

    Event::assertDispatched(Verified::class);

    expect($this->user)
        ->fresh()
        ->hasVerifiedEmail()
        ->toBeTrue();
});

test('email is not verified with invalid hash', function(): void {
    $verificationUrl = URL::temporarySignedRoute(
        name: 'verification.verify',
        expiration: now()->addMinutes(60),
        parameters: ['id' => $this->user->id, 'hash' => sha1('wrong-email')]
    );

    actingAs($this->user)
        ->get($verificationUrl);

    expect($this->user)
        ->fresh()
        ->hasVerifiedEmail()
        ->toBeFalse();
});
