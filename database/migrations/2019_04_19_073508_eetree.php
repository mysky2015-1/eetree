<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Eetree extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('mobile', 32)->unique();
            $table->string('nickname');
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
        Schema::create('article_draft', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0);
            $table->integer('article_id')->default(0);
            $table->integer('user_category_id')->default(0);
            $table->string('title', 255);
            $table->text('content');
            $table->tinyInteger('status')->default(0)->comment('0:草稿,1:提交审核,8:审核不通过,9:审核通过');
            $table->text('review_remark')->comment('审核不通过的原因');
            $table->tinyInteger('deleted')->default(0);
            $table->timestamp('submit_at');

            $table->timestamps();

            $table->index('article_id');
        });
        Schema::create('article', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0);
            $table->integer('category_id')->default(0);
            $table->string('title', 255);
            $table->text('content');
            $table->tinyInteger('deleted')->default(0);

            $table->timestamps();
        });
        Schema::create('category', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('parent_id')->default(0);
            $table->integer('order')->default(0);
            $table->string('name', 50);

            $table->timestamps();
        });
        Schema::create('user_category', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0);
            $table->integer('parent_id')->default(0);
            $table->integer('order')->default(0);
            $table->string('name', 50);

            $table->timestamps();

            $table->index('user_id');
        });
        Schema::create('comment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0);
            $table->integer('article_id')->default(0);
            $table->text('content');
            $table->tinyInteger('active')->default(0);

            $table->timestamps();

            $table->index('article_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user');
        Schema::dropIfExists('article_draft');
        Schema::dropIfExists('article');
        Schema::dropIfExists('category');
        Schema::dropIfExists('user_category');
        Schema::dropIfExists('comment');
    }
}
