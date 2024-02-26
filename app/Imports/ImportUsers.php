<?php

namespace App\Imports;

use App\Models\User;
use App\Models\UserTrainerProfile;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportUsers implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Validate CSV row data
        $validator = Validator::make($row, [
            '0' => 'required', // 'first_name' is required
            '1' => 'required|numeric', // 'mobile_number' is required and numeric
            '2' => 'required|email|unique:users,email', // 'email' is required, valid, and unique in users table
            // Add more validation rules as needed for other fields
        ]);
    
        // Check if validation fails
        if ($validator->fails()) {
            // Handle validation errors, maybe log them or throw an exception
            // For example:
            throw new \Exception("CSV data is invalid: " . $validator->errors()->first());
        }
    
        // If validation passes, proceed with creating the user
        $userId = auth()->user()->id;
        $newUser = new User([
            'first_name' => $row[0],
            'mobile_number' => $row[1],
            'email' => $row[2],
            'introduction' => $row[3],
            'email_verified_at' => \Carbon\Carbon::now(),
            'password' => bcrypt(12345678),
            'is_approve' => 1,
            'created_by' => $userId
        ]);
        $newUser->save();
        $lastInsertId = $newUser->id;
        $newUsers = new UserTrainerProfile([
            'user_id' =>  $lastInsertId,
            'introduction' => $row[3]
        ]);
        $newUsers->save();
    
        $newUser->roles()->sync(10);
    }
}
