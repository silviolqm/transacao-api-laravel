<?php

namespace Database\Seeders;

use App\Models\Transacao;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(3)->create();

        foreach ($users as $user) {
            Transacao::factory(5)->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
