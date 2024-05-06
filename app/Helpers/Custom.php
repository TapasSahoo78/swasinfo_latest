<?php

use App\Models\Category;
use App\Models\ProductBrand;
use App\Models\Subcategory;

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
    $data = Subcategory::get();

    echo "<option value=''>Select Sub Category</option>";
    foreach ($data as $key => $val) {
        if ($id == $val?->id) {
            echo "<option value='" . $val?->id . "' selected>" . $val->name . "</option>";
        } else {
            echo "<option value='" . $val?->id . "'>" . $val->name . "</option>";
        }
    }
}

function getProductBrand($id)
{
    $data = ProductBrand::where('is_active', 1)->get();

    echo "<option value=''>Select Brand</option>";
    foreach ($data as $key => $val) {
        if ($id == $val?->id) {
            echo "<option value='" . $val?->id . "' selected>" . $val->name . "</option>";
        } else {
            echo "<option value='" . $val?->id . "'>" . $val->name . "</option>";
        }
    }
}
