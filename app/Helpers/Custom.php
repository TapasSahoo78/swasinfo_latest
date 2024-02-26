<?php

use App\Models\Category;

function getParentCategory($id)
{
    $data = Category::all();

    echo "<option value='0'>Main Category</option>";
    foreach ($data as $key => $val) {

        if ($id == $val->id) {

            echo "<option value='" . $val->id . "' selected>" . $val->name . "</option>";
        } else {
            echo "<option value='" . $val->id . "'>" . $val->name . "</option>";
        }
    }
}

// function getAllCategory()
// {
//     $data = Category::all();
//     $listCategories = $listCategories->chunk(ceil($listCategories->count() / 4));
//     return $data;
// }
