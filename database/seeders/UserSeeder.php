<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        #generate 3 super admin: buat kelola semua data
        $users = User::factory()
            ->count(3)
            ->create();
           
        foreach($users as $user) :
            $user->assignRole('super admin');
        endforeach;
    }
}
