<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'first_name' => 'Nathon',
            'middle_name' => '',
            'last_name' => 'Scott',
            'email' => 'test@example.com',
            'phone' => '8702923154',
            'dob' => '1987/03/29',
            'avatar' => 'avatars/mdCtYmyIvfXbeeNKtUfaAK5qf2RIflWKzxRlMkI6.jpg',
        ]);

        User::factory()->create([
            'first_name' => 'Elmer',
            'middle_name' => '',
            'last_name' => 'Massey',
            'email' => 'test2@example.com',
            'phone' => '8709381611',
            'dob' => '1987/03/29',
            'avatar' => '',
        ]);

        User::factory()->create([
            'first_name' => 'Debbie',
            'middle_name' => '',
            'last_name' => 'Massey',
            'email' => 'test3@example.com',
            'phone' => '8709383389',
            'dob' => '1987/03/29',
            'avatar' => '',
        ]);

        User::factory()->create([
            'first_name' => 'Brandon',
            'middle_name' => '',
            'last_name' => 'Yoh',
            'email' => 'test4@example.com',
            'phone' => '8709381611',
            'dob' => '2003/01/04',
            'avatar' => '',
        ]);

        $user = User::find(1);

        if($user) {
            $user->assignRole('super-admin');
        }
    }
}
