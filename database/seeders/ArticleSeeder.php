<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        Article::factory()
            ->for($user)
            ->count(20)
            ->create();
    }
}
