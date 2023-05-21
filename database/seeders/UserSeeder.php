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
        User::create([
            'nik_tmu' => '123456789',
            'name_tmu' => 'Administrator',
            'role_tmu' =>'admin',
            'username_tmu' => 'admin@admin.com',
            'password_tmu' => 'admin',
            'created_by_tmu' => '1'
        ]);
        User::factory()->count(5)->create();
    }
}
