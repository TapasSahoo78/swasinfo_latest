<?php

namespace App\Imports;

use App\Models\User;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;

class Productimport implements ToModel
{
    /**
     * 
     * 
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */

     private $id;
     public function __construct($id)
    {
        $this->id = $id;
    }
        public function model(array $row)
    {
        // Validate CSV row data
        $validator = Validator::make($row, [
            '0' => 'required|string', // Assuming 'name' is a string, adjust as needed
            '1' => 'required|string', // Assuming 'title' is a string, adjust as needed
            '2' => 'required|numeric', // Assuming 'price' is a numeric field, adjust as needed
            '3' => 'nullable|numeric', // Assuming 'discount' is a numeric field, adjust as needed
            '4' => 'nullable|string', // Assuming 'color' is a string, adjust as needed
            '5' => 'nullable|string', // Assuming 'description' is a string, adjust as needed
            '6' => 'required|integer', // Assuming 'stock' is an integer, adjust as needed
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            throw new \Exception("CSV data is invalid: " . $validator->errors()->first());
        }

        $categoriesId = uuidtoid($this->id, 'categories');

        // If validation passes, proceed with creating the product
        $userId = auth()->user()->id;

        $newProduct = new Product([
            'name' => $row['0'],
            'title' => $row['1'],
            'price' => $row['2'],
            'discount' => $row['3'],
            'color' => $row['4'],
            'description' => $row['5'],
            'stock' => $row['6'],
            'category_id' => $categoriesId,
            'created_by' => $userId
        ]);

        $newProduct->save();
    }
}
