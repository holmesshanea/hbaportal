<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Shane Holmes',
            'email' => 'sholmes@hbadk.org',
            'password' => Hash::make('blueline'),
            'role' => 'Super',
            'status' => 'Staff',
            'branch' => 'Marine Corps',
            'gender' => 'Male',
            'phone' => '518-618-7776',
            'emergency_contact_name' => 'Doreen Alessi-Holmes',
            'emergency_contact_phone' => '518-955-6655',
            'town' => 'Long Lake',
            'state' => 'NY',
            'zipcode' => '12847',
            'profile_confirmed' => true,
            'id_confirmed' => true,
            'status_confirmed' => true,
            'image' => null,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Shane Holmes',
            'email' => 'holmesshanea@yahoo.com',
            'password' => Hash::make('blueline'),
            'role' => 'Admin',
            'status' => 'Staff',
            'branch' => 'Army National Guard',
            'gender' => 'Male',
            'phone' => '518-618-7776',
            'emergency_contact_name' => 'Doreen Alessi-Holmes',
            'emergency_contact_phone' => '518-955-6655',
            'town' => 'Long Lake',
            'state' => 'NY',
            'zipcode' => '12847',
            'profile_confirmed' => true,
            'id_confirmed' => true,
            'status_confirmed' => true,
            'image' => null,
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Shane Holmes',
            'email' => 'holmesshanea@gmail.com',
            'password' => Hash::make('blueline'),
            'role' => 'User',
            'status' => 'Veteran',
            'branch' => 'Other',
            'gender' => 'Male',
            'phone' => '518-618-7776',
            'emergency_contact_name' => 'Doreen Alessi-Holmes',
            'emergency_contact_phone' => '518-955-6655',
            'town' => 'Long Lake',
            'state' => 'NY',
            'zipcode' => '12847',
            'id_confirmed' => false,
            'status_confirmed' => false,
            'image' => null,
            'email_verified_at' => now(),
        ]);
    }
}
