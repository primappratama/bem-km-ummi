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
                'username' => 'admin',
                'email'    => 'admin@bemkm.ac.id',
                'password' => Hash::make('password'),
                'role'     => 'super_admin',
            ],
            [
                'name'     => 'Sekretaris Umum',
                'username' => 'sekretaris',
                'email'    => 'sekretaris@bemkm.ac.id',
                'password' => Hash::make('password'),
                'role'     => 'sekretaris',
            ],
            [
                'name'     => 'Bendahara Umum',
                'username' => 'bendahara',
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
                    'username' => $u['username'],
                    'email'    => $u['email'],
                    'password' => $u['password'],
                    'role'     => $u['role'],
                ]
            );
        }

        $this->command->info('✓ Users seeded (admin, sekretaris, bendahara)');
        $this->command->info('  Login: username=admin / password=password');
    }
}
