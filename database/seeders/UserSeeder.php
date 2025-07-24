<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'admin',
            'alamat' => 'xxxxx',
            'telepon' => '08956034',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin@123'),
            'jenis' => 'admin'
        ]);
    }
}
