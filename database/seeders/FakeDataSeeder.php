<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FakeDataSeeder extends Seeder
{

    private function getRoles() {
        $models = \App\Models\Role::all();
        $data = [];
        foreach ($models as $model) {
            $data[$model->gate_name] = $model->id;
        }
        return $data;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = $this->getRoles();

        $model = \App\Models\User::factory()->create([
            'name' => 'Dr João',
            'email' => 'joao@medico.dev',
            'password' => Hash::make('medico.dev'),
        ]);
        \App\Models\UserRole::factory()->create(['user_id' => $model->id, 'role_id' => $roles['doctor']]);

        $model = \App\Models\User::factory()->create([
            'name' => 'Dra Maria',
            'email' => 'maria@medico.dev',
            'password' => Hash::make('medico.dev'),
        ]);
        \App\Models\UserRole::factory()->create(['user_id' => $model->id, 'role_id' => $roles['doctor']]);

        $model = \App\Models\User::factory()->create([
            'name' => 'Dr José',
            'email' => 'jose@medico.dev',
            'password' => Hash::make('medico.dev'),
        ]);
        \App\Models\UserRole::factory()->create(['user_id' => $model->id, 'role_id' => $roles['doctor']]);

        $model = \App\Models\User::factory()->create([
            'name' => 'Atendente 01',
            'email' => 'atendente01@atendimento.dev',
            'password' => Hash::make('atendimento.dev'),
        ]);
        \App\Models\UserRole::factory()->create(['user_id' => $model->id, 'role_id' => $roles['attendant']]);

        $model = \App\Models\User::factory()->create([
            'name' => 'Atendente 02',
            'email' => 'atendente02@atendimento.dev',
            'password' => Hash::make('atendimento.dev'),
        ]);
        \App\Models\UserRole::factory()->create(['user_id' => $model->id, 'role_id' => $roles['attendant']]);

        $model = \App\Models\User::factory()->create([
            'name' => 'Eduardo Fernandes Azevedo',
            'email' => 'eduardo.azevedo@paciente.dev',
            'password' => Hash::make('paciente.dev'),
        ]);
        \App\Models\UserRole::factory()->create(['user_id' => $model->id, 'role_id' => $roles['patient']]);

        $model = \App\Models\User::factory()->create([
            'name' => 'Danilo Melo Costa',
            'email' => 'danilo.costa@paciente.dev',
            'password' => Hash::make('paciente.dev'),
        ]);
        \App\Models\UserRole::factory()->create(['user_id' => $model->id, 'role_id' => $roles['patient']]);

        $model = \App\Models\User::factory()->create([
            'name' => 'Mateus Souza Alves',
            'email' => 'mateus.alves@paciente.dev',
            'password' => Hash::make('paciente.dev'),
        ]);
        \App\Models\UserRole::factory()->create(['user_id' => $model->id, 'role_id' => $roles['patient']]);

        $model = \App\Models\User::factory()->create([
            'name' => 'Vinicius Dias Barbosa',
            'email' => 'vinicius.barbosa@paciente.dev',
            'password' => Hash::make('paciente.dev'),
        ]);
        \App\Models\UserRole::factory()->create(['user_id' => $model->id, 'role_id' => $roles['patient']]);
    }
}
