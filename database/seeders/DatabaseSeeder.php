<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        \App\Models\Server::create([
            'name' => "id",
            'ip' => 'id2.bukanvvip.my.id',
            'port' => '8000',
            'username' => 'asep',
            'password' => 'asepasep1010',
            'token' => null
        ]);
        \App\Models\Server::create([
            'name' => "sg",
            'ip' => 'sg.bukanvvip.my.id',
            'port' => '8000',
            'username' => 'asep',
            'password' => 'asepasep1010',
            'token' => null
        ]);

    }
}
