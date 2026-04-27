<?php
 
namespace Database\Seeders;
 
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
 
class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
 
        $permissions = [
            // Users & Roles
            'user-list','user-create','user-edit','user-delete',
            'role-list','role-create','role-edit','role-delete',
            // Projects
            'project-list','project-create','project-edit','project-delete',
            // Tasks
            'task-list','task-create','task-edit','task-delete',
            // Tickets
            'ticket-list','ticket-create','ticket-reply','ticket-delete',
            // Reclamations
            'reclamation-list','reclamation-create','reclamation-reply',
            'reclamation-delete','reclamation-assign',
            // Categories
            'category-list','category-create','category-edit','category-delete',
            // Meetings
            'meeting-list','meeting-create','meeting-edit','meeting-delete',
            'meeting-respond','meeting-request',
        ];
 
        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm, 'guard_name' => 'web']);
        }
 
        // Admin — everything
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions(Permission::all());
 
        // Employee
        $employeeRole = Role::firstOrCreate(['name' => 'employee', 'guard_name' => 'web']);
        $employeeRole->syncPermissions([
            'project-list',
            'task-list','task-edit',
            'reclamation-list','reclamation-create',
            'meeting-list','meeting-respond',
        ]);
 
        // Client
        $clientRole = Role::firstOrCreate(['name' => 'client', 'guard_name' => 'web']);
        $clientRole->syncPermissions([
            'project-list',
            'ticket-list','ticket-create',
            'reclamation-list','reclamation-create',
            'meeting-list','meeting-respond','meeting-request',
        ]);

        // Seed users
        $admin = User::firstOrCreate(['email' => 'admin@crm.com'], [
            'name' => 'Admin', 'password' => Hash::make('password'),
            'type_client' => 'admin', 'status' => 'active',
        ]);
        $admin->syncRoles('admin');

        $emp = User::firstOrCreate(['email' => 'employee@crm.com'], [
            'name' => 'Alice Employee', 'password' => Hash::make('password'),
            'type_client' => 'employee', 'status' => 'active',
        ]);
        $emp->syncRoles('employee');

        $client = User::firstOrCreate(['email' => 'client@crm.com'], [
            'name' => 'Client Corp', 'password' => Hash::make('password'),
            'type_client' => 'client', 'status' => 'active',
        ]);
        $client->syncRoles('client');

        $this->command->info('✅ Done! Login: admin@crm.com / password');
    }
}