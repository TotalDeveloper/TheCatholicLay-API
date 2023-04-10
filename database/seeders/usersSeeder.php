<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Hash;
use Str;

class usersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->name = 'earliternety';
        $user->uuid = Str::uuid();
        $user->email = 'earliternety@gmail.com';
        $user->password = Hash::make('Qwe1234!');
        $user->save();
        $user->roles()->attach(Role::SUPER_ADMIN);

        $user = new User;
        $user->name = 'admin';
        $user->uuid = Str::uuid();
        $user->email = 'churchandstateph@gmail.com';
        $user->password = Hash::make('Qwe1234!');
        $user->save();
        $user->roles()->attach(Role::ADMIN);
        
        $user = new User;
        $user->name = 'earlrodson';
        $user->uuid = Str::uuid();
        $user->email = 'earlrodson@gmail.com';
        $user->password = Hash::make('Qwe1234!');
        $user->save();
        $user->roles()->attach(Role::USER);
        
        $user = new User;
        $user->name = 'fiebelle';
        $user->uuid = Str::uuid();
        $user->email = 'ellebeif88@gmail.com';
        $user->password = Hash::make('Qwe1234!');
        $user->save();
        $user->roles()->attach(Role::GUEST);
    }
}
