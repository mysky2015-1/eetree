<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // factory('App\Models\Admin', 3)->create([
        //     'password' => bcrypt('admin'),
        // ]);
        DB::table('admin')->insert([
            'name' => 'admin',
            'password' => bcrypt('admin'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('admin_role')->insert([
            'name' => 'admin',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('admin_role_user')->insert([
            'role_id' => 1,
            'user_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        foreach ([1, 2] as $menu_id) {
            DB::table('admin_role_menu')->insert([
                'role_id' => 1,
                'menu_id' => $menu_id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
        DB::table('admin_permission')->insert([
            'name' => 'all',
            'http_method' => 'ANY',
            'http_path' => '*',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
        DB::table('admin_role_permission')->insert([
            'role_id' => 1,
            'permission_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
