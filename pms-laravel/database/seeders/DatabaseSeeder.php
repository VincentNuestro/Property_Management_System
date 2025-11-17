<?php

namespace Database\Seeders;

use App\Models\User;
use App\Enums\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create roles and permissions first
        $this->call(RolePermissionSeeder::class);

        // Create Super Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@pms.local'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole(Role::SUPER_ADMIN->value);
        $this->command->info('Created Super Admin user: admin@pms.local / password');

        // Create Property Manager user
        $propertyManager = User::firstOrCreate(
            ['email' => 'manager@pms.local'],
            [
                'name' => 'Property Manager',
                'password' => Hash::make('password'),
            ]
        );
        $propertyManager->assignRole(Role::PROPERTY_MANAGER->value);
        $this->command->info('Created Property Manager user: manager@pms.local / password');

        // Create Accountant user
        $accountant = User::firstOrCreate(
            ['email' => 'accountant@pms.local'],
            [
                'name' => 'Accountant',
                'password' => Hash::make('password'),
            ]
        );
        $accountant->assignRole(Role::ACCOUNTANT->value);
        $this->command->info('Created Accountant user: accountant@pms.local / password');

        // Create Leasing Officer user
        $leasingOfficer = User::firstOrCreate(
            ['email' => 'leasing@pms.local'],
            [
                'name' => 'Leasing Officer',
                'password' => Hash::make('password'),
            ]
        );
        $leasingOfficer->assignRole(Role::LEASING_OFFICER->value);
        $this->command->info('Created Leasing Officer user: leasing@pms.local / password');

        // Create Maintenance Staff user
        $maintenanceStaff = User::firstOrCreate(
            ['email' => 'maintenance@pms.local'],
            [
                'name' => 'Maintenance Staff',
                'password' => Hash::make('password'),
            ]
        );
        $maintenanceStaff->assignRole(Role::MAINTENANCE_STAFF->value);
        $this->command->info('Created Maintenance Staff user: maintenance@pms.local / password');

        $this->command->info('Database seeding completed successfully!');
    }
}
