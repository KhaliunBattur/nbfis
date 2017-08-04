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
        $faker = Factory::create();

        User::create([
            'first_name' => 'Chimedbazar',
            'name' => 'Munkhsaikhan',
            'email' => 'chmunkhsaikhan@gmail.com',
            'phone_number' => '99017534',
            'address' => null,
            'password' => \Hash::make('root')
        ]);

        foreach (range(1, 40) as $i)
        {
            User::create([
                'first_name' => $faker->firstName,
                'name' => $faker->name,
                'email' => $faker->email,
                'phone_number' => $faker->phoneNumber,
                'address' => $faker->address,
                'password' => \Hash::make('123')
            ]);
        }
    }
}
