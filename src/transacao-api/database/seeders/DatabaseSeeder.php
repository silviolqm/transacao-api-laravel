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
        $user1 = User::factory()->create([
            'name' => 'user1',
            'email' => 'test1@test.com',
            'password' => bcrypt('Password!1'),
        ]);
        $user2 = User::factory()->create([
            'name' => 'user2',
            'email' => 'test2@test.com',
            'password' => bcrypt('Password!1'),
        ]);
        Transacao::factory(2)->create([
            'user_id' => $user1->id,
        ]);
        Transacao::factory(2)->create([
            'user_id' => $user2->id,
        ]);
    }
}
