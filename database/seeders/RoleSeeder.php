<?php
namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions= Permission::get();
        $faker = Faker::create();
        $json  = file_get_contents(database_path() . '/data/roles.json');
        $data  = json_decode($json);
        $permissions = Permission::get();
        foreach ($data->roles as $key => $value) {
            Role::updateOrCreate([
                'name'=> $value->name,
            //  'short_code'=> $value->short_code,
                'slug'=> $value->slug,
                'is_default_role'=>1,
                // 'status'=>0,
                'role_type'=>$value->role_type,
                'uuid'=> $faker->uuid
            ]);
        }
        $role= Role::find(1);
        $role->permissions()->attach($permissions);
    }
}
