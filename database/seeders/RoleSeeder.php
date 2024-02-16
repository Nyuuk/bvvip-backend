<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Role::create([
            'name' => 'Developer',
            'can' => [
                'r-server-free',
                'r-server-paid',
                'r-service-free',
                'r-service-paid',
                'w-server-free',
                'w-server-paid',
                'w-service-free',
                'w-service-paid',
                'r-proxy',
                'w-proxy',
                'r-vpn',
                'w-vpn',
                'r-log',
            ]
        ]);

        Role::create([
            'name' => 'Admin',
            'can' => [
                'r-server-free',
                'r-server-paid',
                'r-service-free',
                'r-service-paid',
                'w-server-free',
                'w-server-paid',
                'w-service-free',
                'w-service-paid',
                'r-proxy',
                'w-proxy',
                'r-vpn',
                'w-vpn'
            ]
        ]);

        Role::create([
            'name' => 'Reseller',
            'can' => [
                'r-server-free',
                'r-server-paid',
                'r-service-free',
                'r-service-paid',
                'r-proxy',
                'w-proxy'
            ]
        ]);
    }
}
