<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Enums\RoleEnum;
use App\Enums\AdminRoleEnum;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        $generalUserRole = Role::create(['name' => RoleEnum::GENERAL_USER->value]);
        $businessUserRole = Role::create(['name' => RoleEnum::BUSINESS_USER->value]);
        $vendorUserRole = Role::create(['name' => RoleEnum::VENDOR_USER->value]);
        $superAdminRole = Role::create(['name' => AdminRoleEnum::SUPER_ADMIN->value]);
        $adminRole = Role::create(['name' => AdminRoleEnum::ADMIN->value]);
        $salesTeamRole = Role::create(['name' => AdminRoleEnum::SALES_TEAM->value]);
        $accountingTeamRole = Role::create(['name' => AdminRoleEnum::ACCOUNTING_TEAM->value]);
        $operationsTeamRole = Role::create(['name' => AdminRoleEnum::OPERATIONS_TEAM->value]);
    }
}
