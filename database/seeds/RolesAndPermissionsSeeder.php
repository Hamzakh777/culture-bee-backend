<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit jobs']);
        Permission::create(['name' => 'delete jobs']);
        Permission::create(['name' => 'publish jobs']);
        Permission::create(['name' => 'unpublish jobs']);

        // create roles and assign created permissions

        // this can be done as separate statements
        $role = Role::create(['name' => 'employer'])
            ->givePermissionTo('edit jobs')
            ->givePermissionTo('delete jobs')
            ->givePermissionTo('publish jobs')
            ->givePermissionTo('unpublish jobs');

        // or may be done by chaining
        $role = Role::create(['name' => 'job-seeker']);

        $role = Role::create(['name' => 'super-admin']);
        $role->givePermissionTo(Permission::all());
    }
}
