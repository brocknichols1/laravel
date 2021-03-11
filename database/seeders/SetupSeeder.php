<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Organization;

class SetupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'username' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => bcrypt('admin'),
            'organization_id' => 1
        ]);

        $role = Role::create(['user_id' => $user->id, 'user_role' => 'Admin']);
        
        // Create a couple of Organizations
        $orgOne = Organization::create(['name'=>'Nichols Inc','details'=>'Organization One']);
        $orgTwo = Organization::create(['name'=>"Cowboy Hat's Emporium",'details'=>'A place that sells cowboy hats']);

    }
}
