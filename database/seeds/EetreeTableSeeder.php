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
        DB::table('user_category')->truncate();
        DB::table('user')->truncate();
        DB::table('doc_draft')->truncate();
        DB::table('doc')->truncate();
        DB::table('comment')->truncate();
        $status = [1, 8, 9];
        // for ($i = 0; $i < 50; $i++) {
        //     DB::table('doc_draft')->insert([
        //         'title' => $faker->title,
        //         'content' => $faker->text,
        //         'user_id' => rand(1, 49),
        //         'doc_id' => rand(1, 49),
        //         'user_category_id' => rand(1, 3),
        //         'status' => $status[rand(0, 3)],
        //         'review_remarks' => '',
        //         'created_at' => $now,
        //         'updated_at' => $now,
        //     ]);
        // }
        // return;
        DB::table('category')->insert([
            'parent_id' => 0,
            'order' => 0,
            'name' => '分类1',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('category')->insert([
            'parent_id' => 1,
            'order' => 0,
            'name' => '分类1-1',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('category')->insert([
            'parent_id' => 1,
            'order' => 1,
            'name' => '分类1-2',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('category')->insert([
            'parent_id' => 0,
            'order' => 1,
            'name' => '分类2',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('category')->insert([
            'parent_id' => 0,
            'order' => 2,
            'name' => '分类3',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('user_category')->insert([
            'parent_id' => 0,
            'user_id' => 1,
            'order' => 0,
            'name' => '分类1',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('user_category')->insert([
            'parent_id' => 1,
            'user_id' => 1,
            'order' => 0,
            'name' => '分类1-1',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('user_category')->insert([
            'parent_id' => 1,
            'user_id' => 1,
            'order' => 1,
            'name' => '分类1-2',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('user_category')->insert([
            'parent_id' => 0,
            'user_id' => 1,
            'order' => 1,
            'name' => '分类2',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        DB::table('user_category')->insert([
            'parent_id' => 0,
            'user_id' => 1,
            'order' => 2,
            'name' => '分类3',
            'created_at' => $now,
            'updated_at' => $now,
        ]);
        for ($i = 0; $i < 50; $i++) {
            DB::table('user')->insert([
                'name' => $faker->userName,
                'nickname' => $faker->name,
                'password' => bcrypt('test'),
                'mobile' => 13451234000 + $i,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            DB::table('doc_publish')->insert([
                'title' => $faker->text(30),
                'content' => '{"root":{"data":{"id":"btxlk2q7ng00","created":"1557279632127","text":"\u4e2d\u5fc3\u4e3b\u9898"},"children":[{"data":{"id":"btyqiod7qa80","created":1557395188007,"text":"1"},"children":[{"data":{"id":"btyqiu4onyw0","created":1557395200552,"text":"depth2-1"},"children":[{"data":{"id":"btyqj25cl280","created":1557395218007,"text":"depth3 - 1"},"children":[]},{"data":{"id":"btyqjdx0kg00","created":1557395243624,"text":"depth3-2"},"children":[]}]},{"data":{"id":"btyqiv1ujjc0","created":1557395202558,"text":"depth2-2"},"children":[]},{"data":{"id":"btyqjgynq1c0","created":1557395250254,"text":"depth2-3"},"children":[]}]},{"data":{"id":"btyqisdob8o0","created":1557395196742,"text":"2"},"children":[]}]},"template":"default","theme":"fresh-blue","version":"1.4.43"}',
                'user_id' => 1,
                'doc_id' => $i + 1,
                'status' => $status[rand(0, 2)],
                'review_remarks' => '',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            DB::table('doc_draft')->insert([
                'title' => $faker->text(30),
                'content' => '{"root":{"data":{"id":"btxlk2q7ng00","created":"1557279632127","text":"\u4e2d\u5fc3\u4e3b\u9898"},"children":[{"data":{"id":"btyqiod7qa80","created":1557395188007,"text":"1"},"children":[{"data":{"id":"btyqiu4onyw0","created":1557395200552,"text":"depth2-1"},"children":[{"data":{"id":"btyqj25cl280","created":1557395218007,"text":"depth3 - 1"},"children":[]},{"data":{"id":"btyqjdx0kg00","created":1557395243624,"text":"depth3-2"},"children":[]}]},{"data":{"id":"btyqiv1ujjc0","created":1557395202558,"text":"depth2-2"},"children":[]},{"data":{"id":"btyqjgynq1c0","created":1557395250254,"text":"depth2-3"},"children":[]}]},{"data":{"id":"btyqisdob8o0","created":1557395196742,"text":"2"},"children":[]}]},"template":"default","theme":"fresh-blue","version":"1.4.43"}',
                'user_id' => 1,
                'doc_id' => $i + 1,
                'user_category_id' => rand(1, 5),
                'last_edit' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            DB::table('doc')->insert([
                'user_id' => 1,
                'title' => $faker->text(30),
                'content' => '{"root":{"data":{"id":"btxlk2q7ng00","created":"1557279632127","text":"\u4e2d\u5fc3\u4e3b\u9898"},"children":[{"data":{"id":"btyqiod7qa80","created":1557395188007,"text":"1"},"children":[{"data":{"id":"btyqiu4onyw0","created":1557395200552,"text":"depth2-1"},"children":[{"data":{"id":"btyqj25cl280","created":1557395218007,"text":"depth3 - 1"},"children":[]},{"data":{"id":"btyqjdx0kg00","created":1557395243624,"text":"depth3-2"},"children":[]}]},{"data":{"id":"btyqiv1ujjc0","created":1557395202558,"text":"depth2-2"},"children":[]},{"data":{"id":"btyqjgynq1c0","created":1557395250254,"text":"depth2-3"},"children":[]}]},{"data":{"id":"btyqisdob8o0","created":1557395196742,"text":"2"},"children":[]}]},"template":"default","theme":"fresh-blue","version":"1.4.43"}',
                'category_id' => rand(1, 5),
                'publish_at' => $now,
                'view_count' => rand(1, 100),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            DB::table('comment')->insert([
                'user_id' => 1,
                'doc_id' => rand(1, 49),
                'content' => $faker->text,
                'active' => rand(0, 1),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
}
