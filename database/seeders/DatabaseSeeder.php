<?php

namespace Database\Seeders;

use App\Models\Event;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'last_name' => 'Holmes',
            'first_name' => 'Shane',
            'email' => 'sholmes@hbadk.org',
            'password' => Hash::make('blueline'),
            'role' => 'Super',
            'status' => 'Staff',
            'branch' => 'Marine Corps',
            'combat' => 'true',
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
            'last_name' => 'Holmes',
            'first_name' => 'Shane',
            'email' => 'holmesshanea@yahoo.com',
            'password' => Hash::make('blueline'),
            'role' => 'Admin',
            'status' => 'Staff',
            'branch' => 'Army National Guard',
            'combat' => 'true',
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
            'last_name' => 'Holmes',
            'first_name' => 'Shane',
            'email' => 'holmesshanea@gmail.com',
            'password' => Hash::make('blueline'),
            'role' => 'User',
            'status' => 'Veteran',
            'branch' => 'Other',
            'combat' => 'false',
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

        /**
         * RETREAT EVENT
         */
        Event::factory()->create([
            'event_type' => 'retreat',
            'title' => 'Veteran Nature Retreat',
        ]);

        /**
         * REGULAR EVENT
         */
        Event::factory()->create([
            'event_type' => 'event',
            'title' => 'Community Outreach Event',
        ]);
    }
}
