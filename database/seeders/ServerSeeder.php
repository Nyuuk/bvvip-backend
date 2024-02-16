<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
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
