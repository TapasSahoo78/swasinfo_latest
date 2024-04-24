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

function getAllCategory($id)
{
    $data = Category::where('is_active', 1)->get();

    echo "<option value=''>Select Category</option>";
    foreach ($data as $key => $val) {
        if ($id == $val->id) {
            echo "<option value='" . $val->id . "' selected>" . $val->name . "</option>";
        } else {
            echo "<option value='" . $val->id . "'>" . $val->name . "</option>";
        }
    }
}

function getAllUnit($id)
{
    $data = [
        'gm' => 'GM',
        'kg' => 'KG',
        'pcs' => 'PCS',
        'pkg' => 'PKG'
    ];

    echo "<option value=''>Select Unit</option>";
    foreach ($data as $key => $val) {
        if ($id == $key) {
            echo "<option value='" . $key . "' selected>" . $val . "</option>";
        } else {
            echo "<option value='" . $key . "'>" . $val . "</option>";
        }
    }
}

function getSubCategory($id)
{
    $data = Category::where('is_active', 1)->get();

    echo "<option value=''>Select Category</option>";
    foreach ($data as $key => $val) {
        if ($id == $val?->id) {
            echo "<option value='" . $val?->id . "' selected>" . $val->name . "</option>";
        } else {
            echo "<option value='" . $val?->id . "'>" . $val->name . "</option>";
        }
    }
}
