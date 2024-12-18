<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class run extends Seeder
{
    /**
     * Run the database seeds.
     */
    

    public function run()
    {
        $superAdminUser = User::find(1); // Replace with the correct user ID
        $superAdminUser->assignRole('superadmin');
    
    }
    
}
