<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'staging@alfinsys.my.id',
            'password' => Hash::make('testing123'),
            'is_admin' => true,
        ]);
    }
}
