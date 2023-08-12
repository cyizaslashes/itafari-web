<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Filling multiple data
        DB::Table('users')->insert([
           //Admin
           [
            'name'=>'ADMIIN',
            'username'=>'admin',
            'email'=>'admin@gmail.com',
            'password'=> Hash::make('111'),
            'role'=>'admin',
            'status'=>'active',
           ],

           //Agent
            [
                'name'=>'AGENT',
                'username'=>'agent',
                'email'=>'agent@gmail.com',
                'password'=>Hash::make('123'),
                'role'=>'agent',
                'status'=>'active',
            ],

            //
            [
                'name'=>'USER',
                'username'=>'user',
                'email'=>'user@gmail.com',
                'password'=>Hash::make('444'),
                'role'=>'user',
                'status'=>'active'
            ],

        ]);
    }
}
