<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     *
     * @return void
     */
    public function run(): void
    {
        $users = [
            1 => [
                'name'  => 'admin',
                'email' => 'admin@admin.admin',
                'password' => 'admin'
            ]
        ];

        foreach ($users as $user_id => $userData)
        {
            $user = User::find($user_id);

            if(!$user)
            {
                $newUser = new User();
                $newUser->id = $user_id;
                $newUser->name = $userData['name'];
                $newUser->email = $userData['email'];
                $newUser->password = Hash::make($userData['password']);
                $newUser->save();
            }
        }
    }
}
