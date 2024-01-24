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
        #generate 3 admin: buat melihat order masuk
        $users = User::factory()
            ->count(3)
            ->create();
           
        foreach($users as $user) :
            $user->assignRole('admin');
        endforeach;
    }
}
