<?php

namespace Database\Seeders;

use BezhanSalleh\FilamentShield\Support\Utils;
use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $rolesWithPermissions = '[{"name":"admin","guard_name":"web","permissions":["view_internship::letter","view_any_internship::letter","create_internship::letter","update_internship::letter","delete_internship::letter","delete_any_internship::letter","accept_internship::letter","reject_internship::letter","view_role","view_any_role","create_role","update_role","delete_role","delete_any_role","view_study::program","view_any_study::program","create_study::program","update_study::program","restore_study::program","restore_any_study::program","replicate_study::program","reorder_study::program","delete_study::program","delete_any_study::program","force_delete_study::program","force_delete_any_study::program","view_user","view_any_user","create_user","update_user","restore_user","restore_any_user","replicate_user","reorder_user","delete_user","delete_any_user","force_delete_user","force_delete_any_user","page_Themes","page_MyProfilePage"]},{"name":"mahasiswa","guard_name":"web","permissions":["view_internship::letter","create_internship::letter","view_any_internship::letter","page_Themes","page_MyProfilePage"]},{"name":"kaprodi","guard_name":"web","permissions":["view_internship::letter","view_any_internship::letter","accept_internship::letter","reject_internship::letter","page_Themes","page_MyProfilePage"]},{"name":"petugas","guard_name":"web","permissions":["view_internship::letter","view_any_internship::letter","page_Themes","page_MyProfilePage"]}]';
        $directPermissions = '{"40":{"name":"restore_internship::letter","guard_name":"web"},"41":{"name":"restore_any_internship::letter","guard_name":"web"},"42":{"name":"replicate_internship::letter","guard_name":"web"},"43":{"name":"reorder_internship::letter","guard_name":"web"},"44":{"name":"force_delete_internship::letter","guard_name":"web"},"45":{"name":"force_delete_any_internship::letter","guard_name":"web"},"46":{"name":"view_language::line","guard_name":"web"},"47":{"name":"view_any_language::line","guard_name":"web"},"48":{"name":"create_language::line","guard_name":"web"},"49":{"name":"update_language::line","guard_name":"web"},"50":{"name":"restore_language::line","guard_name":"web"},"51":{"name":"restore_any_language::line","guard_name":"web"},"52":{"name":"replicate_language::line","guard_name":"web"},"53":{"name":"reorder_language::line","guard_name":"web"},"54":{"name":"delete_language::line","guard_name":"web"},"55":{"name":"delete_any_language::line","guard_name":"web"},"56":{"name":"force_delete_language::line","guard_name":"web"},"57":{"name":"force_delete_any_language::line","guard_name":"web"},"58":{"name":"page_QuickTranslate","guard_name":"web"},"59":{"name":"modify_status_internship::letter","guard_name":"web"},"60":{"name":"print_internship::letter","guard_name":"web"}}';

        static::makeRolesWithPermissions($rolesWithPermissions);
        static::makeDirectPermissions($directPermissions);

        $this->command->info('Shield Seeding Completed.');
    }

    protected static function makeRolesWithPermissions(string $rolesWithPermissions): void
    {
        if (!blank($rolePlusPermissions = json_decode($rolesWithPermissions, true))) {
            /** @var Model $roleModel */
            $roleModel = Utils::getRoleModel();
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($rolePlusPermissions as $rolePlusPermission) {
                $role = $roleModel::firstOrCreate([
                    'name' => $rolePlusPermission['name'],
                    'guard_name' => $rolePlusPermission['guard_name'],
                ]);

                if (!blank($rolePlusPermission['permissions'])) {
                    $permissionModels = collect($rolePlusPermission['permissions'])
                        ->map(fn($permission) => $permissionModel::firstOrCreate([
                            'name' => $permission,
                            'guard_name' => $rolePlusPermission['guard_name'],
                        ]))
                        ->all();

                    $role->syncPermissions($permissionModels);
                }
            }
        }
    }

    public static function makeDirectPermissions(string $directPermissions): void
    {
        if (!blank($permissions = json_decode($directPermissions, true))) {
            /** @var Model $permissionModel */
            $permissionModel = Utils::getPermissionModel();

            foreach ($permissions as $permission) {
                if ($permissionModel::whereName($permission)->doesntExist()) {
                    $permissionModel::create([
                        'name' => $permission['name'],
                        'guard_name' => $permission['guard_name'],
                    ]);
                }
            }
        }
    }
}
