<?php

use Illuminate\Database\Seeder;

use Faker\Factory;
use App\User\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name' => 'Woovoo',
            'name' => 'Woovoo',
            'email' => 'admin@woovoo.com',
            'password' => \Hash::make('root')
        ]);
    }
}
