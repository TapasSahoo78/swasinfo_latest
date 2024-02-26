<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $json  = file_get_contents(database_path() . '/data/categories.json');
        $data  = json_decode($json);
        $attributes= Attribute::get();
        foreach ($data->categories as $key => $value) {
            $categoryCreated= Category::updateOrCreate(['name'=>$value->name ],[
                'name'=> $value->name,
                'created_by'=> 1,
                'updated_by'=> 1
            ]);
            if($categoryCreated){
                $categoryCreated->attribute()->attach($attributes);
            }
            if(isset($value->sub_category)){
                foreach ($value->sub_category as $valuesub) {
                    $subCategoryCreated= Category::updateOrCreate(['name'=>$valuesub->name ],[
                        'name'=> $valuesub->name,
                        'parent_id'=> $categoryCreated->id,
                        'created_by'=> 1,
                        'updated_by'=> 1
                    ]);
                    if($subCategoryCreated){
                        $subCategoryCreated->attribute()->attach($attributes);
                    }
                }
                if(isset($valuesub->sub_category)){
                    foreach ($valuesub->sub_category as $valueSubSub) {
                        $subSubCategoryCreated= Category::updateOrCreate(['name'=>$valueSubSub->name ],[
                            'name'=> $valueSubSub->name,
                            'parent_id'=> $subCategoryCreated->id,
                            'created_by'=> 1,
                            'updated_by'=> 1
                        ]);
                        if($subSubCategoryCreated){
                            $subSubCategoryCreated->attribute()->attach($attributes);
                        }
                    }
                }
            }
        }
    }
}
