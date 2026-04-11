<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $universityName = 'Daffodil International University (DIU)';

        $universityId = DB::table('universities')
            ->where('name', $universityName)
            ->value('id');

        if (!$universityId) {
            DB::table('universities')->insert([
                'name' => $universityName,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $universityId = DB::table('universities')
                ->where('name', $universityName)
                ->value('id');
        }

        DB::table('users')->updateOrInsert(
            ['phone' => '01700000001'],
            [
                'name' => 'Admin User',
                'role_id' => 1,
                'university_id' => $universityId ?: 0,
                'phone' => '01700000001',
                'email' => 'admin@bdapps.local',
                'password' => Hash::make('password'),
                'status' => 1,
                'approved_by' => 0,
                'versity_name' => $universityName,
                'updated_at' => now(),
            ]
        );

        $adminId = DB::table('users')->where('phone', '01700000001')->value('id') ?: 0;

        DB::table('users')->updateOrInsert(
            ['phone' => '01700000002'],
            [
                'name' => 'Demo User',
                'role_id' => 2,
                'university_id' => $universityId ?: 0,
                'phone' => '01700000002',
                'email' => 'user@bdapps.local',
                'password' => Hash::make('password'),
                'status' => 1,
                'approved_by' => $adminId,
                'versity_name' => $universityName,
                'updated_at' => now(),
            ]
        );
    }
}
