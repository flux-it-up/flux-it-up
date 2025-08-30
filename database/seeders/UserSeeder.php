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
            'name' => 'Nathon Scott',
            'email' => 'test@example.com',
            'phone' => '8702923154',
            'avatar' => 'avatars/mdCtYmyIvfXbeeNKtUfaAK5qf2RIflWKzxRlMkI6.jpg',
        ]);

        $user = User::find(1);

        if($user) {
            $user->assignRole('super-admin');
        }
    }
}
