<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Level;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Level::create([
            'namalevel' => 'Super Admin',
            'idlevel' => '1',
        ]);

        Level::create([
            'namalevel' => 'Siswa',
            'idlevel' => '2',
        ]);

        Level::create([
            'namalevel' => 'Guru',
            'idlevel' => '3',
        ]);

        Level::create([
            'namalevel' => 'Waka',
            'idlevel' => '4',
        ]);

        Level::create([
            'namalevel' => 'Kepala Sekolah',
            'idlevel' => '5',
        ]);

        User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'email_verified_at' => Carbon::now(),
            'password' => bcrypt('12345678'),
            'level_id' => '1',
            'telp' => '082389882323',
        ]);
    }
}
