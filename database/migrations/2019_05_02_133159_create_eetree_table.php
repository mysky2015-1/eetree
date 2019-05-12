<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEetreeTable extends Migration
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
        Schema::create('doc_draft', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0);
            $table->integer('doc_id')->default(0);
            $table->integer('user_category_id')->default(0);
            $table->string('title', 255);
            $table->text('content');
            $table->tinyInteger('status')->default(0)->comment('0:草稿,1:提交审核,8:审核不通过,9:审核通过');
            $table->text('review_remarks')->comment('审核不通过的原因');
            $table->timestamp('submit_at')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->index('doc_id');
            $table->index('user_id');
        });
        Schema::create('doc', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0);
            $table->integer('category_id')->default(0);
            $table->string('title', 255);
            $table->text('content');
            $table->timestamp('publish_at')->nullable();
            $table->integer('view_count')->default(0);

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
            $table->softDeletes();

            $table->index('user_id');
        });
        Schema::create('comment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->default(0);
            $table->integer('doc_id')->default(0);
            $table->text('content');
            $table->tinyInteger('active')->default(0);

            $table->timestamps();

            $table->index('doc_id');
        });
        Schema::create('file', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('path', 255);
            $table->string('type', 50);
            $table->string('mime', 50);
            $table->integer('pid')->default(0);

            $table->timestamps();
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
        Schema::dropIfExists('doc_draft');
        Schema::dropIfExists('doc');
        Schema::dropIfExists('category');
        Schema::dropIfExists('user_category');
        Schema::dropIfExists('comment');
    }
}
