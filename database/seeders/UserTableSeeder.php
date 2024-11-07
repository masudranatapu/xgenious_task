<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        try {
            DB::beginTransaction();
            $this->userCreate();
            DB::commit();
            $this->command->info('User Successfully Created');
        } catch (\Throwable $th) {
            DB::rollBack();
            $this->command->info($th->getMessage());
        }
    }

    public function userCreate()
    {

        $admin = new User();
        $admin->name = 'User';
        $admin->email = 'user@gmail.com';
        $admin->password = Hash::make('password');
        $admin->save();
    }
}
