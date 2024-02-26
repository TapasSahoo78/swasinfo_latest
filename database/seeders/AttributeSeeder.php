<?php

namespace Database\Seeders;

use App\Models\Attribute;
use Illuminate\Database\Seeder;

class AttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json  = file_get_contents(database_path() . '/data/attributes.json');
        $data  = json_decode($json);
        foreach ($data->attributes as $key => $value) {
            $attributeCreated= Attribute::updateOrCreate(['name'=>$value->name ],[
                'name'=> $value->name,
                'created_by'=> 1,
                'updated_by'=> 1
            ]);
        }
    }
}
