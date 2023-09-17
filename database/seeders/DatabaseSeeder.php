<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        DB::table('doctors')->insert([
            'nama_depan' => 'Dokter',
            'nama_belakang' => '1',
            'no_telp' => '080011112222',
            'alamat' => 'Bekasi',
            'username' => 'doktersatu',
            'password' => Hash::make('12345678'),
        ]);
        DB::table('doctors')->insert([
            'nama_depan' => 'Dokter',
            'nama_belakang' => '2',
            'no_telp' => '080011113333',
            'alamat' => 'Bekasi',
            'username' => 'dokterdua',
            'password' => Hash::make('12345678'),
        ]);
        DB::table('patients')->insert([
            'username' => 'rahusiens',
            'password' => Hash::make('12345678'),
            'address' => 'Ciganitri',
            'phone' => '082151544151',
            'emergency_phone' => '0811587080',
            'age' => '21',
            'gender' => 'Male',
        ]);
        Admin::insert([
            'nama_depan' => 'Admin',
            'nama_belakang' => 'Satu',
            'no_telp' => '080000000000',
            'alamat' => 'Bontang',
            'username' => 'admin',
            'password' => Hash::make('12345678'),
        ]);
    }
}
