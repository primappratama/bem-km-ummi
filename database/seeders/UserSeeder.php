<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'     => 'Administrator',
                'email'    => 'admin@bemkm.ac.id',
                'password' => Hash::make('password'),
                'role'     => 'super_admin',
            ],
            [
                'name'     => 'Sekretaris Umum',
                'email'    => 'sekretaris@bemkm.ac.id',
                'password' => Hash::make('password'),
                'role'     => 'sekretaris',
            ],
            [
                'name'     => 'Bendahara Umum',
                'email'    => 'bendahara@bemkm.ac.id',
                'password' => Hash::make('password'),
                'role'     => 'bendahara',
            ],
        ];

        foreach ($users as $u) {
            User::firstOrCreate(
                ['email' => $u['email']],
                [
                    'name'     => $u['name'],
                    'password' => $u['password'],
                    'role'     => $u['role'],
                ]
            );
        }

        $this->command->info('✓ Users seeded (admin, sekretaris, bendahara)');
        $this->command->info('  Login: admin@bemkm.ac.id / password');
    }
}
