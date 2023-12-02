<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create();

        $user = new User();
        $user->name = "Owner";
        $user->surname = "Owner";
        $user->national_id = "1111111111111";
        $user->password = "11111111";
        $user->phone_number = "0811111111";

        $user->role = "owner";
        $user->save();

        $user = new User();
        $user->name = "Seller";
        $user->surname = "Seller";
        $user->national_id = "2222222222222";
        $user->password = "22222222";
        $user->phone_number = "0822222222";
        $user->role = "seller";
        $user->save();

        $user = new User();
        $user->name = "Accountant";
        $user->surname = "Accountant";
        $user->national_id = "3333333333333";
        $user->password = "33333333";
        $user->phone_number = "0833333333";
        $user->role = "accountant";
        $user->save();

        $user = new User();
        $user->name = "Customer";
        $user->surname = "Customer";
        $user->national_id = "4444444444444";
        $user->password = "44444444";
        $user->phone_number = "0844444444";
        $user->role = "customer";
        $user->save();
    }
}
