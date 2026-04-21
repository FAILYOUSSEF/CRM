<?php

namespace Database\Seeders;
use App\Models\User;
use App\Models\Project;
use App\Models\Task;
use App\Models\Categorie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder {
    public function run(): void {

        // Admin
        $admin = User::create([
            'name'        => 'Admin User',
            'email'       => 'admin@app.com',
            'password'    => Hash::make('password'),
            'type_client' => 'admin',
            'status'      => 'active',
        ]);

        // Employees
        $emp1 = User::create([
            'name'        => 'Alice Employee',
            'email'       => 'alice@app.com',
            'password'    => Hash::make('password'),
            'type_client' => 'employee',
            'status'      => 'active',
        ]);
        $emp2 = User::create([
            'name'        => 'Bob Employee',
            'email'       => 'bob@app.com',
            'password'    => Hash::make('password'),
            'type_client' => 'employee',
            'status'      => 'active',
        ]);

        // Client
        $client = User::create([
            'name'        => 'Client Corp',
            'email'       => 'client@app.com',
            'password'    => Hash::make('password'),
            'type_client' => 'client',
            'status'      => 'active',
        ]);

        // Categories
        $cat1 = Categorie::create(['name' => 'Bug Report',   'description' => 'Software bugs']);
        $cat2 = Categorie::create(['name' => 'Feature Request', 'description' => 'New feature requests']);
        $cat3 = Categorie::create(['name' => 'Support',      'description' => 'General support']);

        // Project
        $project = Project::create([
            'titre'       => 'Website Redesign',
            'description' => 'Full redesign of corporate website.',
            'status'      => 'en cours',
            'priorite'    => 'haute',
            'budget'      => 50000.00,
            'date_duree'  => now()->toDateString(),
            'date_fin'    => now()->addMonths(3)->toDateString(),
            'client_id'   => $client->id,
        ]);

        // Assign employees to project
        $project->employees()->attach([$emp1->id, $emp2->id]);

        // Tasks
        Task::create([
            'titre'       => 'Design mockups',
            'description' => 'Create Figma mockups for all pages.',
            'status'      => 'en cours',
            'priorite'    => 'haute',
            'date_debut'  => now()->toDateString(),
            'date_fin'    => now()->addWeeks(2)->toDateString(),
            'employee_id' => $emp1->id,
            'project_id'  => $project->id,
        ]);
        Task::create([
            'titre'       => 'Backend API',
            'description' => 'Develop REST API endpoints.',
            'status'      => 'à faire',
            'priorite'    => 'moyenne',
            'date_debut'  => now()->addWeeks(1)->toDateString(),
            'date_fin'    => now()->addMonths(2)->toDateString(),
            'employee_id' => $emp2->id,
            'project_id'  => $project->id,
        ]);
    }
}