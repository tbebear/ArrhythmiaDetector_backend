<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->string('nama_depan');
            $table->string('nama_belakang');
            $table->string('no_telp');
            $table->string('alamat');
            $table->string('username')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });

        // DB::table('doctors')->insert([
        //     'nama_depan' => 'Dokter',
        //     'nama_belakang' => '1',
        //     'no_telp' => '080011112222',
        //     'alamat' => 'Bandung',
        //     'username' => 'doktersatu',
        //     'password' => Hash::make('12345678'),
        // ]);
        // DB::table('doctors')->insert([
        //     'nama_depan' => 'Dokter',
        //     'nama_belakang' => '2',
        //     'no_telp' => '080011113333',
        //     'alamat' => 'Bekasi',
        //     'username' => 'dokterdua',
        //     'password' => Hash::make('12345678'),
        // ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
