<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class SetUserTeamAndRolePermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ---------- Create Master Teams or Department -------- //
        $teamOwner = Team::create([
            'name'              => 'owner',
            'display_name'      => 'Owner',
            'description'       => 'Owner',
            'created_at'        => date("Y-m-d H:i:s"),
            'updated_at'        => date("Y-m-d H:i:s"),
        ]);
        $teamSales = Team::create([
            'name'              => 'sales',
            'display_name'      => 'Sales',
            'description'       => 'Sales',
            'created_at'        => date("Y-m-d H:i:s"),
            'updated_at'        => date("Y-m-d H:i:s"),
        ]);
        $teamHResource = Team::create([
            'name'              => 'human-resource',
            'display_name'      => 'Human Resources',
            'description'       => 'Human Resources',
            'created_at'        => date("Y-m-d H:i:s"),
            'updated_at'        => date("Y-m-d H:i:s"),
        ]);
        $teamGeneralaffair = Team::create([
            'name'              => 'general-affair',
            'display_name'      => 'General Affair',
            'description'       => 'General Affair',
            'created_at'        => date("Y-m-d H:i:s"),
            'updated_at'        => date("Y-m-d H:i:s"),
        ]);
        $teamFinance = Team::create([
            'name'              => 'finance',
            'display_name'      => 'Finance',
            'description'       => 'Finance',
            'created_at'        => date("Y-m-d H:i:s"),
            'updated_at'        => date("Y-m-d H:i:s"),
        ]);
        $teamAccounting = Team::create([
            'name'              => 'accounting',
            'display_name'      => 'Accounting',
            'description'       => 'Accounting',
            'created_at'        => date("Y-m-d H:i:s"),
            'updated_at'        => date("Y-m-d H:i:s"),
        ]);
        $teamPurchasing = Team::create([
            'name'              => 'purchasing',
            'display_name'      => 'Purchasing',
            'description'       => 'Purchasing',
            'created_at'        => date("Y-m-d H:i:s"),
            'updated_at'        => date("Y-m-d H:i:s"),
        ]);
        $teamInformationTechnology = Team::create([
            'name'              => 'information-technology',
            'display_name'      => 'Information Technology',
            'description'       => 'Information Technology',
            'created_at'        => date("Y-m-d H:i:s"),
            'updated_at'        => date("Y-m-d H:i:s"),
        ]);
        $teamTechnician = Team::create([
            'name'              => 'technician',
            'display_name'      => 'Technician',
            'description'       => 'Technician',
            'created_at'        => date("Y-m-d H:i:s"),
            'updated_at'        => date("Y-m-d H:i:s"),
        ]);
        $teamMarketingCommunication = Team::create([
            'name'              => 'marketing-communication',
            'display_name'      => 'Marketing Communication',
            'description'       => 'Marketing Communication',
            'created_at'        => date("Y-m-d H:i:s"),
            'updated_at'        => date("Y-m-d H:i:s"),
        ]);
        // ---------- End Create Master Teams or Department -------- //

        // ---------- Create Master Role -------- //
        $roleRoot = Role::create([
            'name' => 'root',
            'display_name' => 'root',
            'description' => 'root',
        ]);
        $roleAdministrator = Role::create([
            'name' => 'administrator',
            'display_name' => 'administrator',
            'description' => 'administrator',
        ]);
        $roleOwner = Role::create([
            'name' => 'owner',
            'display_name' => 'owner',
            'description' => 'owner',
        ]);
        $roleBod = Role::create([
            'name' => 'board-of-director',
            'display_name' => 'Board Of Director',
            'description' => 'Board Of Director',
        ]);
        $roleGmo = Role::create([
            'name' => 'general-manager-operation',
            'display_name' => 'General Manager Operation',
            'description' => 'General Manager Operation',
        ]);
        $roleGms = Role::create([
            'name' => 'general-manager-sales',
            'display_name' => 'General Manager Sales',
            'description' => 'General Manager Sales',
        ]);
        $roleBm = Role::create([
            'name' => 'branch-manager',
            'display_name' => 'Branch Manager',
            'description' => 'Branch Manager',
        ]);
        $roleManager = Role::create([
            'name' => 'manager',
            'display_name' => 'Manager',
            'description' => 'Manager',
        ]);
        $roleSupervisor = Role::create([
            'name' => 'supervisor',
            'display_name' => 'Supervisor',
            'description' => 'Supervisor',
        ]);
        $roleLeader = Role::create([
            'name' => 'leader',
            'display_name' => 'Leader',
            'description' => 'Leader',
        ]);
        $roleStaffSpecialist = Role::create([
            'name' => 'staff-specialist',
            'display_name' => 'Staff Specialist',
            'description' => 'Staff Specialist',
        ]);
        $roleStaff = Role::create([
            'name' => 'staff',
            'display_name' => 'Staff',
            'description' => 'Staff',
        ]);
        $roleCustomer = Role::create([
            'name' => 'customer',
            'display_name' => 'Customer',
            'description' => 'Customer',
        ]);
        // ---------- End Create Master Role -------- //

        // --------- Create Master or Module Permissions --------- //

        // Company
        $createCompany = Permission::create([
            'name' => 'create-company', 'display_name' => 'create company', 'description' => 'create company',
        ]);
        $readCompany = Permission::create([
            'name' => 'read-company', 'display_name' => 'read company', 'description' => 'read company',
        ]);
        $updateCompany = Permission::create([
            'name' => 'update-company', 'display_name' => 'update company', 'description' => 'update company',
        ]);
        $deleteCompany = Permission::create([
            'name' => 'delete-company', 'display_name' => 'delete company', 'description' => 'delete company',
        ]);
        // End Company

        // User
        $createUser = Permission::create([
            'name' => 'create-user', 'display_name' => 'create user', 'description' => 'create user',
        ]);
        $readUser = Permission::create([
            'name' => 'read-user', 'display_name' => 'read user', 'description' => 'read user',
        ]);
        $updateUser = Permission::create([
            'name' => 'update-user', 'display_name' => 'update user', 'description' => 'update user',
        ]);
        $deleteUser = Permission::create([
            'name' => 'delete-user', 'display_name' => 'delete user', 'description' => 'delete user',
        ]);
        // End Users

        // Role
        $createRole = Permission::create([
            'name' => 'create-role', 'display_name' => 'create role', 'description' => 'create role',
        ]);
        $readRole = Permission::create([
            'name' => 'read-role', 'display_name' => 'read role', 'description' => 'read role',
        ]);
        $updateRole = Permission::create([
            'name' => 'update-role', 'display_name' => 'update role', 'description' => 'update role',
        ]);
        $deleteRole = Permission::create([
            'name' => 'delete-role', 'display_name' => 'delete role', 'description' => 'delete role',
        ]);
        // End Role

        // Permission
        $createPermission = Permission::create([
            'name' => 'create-permission', 'display_name' => 'create permission', 'description' => 'create permission',
        ]);
        $readPermission = Permission::create([
            'name' => 'read-permission', 'display_name' => 'read permission', 'description' => 'read permission',
        ]);
        $updatePermission = Permission::create([
            'name' => 'update-permission', 'display_name' => 'update permission', 'description' => 'update permission',
        ]);
        $deletePermission = Permission::create([
            'name' => 'delete-permission', 'display_name' => 'delete permission', 'description' => 'delete permission',
        ]);
        // End Permission

        // Team
        $createTeam = Permission::create([
            'name' => 'create-team', 'display_name' => 'create team', 'description' => 'create team',
        ]);
        $readTeam = Permission::create([
            'name' => 'read-team', 'display_name' => 'read team', 'description' => 'read team',
        ]);
        $updateTeam = Permission::create([
            'name' => 'update-team', 'display_name' => 'update team', 'description' => 'update team',
        ]);
        $deleteTeam = Permission::create([
            'name' => 'delete-team', 'display_name' => 'delete team', 'description' => 'delete team',
        ]);
        // End Team

        // Profile
        $readProfile = Permission::create([
            'name' => 'read-profile', 'display_name' => 'read profile', 'description' => 'read profile',
        ]);
        $updateProfile = Permission::create([
            'name' => 'update-profile', 'display_name' => 'update profile', 'description' => 'update profile',
        ]);
        // End Profile

        // Employee
        $createEmployee = Permission::create([
            'name' => 'create-employee', 'display_name' => 'create employee', 'description' => 'create employee',
        ]);
        $readEmployee = Permission::create([
            'name' => 'read-employee', 'display_name' => 'read employee', 'description' => 'read employee',
        ]);
        $updateEmployee = Permission::create([
            'name' => 'update-employee', 'display_name' => 'update employee', 'description' => 'update employee',
        ]);
        $deleteEmployee = Permission::create([
            'name' => 'delete-employee', 'display_name' => 'delete employee', 'description' => 'delete employee',
        ]);
        // End Employee

        // Customer
        $createCustomer = Permission::create([
            'name' => 'create-customer', 'display_name' => 'create customer', 'description' => 'create customer',
        ]);
        $readCustomer = Permission::create([
            'name' => 'read-customer', 'display_name' => 'read customer', 'description' => 'read customer',
        ]);
        $updateCustomer = Permission::create([
            'name' => 'update-customer', 'display_name' => 'update customer', 'description' => 'update customer',
        ]);
        $deleteCustomer = Permission::create([
            'name' => 'delete-customer', 'display_name' => 'delete customer', 'description' => 'delete customer',
        ]);
        // End Customer

        // Province
        $createProvince = Permission::create([
            'name' => 'create-province', 'display_name' => 'create province', 'description' => 'create province',
        ]);
        $readProvince = Permission::create([
            'name' => 'read-province', 'display_name' => 'read province', 'description' => 'read province',
        ]);
        $updateProvince = Permission::create([
            'name' => 'update-province', 'display_name' => 'update province', 'description' => 'update province',
        ]);
        $deleteProvince = Permission::create([
            'name' => 'delete-province', 'display_name' => 'delete province', 'description' => 'delete province',
        ]);
        // End Province

        // City
        $createCity = Permission::create([
            'name' => 'create-city', 'display_name' => 'create city', 'description' => 'create city',
        ]);
        $readCity = Permission::create([
            'name' => 'read-city', 'display_name' => 'read city', 'description' => 'read city',
        ]);
        $updateCity = Permission::create([
            'name' => 'update-city', 'display_name' => 'update city', 'description' => 'update city',
        ]);
        $deleteCity = Permission::create([
            'name' => 'delete-city', 'display_name' => 'delete city', 'description' => 'delete city',
        ]);
        // End City

        // District
        $createDistrict = Permission::create([
            'name' => 'create-district', 'display_name' => 'create district', 'description' => 'create district',
        ]);
        $readDistrict = Permission::create([
            'name' => 'read-district', 'display_name' => 'read district', 'description' => 'read district',
        ]);
        $updateDistrict = Permission::create([
            'name' => 'update-district', 'display_name' => 'update district', 'description' => 'update district',
        ]);
        $deleteDistrict = Permission::create([
            'name' => 'delete-district', 'display_name' => 'delete district', 'description' => 'delete district',
        ]);
        // End District

        // Village
        $createVillage = Permission::create([
            'name' => 'create-village', 'display_name' => 'create village', 'description' => 'create village',
        ]);
        $readVillage = Permission::create([
            'name' => 'read-village', 'display_name' => 'read village', 'description' => 'read village',
        ]);
        $updateVillage = Permission::create([
            'name' => 'update-village', 'display_name' => 'update village', 'description' => 'update village',
        ]);
        $deleteVillage = Permission::create([
            'name' => 'delete-village', 'display_name' => 'delete village', 'description' => 'delete village',
        ]);
        // End Village

        // Branch
        $createBranch = Permission::create([
            'name' => 'create-branch', 'display_name' => 'create branch', 'description' => 'create branch',
        ]);
        $readBranch = Permission::create([
            'name' => 'read-branch', 'display_name' => 'read branch', 'description' => 'read branch',
        ]);
        $updateBranch = Permission::create([
            'name' => 'update-branch', 'display_name' => 'update branch', 'description' => 'update branch',
        ]);
        $deleteBranch = Permission::create([
            'name' => 'delete-branch', 'display_name' => 'delete branch', 'description' => 'delete branch',
        ]);
        // End Branch

        // BranchArea
        $createBranchArea = Permission::create([
            'name' => 'create-branch-area', 'display_name' => 'create branch-area', 'description' => 'create branch-area',
        ]);
        $readBranchArea = Permission::create([
            'name' => 'read-branch-area', 'display_name' => 'read branch-area', 'description' => 'read branch-area',
        ]);
        $updateBranchArea = Permission::create([
            'name' => 'update-branch-area', 'display_name' => 'update branch-area', 'description' => 'update branch-area',
        ]);
        $deleteBranchArea = Permission::create([
            'name' => 'delete-branch-area', 'display_name' => 'delete branch-area', 'description' => 'delete branch-area',
        ]);
        // End BranchArea

        // Warehouse
        $createWarehouse = Permission::create([
            'name' => 'create-warehouse', 'display_name' => 'create warehouse', 'description' => 'create warehouse',
        ]);
        $readWarehouse = Permission::create([
            'name' => 'read-warehouse', 'display_name' => 'read warehouse', 'description' => 'read warehouse',
        ]);
        $updateWarehouse = Permission::create([
            'name' => 'update-warehouse', 'display_name' => 'update warehouse', 'description' => 'update warehouse',
        ]);
        $deleteWarehouse = Permission::create([
            'name' => 'delete-warehouse', 'display_name' => 'delete warehouse', 'description' => 'delete warehouse',
        ]);
        // EndWarehouse
        // --------- End Create Master or Module Permissions --------- //

        // ------------------------ Role Permissions Assignment -------------------------//
        $roleRoot->attachPermissions([
            $createCompany,
            $readCompany,
            $updateCompany,
            $deleteCompany,
            $createUser,
            $readUser,
            $updateUser,
            $deleteUser,
            $createRole,
            $readRole,
            $updateRole,
            $deleteRole,
            $createPermission,
            $readPermission,
            $updatePermission,
            $deletePermission,
            $createTeam,
            $readTeam,
            $updateTeam,
            $deleteTeam,
            $readProfile,
            $updateProfile,
            $createEmployee,
            $readEmployee,
            $updateEmployee,
            $deleteEmployee,
            $createCustomer,
            $readCustomer,
            $updateCustomer,
            $deleteCustomer,
            $createProvince,
            $readProvince,
            $updateProvince,
            $deleteProvince,
            $createCity,
            $readCity,
            $updateCity,
            $deleteCity,
            $createDistrict,
            $readDistrict,
            $updateDistrict,
            $deleteDistrict,
            $createVillage,
            $readVillage,
            $updateVillage,
            $deleteVillage,
            $createBranch,
            $readBranch,
            $updateBranch,
            $deleteBranch,
            $createBranchArea,
            $readBranchArea,
            $updateBranchArea,
            $deleteBranchArea,
            $createWarehouse,
            $readWarehouse,
            $updateWarehouse,
            $deleteWarehouse,
        ]);
        $roleAdministrator->attachPermissions([
            $createCompany,
            $readCompany,
            $updateCompany,
            $deleteCompany,
            $createUser,
            $readUser,
            $updateUser,
            $deleteUser,
            $createRole,
            $readRole,
            $updateRole,
            $deleteRole,
            $createPermission,
            $readPermission,
            $updatePermission,
            $deletePermission,
            $createTeam,
            $readTeam,
            $updateTeam,
            $deleteTeam,
            $readProfile,
            $updateProfile,
            $createEmployee,
            $readEmployee,
            $updateEmployee,
            $deleteEmployee,
            $createCustomer,
            $readCustomer,
            $updateCustomer,
            $deleteCustomer,
            $createProvince,
            $readProvince,
            $updateProvince,
            $deleteProvince,
            $createCity,
            $readCity,
            $updateCity,
            $deleteCity,
            $createDistrict,
            $readDistrict,
            $updateDistrict,
            $deleteDistrict,
            $createVillage,
            $readVillage,
            $updateVillage,
            $deleteVillage,
            $createBranch,
            $readBranch,
            $updateBranch,
            $deleteBranch,
            $createBranchArea,
            $readBranchArea,
            $updateBranchArea,
            $deleteBranchArea,
            $createWarehouse,
            $readWarehouse,
            $updateWarehouse,
            $deleteWarehouse,
        ]);
        $roleOwner->attachPermissions([
            $readCompany,
            $updateCompany,
            $createUser,
            $readUser,
            $updateUser,
            $deleteUser,
            $createRole,
            $readRole,
            $updateRole,
            $deleteRole,
            $createPermission,
            $readPermission,
            $updatePermission,
            $deletePermission,
            $createTeam,
            $readTeam,
            $updateTeam,
            $deleteTeam,
            $readProfile,
            $updateProfile,
            $createEmployee,
            $readEmployee,
            $updateEmployee,
            $deleteEmployee,
            $createCustomer,
            $readCustomer,
            $updateCustomer,
            $deleteCustomer,
            $createProvince,
            $readProvince,
            $updateProvince,
            $deleteProvince,
            $createCity,
            $readCity,
            $updateCity,
            $deleteCity,
            $createDistrict,
            $readDistrict,
            $updateDistrict,
            $deleteDistrict,
            $createVillage,
            $readVillage,
            $updateVillage,
            $deleteVillage,
            $createBranch,
            $readBranch,
            $updateBranch,
            $deleteBranch,
            $createBranchArea,
            $readBranchArea,
            $updateBranchArea,
            $deleteBranchArea,
            $createWarehouse,
            $readWarehouse,
            $updateWarehouse,
            $deleteWarehouse,
        ]);
        $roleBod->attachPermissions([
            $readCompany,
            $updateCompany,
            $createUser,
            $readUser,
            $updateUser,
            $deleteUser,
            $createRole,
            $readRole,
            $updateRole,
            $deleteRole,
            $createPermission,
            $readPermission,
            $updatePermission,
            $deletePermission,
            $createTeam,
            $readTeam,
            $updateTeam,
            $deleteTeam,
            $readProfile,
            $updateProfile,
            $createEmployee,
            $readEmployee,
            $updateEmployee,
            $deleteEmployee,
            $createCustomer,
            $readCustomer,
            $updateCustomer,
            $deleteCustomer,
            $createProvince,
            $readProvince,
            $updateProvince,
            $deleteProvince,
            $createCity,
            $readCity,
            $updateCity,
            $deleteCity,
            $createDistrict,
            $readDistrict,
            $updateDistrict,
            $deleteDistrict,
            $createVillage,
            $readVillage,
            $updateVillage,
            $deleteVillage,
            $createBranch,
            $readBranch,
            $updateBranch,
            $deleteBranch,
            $createBranchArea,
            $readBranchArea,
            $updateBranchArea,
            $deleteBranchArea,
            $createWarehouse,
            $readWarehouse,
            $updateWarehouse,
            $deleteWarehouse,
        ]);

        // ------------------------ End Role Permissions Assignment -------------------------//

        // --------- Create Master Users --------- //
        $faker = Faker::create('id_ID');

        $userRoot = User::create([
            'nik' => '3671052608920004',
            'name' => "root",
            'email' => "root@penaindie.com",
            'password' => bcrypt("Rahasia*1!"),
            'email_verified_at' => date("Y-m-d H:i:s"),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        $userAdministrator = User::create([
            'nik' => '3671052608920001',
            'name' => "administrator",
            'email' => "administrator@penaindie.com",
            'password' => bcrypt("Rahasia*1!"),
            'email_verified_at' => date("Y-m-d H:i:s"),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        $userOwner = User::create([
            'nik' => '3671052608920002',
            'name' => $faker->name,
            'email' => "owner@penaindie.com",
            'password' => bcrypt("Rahasia*1!"),
            'email_verified_at' => date("Y-m-d H:i:s"),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        // --------- User Roles Assignment ------------ //
        $userRoot->attachRole($roleRoot, $teamOwner);
        $userAdministrator->attachRole($roleAdministrator, $teamOwner);
        $userOwner->attachRole($roleOwner, $teamOwner);
        // --------- End User Roles Assignment ------------ //

        // --------- User Permissions Assignment ------------ //
        $userRoot->attachPermissions([
            $createCompany,
            $readCompany,
            $updateCompany,
            $deleteCompany,
            $createUser,
            $readUser,
            $updateUser,
            $deleteUser,
            $createRole,
            $readRole,
            $updateRole,
            $deleteRole,
            $createPermission,
            $readPermission,
            $updatePermission,
            $deletePermission,
            $createTeam,
            $readTeam,
            $updateTeam,
            $deleteTeam,
            $readProfile,
            $updateProfile,
            $createEmployee,
            $readEmployee,
            $updateEmployee,
            $deleteEmployee,
            $createCustomer,
            $readCustomer,
            $updateCustomer,
            $deleteCustomer,
            $createProvince,
            $readProvince,
            $updateProvince,
            $deleteProvince,
            $createCity,
            $readCity,
            $updateCity,
            $deleteCity,
            $createDistrict,
            $readDistrict,
            $updateDistrict,
            $deleteDistrict,
            $createVillage,
            $readVillage,
            $updateVillage,
            $deleteVillage,
            $createBranch,
            $readBranch,
            $updateBranch,
            $deleteBranch,
            $createBranchArea,
            $readBranchArea,
            $updateBranchArea,
            $deleteBranchArea,
            $createWarehouse,
            $readWarehouse,
            $updateWarehouse,
            $deleteWarehouse,
        ], $teamOwner);
        $userAdministrator->attachPermissions([
            $createCompany,
            $readCompany,
            $updateCompany,
            $deleteCompany,
            $createUser,
            $readUser,
            $updateUser,
            $deleteUser,
            $createRole,
            $readRole,
            $updateRole,
            $deleteRole,
            $createPermission,
            $readPermission,
            $updatePermission,
            $deletePermission,
            $createTeam,
            $readTeam,
            $updateTeam,
            $deleteTeam,
            $readProfile,
            $updateProfile,
            $createEmployee,
            $readEmployee,
            $updateEmployee,
            $deleteEmployee,
            $createCustomer,
            $readCustomer,
            $updateCustomer,
            $deleteCustomer,
            $createProvince,
            $readProvince,
            $updateProvince,
            $deleteProvince,
            $createCity,
            $readCity,
            $updateCity,
            $deleteCity,
            $createDistrict,
            $readDistrict,
            $updateDistrict,
            $deleteDistrict,
            $createVillage,
            $readVillage,
            $updateVillage,
            $deleteVillage,
            $createBranch,
            $readBranch,
            $updateBranch,
            $deleteBranch,
            $createBranchArea,
            $readBranchArea,
            $updateBranchArea,
            $deleteBranchArea,
            $createWarehouse,
            $readWarehouse,
            $updateWarehouse,
            $deleteWarehouse,
        ], $teamOwner);
        $userOwner->attachPermissions([
            $readCompany,
            $updateCompany,
            $createUser,
            $readUser,
            $updateUser,
            $deleteUser,
            $createRole,
            $readRole,
            $updateRole,
            $deleteRole,
            $createPermission,
            $readPermission,
            $updatePermission,
            $deletePermission,
            $createTeam,
            $readTeam,
            $updateTeam,
            $deleteTeam,
            $readProfile,
            $updateProfile,
            $createEmployee,
            $readEmployee,
            $updateEmployee,
            $deleteEmployee,
            $createCustomer,
            $readCustomer,
            $updateCustomer,
            $deleteCustomer,
            $createProvince,
            $readProvince,
            $updateProvince,
            $deleteProvince,
            $createCity,
            $readCity,
            $updateCity,
            $deleteCity,
            $createDistrict,
            $readDistrict,
            $updateDistrict,
            $deleteDistrict,
            $createVillage,
            $readVillage,
            $updateVillage,
            $deleteVillage,
            $createBranch,
            $readBranch,
            $updateBranch,
            $deleteBranch,
            $createBranchArea,
            $readBranchArea,
            $updateBranchArea,
            $deleteBranchArea,
            $createWarehouse,
            $readWarehouse,
            $updateWarehouse,
            $deleteWarehouse,
        ], $teamOwner);
        // --------- End User Permissions Assignment ------------ //

        for ($bod = 1; $bod <= 6; $bod++) {
            $userBod = User::create([
                'nik' => 'BOD36710526089200' . $bod,
                'name' => $faker->name,
                'email' => "bod.$bod.@penaindie.com",
                'password' => bcrypt("password"),
                'email_verified_at' => date("Y-m-d H:i:s"),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
            // --------- User Roles Assignment ------------ //
            $userBod->attachRole($roleBod, $teamOwner);
            // --------- End User Roles Assignment ------------ //

            // --------- User Permissions Assignment ------------ //
            $userBod->attachPermissions([
                $readCompany,
                $updateCompany,
                $createUser,
                $readUser,
                $updateUser,
                $deleteUser,
                $createRole,
                $readRole,
                $updateRole,
                $deleteRole,
                $createPermission,
                $readPermission,
                $updatePermission,
                $deletePermission,
                $createTeam,
                $readTeam,
                $updateTeam,
                $deleteTeam,
                $readProfile,
                $updateProfile,
                $createEmployee,
                $readEmployee,
                $updateEmployee,
                $deleteEmployee,
                $createCustomer,
                $readCustomer,
                $updateCustomer,
                $deleteCustomer,
                $createProvince,
                $readProvince,
                $updateProvince,
                $deleteProvince,
                $createCity,
                $readCity,
                $updateCity,
                $deleteCity,
                $createDistrict,
                $readDistrict,
                $updateDistrict,
                $deleteDistrict,
                $createVillage,
                $readVillage,
                $updateVillage,
                $deleteVillage,
                $createBranch,
                $readBranch,
                $updateBranch,
                $deleteBranch,
                $createBranchArea,
                $readBranchArea,
                $updateBranchArea,
                $deleteBranchArea,
                $createWarehouse,
                $readWarehouse,
                $updateWarehouse,
                $deleteWarehouse,
            ], $teamOwner);
            // --------- End User Permissions Assignment ------------ //
        }
        $userGmo = User::create([
            'nik' => 'GMO36710526089201',
            'name' => $faker->name,
            'email' => "gmo@penaindie.com",
            'password' => bcrypt("password"),
            'email_verified_at' => date("Y-m-d H:i:s"),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        $userGmo->attachRole($roleGmo);

        $userGms = User::create([
            'nik' => 'GMS36710526089202',
            'name' => $faker->name,
            'email' => "gms@penaindie.com",
            'password' => bcrypt("password"),
            'email_verified_at' => date("Y-m-d H:i:s"),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
        $userGms->attachRole($roleGms);

        for ($bm = 1; $bm <= 19; $bm++) {
            $userBm = User::create([
                'nik' => 'BM367105260892' . $bm,
                'name' => $faker->name,
                'email' => "bm.$bm.@penaindie.com",
                'password' => bcrypt("password"),
                'email_verified_at' => date("Y-m-d H:i:s"),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
            $userBm->attachRole($roleBm);
        }
        for ($mgr = 1; $mgr <= 4; $mgr++) {
            $userManager = User::create([
                'nik' => 'MGR3671052608' . $mgr,
                'name' => $faker->name,
                'email' => "mgr.$mgr.@penaindie.com",
                'password' => bcrypt("password"),
                'email_verified_at' => date("Y-m-d H:i:s"),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
            $userManager->attachRole($roleManager);
        }
        for ($spv = 1; $spv <= 4; $spv++) {
            $userSupervisor = User::create([
                'nik' => 'SPV3671052600' . $spv,
                'name' => $faker->name,
                'email' => "spv.$spv.@penaindie.com",
                'password' => bcrypt("password"),
                'email_verified_at' => date("Y-m-d H:i:s"),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
            $userSupervisor->attachRole($roleSupervisor);
        }
        for ($lead = 1; $lead <= 4; $lead++) {
            $userLeader = User::create([
                'nik' => 'LD3671052000' . $lead,
                'name' => $faker->name,
                'email' => "leader.$lead.@penaindie.com",
                'password' => bcrypt("password"),
                'email_verified_at' => date("Y-m-d H:i:s"),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
            $userLeader->attachRole($roleLeader);
        }
        for ($staffSp = 1; $staffSp <= 4; $staffSp++) {
            $userStaffSp = User::create([
                'nik' => 'STP' . $staffSp,
                'name' => $faker->name,
                'email' => "staff-specialist.$staffSp.@penaindie.com",
                'password' => bcrypt("password"),
                'email_verified_at' => date("Y-m-d H:i:s"),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
            $userStaffSp->attachRole($roleStaffSpecialist);
        }
        for ($staff = 1; $staff <= 50; $staff++) {
            $userStaff = User::create([
                'nik' => 'STF' . $staff,
                'name' => $faker->name,
                'email' => "staff.$staff.@penaindie.com",
                'password' => bcrypt("password"),
                'email_verified_at' => date("Y-m-d H:i:s"),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
            $userStaff->attachRole($roleStaff);
        }
        for ($customer = 1; $customer <= 666; $customer++) {
            $userCustomer = User::create([
                'nik' => 'CUST' . $customer,
                'name' => $faker->company,
                'email' => "customer.$customer.@penaindie.com",
                'password' => bcrypt("password"),
                'email_verified_at' => date("Y-m-d H:i:s"),
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);
            $userCustomer->attachRole($roleCustomer);
        }
        // --------- End Create Master Users --------- //
    }
}
