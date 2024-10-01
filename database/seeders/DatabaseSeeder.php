<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $adminUser = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.dev',
            'password' => Hash::make('admin.dev'),
        ]);

        $adminRole = \App\Models\Role::factory()->create(['name' => 'Admin', 'gate_name' => 'admin']);

        \App\Models\UserRole::factory()->create(['user_id' => $adminUser->id, 'role_id' => $adminRole->id]);

        \App\Models\Role::factory()->create(['name' => 'Atendente', 'gate_name' => 'attendant']);
        \App\Models\Role::factory()->create(['name' => 'Paciente', 'gate_name' => 'patient']);
        \App\Models\Role::factory()->create(['name' => 'Médico', 'gate_name' => 'doctor']);
    }
}
