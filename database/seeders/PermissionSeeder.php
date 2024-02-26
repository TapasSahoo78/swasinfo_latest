<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json  = file_get_contents(database_path() . '/data/permission.json');
        $data  = json_decode($json);
        foreach ($data->permissions as $key => $value) {
            Permission::updateOrCreate([
                'name'=> $value->name,
                'permission_type'=> !empty($value->permission_type) ? $value->permission_type :""
            ]);
        }
    }
}
