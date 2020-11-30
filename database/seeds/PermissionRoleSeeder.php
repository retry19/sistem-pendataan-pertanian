<?php

use App\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::all();

        foreach ($permissions as $idx => $permission) {
            $arrayPermissionRole[$idx]['permission_id'] = $permission->id;
            $arrayPermissionRole[$idx]['role_id'] = 1;
        }

        DB::table('permission_role')->insert($arrayPermissionRole);
    }
}
