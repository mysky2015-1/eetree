<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EetreeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $now = Carbon::now();
        // DB::table('admin_role_menu')->truncate();
        // foreach ([1, 2, 3, 4, 5, 6] as $menu_id) {
        //     DB::table('admin_role_menu')->insert([
        //         'role_id' => 1,
        //         'menu_id' => $menu_id,
        //         'created_at' => $now,
        //         'updated_at' => $now,
        //     ]);
        // }
        // return;
        DB::table('category')->truncate();
        DB::table('user')->truncate();
        DB::table('article_draft')->truncate();
        DB::table('article')->truncate();
        DB::table('comment')->truncate();
        foreach (['category', 'user_category'] as $table) {
            DB::table($table)->insert([
                'parent_id' => 0,
                'order' => 0,
                'name' => '分类1',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            DB::table($table)->insert([
                'parent_id' => 0,
                'order' => 1,
                'name' => '分类2',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            DB::table($table)->insert([
                'parent_id' => 0,
                'order' => 2,
                'name' => '分类3',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
        for ($i = 0; $i < 50; $i++) {
            DB::table('user')->insert([
                'name' => $faker->userName,
                'nickname' => $faker->name,
                'password' => bcrypt('test'),
                'mobile' => 13451234000 + $i,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            DB::table('article_draft')->insert([
                'title' => $faker->title,
                'content' => $faker->text,
                'user_id' => rand(1, 49),
                'article_id' => rand(1, 49),
                'user_category_id' => rand(1, 3),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            DB::table('article')->insert([
                'user_id' => rand(1, 49),
                'title' => $faker->title,
                'content' => $faker->text,
                'category_id' => rand(1, 3),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            DB::table('comment')->insert([
                'user_id' => rand(1, 49),
                'article_id' => rand(1, 49),
                'content' => $faker->text,
                'active' => rand(0, 1),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
