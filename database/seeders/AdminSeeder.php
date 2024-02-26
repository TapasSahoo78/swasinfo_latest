<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Faker\Factory as Faker;
use Illuminate\Http\Request;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Request $request)
    {
        $faker = Faker::create();
        $isAdminRole = Role::where('slug', 'super-admin')->first();
        $permissions= Permission::get();
        $user = new User();
        $user->uuid = $faker->uuid;
        $user->first_name = 'Super';
        $user->last_name = 'Admin';
        $user->username = 'superadmin';
        $user->email = 'superadmin@swashfit.com';
        $user->mobile_number = 9191244321;
        $user->email_verified_at = $faker->dateTime();
        $user->mobile_number_verified_at = $faker->dateTime();
        $user->password = bcrypt('12345678');
        $user->registration_ip = $request->getClientIp();
        $user->is_active = 1;
        $user->save();
        // if($user->save()){
            // $user->profile()->create([
            //     'uuid'=>$faker->uuid,
            //     'birthday'=>'1993-05-27',
            //     'gender'=> 'male',
            // ]);
        // }
        $user->roles()->attach($isAdminRole);
        $permissions= Permission::whereIn('permission_type',['super_admin'])->get();
        $user->permissions()->attach($permissions);

        // $isSellerRole = Role::where('slug', 'seller')->first();
        // $seller = new User();
        // $seller->uuid = $faker->uuid;
        // $seller->first_name = 'Canably';
        // $seller->last_name = 'Vendor';
        // $seller->username = 'adminseller';
        // $seller->email = 'seller.admin@canably.com';
        // $seller->mobile_number = 9193244321;
        // $seller->email_verified_at = $faker->dateTime();
        // $seller->mobile_number_verified_at = $faker->dateTime();
        // $seller->password = bcrypt('secret');
        // $seller->registration_ip = $request->getClientIp();
        // $seller->is_active = 1;
        // if($seller->save()){
        //     $seller->profile()->create([
        //         'uuid'=>$faker->uuid,
        //         'organization_name'=>'Canably',
        //         'designation'=>'Admin Seller',
        //         'birthday'=>'1993-05-27',
        //         'gender'=> 'male',
        //     ]);
        // }
        // $seller->roles()->attach($isSellerRole);
    }
}
