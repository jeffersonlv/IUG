<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::firstOrCreate(
            ['email' => 'admin@institutoulyssesguimaraes.com.br'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('Iug@2026Adm!'),
                'active' => true,
            ]
        );
    }
}
