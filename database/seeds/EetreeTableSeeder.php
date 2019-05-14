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
        // DB::table('category')->truncate();
        // DB::table('user_category')->truncate();
        // DB::table('user')->truncate();
        // DB::table('doc_draft')->truncate();
        // DB::table('doc')->truncate();
        // DB::table('comment')->truncate();
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
                'description' => $faker->text(30),
                'content' => '{"root":{"data":{"id":"btxlk2q7ng00","created":"1557279632127","text":"\u6d4b\u8bd5\u4e00\u4e0b"},"children":[{"data":{"id":"btyqiod7qa80","created":1557395188007,"text":"\u70b9\u6211\u6d4b\u8bd5\u94fe\u63a5","hyperlink":"http:\/\/www.eelib.io","hyperlinkTitle":"\u7535\u5b50\u68ee\u6797"},"children":[{"data":{"id":"btyqiu4onyw0","created":1557395200552,"text":"depth2-1"},"children":[{"data":{"id":"btyqj25cl280","created":1557395218007,"text":"depth3 - 1"},"children":[]},{"data":{"id":"btyqjdx0kg00","created":1557395243624,"text":"depth3-2"},"children":[]}]},{"data":{"id":"btyqiv1ujjc0","created":1557395202558,"text":"depth2-2"},"children":[]},{"data":{"id":"btyqjgynq1c0","created":1557395250254,"text":"depth2-3"},"children":[]},{"data":{"id":"bu32unn3wdk0","created":1557836219944,"text":"\u6d4b\u8bd5\u56fe\u7247","image":"http:\/\/img1.imgtn.bdimg.com\/it\/u=3030642356,2321064273&fm=26&gp=0.jpg","imageTitle":"give a hand to wildlife \u5f69\u7ed8\u5927\u8c61\u7bc7 - wwf\u52a8\u7269\u4fdd\u62a4\u516c\u76ca","imageSize":{"width":200,"height":150}},"children":[]}]},{"data":{"id":"btyqisdob8o0","created":1557395196742,"text":"\u6d4b\u8bd5\u5907\u6ce8","note":"\u6211\u662f\u5907\u6ce8"},"children":[]}]},"template":"default","theme":"fresh-blue","version":"1.4.43"}',
                'user_id' => 1,
                'doc_id' => $i + 1,
                'status' => $status[rand(0, 2)],
                'review_remarks' => '',
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            DB::table('doc_draft')->insert([
                'title' => $faker->text(30),
                'content' => '{"root":{"data":{"id":"btxlk2q7ng00","created":"1557279632127","text":"\u6d4b\u8bd5\u4e00\u4e0b"},"children":[{"data":{"id":"btyqiod7qa80","created":1557395188007,"text":"\u70b9\u6211\u6d4b\u8bd5\u94fe\u63a5","hyperlink":"http:\/\/www.eelib.io","hyperlinkTitle":"\u7535\u5b50\u68ee\u6797"},"children":[{"data":{"id":"btyqiu4onyw0","created":1557395200552,"text":"depth2-1"},"children":[{"data":{"id":"btyqj25cl280","created":1557395218007,"text":"depth3 - 1"},"children":[]},{"data":{"id":"btyqjdx0kg00","created":1557395243624,"text":"depth3-2"},"children":[]}]},{"data":{"id":"btyqiv1ujjc0","created":1557395202558,"text":"depth2-2"},"children":[]},{"data":{"id":"btyqjgynq1c0","created":1557395250254,"text":"depth2-3"},"children":[]},{"data":{"id":"bu32unn3wdk0","created":1557836219944,"text":"\u6d4b\u8bd5\u56fe\u7247","image":"http:\/\/img1.imgtn.bdimg.com\/it\/u=3030642356,2321064273&fm=26&gp=0.jpg","imageTitle":"give a hand to wildlife \u5f69\u7ed8\u5927\u8c61\u7bc7 - wwf\u52a8\u7269\u4fdd\u62a4\u516c\u76ca","imageSize":{"width":200,"height":150}},"children":[]}]},{"data":{"id":"btyqisdob8o0","created":1557395196742,"text":"\u6d4b\u8bd5\u5907\u6ce8","note":"\u6211\u662f\u5907\u6ce8"},"children":[]}]},"template":"default","theme":"fresh-blue","version":"1.4.43"}',
                'user_id' => 1,
                'doc_id' => $i + 1,
                'publish_id' => $i + 1,
                'user_category_id' => rand(1, 5),
                'last_edit' => $now,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
            DB::table('doc')->insert([
                'user_id' => 1,
                'title' => $faker->text(30),
                'description' => $faker->text(30),
                'content' => '{"root":{"data":{"id":"btxlk2q7ng00","created":"1557279632127","text":"\u6d4b\u8bd5\u4e00\u4e0b"},"children":[{"data":{"id":"btyqiod7qa80","created":1557395188007,"text":"\u70b9\u6211\u6d4b\u8bd5\u94fe\u63a5","hyperlink":"http:\/\/www.eelib.io","hyperlinkTitle":"\u7535\u5b50\u68ee\u6797"},"children":[{"data":{"id":"btyqiu4onyw0","created":1557395200552,"text":"depth2-1"},"children":[{"data":{"id":"btyqj25cl280","created":1557395218007,"text":"depth3 - 1"},"children":[]},{"data":{"id":"btyqjdx0kg00","created":1557395243624,"text":"depth3-2"},"children":[]}]},{"data":{"id":"btyqiv1ujjc0","created":1557395202558,"text":"depth2-2"},"children":[]},{"data":{"id":"btyqjgynq1c0","created":1557395250254,"text":"depth2-3"},"children":[]},{"data":{"id":"bu32unn3wdk0","created":1557836219944,"text":"\u6d4b\u8bd5\u56fe\u7247","image":"http:\/\/img1.imgtn.bdimg.com\/it\/u=3030642356,2321064273&fm=26&gp=0.jpg","imageTitle":"give a hand to wildlife \u5f69\u7ed8\u5927\u8c61\u7bc7 - wwf\u52a8\u7269\u4fdd\u62a4\u516c\u76ca","imageSize":{"width":200,"height":150}},"children":[]}]},{"data":{"id":"btyqisdob8o0","created":1557395196742,"text":"\u6d4b\u8bd5\u5907\u6ce8","note":"\u6211\u662f\u5907\u6ce8"},"children":[]}]},"template":"default","theme":"fresh-blue","version":"1.4.43"}',
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
