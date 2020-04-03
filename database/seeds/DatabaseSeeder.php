<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admin_users')->truncate();
        // create admin account
        $user = \App\Models\AdminUser::updateOrCreate(['username'=>'test'],[
            'username'=>'test',
            'password'=> 'test123',
            'status'=>1,
        ]);

        $role = \App\Models\Role::updateOrCreate(['name'=>'测试角色'],['name'=>'测试角色','slug'=>'test','guard_name'=>'api']);

        $role->syncPermissions(Permission::find([1,3]));

        $user->syncRoles($role);


    }
}
