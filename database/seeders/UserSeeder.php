<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

	    $faker = Faker::create();

        User::create([
            'name' => Str::random(10),
            'email' => Str::random(10).'@gmail.com',
            'password' => Hash::make('password'),
            'phone' => $faker->phoneNumber,
            'position_id' => rand(1,45),
            'photo'=> $faker->image('public/storage/images',70,70, null, false),
        ]);
    }
}
