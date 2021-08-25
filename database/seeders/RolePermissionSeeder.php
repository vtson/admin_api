<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::all();
        $admin = Role::whereName('Admin')->first();

        foreach ($permissions as $permisson){
            DB::table('role_permission')->insert([
                'role_id' => $admin->id,
                'permission_id' => $permisson->id
            ]);
        }

        $editor = Role::whereName('Editor')->first();

        foreach ($permissions as $permisson){
            if (in_array($permisson->name, ['edit_roles'])){

                DB::table('role_permission')->insert([
                    'role_id' => $editor->id,
                    'permission_id' => $permisson->id
                ]);
            }
        }

        $viewer = Role::whereName('Viewer')->first();
        $viewerRoles = [
            'view_users',
            'view_roles',
            'view_products',
            'view_orders'
        ];
        foreach ($permissions as $permisson){
            if (in_array($permisson->name, $viewerRoles)){

                DB::table('role_permission')->insert([
                    'role_id' => $viewer->id,
                    'permission_id' => $permisson->id
                ]);
            }
        }
    }
}
