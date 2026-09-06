<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name'     => 'Presiden BEM',
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
            [
                'name'     => 'Pengurus Kemenlu',
                'email'    => 'kemenlu@bemkm.ac.id',
                'password' => Hash::make('password'),
                'role'     => 'kementerian',
            ],
        ];

        foreach ($users as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                $data
            );
        }

        $this->command->info('✓ 4 demo users seeded (password: password)');
    }
}
