<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\SuperAdmin;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        SuperAdmin::create([
            'name' => 'superadmin01',
            'password' => Hash::make('Superadmin@01'), // Hashing the password
            'email' => 'tejima911@gmail.com',
        ]);
    }
}
