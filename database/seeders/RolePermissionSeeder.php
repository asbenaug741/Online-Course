<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ownerRole = Role::create([
            'name' => 'owner'
        ]);

        $teacherRole = Role::create([
            'name' => 'teacher'
        ]);
        
        $studentRole = Role::create([
            'name' => 'student'
        ]);
        
        //akun super admin
        $userOwner = User::create([
            'name' => 'Rafli',
            'occupation' => 'developer',
            'avatar' => 'images/default-ava.jpg',
            'email' => 'raflinailurr@gmail.com',
            'password' => bcrypt('123123123')
        ]);
        
        $userOwner->assignRole($ownerRole);
        
    }

}
