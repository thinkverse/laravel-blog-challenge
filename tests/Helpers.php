<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;

function user(array $attributes = [], mixed ...$parameters): Collection|Model|Authenticatable
{
    return User::factory($parameters)->create($attributes);
}
